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


class MasterSchoolListController extends Controller
{
    protected $e_controller = "MasterSchoolListController";

    public function index()
    {
        try {
            $permission_flag = MyFuncs::isPermission_route(34);
            if(!$permission_flag){
                return view('admin.common.error');
            }
            $rs_records = DB::select(DB::raw("SELECT * from `mst_school_list` order by `id`;"));
            return view('admin.SchoolMaster.index',compact('rs_records'));                
        } catch (\Exception $e) {
            $e_method = "index";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }
    
    public function addform($id)
    {
        try {
            $permission_flag = MyFuncs::isPermission_route(34);
            if(!$permission_flag){
                return view('admin.common.error_popup');
            }
            $id = intval(Crypt::decrypt($id));
            $rs_record = DB::select(DB::raw("SELECT * from `mst_school_list` where `id` = $id limit 1;"));
            $rs_record = reset($rs_record);
            return view('admin.SchoolMaster.form',compact('rs_record', 'id'));
                
        } catch (\Exception $e) {
            $e_method = "addform";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
        
    }

    public function store(Request $request, $id)
    {  
        try {
            $permission_flag = MyFuncs::isPermission_route(34);
            if(!$permission_flag){
                $response=['status'=>0,'msg'=>'Something Went Wrong'];
                return response()->json($response);
            }
            $rules=[
                'school_name' => 'required',
            ];

            $validator = Validator::make($request->all(),$rules);
            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $response=array();
                $response["status"]=0;
                $response["msg"]=$errors[0];
                return response()->json($response);// response as json
            }
            $id = intval(Crypt::decrypt($id));
            $school_name = substr(MyFuncs::removeSpacialChr($request->school_name), 0, 100);
            $state_name = substr(MyFuncs::removeSpacialChr($request->state_name), 0, 50);
            $city_name = substr(MyFuncs::removeSpacialChr($request->city_name), 0, 50);
            $address_1 = substr(MyFuncs::removeSpacialChr($request->address_1), 0, 100);
            $address_2 = substr(MyFuncs::removeSpacialChr($request->address_2), 0, 100);
            $pin_code = substr(MyFuncs::removeSpacialChr($request->pin_code), 0, 6);
            $mobile_no = substr(MyFuncs::removeSpacialChr($request->mobile_no), 0, 10);
            $email = substr(MyFuncs::removeSpacialChr($request->email), 0, 100);

            if ($id == 0) {
                $rs_insert = DB::select(DB::raw("INSERT into `mst_school_list`(`school_name`, `state_name`, `city_name`, `address_1`, `address_2`, `pin_code`, `mobile_no`, `email_id`) values('$school_name', '$state_name', '$city_name', '$address_1', '$address_2', '$pin_code', '$mobile_no', '$email');"));                
            }else{
                $rs_update = DB::select(DB::raw("UPDATE `mst_school_list` set `school_name` = '$school_name', `state_name` = '$state_name', `city_name` = '$city_name', `address_1` = '$address_1', `address_2` = '$address_2', `pin_code` = '$pin_code', `mobile_no` = '$mobile_no', `email_id` = '$email' where `id` = $id limit 1;"));
            }
            $response=['status'=>1,'msg'=>'Saved Successfully'];
            return response()->json($response);
                
        } catch (\Exception $e) {
            $e_method = "store";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }         
    }

    public function delete($id)
    {  
        try {
            $permission_flag = MyFuncs::isPermission_route(34);
            if(!$permission_flag){
                return  redirect()->back()->with(['message'=>'Something Went Wrong','class'=>'error']);
            }
            $id = intval(Crypt::decrypt($id));
            $rs_update = DB::select(DB::raw("DELETE from `mst_school_list` where `id` = $id limit 1;"));
            
            return  redirect()->back()->with(['message'=>'Deleted Successfully','class'=>'success']);
                
        } catch (\Exception $e) {
            $e_method = "delete";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function contactDetail($mst_school_id)
    {
        try {
            $permission_flag = MyFuncs::isPermission_route(34);
            if(!$permission_flag){
                return view('admin.common.error_popup');
            }
            $mst_school_id = intval(Crypt::decrypt($mst_school_id));
            $rs_records = DB::select(DB::raw("SELECT * from `school_contact_person_detail` where `mst_school_id` = $mst_school_id;"));
            return view('admin.SchoolMaster.contact_detail',compact('rs_records', 'mst_school_id'));
                
        } catch (\Exception $e) {
            $e_method = "contactDetail";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function contactAddForm($para)
    {
        try {
            $permission_flag = MyFuncs::isPermission_route(34);
            if(!$permission_flag){
                return view('admin.common.error_popup');
            }
            $param_values = explode(':', Crypt::decrypt($para));
            if (count($param_values) != 2) {
                return view('admin.common.error_popup');
            }
            $rec_id = intval($param_values[0]);
            $mst_school_id = intval($param_values[1]);
            $rs_records = DB::select(DB::raw("SELECT * from `school_contact_person_detail` where `id` = $rec_id limit 1;"));
            return view('admin.SchoolMaster.contact_form',compact('rs_records', 'para'));
                
        } catch (\Exception $e) {
            $e_method = "contactAddForm";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function contactDetailStore(Request $request, $para)
    {  
        try {
            $permission_flag = MyFuncs::isPermission_route(34);
            if(!$permission_flag){
                $response=['status'=>0,'msg'=>'Something Went Wrong'];
                return response()->json($response);
            }
            $rules=[
                'contact_person_name' => 'required',
            ];

            $validator = Validator::make($request->all(),$rules);
            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $response=array();
                $response["status"]=0;
                $response["msg"]=$errors[0];
                return response()->json($response);// response as json
            }

            $param_values = explode(':', Crypt::decrypt($para));
            if (count($param_values) != 2) {
                $response=['status'=>0,'msg'=>'Something Went Wrong'];
                return response()->json($response);
            }
            $rec_id = intval($param_values[0]);
            $mst_school_id = intval($param_values[1]);

            $contact_person_name = substr(MyFuncs::removeSpacialChr($request->contact_person_name), 0, 50);
            $designation = substr(MyFuncs::removeSpacialChr($request->designation), 0, 50);
            $mobile_no = substr(MyFuncs::removeSpacialChr($request->mobile_no), 0, 10);
            $email = substr(MyFuncs::removeSpacialChr($request->email), 0, 100);

            if ($rec_id == 0) {
                $rs_insert = DB::select(DB::raw("INSERT into `school_contact_person_detail`(`mst_school_id`, `contact_person_name`, `designation`, `mobile_no`, `email_id`) values($mst_school_id, '$contact_person_name', '$designation', '$mobile_no', '$email');"));            
            }else{
                $rs_update = DB::select(DB::raw("UPDATE `school_contact_person_detail` set `contact_person_name` = '$contact_person_name', `designation` = '$designation', `mobile_no` = '$mobile_no', `email_id` = '$email' where `id` = $rec_id limit 1;"));
            }
                            
            $response=['status'=>1,'msg'=>'Saved Successfully'];
            return response()->json($response);
        } catch (Exception $e) {
            $e_method = "contactDetailStore";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }         
    }

    public function contactDetailDelete($id)
    {  
        try {
            $permission_flag = MyFuncs::isPermission_route(34);
            if(!$permission_flag){
                $response=['status'=>0,'msg'=>'Something Went Wrong'];
                return response()->json($response);
            }

            $id = intval(Crypt::decrypt($id));
            $rs_update = DB::select(DB::raw("DELETE from `school_contact_person_detail` where `id` = $id limit 1;"));
            $response=['status'=>1,'msg'=>'Deleted Successfully'];
            return response()->json($response);
                
        } catch (\Exception $e) {
            $e_method = "contactDetailDelete";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    
     
}
