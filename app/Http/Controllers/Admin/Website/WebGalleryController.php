<?php

namespace App\Http\Controllers\Admin\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;
use App\Helper\MyFuncs;
use App\Helper\WebHelper;
use Response;

class WebGalleryController extends Controller
{
    protected $e_controller = "WebGalleryController";

//     public function exception_handler()
//     {
//         try {
            
//         } catch (\Exception $e) {
//             $e_method = "imageShowPath";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }
//     }

    public function imageShowPath($imagePath)
    {
        try {
            $l_act_image_path = Crypt::decrypt($imagePath);
            $storagePath = storage_path($l_act_image_path);          
            if(file_exists($storagePath)){
                $mimeType = mime_content_type($storagePath);
            }else{
                $storagePath = storage_path('app/blank.jpg');
                $mimeType = mime_content_type($storagePath);
            }
            $headers = array(
              'Content-Type' => $mimeType,
              'Content-Disposition' => 'inline; '
            );            
            return Response::make(file_get_contents($storagePath), 200, $headers);
        } catch (\Exception $e) {
            $e_method = "imageShowPath";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }        
    }

//     public function imageShowPath_withoutCrypt($imagePath)
//     {
//         try {
//             $l_act_image_path = $imagePath;
//             $storagePath = storage_path($l_act_image_path);          
//             $mimeType = mime_content_type($storagePath);
//             if( ! \File::exists($storagePath)){
//                 $storagePath = storage_path('app/blank.jpg');
//                 $mimeType = mime_content_type($storagePath);
//             }
//             $headers = array(
//               'Content-Type' => $mimeType,
//               'Content-Disposition' => 'inline; '
//             );            
//             return Response::make(file_get_contents($storagePath), 200, $headers);
//         } catch (\Exception $e) {
//             $e_method = "imageShowPath_withoutCrypt";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }        
//     }

//     public function ShowPdfFile($pdfFilePath)
//     {
//         try {
//             $l_act_file_path = Crypt::decrypt($pdfFilePath);
//             $storagePath = storage_path($l_act_file_path);          
//             if(file_exists($storagePath)){
//                 $mimeType = mime_content_type($storagePath);
//                 return response()->file($storagePath);
//             }else{
//                 return 'File Not Found';
//             }
//         } catch (\Exception $e) {
//             $e_method = "ShowPdfFile";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }        
//     }

//     public function ShowCertificatePdfFile($param)
//     {
//         try {
//             $temp_value = explode("-", Crypt::decrypt($param));
//             $storagePath = "Something Went Wrong";
//             if(count($temp_value)!=2){
//                 return view('error.fnf', compact('storagePath'));
//             }
//             $rec_id = intval($temp_value[0]);
//             $certificate_type = intval($temp_value[1]);
            
//             if($certificate_type == 1){         //Tuition Fee Certificate
//                 $rs_fetch = DB::select(DB::raw("SELECT `tc_file_path` as `storagePath`, `status` as `rec_status` from `cert_tution_fee` where `id` = $rec_id limit 1;"));
//             }elseif($certificate_type == 2){    //Children Education Allowance Certificate
//                 $rs_fetch = DB::select(DB::raw("SELECT `cea_file_path` as `storagePath`, `status` as `rec_status` from `cert_tution_fee` where `id` = $rec_id limit 1;"));
//             }elseif($certificate_type == 3){    //Character Certificate
//                 $rs_fetch = DB::select(DB::raw("SELECT `cc_file_path` as `storagePath`, `status` as `rec_status` from `cert_character` where `id` = $rec_id limit 1;"));
//             }elseif($certificate_type == 4){    //Character Certificate
//                 $rs_fetch = DB::select(DB::raw("SELECT `slc_file_path` as `storagePath`, `status` as `rec_status` from `cert_slc` where `id` = $rec_id limit 1;"));
//             }
//             if(count($rs_fetch) == 0){
//                 return view('error.fnf', compact('storagePath'));    
//             }

//             $storagePath = storage_path($rs_fetch[0]->storagePath);
//             $status = $rs_fetch[0]->rec_status;
//             if($status == 1){
//                 $storagePath = "Certificate Not Valid";
//                 return view('error.fnf', compact('storagePath'));   
//             }elseif($status == 3){
//                 $storagePath = "Certificate Cancelled By Authority";
//                 return view('error.fnf', compact('storagePath'));
//             }

//             if(file_exists($storagePath)){
//                 $mimeType = mime_content_type($storagePath);
//                 return response()->file($storagePath);
//             }else{
//                 $storagePath = "File Not Found";
//                 return view('error.fnf', compact('storagePath'));
//             }
//         } catch (\Exception $e) {
//             $e_method = "ShowCertificatePdfFile";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }        
//     }

//     public function bannerIndex()
//     {
//         try {
//             $rs_records = DB::select(DB::raw("SELECT * from `web_gallery` order by `display_order`;"));
//             $rs_school_detail = WebHelper::getSchoolDetail(1);
//             $banner_size = $rs_school_detail[0]->banner_size;
//             return view('admin.webgallery.banner.index',compact('rs_records', 'banner_size'));
//         } catch (\Exception $e) {
//             $e_method = "bannerIndex";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }
//     }

//     public function bannerForm($rec_id)
//     {
//         try {
//             $permission_flag = MyFuncs::isPermission_route(705);
//             if(!$permission_flag){
//                 return view('admin.common.error_popup');
//             }
//             $rec_id = intval(Crypt::decrypt($rec_id));
//             $rs_records = DB::select(DB::raw("SELECT * from `web_gallery` where `id` = $rec_id limit 1;"));
//             $rs_records = reset($rs_records);
//             return view('admin.webgallery.banner.form',compact('rs_records', 'rec_id'));
//         } catch (\Exception $e) {
//             $e_method = "bannerForm";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }
//     }

//     public function bannerStore(Request $request, $rec_id)
//     {  
//         try{
//             $permission_flag = MyFuncs::isPermission_route(705);
//             if(!$permission_flag){
//                 $response=['status'=>0,'msg'=>'Something Went Wrong'];
//                 return response()->json($response);
//             }

//             $rules=[
//                 'banner' => 'nullable|image|mimes:jpeg,jpg|max:700',
//             ];
//             $validator = Validator::make($request->all(),$rules);
//             if ($validator->fails()) {
//                 $errors = $validator->errors()->all();
//                 $response=array();
//                 $response["status"]=0;
//                 $response["msg"]=$errors[0];
//                 return response()->json($response);// response as json
//             }
//             $rec_id =Crypt::decrypt($rec_id);

//             $description = MyFuncs::removeSpacialChr_editor($request->description);
//             $description_l = MyFuncs::removeSpacialChr_editor($request->description_l);
//             $display_order = intval(MyFuncs::removeSpacialChr($request->display_order));
//             $status = intval($request->status);
//             if($display_order > 99){
//                 $display_order = 99;
//             }
//             if($status > 1){
//                 $status = 1;
//             }

//             $file_name = '';
//             $rs_fetch = DB::select(DB::raw("SELECT * from `web_gallery` where `id` = $rec_id limit 1;"));
//             if(count($rs_fetch) > 0){
//                 $file_name = $rs_fetch[0]->image;    
//             }
            

//             if ($request->hasFile('banner')){
//                 $imageFile = $request->banner; 
//                 if($file_name == ''){
//                     $file_name = time().'.jpg';    
//                 }
//                 $folder_name = 'banner';
//                 $imageFile->storeAs($folder_name,$file_name);
//             }

//             if ($rec_id == 0) {
//                 $rs_insert = DB::select(DB::raw("INSERT into `web_gallery` (`category_id`, `image`, `description`, `description_l`, `display_order`, `status`) values (0, '$file_name', '$description', '$description_l', '$display_order', '$status');"));
//                 $response=['status'=>1,'msg'=>'Banner Saved Successfully'];
//             }else{
//                 $rs_update = DB::select(DB::raw("UPDATE `web_gallery` set `image` = '$file_name', `description` = '$description', `description_l` = '$description_l', `display_order` = '$display_order', `status` = '$status' where `id` = $rec_id limit 1;"));
//                 $response=['status'=>1,'msg'=>'Banner Updated Successfully'];
//             }
            
//             return response()->json($response);
//         } catch (\Exception $e) {
//             $e_method = "bannerStore";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }
//     }

//     public function delete($rec_id)
//     { 
//         try {

//             $permission_flag = MyFuncs::isPermission_route(705);
//             if(!$permission_flag){
//                 $response=['status'=>0,'msg'=>'Something Went Wrong'];
//                 return response()->json($response);
//             }

//             $rec_id = intval(Crypt::decrypt($rec_id));
            
//             $rs_delete = DB::select(DB::raw("DELETE from `web_gallery` where `id` = $rec_id;"));
//             WebHelper::db_update_date_time();

//             return  redirect()->back()->with(['message'=>'Deleted Successfully','class'=>'success']);
//         } catch (\Exception $e) {
//             $e_method = "delete";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }
//     }

// // //features

//     public function featuresIndex()
//     {
//         try {
//             $rs_records = DB::select(DB::raw("SELECT `ft`.`id`, `ft`.`title`, `ft`.`title_l`, `ft`.`sub_title`, `ft`.`sub_title_l`, `it`.`icon_name`, `it`.`icon`, `it`.`text_color`, `ft`.`display_order` from `features` `ft` inner join `icon_type` `it` on `it`.`id` = `ft`.`icon_id` order by `ft`.`display_order`;"));
//             return view('admin.webgallery.features.index',compact('rs_records'));
//         } catch (\Exception $e) {
//             $e_method = "featuresIndex";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }
            
//     }

//     public function featuresForm($rec_id)
//     {
//         try {
//             $permission_flag = MyFuncs::isPermission_route(706);
//             if(!$permission_flag){
//                 return view('admin.common.error_popup');
//             }
            
//             $rec_id = intval(Crypt::decrypt($rec_id));
//             $rs_icon_type = DB::select(DB::raw("SELECT `id`, `icon_name`, `icon`, `text_color` from `icon_type` order by `icon_name`;"));
//             $rs_records = DB::select(DB::raw("SELECT * from `features` where `id` = $rec_id limit 1;"));
//             $rs_records = reset($rs_records);
//             return view('admin.webgallery.features.form',compact('rs_records', 'rs_icon_type', 'rec_id'));    
//         } catch (\Exception $e) {
//             $e_method = "featuresForm";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }
//     }

//     public function featuresStore(Request $request, $rec_id)
//     { 
//         try {
//             // return $request;
//             $permission_flag = MyFuncs::isPermission_route(706);
//             if(!$permission_flag){
//                 $response=['status'=>0,'msg'=>'Something Went Wrong'];
//                 return response()->json($response);
//             }

//             $rec_id = intval(Crypt::decrypt($rec_id));
//             $title = substr(MyFuncs::removeSpacialChr($request->title), 0, 25);
//             $title_l = MyFuncs::removeSpacialChr($request->title_l);
//             $sub_title = substr(MyFuncs::removeSpacialChr($request->sub_title), 0, 100);
//             $sub_title_l = MyFuncs::removeSpacialChr($request->sub_title_l);
//             $display_order = intval(MyFuncs::removeSpacialChr($request->display_order));
//             if (!empty($request->icon)) {
//                 $icon = intval(Crypt::decrypt($request->icon));
//             }else{
//                 $icon = 0;
//             }

//             if($display_order > 50){
//                 $display_order = 50;
//             }
//             if($icon == 0 || $icon > 6){
//                 $icon = 1;
//             }

//             if ($rec_id == 0) {                
//                 $rs_save = DB::select(DB::raw("INSERT into `features` (`title`, `title_l`, `sub_title`, `sub_title_l`, `display_order`, `icon_id`) values ('$title', '$title_l', '$sub_title', '$sub_title_l', '$display_order', '$icon')"));
//                 $response=['status'=>1,'msg'=>'Saved Successfully'];
//             }else{
//                 $rs_save = DB::select(DB::raw("UPDATE `features` set `title` = '$title', `title_l` = '$title_l', `sub_title` = '$sub_title', `sub_title_l` = '$sub_title_l', `display_order` = '$display_order', `icon_id` = '$icon' where `id` = $rec_id limit 1;"));
//                 $response=['status'=>1,'msg'=>'Updated Successfully'];
//             }
//             WebHelper::db_update_date_time();
//             return response()->json($response);
//         } catch (\Exception $e) {
//             $e_method = "featuresStore";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }
//     }

//     public function featuresDelete($rec_id)
//     {  
//         try {
//             $permission_flag = MyFuncs::isPermission_route(706);
//             if(!$permission_flag){
//                 $response=['status'=>0,'msg'=>'Something Went Wrong'];
//                 return response()->json($response);
//             }
//             $rec_id = intval(Crypt::decrypt($rec_id));
//             $rs_delete = DB::select(DB::raw("DELETE from `features` where `id` = $rec_id limit 1;"));
//             WebHelper::db_update_date_time();
//             return  redirect()->back()->with(['message'=>'Deleted Successfully','class'=>'success']);
//         } catch (\Exception $e) {
//             $e_method = "featuresDelete";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }
            
//     }

// // //features-detail
//     public function featuresDetailIndex()
//     {
//         try {
//             $rs_records = DB::select(DB::raw("SELECT `fd`.`id`, `f`.`title`, `fd`.`image`, `fd`.`description`, `fd`.`description_l` from `features_detail` `fd` inner join `features` `f` on `f`.`id` = `fd`.`features_id` order by `f`.`display_order`, `fd`.`id`;"));
//             return view('admin.webgallery.features.detail_index',compact('rs_records'));
//         } catch (\Exception $e) {
//             $e_method = "featuresDetailIndex";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }
            
//     }

//     public function featuresDetailForm($rec_id)
//     {
//         try {

//             $permission_flag = MyFuncs::isPermission_route(707);
//             if(!$permission_flag){
//                 return view('admin.common.error_popup');
//             }

//             $rec_id = intval(Crypt::decrypt($rec_id));
//             $rs_features = DB::select(DB::raw("SELECT * from `features` order by `title`;"));
//             $rs_records = DB::select(DB::raw("SELECT * from `features_detail` where `id` = $rec_id limit 1;"));
//             $rs_records = reset($rs_records);
//             return view('admin.webgallery.features.detail_form',compact('rs_records', 'rs_features', 'rec_id'));
//         } catch (\Exception $e) {
//             $e_method = "featuresDetailForm";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }
//     }

//     public function featuresDetailStore(Request $request, $rec_id)
//     {
//         try {
            
//             $permission_flag = MyFuncs::isPermission_route(707);
//             if(!$permission_flag){
//                 $response=['status'=>0,'msg'=>'Something Went Wrong'];
//                 return response()->json($response);
//             }
            
//             $rules=[ 
//               'features_id' => 'required',
//               'image' => 'nullable|image|mimes:jpeg,jpg|max:500',
//             ];
//             $customMessages = [
//                 'features_id.required'=> 'Please Select Feature',
//             ]; 
//             $validator = Validator::make($request->all(),$rules);
//             if ($validator->fails()) {
//               $errors = $validator->errors()->all();
//               $response=array();
//               $response["status"]=0;
//               $response["msg"]=$errors[0];
//               return response()->json($response);// response as json
//             }

//             $rec_id = intval(Crypt::decrypt($rec_id));

//             $file_name = '';
//             $rs_fetch = DB::select(DB::raw("SELECT * from `features_detail` where `id` = $rec_id limit 1;"));
//             if(count($rs_fetch) > 0){
//                 $file_name = $rs_fetch[0]->image;    
//             }
            

//             if ($request->hasFile('image')){
//                 $imageFile = $request->image; 
//                 if($file_name == ''){
//                     $file_name = time().'.jpg';    
//                 }
//                 $folder_name = 'website/feature_detail';
//                 $imageFile->storeAs($folder_name,$file_name);
//             }

//             $features_id = intval(Crypt::decrypt($request->features_id));
//             if($features_id == 0){
//                 $response=['status'=>1,'msg'=>'Please Select Feature'];
//                 return response()->json($response);    
//             }
//             $description = MyFuncs::removeSpacialChr_editor($request->description);
//             $description_l = MyFuncs::removeSpacialChr_editor($request->description_l);
            
//             if ($rec_id == 0) {
//                 $rs_save = DB::select(DB::raw("INSERT into `features_detail` (`features_id`, `image`, `description`, `description_l`) values ($features_id, '$file_name', '$description', '$description_l')"));
//                 $response=['status'=>1,'msg'=>'Saved Successfully'];
//             }else{
//                 $rs_save = DB::select(DB::raw("UPDATE `features_detail` set `features_id` = $features_id, `image` = '$file_name', `description` = '$description', `description_l` = '$description_l' where `id` = $rec_id limit 1;"));
//                 $response=['status'=>1,'msg'=>'Updated Successfully'];
//             }
//             WebHelper::db_update_date_time();
//             return response()->json($response);
//         } catch (\Exception $e) {
//             $e_method = "featuresDetailStore";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }  
//     }

//     public function featuresDetailDelete($rec_id)
//     { 
//         try {
//             $permission_flag = MyFuncs::isPermission_route(707);
//             if(!$permission_flag){
//                 $response=['status'=>0,'msg'=>'Something Went Wrong'];
//                 return response()->json($response);
//             }
//             $rec_id = intval(Crypt::decrypt($rec_id));
//             $rs_delete = DB::select(DB::raw("DELETE from `features_detail` where `id` = $rec_id limit 1;"));
//             WebHelper::db_update_date_time();
//             return  redirect()->back()->with(['message'=>'Deleted Successfully','class'=>'success']);
//         } catch (\Exception $e) {
//             $e_method = "featuresDetailDelete";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }
//     }

// // //infrastructure

//     public function infrastructureIndex()
//     {
//         try {
//             $rs_records = DB::select(DB::raw("SELECT `ifr`.`id`, `ifr`.`image`, `ifr`.`title`, `ifr`.`title_l`, `ifr`.`sub_title`, `ifr`.`sub_title_l`, `it`.`text_color_name`, `ifr`.`display_order` from `infrastructure` `ifr` inner join `icon_type` `it` on `it`.`id` = `ifr`.`text_color` order by `ifr`.`display_order`;"));
//             return view('admin.webgallery.infrastructure.index',compact('rs_records'));   
//         } catch (\Exception $e) {
//             $e_method = "infrastructureIndex";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }
//     }

//     public function infrastructureForm($rec_id)
//     {   
//         try {
//             $permission_flag = MyFuncs::isPermission_route(708);
//             if(!$permission_flag){
//                 return view('admin.common.error_popup');
//             }

//             $rec_id = intval(Crypt::decrypt($rec_id));
//             $rs_icon_type = DB::select(DB::raw("SELECT `id`, `text_color_name` from `icon_type` order by `text_color_name`;"));
//             $rs_records = DB::select(DB::raw("SELECT * from `infrastructure` where `id` = $rec_id limit 1;"));
//             $rs_records = reset($rs_records);
//             return view('admin.webgallery.infrastructure.form',compact('rs_records', 'rs_icon_type', 'rec_id'));
//         } catch (\Exception $e) {
//             $e_method = "infrastructureForm";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }
//     }

//     public function infrastructureStore(Request $request, $rec_id)
//     {
//         try {
//             $permission_flag = MyFuncs::isPermission_route(708);
//             if(!$permission_flag){
//                 $response=['status'=>0,'msg'=>'Something Went Wrong'];
//                 return response()->json($response);
//             }

//             $rules=[ 
//               'image' => 'nullable|image|mimes:jpeg,jpg|max:500',
//             ];
//             $validator = Validator::make($request->all(),$rules);
//             if ($validator->fails()) {
//               $errors = $validator->errors()->all();
//               $response=array();
//               $response["status"]=0;
//               $response["msg"]=$errors[0];
//               return response()->json($response);// response as json
//             }


//             $rec_id = intval(Crypt::decrypt($rec_id));
//             $title = substr(MyFuncs::removeSpacialChr($request->title), 0, 25);
//             $title_l = substr(MyFuncs::removeSpacialChr($request->title_l), 0, 25);
//             $sub_title = substr(MyFuncs::removeSpacialChr($request->sub_title), 0, 100);
//             $sub_title_l = substr(MyFuncs::removeSpacialChr($request->sub_title_l), 0, 100);
//             $display_order = intval(MyFuncs::removeSpacialChr($request->display_order));
//             $text_color_l = intval(Crypt::decrypt($request->text_color));

//             if($display_order > 999){
//                 $display_order = 999;
//             }
//             if($text_color_l>6){
//                 $text_color_l = 6;
//             }
//             if($text_color_l==0){
//                 $text_color_l = 1;
//             }

//             $file_name = '';
//             $rs_fetch = DB::select(DB::raw("SELECT `image` from `infrastructure` where `id` = $rec_id limit 1;"));
//             if(count($rs_fetch) > 0){
//                 $file_name = $rs_fetch[0]->image;    
//             }

//             if ($request->hasFile('image')){
//                 $imageFile = $request->image; 
//                 if($file_name == ''){
//                     $file_name = time().'.jpg';    
//                 }
//                 $folder_name = 'website/infrastructure';
//                 $imageFile->storeAs($folder_name,$file_name);
//             }

//             if ($rec_id == 0) {
//                 $query = "INSERT into `infrastructure` (`image`, `title`, `title_l`, `sub_title`, `sub_title_l`, `display_order`, `text_color`) values ('$file_name', '$title', '$title_l', '$sub_title', '$sub_title_l', '$display_order', '$text_color_l');";
                
//                 $response=['status'=>1,'msg'=>'Saved Successfully'];
//             }else{
//                 $query = "UPDATE `infrastructure` set `image` = '$file_name', `title` = '$title', `title_l` = '$title_l', `sub_title` = '$sub_title', `sub_title_l` = '$sub_title_l', `display_order` = '$display_order', `text_color` = '$text_color_l' where `id` = $rec_id limit 1;";
//                 $response=['status'=>1,'msg'=>'Updated Successfully'];
//             }
//             $rs_save = DB::select(DB::raw($query));

//             $userid = MyFuncs::getUserId();
//             $from_ip = MyFuncs::getIp();
//             $sub_menu_id = 708;
//             $log_insert = MyFuncs::create_log_query($query, $userid, $from_ip, $sub_menu_id);

//             WebHelper::db_update_date_time();
//             return response()->json($response);
            
//         } catch (\Exception $e) {
//             $e_method = "infrastructureStore";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         } 
         
//     }

//     public function infrastructureDelete($rec_id)
//     { 
//         try {
//             $permission_flag = MyFuncs::isPermission_route(708);
//             if(!$permission_flag){
//                 $response=['status'=>0,'msg'=>'Something Went Wrong'];
//                 return response()->json($response);
//             }
//             $rec_id = intval(Crypt::decrypt($rec_id));
//             $rs_delete = DB::select(DB::raw("DELETE from `infrastructure` where `id` = $rec_id limit 1;"));
//             WebHelper::db_update_date_time();
//             return  redirect()->back()->with(['message'=>'Deleted Successfully','class'=>'success']);
//         } catch (\Exception $e) {
//             $e_method = "infrastructureDelete";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         } 
        
        
//     }
    
// // //teacher

// //     public function teacherIndex()
// //     {
// //         $rs_records = DB::select(DB::raw("SELECT * from `teacher` order by `id`;"));
// //         return view('admin.webgallery.teacher.index',compact('rs_records'));
// //     }

// //     public function teacherForm($rec_id)
// //     {   
// //         $rec_id = Crypt::decrypt($rec_id);
// //         $rs_icon_type = DB::select(DB::raw("SELECT * from `icon_type`;"));
// //         if ($rec_id!= 0) {
// //             $rs_records = DB::select(DB::raw("SELECT * from `teacher` where `id` = $rec_id limit 1;"));
// //             $rs_records = reset($rs_records);
// //         }else { 
// //             $rs_records = ''; 
// //         }
// //         return view('admin.webgallery.teacher.form',compact('rs_records', 'rs_icon_type'));
// //     }

// //     public function teacherStore(Request $request, $rec_id)
// //     {  
// //         $rec_id =Crypt::decrypt($rec_id);
// //         if ($rec_id == 0) {
// //             if ($request->hasFile('image')) { 
// //                 $imageFile = $request->image;
// //                 $imageName = time().'.jpg';
// //                 $imageFile->move(public_path('teacher'),$imageName);
// //                 $imageName = "teacher/".time().'.jpg';
// //                 $name = MyFuncs::removeSpacialChr($request->name);
// //                 $name_l = MyFuncs::removeSpacialChr($request->name_l);
// //                 $subject = MyFuncs::removeSpacialChr($request->subject);
// //                 $subject_l = MyFuncs::removeSpacialChr($request->subject_l);
// //                 $description = MyFuncs::removeSpacialChr($request->description);
// //                 $description_l = MyFuncs::removeSpacialChr($request->description_l);
// //                 $display_order = intval(MyFuncs::removeSpacialChr($request->display_order));
// //                 $text_color = intval($request->text_color);
// //                 $rs_save = DB::select(DB::raw("insert into `teacher` (`image`, `name`, `name_l`, `subject`, `subject_l`, `description`, `description_l`, `display_order`, `text_color`) values ('$imageName', '$name', '$name_l', '$subject', '$subject_l', '$description', '$description_l', '$display_order', '$text_color')"));
// //             }
// //         }else{
// //             if ($request->hasFile('image')) { 
// //                 $imageFile = $request->image;
// //                 $imageName = time().'.jpg';
// //                 $imageFile->move(public_path('teacher'),$imageName);
// //                 $imageName = "teacher/".time().'.jpg'; 
// //             }else{
// //                 $rs_fatch = DB::select(DB::raw("SELECT * from `teacher` where `id` = $rec_id limit 1;"));
// //                 $imageName = $rs_fatch[0]->image;   
// //             }
// //             $name = MyFuncs::removeSpacialChr($request->name);
// //             $name_l = MyFuncs::removeSpacialChr($request->name_l);
// //             $subject = MyFuncs::removeSpacialChr($request->subject);
// //             $subject_l = MyFuncs::removeSpacialChr($request->subject_l);
// //             $description = MyFuncs::removeSpacialChr($request->description);
// //             $description_l = MyFuncs::removeSpacialChr($request->description_l);
// //             $display_order = intval(MyFuncs::removeSpacialChr($request->display_order));
// //             $text_color = intval($request->text_color);
// //             $rs_save = DB::select(DB::raw("UPDATE `teacher` set `image` = '$imageName', `name` = '$name', `name_l` = '$name_l', `subject` = '$subject', `subject_l` = '$subject_l', `description` = '$description', `description_l` = '$description_l', `display_order` = '$display_order', `text_color` = '$text_color' where `id` = $rec_id limit 1;"));
// //         }
// //         WebHelper::db_update_date_time();
// //         $response=['status'=>1,'msg'=>'Save Successfully'];
// //         return response()->json($response);
         
// //     }

// //     public function teacherDelete($rec_id)
// //     {  
// //         $rec_id =Crypt::decrypt($rec_id);
// //         $rs_fetch = DB::select(DB::raw("select * from `teacher` where `id` = $rec_id limit 1;"));
// //         $imageName = '';
// //         if (count($rs_fetch) > 0) {

// //            $imageName = $rs_fetch[0]->image;
// //         }

// //         $imagePath = public_path($imageName);

// //         if (File::exists($imagePath)) {
// //             File::delete($imagePath);
// //         }
// //         $rs_delete = DB::select(DB::raw("delete from `teacher` where `id` = $rec_id;"));
// //         WebHelper::db_update_date_time();
// //         return  redirect()->back()->with(['message'=>'Deleted Successfully','class'=>'success']);
// //     }

// // //gallery

//     public function galleryIndex()
//     {
//         try {
//             $rs_records = DB::select(DB::raw("SELECT * from `gallery` order by `display_order`;"));
//             return view('admin.webgallery.gallery.index',compact('rs_records'));    
//         } catch (\Exception $e) {
//             $e_method = "galleryIndex";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }
//     }

//     public function galleryForm($rec_id)
//     {   
//         try {
//             $permission_flag = MyFuncs::isPermission_route(709);
//             if(!$permission_flag){
//                 return view('admin.common.error_popup');
//             }

//             $rec_id = intval(Crypt::decrypt($rec_id));
//             $rs_records = DB::select(DB::raw("SELECT * from `gallery` where `id` = $rec_id limit 1;"));
//             $rs_records = reset($rs_records);
//             return view('admin.webgallery.gallery.form',compact('rs_records', 'rec_id'));
//         } catch (\Exception $e) {
//             $e_method = "galleryForm";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }
//     }

//     public function galleryStore(Request $request, $rec_id)
//     {
//         try {
//             $permission_flag = MyFuncs::isPermission_route(709);
//             if(!$permission_flag){
//                 $response=['status'=>0,'msg'=>'Something Went Wrong'];
//                 return response()->json($response);
//             }

//             $rules=[ 
//               'image' => 'nullable|image|mimes:jpeg,jpg|max:500',
//             ];
//             $validator = Validator::make($request->all(),$rules);
//             if ($validator->fails()) {
//               $errors = $validator->errors()->all();
//               $response=array();
//               $response["status"]=0;
//               $response["msg"]=$errors[0];
//               return response()->json($response);// response as json
//             }


//             $rec_id = intval(Crypt::decrypt($rec_id));
//             $title = substr(MyFuncs::removeSpacialChr($request->title), 0, 50);
//             $title_l = substr(MyFuncs::removeSpacialChr($request->title_l), 0, 50);
//             $display_order = intval(MyFuncs::removeSpacialChr($request->display_order));
            
//             if($display_order > 999){
//                 $display_order = 999;
//             }
            
//             $file_name = '';
//             $rs_fetch = DB::select(DB::raw("SELECT `image` from `gallery` where `id` = $rec_id limit 1;"));
//             if(count($rs_fetch) > 0){
//                 $file_name = $rs_fetch[0]->image;    
//             }

//             if ($request->hasFile('image')){
//                 $imageFile = $request->image; 
//                 if($file_name == ''){
//                     $file_name = time().'.jpg';    
//                 }
//                 $folder_name = 'website/gallery';
//                 $imageFile->storeAs($folder_name,$file_name);
//             }

//             if ($rec_id == 0) {
//                 $rs_save = DB::select(DB::raw("INSERT into `gallery` (`image`, `title`, `title_l`, `display_order`) values ('$file_name', '$title', '$title_l', '$display_order');"));
//                 $response=['status'=>1,'msg'=>'Saved Successfully'];
//             }else{
//                 $rs_save = DB::select(DB::raw("UPDATE `gallery` set `image` = '$file_name', `title` = '$title', `title_l` = '$title_l', `display_order` = '$display_order' where `id` = $rec_id limit 1;"));
//                 $response=['status'=>1,'msg'=>'Updated Successfully'];
//             }
//             WebHelper::db_update_date_time();
//             return response()->json($response);
            
//         } catch (\Exception $e) {
//             $e_method = "galleryStore";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         } 
         
//     }

//     public function galleryDelete($rec_id)
//     { 
//         try {
//             $permission_flag = MyFuncs::isPermission_route(709);
//             if(!$permission_flag){
//                 $response=['status'=>0,'msg'=>'Something Went Wrong'];
//                 return response()->json($response);
//             }
//             $rec_id = intval(Crypt::decrypt($rec_id));
//             $rs_delete = DB::select(DB::raw("DELETE from `gallery` where `id` = $rec_id limit 1;"));
//             WebHelper::db_update_date_time();
//             return  redirect()->back()->with(['message'=>'Deleted Successfully','class'=>'success']);
//         } catch (\Exception $e) {
//             $e_method = "galleryDelete";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }        
//     }

// // //video

//     public function videoIndex()
//     {
//         try {
//             $rs_records = DB::select(DB::raw("SELECT `wb`.`id` as `rec_id`, `vt`.`id` as `v_type_id`, `vt`.`name`, `wb`.`title_e`, `wb`.`title_l`, `wb`.`video_path` from `web_video` `wb` inner join `video_types` `vt` on `vt`.`id` = `wb`.`video_type_id` where `status` = 1 order by `wb`.`id` desc;"));
//             return view('admin.webgallery.gallery.video_index',compact('rs_records'));    
//         } catch (Exception $e) {
//             $e_method = "videoIndex";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }
//     }

//     public function videoForm()
//     {   
//         try {
//             $permission_flag = MyFuncs::isPermission_route(709);
//             if(!$permission_flag){
//                 return view('admin.common.error_popup');
//             }
//             $rs_video_cats = DB::select(DB::raw("SELECT * from `video_types`;"));
//             return view('admin.webgallery.gallery.video_form',compact('rs_video_cats'));
//         } catch (\Exception $e) {
//             $e_method = "videoForm";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }
//     }

//     public function videoStore(Request $request)
//     {
//         try {
//             $permission_flag = MyFuncs::isPermission_route(709);
//             if(!$permission_flag){
//                 $response=['status'=>0,'msg'=>'Something Went Wrong'];
//                 return response()->json($response);
//             }

//             $rules=[ 
//                 'category' => 'required',
//                 'video' => 'required|mimes:mp4,mov,avi,wmv|max:102400', // max 100MB
//             ];
//             $validator = Validator::make($request->all(),$rules);
//             if ($validator->fails()) {
//               $errors = $validator->errors()->all();
//               $response=array();
//               $response["status"]=0;
//               $response["msg"]=$errors[0];
//               return response()->json($response);// response as json
//             }
//             $category = intval(Crypt::decrypt($request->category));
//             $title = substr(MyFuncs::removeSpacialChr($request->title), 0, 50);
//             $title_l = substr(MyFuncs::removeSpacialChr($request->title_l), 0, 50);

//             $final_path_video = '';
//             if ($request->hasFile('video')) {

//                 $video = $request->video;          

//                 $extension = $video->getClientOriginalExtension();

//                 // Create unique filename with extension
//                 $filename = time().'.'.$extension;

//                 $folder_path = 'website/gallery/video/';

//                 $final_path_video = $folder_path . '/' . $filename;

//                 $video->storeAs($folder_path, $filename);
//             }
            
//             $rs_save = DB::select(DB::raw("INSERT into `web_video` (`video_type_id`, `title_e`, `title_l`, `video_path`) values ('$category', '$title', '$title_l', '$final_path_video');"));
            
//             WebHelper::db_update_date_time();
//             $response=['status'=>1,'msg'=>'Saved Successfully'];
//             return response()->json($response);
            
//         } catch (\Exception $e) {
//             $e_method = "videoStore";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         } 
         
//     }

//     public function videoDelete($rec_id)
//     {
//         try {
//             $rec_id = intval(Crypt::decrypt($rec_id));
//             $rs_fetch = DB::select("SELECT * FROM `web_video` WHERE `id` = ? LIMIT 1", [$rec_id]);

//             if (count($rs_fetch) > 0) {
//                 $filepath = storage_path("app/" . $rs_fetch[0]->video_path);

//                 if (file_exists($filepath)) {
//                     unlink($filepath); // native delete
//                 }

//                 // FIX: use DB::delete instead of DB::select
//                 DB::delete("DELETE FROM `web_video` WHERE `id` = ? LIMIT 1", [$rec_id]);

//                 return redirect()->back()->with(['message' => 'Video deleted successfully', 'class' => 'success']);
//             } else {
//                 return redirect()->back()->with(['message' => 'Video not found', 'class' => 'error']);
//             }

//         } catch (\Exception $e) {
//             $e_method = "videoDelete";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }
//     }



// // //event
//     public function eventIndex()
//     {
//         try {
//             $rs_records = DB::select(DB::raw("SELECT `wpe`.`id`, `wpe`.`image`, `wpe`.`title`, `wpe`.`title_l`, `wpe`.`sub_title`, `wpe`.`sub_title_l`, `wpe`.`description`, `wpe`.`description_l`, `wpe`.`date`, `wpe`.`time`, `wpe`.`display_order`, `it`.`text_color_name` from `web_page_event` `wpe` inner join `icon_type` `it` on `it`.`id` = `wpe`.`text_color` order by `wpe`.`display_order`;"));
//             return view('admin.webgallery.event.index',compact('rs_records'));
//         } catch (\Exception $e) {
//             $e_method = "eventIndex";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }
//     }

//     public function eventForm($rec_id)
//     {   
//         try {
//             $permission_flag = MyFuncs::isPermission_route(710);
//             if(!$permission_flag){
//                 return view('admin.common.error_popup');
//             }

//             $rec_id = intval(Crypt::decrypt($rec_id));
//             $rs_icon_type = DB::select(DB::raw("SELECT `id`, `text_color_name` from `icon_type` `it` order by `it`.`text_color_name`;"));
//             $rs_records = DB::select(DB::raw("SELECT * from `web_page_event` where `id` = $rec_id limit 1;"));
//             $rs_records = reset($rs_records);
//             return view('admin.webgallery.event.form',compact('rs_records', 'rs_icon_type', 'rec_id'));
//         } catch (\Exception $e) {
//             $e_method = "eventForm";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }
//     }

//     public function eventStore(Request $request, $rec_id)
//     {
//         try {
//             $permission_flag = MyFuncs::isPermission_route(710);
//             if(!$permission_flag){
//                 $response=['status'=>0,'msg'=>'Something Went Wrong'];
//                 return response()->json($response);
//             }

//             $rules=[ 
//               'image' => 'nullable|image|mimes:jpeg,jpg|max:500',
//               'text_color' => 'required',
//             ];
            
//             $customMessages = [
//                 'image.image'=> 'Something Went Wrong - 01',
//                 'image.mimes'=> 'Something Went Wrong - 02',
//                 'image.max'=> 'Maximum Size of Image is 500 KB',

//                 'text_color.required'=> 'Please Select Text Color',
//             ];

//             $validator = Validator::make($request->all(),$rules, $customMessages);
//             if ($validator->fails()) {
//               $errors = $validator->errors()->all();
//               $response=array();
//               $response["status"]=0;
//               $response["msg"]=$errors[0];
//               return response()->json($response);// response as json
//             }


//             $rec_id = intval(Crypt::decrypt($rec_id));
//             $title = substr(MyFuncs::removeSpacialChr($request->title), 0, 25);
//             $title_l = substr(MyFuncs::removeSpacialChr($request->title_l), 0, 25);
//             $sub_title = substr(MyFuncs::removeSpacialChr($request->sub_title), 0, 100);
//             $sub_title_l = substr(MyFuncs::removeSpacialChr($request->sub_title_l), 0, 100);
//             $description = MyFuncs::removeSpacialChr_editor($request->description);
//             $description_l = MyFuncs::removeSpacialChr_editor($request->description_l);
//             $date = substr(MyFuncs::removeSpacialChr($request->date), 0, 20);
//             $time = substr(MyFuncs::removeSpacialChr($request->time), 0, 20);
//             $display_order = intval(MyFuncs::removeSpacialChr($request->display_order));
//             $text_color_l = intval(Crypt::decrypt($request->text_color));

//             if($display_order > 999){
//                 $display_order = 999;
//             }
//             if($text_color_l>6){
//                 $text_color_l = 6;
//             }
//             if($text_color_l==0){
//                 $text_color_l = 1;
//             }

//             $file_name = '';
//             $rs_fetch = DB::select(DB::raw("SELECT `image` from `web_page_event` where `id` = $rec_id limit 1;"));
//             if(count($rs_fetch) > 0){
//                 $file_name = $rs_fetch[0]->image;    
//             }

//             if ($request->hasFile('image')){
//                 $imageFile = $request->image; 
//                 if($file_name == ''){
//                     $file_name = time().'.jpg';    
//                 }
//                 $folder_name = 'website/events';
//                 $imageFile->storeAs($folder_name,$file_name);
//             }

//             if ($rec_id == 0) {
//                 $rs_save = DB::select(DB::raw("INSERT into `web_page_event` (`image`, `title`, `title_l`, `sub_title`, `sub_title_l`, `description`, `description_l`, `date`, `time`, `display_order`, `text_color`) values ('$file_name', '$title', '$title_l', '$sub_title', '$sub_title_l', '$description', '$description_l', '$date', '$time', '$display_order', '$text_color_l')"));
//                 $response=['status'=>1,'msg'=>'Saved Successfully'];
//             }else{
//                 $rs_save = DB::select(DB::raw("UPDATE `web_page_event` set `image` = '$file_name', `title` = '$title', `title_l` = '$title_l', `sub_title` = '$sub_title', `sub_title_l` = '$sub_title_l', `description` = '$description', `description_l` = '$description_l', `date` = '$date', `time` = '$time', `display_order` = '$display_order', `text_color` = '$text_color_l' where `id` = $rec_id limit 1;"));
//                 $response=['status'=>1,'msg'=>'Updated Successfully'];
//             }
//             WebHelper::db_update_date_time();
//             return response()->json($response);
            
//         } catch (\Exception $e) {
//             $e_method = "eventStore";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }
         
//     }

//     public function eventDelete($rec_id)
//     { 
//         try {
//             $permission_flag = MyFuncs::isPermission_route(709);
//             if(!$permission_flag){
//                 $response=['status'=>0,'msg'=>'Something Went Wrong'];
//                 return response()->json($response);
//             }
//             $rec_id = intval(Crypt::decrypt($rec_id));
//             $rs_delete = DB::select(DB::raw("DELETE from `web_page_event` where `id` = $rec_id limit 1;"));
//             WebHelper::db_update_date_time();
//             return  redirect()->back()->with(['message'=>'Deleted Successfully','class'=>'success']);
//         } catch (\Exception $e) {
//             $e_method = "eventDelete";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }  
//     }

// // //about-us
//     public function aboutIndex()
//     {
//         try {
//             $rs_records = DB::select(DB::raw("SELECT * from `web_page_about` limit 1;"));
//             $rec_id = 0;
//             if(count($rs_records) > 0){
//                 $rec_id = $rs_records[0]->id;
//             }
//             return view('admin.webgallery.about.index',compact('rs_records', 'rec_id'));    
//         } catch (\Exception $e) {
//             $e_method = "aboutIndex";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }
        
//     }

//     public function aboutStore(Request $request)
//     {
//         try {
//             $permission_flag = MyFuncs::isPermission_route(711);
//             if(!$permission_flag){
//                 $response=['status'=>0,'msg'=>'Something Went Wrong'];
//                 return response()->json($response);
//             }

//             $rules=[ 
//               'image' => 'nullable|image|mimes:jpeg,jpg|max:500',
//             ];
//             $validator = Validator::make($request->all(),$rules);
//             if ($validator->fails()) {
//               $errors = $validator->errors()->all();
//               $response=array();
//               $response["status"]=0;
//               $response["msg"]=$errors[0];
//               return response()->json($response);// response as json
//             }


//             $description = MyFuncs::removeSpacialChr_editor($request->description);
//             $description_l = MyFuncs::removeSpacialChr_editor($request->description_l);
            
//             $file_name = '';
//             $rs_fetch = DB::select(DB::raw("SELECT `image` from `web_page_about` limit 1;"));
//             if(count($rs_fetch) > 0){
//                 $file_name = $rs_fetch[0]->image;    
//             }

//             if ($request->hasFile('image')){
//                 $imageFile = $request->image; 
//                 if($file_name == ''){
//                     $file_name = time().'.jpg';    
//                 }
//                 $folder_name = 'website/aboutus';
//                 $imageFile->storeAs($folder_name,$file_name);
//             }

//             $rs_fetch = DB::select(DB::raw("SELECT * from `web_page_about`;"));
//             if(count($rs_fetch) > 0){
//                 $rs_save = DB::select(DB::raw("UPDATE `web_page_about` set `image` = '$file_name', `description` = '$description', `description_l` = '$description_l' limit 1;"));
//             }else{
//                 $rs_save = DB::select(DB::raw("INSERT into `web_page_about` (`image`, `description`, `description_l`) values ('$file_name', '$description', '$description_l')"));
//             }
            
//             WebHelper::db_update_date_time();
//             return  redirect()->back()->with(['message'=>'Saved Successfully','class'=>'success']);     
//         } catch (\Exception $e) {
//             $e_method = "aboutStore";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }
//     }

// // //facts
//     public function factsIndex()
//     {
//         try {
//             $rs_records = DB::select(DB::raw("SELECT * from `web_page_facts` limit 1;"));
//             return view('admin.webgallery.facts.index',compact('rs_records'));   
//         } catch (\Exception $e) {
//             $e_method = "factsIndex";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }
//     }

//     public function factsStore(Request $request)
//     {  
//         try {
//             $permission_flag = MyFuncs::isPermission_route(712);
//             if(!$permission_flag){
//                 $response=['status'=>0,'msg'=>'Something Went Wrong'];
//                 return response()->json($response);
//             }

//             $title = substr(MyFuncs::removeSpacialChr($request->title), 0, 50);
//             $title_l = substr(MyFuncs::removeSpacialChr($request->title_l), 0, 50);
//             $sub_title = substr(MyFuncs::removeSpacialChr($request->sub_title), 0, 100);
//             $sub_title_l = substr(MyFuncs::removeSpacialChr($request->sub_title_l), 0, 100);
            
//             $caption_1 = substr(MyFuncs::removeSpacialChr($request->caption_1), 0, 20);
//             $caption_1_l = substr(MyFuncs::removeSpacialChr($request->caption_1_l), 0, 20);
//             $caption_2 = substr(MyFuncs::removeSpacialChr($request->caption_2), 0, 20);
//             $caption_2_l = substr(MyFuncs::removeSpacialChr($request->caption_2_l), 0, 20);
//             $caption_3 = substr(MyFuncs::removeSpacialChr($request->caption_3), 0, 20);
//             $caption_3_l = substr(MyFuncs::removeSpacialChr($request->caption_3_l), 0, 20);
//             $caption_4 = substr(MyFuncs::removeSpacialChr($request->caption_4), 0, 20);
//             $caption_4_l = substr(MyFuncs::removeSpacialChr($request->caption_4_l), 0, 20);
            
//             $values_1 = intval(MyFuncs::removeSpacialChr($request->value_1));
//             if($values_1 > 9999){
//                 $values_1 = 9999;
//             }
//             $values_2 = intval(MyFuncs::removeSpacialChr($request->value_2));
//             if($values_2 > 9999){
//                 $values_2 = 9999;
//             }
//             $values_3 = intval(MyFuncs::removeSpacialChr($request->value_3));
//             if($values_3 > 9999){
//                 $values_3 = 9999;
//             }
//             $values_4 = intval(MyFuncs::removeSpacialChr($request->value_4));
//             if($values_4 > 9999){
//                 $values_4 = 9999;
//             }
                        
//             $rs_fetch = DB::select(DB::raw("SELECT * from `web_page_facts`;"));
//             if(count($rs_fetch) > 0){
//                 $rs_save = DB::select(DB::raw("UPDATE `web_page_facts` set `title` = '$title', `title_l` = '$title_l', `sub_title` = '$sub_title', `sub_title_l` = '$sub_title_l', `caption_1` = '$caption_1', `caption_1_l` = '$caption_1_l', `val_1` = '$values_1', `caption_2` = '$caption_2', `caption_2_l` = '$caption_2_l', `val_2` = '$values_2', `caption_3` = '$caption_3', `caption_3_l` = '$caption_3_l', `val_3` = '$values_3', `caption_4` = '$caption_4', `caption_4_l` = '$caption_4_l', `val_4` = '$values_4';"));
//             }else{
//                 $rs_save = DB::select(DB::raw("INSERT into `web_page_facts` (`title`, `title_l`, `sub_title`, `sub_title_l`, `caption_1`, `caption_1_l`, `val_1`, `caption_2`, `caption_2_l`, `val_2`, `caption_3`, `caption_3_l`, `val_3`, `caption_4`, `caption_4_l`, `val_4`) values ('$title', '$title_l', '$sub_title', '$sub_title_l', '$caption_1', '$caption_1_l', '$values_1', '$caption_2', '$caption_2_l', '$values_2', '$caption_3', '$caption_3_l', '$values_3', '$caption_4', '$caption_4_l', '$values_4')"));
//             }
            
//             WebHelper::db_update_date_time();
//             return  redirect()->back()->with(['message'=>'Saved Successfully','class'=>'success']);     
//         } catch (\Exception $e) {
//             $e_method = "factsStore";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }
//     }

// // //add-more-page
//     public function addMorePage()
//     {
//         try {
//             $rs_records = DB::select(DB::raw("SELECT * from `more_page` order by `display_order`;"));
//             return view('admin.webgallery.morePage.index',compact('rs_records'));    
//         } catch (\Exception $e) {
//             $e_method = "addMorePage";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }
//     }

//     public function morePageForm($rec_id)
//     {   
//         try {
//             $permission_flag = MyFuncs::isPermission_route(713);
//             if(!$permission_flag){
//                 return view('admin.common.error_popup');
//             }

//             $rec_id = intval(Crypt::decrypt($rec_id));
//             $rs_records = DB::select(DB::raw("SELECT * from `more_page` where `id` = $rec_id limit 1;"));
//             $rs_records = reset($rs_records);
//             return view('admin.webgallery.morePage.form',compact('rs_records', 'rec_id'));    
//         } catch (\Exception $e) {
//             $e_method = "morePageForm";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }
//     }

//     public function morePageStore(Request $request, $rec_id)
//     { 
//         try {
//             $permission_flag = MyFuncs::isPermission_route(713);
//             if(!$permission_flag){
//                 $response=['status'=>0,'msg'=>'Something Went Wrong'];
//                 return response()->json($response);
//             }

//             $rules=[ 
//                 'pdf_file' => 'nullable|mimes:pdf|max:1024',
//             ];
//             $validator = Validator::make($request->all(),$rules);
//             if ($validator->fails()) {
//                 $errors = $validator->errors()->all();
//                 $response=array();
//                 $response["status"]=0;
//                 $response["msg"]=$errors[0];
//                 return response()->json($response);// response as json
//             }

//             $rec_id = intval(Crypt::decrypt($rec_id));
//             $link_name = substr(MyFuncs::removeSpacialChr($request->link_name), 0, 30);
//             $link_name_l = substr(MyFuncs::removeSpacialChr($request->link_name_l), 0, 30);
//             $link_type = intval($request->link_type);
//             $page_heading = substr(MyFuncs::removeSpacialChr($request->page_heading), 0, 100);
//             $page_heading_l = substr(MyFuncs::removeSpacialChr($request->page_heading_l), 0, 100);
//             $page_content = MyFuncs::removeSpacialChr_editor($request->page_content);
//             $page_content_l = MyFuncs::removeSpacialChr_editor($request->page_content_l);
//             $display_order = intval(MyFuncs::removeSpacialChr($request->display_order));

//             if($display_order > 50){
//                 $display_order = 50;
//             }
            
//             $file_name = '';
//             $rs_fetch = DB::select(DB::raw("SELECT `file_path` from `more_page` where `id` = $rec_id limit 1;"));
//             if(count($rs_fetch) > 0){
//                 $file_name = $rs_fetch[0]->file_path;    
//             }

//             if ($request->hasFile('pdf_file')){
//                 $pdfFile = $request->pdf_file; 
//                 if($file_name == ''){
//                     $file_name = time().'.pdf';    
//                 }
//                 $folder_name = 'website/more_page';
//                 $pdfFile->storeAs($folder_name,$file_name);
//             }

//             if ($rec_id == 0) {
//                 $rs_save = DB::select(DB::raw("INSERT into `more_page` (`link_name`, `link_name_l`, `link_type`, `page_heading`, `page_heading_l`, `page_content`, `page_content_l`, `display_order`, `file_path`) values ('$link_name', '$link_name_l', '$link_type', '$page_heading', '$page_heading_l', '$page_content', '$page_content_l', '$display_order', '$file_name')"));
//                 $response=['status'=>1,'msg'=>'Saved Successfully'];
//             }else{
//                 $rs_save = DB::select(DB::raw("UPDATE `more_page` set `link_name` = '$link_name', `link_name_l` = '$link_name_l', `link_type` = '$link_type', `page_heading` = '$page_heading', `page_heading_l` = '$page_heading_l', `page_content` = '$page_content', `page_content_l` = '$page_content_l', `display_order` = '$display_order', `file_path` = '$file_name' where `id` = $rec_id limit 1;"));
//                 $response=['status'=>1,'msg'=>'Updated Successfully'];
//             }
//             WebHelper::db_update_date_time();
//             return response()->json($response);
            
//         }catch (\Exception $e) {
//             $e_method = "morePageStore";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }
//     }

//     public function morePageDelete($rec_id)
//     { 
//         try {
//             $permission_flag = MyFuncs::isPermission_route(713);
//             if(!$permission_flag){
//                 $response=['status'=>0,'msg'=>'Something Went Wrong'];
//                 return response()->json($response);
//             }
//             $rec_id = intval(Crypt::decrypt($rec_id));
//             $rs_delete = DB::select(DB::raw("DELETE from `more_page` where `id` = $rec_id limit 1;"));
//             WebHelper::db_update_date_time();
//             return  redirect()->back()->with(['message'=>'Deleted Successfully','class'=>'success']);
//         } catch (\Exception $e) {
//             $e_method = "morePageDelete";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }  
//     }


// // //MandatoryDisclosure
//     public function MandatoryDisclosure()
//     {
//         try {
//             $rs_records = DB::select(DB::raw("SELECT * from `mandatory_disclosure` order by `display_order`;"));
//             return view('admin.webgallery.MandatoryDisclosure.index',compact('rs_records'));    
//         } catch (\Exception $e) {
//             $e_method = "MandatoryDisclosure";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }
//     }

//     public function MandatoryDisclosureForm($rec_id)
//     {   
//         try {
//             $permission_flag = MyFuncs::isPermission_route(714);
//             if(!$permission_flag){
//                 return view('admin.common.error_popup');
//             }

//             $rec_id = intval(Crypt::decrypt($rec_id));
//             $rs_records = DB::select(DB::raw("SELECT * from `mandatory_disclosure` where `id` = $rec_id limit 1;"));
//             $rs_records = reset($rs_records);
//             return view('admin.webgallery.MandatoryDisclosure.form',compact('rs_records', 'rec_id'));    
//         } catch (\Exception $e) {
//             $e_method = "MandatoryDisclosureForm";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }
//     }

//     public function MandatoryDisclosureStore(Request $request, $rec_id)
//     { 
//         try {
//             $permission_flag = MyFuncs::isPermission_route(714);
//             if(!$permission_flag){
//                 $response=['status'=>0,'msg'=>'Something Went Wrong'];
//                 return response()->json($response);
//             }

//             $rules=[ 
//                 'pdf_file' => 'required|mimes:pdf|max:5000',
//             ];
//             $validator = Validator::make($request->all(),$rules);
//             if ($validator->fails()) {
//                 $errors = $validator->errors()->all();
//                 $response=array();
//                 $response["status"]=0;
//                 $response["msg"]=$errors[0];
//                 return response()->json($response);// response as json
//             }

//             $rec_id = intval(Crypt::decrypt($rec_id));
//             $link_name = substr(MyFuncs::removeSpacialChr($request->link_name), 0, 30);
//             $link_name_l = substr(MyFuncs::removeSpacialChr($request->link_name_l), 0, 30);
//             $display_order = intval(MyFuncs::removeSpacialChr($request->display_order));

//             if($display_order > 50){
//                 $display_order = 50;
//             }
            
//             $file_name = '';
//             $rs_fetch = DB::select(DB::raw("SELECT `file_path` from `mandatory_disclosure` where `id` = $rec_id limit 1;"));
//             if(count($rs_fetch) > 0){
//                 $file_name = $rs_fetch[0]->file_path;    
//             }

//             if ($request->hasFile('pdf_file')){
//                 $pdfFile = $request->pdf_file; 
//                 if($file_name == ''){
//                     $file_name = time().'.pdf';    
//                 }
//                 $folder_name = 'website/mandatoryDisclousre';
//                 $pdfFile->storeAs($folder_name,$file_name);
//             }

//             if ($rec_id == 0) {
//                 $rs_save = DB::select(DB::raw("INSERT into `mandatory_disclosure` (`link_name`, `link_name_l`, `display_order`, `file_path`) values ('$link_name', '$link_name_l', '$display_order', '$file_name')"));
//                 $response=['status'=>1,'msg'=>'Saved Successfully'];
//             }else{
//                 $rs_save = DB::select(DB::raw("UPDATE `mandatory_disclosure` set `link_name` = '$link_name', `link_name_l` = '$link_name_l', `display_order` = '$display_order', `file_path` = '$file_name' where `id` = $rec_id limit 1;"));
//                 $response=['status'=>1,'msg'=>'Updated Successfully'];
//             }
//             WebHelper::db_update_date_time();
//             return response()->json($response);
            
//         }catch (\Exception $e) {
//             $e_method = "MandatoryDisclosureStore";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }
//     }

//     public function MandatoryDisclosureDelete($rec_id)
//     { 
//         try {
//             $permission_flag = MyFuncs::isPermission_route(714);
//             if(!$permission_flag){
//                 $response=['status'=>0,'msg'=>'Something Went Wrong'];
//                 return response()->json($response);
//             }
//             $rec_id = intval(Crypt::decrypt($rec_id));
//             $rs_delete = DB::select(DB::raw("DELETE from `mandatory_disclosure` where `id` = $rec_id limit 1;"));
//             WebHelper::db_update_date_time();
//             return  redirect()->back()->with(['message'=>'Deleted Successfully','class'=>'success']);
//         } catch (\Exception $e) {
//             $e_method = "MandatoryDisclosureDelete";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }  
//     }

// // //whos who
//     public function whosWhoIndex()
//     {
//         try {
//             $rs_records = DB::select(DB::raw("SELECT * from `web_page_whos_who` order by `display_order`;"));
//             return view('admin.webgallery.whos.index',compact('rs_records'));
//         } catch (\Exception $e) {
//             $e_method = "whosWhoIndex";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }
//     }

//     public function whosWhoForm($rec_id)
//     {   
//         try {
//             $permission_flag = MyFuncs::isPermission_route(715);
//             if(!$permission_flag){
//                 return view('admin.common.error_popup');
//             }

//             $rec_id = intval(Crypt::decrypt($rec_id));
//             $rs_records = DB::select(DB::raw("SELECT * from `web_page_whos_who` where `id` = $rec_id limit 1;"));
//             $rs_records = reset($rs_records);
//             return view('admin.webgallery.whos.form',compact('rs_records', 'rec_id'));
//         } catch (\Exception $e) {
//             $e_method = "whosWhoForm";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }
//     }

//     public function whosWhoStore(Request $request, $rec_id)
//     {
//         try {
//             $permission_flag = MyFuncs::isPermission_route(715);
//             if(!$permission_flag){
//                 $response=['status'=>0,'msg'=>'Something Went Wrong'];
//                 return response()->json($response);
//             }

//             $rules=[ 
//               'image' => 'nullable|image|mimes:jpeg,jpg|max:500',
//             ];
//             $validator = Validator::make($request->all(),$rules);
//             if ($validator->fails()) {
//               $errors = $validator->errors()->all();
//               $response=array();
//               $response["status"]=0;
//               $response["msg"]=$errors[0];
//               return response()->json($response);// response as json
//             }


//             $rec_id = intval(Crypt::decrypt($rec_id));
//             $name = substr(MyFuncs::removeSpacialChr($request->name), 0, 50);
//             $name_l = substr(MyFuncs::removeSpacialChr($request->name_l), 0, 50);
//             $designation = substr(MyFuncs::removeSpacialChr($request->designation), 0, 25);
//             $designation_l = substr(MyFuncs::removeSpacialChr($request->designation_l), 0, 25);
//             $message = MyFuncs::removeSpacialChr_editor($request->message);
//             $message_l = MyFuncs::removeSpacialChr_editor($request->message_l);
//             $display_order = intval(MyFuncs::removeSpacialChr($request->display_order));
            
//             if($display_order > 50){
//                 $display_order = 50;
//             }
            
//             $file_name = '';
//             $rs_fetch = DB::select(DB::raw("SELECT `image` from `web_page_whos_who` where `id` = $rec_id limit 1;"));
//             if(count($rs_fetch) > 0){
//                 $file_name = $rs_fetch[0]->image;    
//             }

//             if ($request->hasFile('image')){
//                 $imageFile = $request->image; 
//                 if($file_name == ''){
//                     $file_name = time().'.jpg';    
//                 }
//                 $folder_name = 'website/whoswho';
//                 $imageFile->storeAs($folder_name,$file_name);
//             }

//             if ($rec_id == 0) {
//                 $rs_save = DB::select(DB::raw("INSERT into `web_page_whos_who` (`image`, `name`, `name_l`, `designation`, `designation_l`, `message`, `message_l`, `display_order`) values ('$file_name', '$name', '$name_l', '$designation', '$designation_l', '$message', '$message_l', '$display_order')"));
//                 $response=['status'=>1,'msg'=>'Saved Successfully'];
//             }else{
//                 $rs_save = DB::select(DB::raw("UPDATE `web_page_whos_who` set `image` = '$file_name', `name` = '$name', `name_l` = '$name_l', `designation` = '$designation', `designation_l` = '$designation_l', `message` = '$message', `message_l` = '$message_l', `display_order` = '$display_order' where `id` = $rec_id limit 1;"));
//                 $response=['status'=>1,'msg'=>'Updated Successfully'];
//             }
//             WebHelper::db_update_date_time();
//             return response()->json($response);
            
//         } catch (\Exception $e) {
//             $e_method = "whosWhoStore";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }
         
//     }

//     public function whosWhoDelete($rec_id)
//     { 
//         try {
//             $permission_flag = MyFuncs::isPermission_route(715);
//             if(!$permission_flag){
//                 $response=['status'=>0,'msg'=>'Something Went Wrong'];
//                 return response()->json($response);
//             }
//             $rec_id = intval(Crypt::decrypt($rec_id));
//             $rs_delete = DB::select(DB::raw("DELETE from `web_page_whos_who` where `id` = $rec_id limit 1;"));
//             WebHelper::db_update_date_time();
//             return  redirect()->back()->with(['message'=>'Deleted Successfully','class'=>'success']);
//         } catch (\Exception $e) {
//             $e_method = "whosWhoDelete";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }  
//     }

    
// // //popupFlash
//     public function popupFlash()
//     {
//         try {
//             $rs_records = DB::select(DB::raw("SELECT `pf`.`id`, date_format(`pf`.`from_date`, '%d-%m-%Y') as `from_date`, date_format(`pf`.`to_date`, '%d-%m-%Y') as `to_date`, `pf`.`content`, `pf`.`status` from `popup_flash` `pf` limit 1;"));
//             return view('admin.webgallery.popupFlash.index',compact('rs_records'));   
//         } catch (\Exception $e) {
//             $e_method = "popupFlash";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }
//     }

//     public function popupFlashStore(Request $request)
//     {  
//         try {
//             $permission_flag = MyFuncs::isPermission_route(716);
//             if(!$permission_flag){
//                 $response=['status'=>0,'msg'=>'Something Went Wrong'];
//                 return response()->json($response);
//             }

//             $rules=[      
//                 'from_date' => 'required|max:10|min:10', 
//                 'to_date' => 'required|max:10|min:10',
//                 'image' => 'nullable|image|mimes:jpeg,jpg|max:1024',
//             ];
//             $customMessages = [
//                 'from_date.required'=> 'From Date Is Not A Valid Date',
//                 'from_date.min'=> 'From Date Is Not A Valid Date',
//                 'from_date.max'=> 'From Date Is Not A Valid Date',

//                 'to_date.required'=> 'To Date Is Not A Valid Date',
//                 'to_date.max'=> 'To Date Is Not A Valid Date',
//                 'to_date.min'=> 'To Date Is Not A Valid Date',
//             ];

//             $validator = Validator::make($request->all(),$rules, $customMessages);
//             if ($validator->fails()) {
//                 $errors = $validator->errors()->all();
//                 $response=array();
//                 $response["status"]=0;
//                 $response["msg"]=$errors[0];
//                 return response()->json($response);// response as json
//             }
            

//             $from_date = substr(MyFuncs::removeSpacialChr($request->from_date), 0, 10);
//             $to_date = substr(MyFuncs::removeSpacialChr($request->to_date), 0, 10);
//             // $content = MyFuncs::removeSpacialChr_editor($request->content);
//             $status = intval($request->status);
            
//             if($status > 1){
//                 $status = 1;
//             }

//             $result_from_date = MyFuncs::check_valid_date($from_date);
//             if($result_from_date[0] == 0){
//                 $response=array();
//                 $response['status']=0;
//                 $response['msg']='From Date Not Valid';   
//                 return $response;
//             }
//             $from_date = $result_from_date[2];

//             $result_to_date = MyFuncs::check_valid_date($to_date);
//             if($result_to_date[0] == 0){
//                 $response=array();
//                 $response['status']=0;
//                 $response['msg']='To Date Not Valid';   
//                 return $response;
//             }
//             $to_date = $result_to_date[2];

//             $file_name = '';
//             $rs_fetch = DB::select(DB::raw("SELECT * from `popup_flash`;"));
//             if(count($rs_fetch) > 0){
//                 $file_name = $rs_fetch[0]->content;    
//             }            

//             if ($request->hasFile('image')){
//                 $imageFile = $request->image;                
//                 $file_name = '1.jpg';    
//                 $folder_name = 'website/popupFlash';
//                 $imageFile->storeAs($folder_name,$file_name);
//             }

//             if(count($rs_fetch)== 0){ 
//                 $rs_save = DB::select(DB::raw("INSERT into `popup_flash` (`from_date`, `to_date`, `content`, `status`) values ('$from_date', '$to_date', '$file_name', '$status')"));
//             }else{
//                 $rs_save = DB::select(DB::raw("UPDATE `popup_flash` set `from_date` = '$from_date', `to_date` = '$to_date', `content` = '$file_name', `status` = '$status';"));
//             }
            
//             WebHelper::db_update_date_time();
//             return  redirect()->back()->with(['message'=>'Saved Successfully','class'=>'success']);     
//         } catch (\Exception $e) {
//             $e_method = "popupFlashStore";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }
//     }

// // //notice_board
//     public function noticeBoardIndex()
//     {
//         try {
//             $rs_records = DB::select(DB::raw("SELECT `nb`.`id`, date_format(`nb`.`from_date`, '%d-%m-%Y') as `from_date`, date_format(`nb`.`to_date`, '%d-%m-%Y') as `to_date`, `nb`.`title`, `nb`.`sub_title`, `nb`.`notice_detail`, `nb`.`file_path`, `nb`.`display_order`, `nb`.`title_l`, `nb`.`sub_title_l`, date_format(`nb`.`post_date`, '%d-%m-%Y') as `post_date`, `nb`.`status` from `notice_board` `nb` where `nb`.`status` = 1 order by `nb`.`display_order`;"));
//             return view('admin.webgallery.noticeboard.index',compact('rs_records'));    
//         } catch (\Exception $e) {
//             $e_method = "noticeBoardIndex";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }
//     }

//     public function noticeBoardForm($rec_id)
//     {   
//         try {
//             $permission_flag = MyFuncs::isPermission_route(717);
//             if(!$permission_flag){
//                 return view('admin.common.error_popup');
//             }

//             $rec_id = intval(Crypt::decrypt($rec_id));
//             $rs_records = DB::select(DB::raw("SELECT `nb`.`id`, date_format(`nb`.`from_date`, '%d-%m-%Y') as `from_date`, date_format(`nb`.`to_date`, '%d-%m-%Y') as `to_date`, `nb`.`title`, `nb`.`sub_title`, `nb`.`notice_detail`, `nb`.`file_path`, `nb`.`display_order`, `nb`.`title_l`, `nb`.`sub_title_l`, date_format(`nb`.`post_date`, '%d-%m-%Y') as `post_date`, `nb`.`status` from `notice_board` `nb` where `nb`.`id` = $rec_id limit 1;"));
//             $rs_records = reset($rs_records);
//             return view('admin.webgallery.noticeboard.form',compact('rs_records', 'rec_id'));    
//         } catch (\Exception $e) {
//             $e_method = "noticeBoardForm";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }
//     }

//     public function noticeBoardStore(Request $request, $rec_id)
//     { 
//         try {
//             $permission_flag = MyFuncs::isPermission_route(717);
//             if(!$permission_flag){
//                 $response=['status'=>0,'msg'=>'Something Went Wrong'];
//                 return response()->json($response);
//             }

//             $rules=[ 
//                 'pdf_file' => 'nullable|mimes:pdf|max:1024',
//                 'post_date' => 'required|max:10|min:10', 
//                 'from_date' => 'required|max:10|min:10', 
//                 'to_date' => 'required|max:10|min:10',
//             ];

//             $customMessages = [
//                 'post_date.required'=> 'Post Date Is Not A Valid Date',
//                 'post_date.min'=> 'Post Date Is Not A Valid Date',
//                 'post_date.max'=> 'Post Date Is Not A Valid Date',

//                 'from_date.required'=> 'From Date Is Not A Valid Date',
//                 'from_date.min'=> 'From Date Is Not A Valid Date',
//                 'from_date.max'=> 'From Date Is Not A Valid Date',

//                 'to_date.required'=> 'To Date Is Not A Valid Date',
//                 'to_date.max'=> 'To Date Is Not A Valid Date',
//                 'to_date.min'=> 'To Date Is Not A Valid Date',
//             ];

//             $validator = Validator::make($request->all(),$rules, $customMessages);
//             if ($validator->fails()) {
//                 $errors = $validator->errors()->all();
//                 $response=array();
//                 $response["status"]=0;
//                 $response["msg"]=$errors[0];
//                 return response()->json($response);// response as json
//             }

//             $rec_id = intval(Crypt::decrypt($rec_id));
//             $post_date = substr(MyFuncs::removeSpacialChr($request->post_date), 0, 10);
//             $from_date = substr(MyFuncs::removeSpacialChr($request->from_date), 0, 10);
//             $to_date = substr(MyFuncs::removeSpacialChr($request->to_date), 0, 10);
            
//             $title = substr(MyFuncs::removeSpacialChr($request->title), 0, 100);
//             $title_l = substr(MyFuncs::removeSpacialChr($request->title_l), 0, 100);
            
//             $sub_title = substr(MyFuncs::removeSpacialChr($request->sub_title), 0, 250);
//             $sub_title_l = substr(MyFuncs::removeSpacialChr($request->sub_title_l), 0, 250);
            
//             $notice_detail = MyFuncs::removeSpacialChr_editor($request->notice_detail);
            
//             $display_order = intval(MyFuncs::removeSpacialChr($request->display_order));

//             if($display_order > 50){
//                 $display_order = 50;
//             }

//             $result_from_date = MyFuncs::check_valid_date($from_date);
//             if($result_from_date[0] == 0){
//                 $response=array();
//                 $response['status']=0;
//                 $response['msg']='From Date Not Valid';   
//                 return $response;
//             }
//             $from_date = $result_from_date[2];

//             $result_to_date = MyFuncs::check_valid_date($to_date);
//             if($result_to_date[0] == 0){
//                 $response=array();
//                 $response['status']=0;
//                 $response['msg']='To Date Not Valid';   
//                 return $response;
//             }
//             $to_date = $result_to_date[2];
            
//             $result_post_date = MyFuncs::check_valid_date($post_date);
//             if($result_post_date[0] == 0){
//                 $response=array();
//                 $response['status']=0;
//                 $response['msg']='Post Date Not Valid';   
//                 return $response;
//             }
//             $post_date = $result_post_date[2];
            
//             $file_name = '';
//             $rs_fetch = DB::select(DB::raw("SELECT `file_path` from `notice_board` where `id` = $rec_id limit 1;"));
//             if(count($rs_fetch) > 0){
//                 $file_name = $rs_fetch[0]->file_path;    
//             }

//             if ($request->hasFile('pdf_file')){
//                 $pdfFile = $request->pdf_file; 
//                 if($file_name == ''){
//                     $file_name = time().'.pdf';    
//                 }
//                 $folder_name = 'website/noticeBoard';
//                 $pdfFile->storeAs($folder_name,$file_name);
//             }

//             if ($rec_id == 0) {
//                 $rs_save = DB::select(DB::raw("INSERT into `notice_board` (`from_date`, `to_date`, `class_id`, `section_id`, `class_section_id`, `student_id`, `title`, `title_l`, `sub_title`, `sub_title_l`, `notice_detail`, `file_path`, `display_order`, `post_date`, `status`) values ('$from_date', '$to_date', 0, 0, 0, 0, '$title', '$title_l', '$sub_title', '$sub_title_l', '$notice_detail', '$file_name', '$display_order', '$post_date', 1);"));
//                 $response=['status'=>1,'msg'=>'Saved Successfully'];
//             }else{
//                 $rs_save = DB::select(DB::raw("UPDATE `notice_board` set `from_date` = '$from_date', `to_date` = '$to_date', `title` = '$title', `title_l` = '$title_l', `sub_title` = '$sub_title', `sub_title_l` = '$sub_title_l', `notice_detail` = '$notice_detail', `display_order` = '$display_order', `file_path` = '$file_name', `post_date` = '$post_date' where `id` = $rec_id limit 1;"));
//                 $response=['status'=>1,'msg'=>'Updated Successfully'];
//             }
//             WebHelper::db_update_date_time();
//             return response()->json($response);
            
//         }catch (\Exception $e) {
//             $e_method = "noticeBoardStore";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }
//     }

//     public function noticeBoardDelete($rec_id)
//     { 
//         try {
//             $permission_flag = MyFuncs::isPermission_route(717);
//             if(!$permission_flag){
//                 $response=['status'=>0,'msg'=>'Something Went Wrong'];
//                 return response()->json($response);
//             }
//             $rec_id = intval(Crypt::decrypt($rec_id));
//             $rs_delete = DB::select(DB::raw("UPDATE `notice_board` set `status` = 2 where `id` = $rec_id limit 1;"));
//             WebHelper::db_update_date_time();
//             return  redirect()->back()->with(['message'=>'Deleted Successfully','class'=>'success']);
//         } catch (\Exception $e) {
//             $e_method = "noticeBoardDelete";
//             return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
//         }  
//     }

    
}