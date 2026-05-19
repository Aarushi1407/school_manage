<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;
use App\Helper\MyFuncs;
use App\Helper\WhatsApp;


class WhatsAppTemplateDetailsController extends Controller
{
    protected $e_controller = "WhatsAppTemplateDetailsController";

    public function index()
    {
        try {
            $permission_flag = MyFuncs::isPermission_route(35);
            if(!$permission_flag){
                return view('admin.common.error');
            }
            $rs_records = DB::select(DB::raw("SELECT * from `whatsApp_promo_template_detail` order by `id`;"));
            return view('admin.WhatsAppTemplateDetails.index',compact('rs_records'));                
        } catch (\Exception $e) {
            $e_method = "index";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }
    
    public function addform($id)
    {
        try {
            $permission_flag = MyFuncs::isPermission_route(35);
            if(!$permission_flag){
                return view('admin.common.error_popup');
            }
            $id = intval(Crypt::decrypt($id));
            $rs_record = DB::select(DB::raw("SELECT * from `whatsApp_promo_template_detail` where `id` = $id limit 1;"));
            $rs_record = reset($rs_record);
            return view('admin.WhatsAppTemplateDetails.form',compact('rs_record', 'id'));
                
        } catch (\Exception $e) {
            $e_method = "addform";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
        
    }

    public function store(Request $request, $id)
    {  
        try {
            $permission_flag = MyFuncs::isPermission_route(35);
            if(!$permission_flag){
                return response()->json(['status'=>0,'msg'=>'Something Went Wrong']);
            }
            $rules = [
                'template_name' => 'required',
                'language' => 'required',
                'media_type' => 'required',
                'media_file' => 'nullable|mimes:pdf,jpg,jpeg,png,mp4,doc,docx|max:20480' 
            ];

            $validator = Validator::make($request->all(),$rules);
            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                return response()->json(["status"=>0, "msg"=>$errors[0]]);
            }

            $id = intval(Crypt::decrypt($id));
            $template_name = substr(MyFuncs::removeSpacialChr($request->template_name), 0, 100);
            $language = $request->language;
            $media_type = $request->media_type;

            $upload_media = 0;
            $final_path_attachment = "";
            if ($request->hasFile('media_file')){
                $attachment = $request->file('media_file');
                $extension = strtolower($attachment->getClientOriginalExtension());
                $folder_path = "mktpromo";
                $filename = time() . '_.' . $extension; 
                $final_path_attachment = '/app/'.$folder_path . '/' . $filename;
                $attachment->storeAs($folder_path, $filename);

                $upload_media = 1;
            }

            // To Upload Media File on Whatsapp
            $media_id = '';
            if($upload_media == 1){
                $media_file_path = Storage_path().$final_path_attachment;

                $rs_fetch = DB::select(DB::raw("SELECT `configuration_value` from `master_configuration` where `configuration_type` = 1;"));
                $whatsapp_phone_id = $rs_fetch[0]->configuration_value;
                
                $rs_fetch = DB::select(DB::raw("SELECT `configuration_value` from `master_configuration` where `configuration_type` = 2;"));
                $access_token = $rs_fetch[0]->configuration_value;

                $upload_result =WhatsApp::uploadWhatsAppMedia($media_file_path, $whatsapp_phone_id, $access_token);
                if (!$upload_result["success"]){
                    return response()->json(['status'=>0,'msg'=>'Something Went Wrong - 01']);
                }else{
                    $media_id = $upload_result["media_id"];
                }
            }
            
            if ($id == 0) {
                $rs_insert = DB::select(DB::raw("INSERT into `whatsApp_promo_template_detail` (`template_name`, `file_path`, `media_type`, `language`, `status`, `upload_media`, `whatsapp_media_id`) values ('$template_name', '$final_path_attachment', '$media_type', '$language', 1, $upload_media, '$media_id');"));              
            } else {
                if ($request->hasFile('media_file')) {
                    $rs_update = DB::select(DB::raw("UPDATE `whatsApp_promo_template_detail` set `template_name` = '$template_name', `file_path` = '$final_path_attachment', `media_type` = '$media_type', `language` = '$language', `upload_media` = $upload_media, `whatsapp_media_id` = '$media_id' where `id` = $id limit 1;"));
                }else {
                    $rs_update = DB::select(DB::raw("UPDATE `whatsApp_promo_template_detail` set `template_name` = '$template_name', `media_type` = '$media_type', `language` = '$language' where `id` = $id limit 1;"));
                }
            }
            return response()->json(['status'=>1,'msg'=>'Saved Successfully']);
        } catch (\Exception $e) {
            $e_method = "store";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }         
    }

    public function viewFile($id)
    {
        try {
            $permission_flag = MyFuncs::isPermission_route(35);
            if(!$permission_flag){
                return redirect()->back()->with(['message'=>'Unauthorized Access','class'=>'error']);
            }

            $id = intval(Crypt::decrypt($id));
            $record = DB::select(DB::raw("SELECT `file_path` from `whatsApp_promo_template_detail` where `id` = $id limit 1;"));
            
            if (!empty($record) && !empty($record[0]->file_path)) {
                $fullPath = storage_path($record[0]->file_path);
                if (file_exists($fullPath)) {
                    return response()->file($fullPath);
                } else {
                    return redirect()->back()->with(['message'=>'File does not exist on server!','class'=>'error']);
                }
            }
            return redirect()->back()->with(['message'=>'No file attached to this template!','class'=>'error']);

        } catch (\Exception $e) {
            $e_method = "viewFile";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function delete($id)
    {  
        try {
            $permission_flag = MyFuncs::isPermission_route(35);
            if(!$permission_flag){
                return  redirect()->back()->with(['message'=>'Something Went Wrong','class'=>'error']);
            }
            $id = intval(Crypt::decrypt($id));
            $rs_update = DB::select(DB::raw("DELETE from `whatsApp_promo_template_detail` where `id` = $id limit 1;"));
            
            return  redirect()->back()->with(['message'=>'Deleted Successfully','class'=>'success']);
                
        } catch (\Exception $e) {
            $e_method = "delete";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function textMessage($para)
    {
        try {
            $permission_flag = MyFuncs::isPermission_route(35);
            if(!$permission_flag){
                return view('admin.common.error_popup');
            }
            return view('admin.WhatsAppTemplateDetails.text_message',compact('para'));
        } catch (\Exception $e) {
            $e_method = "textMessage";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function textMessageSend(Request $request)
    {  
        try {
            $permission_flag = MyFuncs::isPermission_route(35);
            if(!$permission_flag){
                $response=['status'=>0,'msg'=>'Something Went Wrong'];
                return response()->json($response);
            }
            $rules=[
                'mobile_no' => 'required',
            ];

            $validator = Validator::make($request->all(),$rules);
            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $response=array();
                $response["status"]=0;
                $response["msg"]=$errors[0];
                return response()->json($response);// response as json
            }

            $template_id = intval(Crypt::decrypt($request->para));
            if ($template_id == 0) {
                $response=['status'=>0,'msg'=>'Something Went Wrong'];
                return response()->json($response);
            }

            $mobile_no = $request->mobile_no;
            
            \Artisan::queue('SendPromoMsgWhatsApp:send',['mobile_no'=>$mobile_no, 'template_id'=>$template_id, 'from_id'=>0, 'to_id'=>0]);

                            
            $response=['status'=>1,'msg'=>'Send Successfully'];
            return response()->json($response);
        } catch (Exception $e) {
            $e_method = "contactDetailStore";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }         
    }

    
     
}
