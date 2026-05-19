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


class MarketingMessageController extends Controller
{
    protected $e_controller = "MarketingMessageController";
    
    public function index()
    {
        try {
            $permission_flag = MyFuncs::isPermission_route("36");
            if(!$permission_flag){
                return view('admin.common.error');
            }
            $rs_records = DB::select(DB::raw("SELECT * from `whatsApp_promo_template_detail` order by `id`;"));
            return view('admin.MarketingMessage.index',compact('rs_records'));                
        } catch (\Exception $e) {
            $e_method = "index";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function show(Request $request)
    {
        try {
            $permission_flag = MyFuncs::isPermission_route("36");
            if(!$permission_flag){
                return view('admin.common.error');
            }

            $rules=[      
                'template_type' => 'required',
                'from_id' => 'required', 
                'to_id' => 'required',
            ];
            $customMessages = [
                'template_type.required'=> 'Please Select Template',
                'from_id.required'=> 'Please Enter From ID',
                'to_id.required'=> 'Please Enter To ID',
            ];

            $validator = Validator::make($request->all(),$rules, $customMessages);
            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $response=array();
                $response["status"]=0;
                $response["msg"]=$errors[0];
                return response()->json($response);// response as json
            }

            $template_type = intval(Crypt::decrypt($request->template_type));
            $from_id = intval(substr($request->from_id, 0, 10));
            $to_id = intval(substr($request->to_id, 0, 10));
            $rs_records = DB::select(DB::raw("SELECT `msl`.`id`, `msl`.`school_name`, `msl`.`state_name`, `msl`.`city_name`, `msl`.`mobile_no` from `mst_school_list` `msl` where `msl`.`status` = 1 and `msl`.`id` >= $from_id and `msl`.`id` <= $to_id order by `msl`.`id`;"));

            $response = array();
            $response['status'] = 1;            
            $response['data'] =view('admin.MarketingMessage.show', compact('template_type', 'from_id', 'to_id', 'rs_records'))->render();
            return response()->json($response);
        } catch (Exception $e) {
            $e_method = "send";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }        
    }

    public function send(Request $request)
    {
        try {
            $permission_flag = MyFuncs::isPermission_route("36");
            if(!$permission_flag){
                return view('admin.common.error');
            }

            $rules=[      
                'parameter' => 'required',
            ];
            $customMessages = [
                'parameter.required'=> 'Something went wrong (01)',
            ];

            $validator = Validator::make($request->all(),$rules, $customMessages);
            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $response=array();
                $response["status"]=0;
                $response["msg"]=$errors[0];
                return response()->json($response);// response as json
            }
            $parameter_values = explode(':', Crypt::decrypt($request->parameter));

            $template_type = intval($parameter_values[0]);
            $from_id = intval($parameter_values[1]);
            $to_id = intval($parameter_values[2]);
            if($template_type <= 0){
                $response=['status'=>0,'msg'=>'Please Select Template'];
                return response()->json($response);                
            }

            \Artisan::queue('SendPromoMsgWhatsApp:send',['mobile_no'=>'0', 'template_id'=>$template_type, 'from_id'=>$from_id, 'to_id'=>$to_id]);

            $response=['status'=>1,'msg'=>'Message Send Successfully'];
            return response()->json($response);
        } catch (Exception $e) {
            $e_method = "send";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }        
    }

}
