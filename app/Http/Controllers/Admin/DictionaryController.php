<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Helper\MyFuncs;
use App\Helper\SelectBox;

class DictionaryController extends Controller
{   
    protected $e_controller = "DictionaryController";
    
    public function index()
    {
        try {
            $permission_flag = MyFuncs::isPermission_route("17");
            if(!$permission_flag){
                return view('admin.common.error');
            }
            return view('admin.dictionary.index');            
        } catch (\Exception $e) {$e_method = "index";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method,$e->getMessage());
        }
    }

    public function fetchHindiName(Request $request,$type)
    {
        $name_english = substr(MyFuncs::removeSpacialChr($request->name_english), 0, 50);

        if (empty($name_english)) {
            return response()->json(['status' => false, 'hindi_name' => '']);
        }

        $rs_result = DB::select(DB::raw("SELECT `uf_convert_english_to_hindi` ('$name_english') as 'name_l'"));
        $hindiName = $rs_result[0]->name_l ?? $name_english;

        return response()->json(['status' => true, 'hindi_name' => $hindiName]);
    }   

    public function correctHindiName(Request $request,$condition_type)
    {   
        try {
            $name_english = substr(MyFuncs::removeSpacialChr($request->name_english), 0, 50);

            // Multiple suggestions ke liye applied_times DESC order me fetch karna
            $rs_result = DB::select(DB::raw("SELECT `name_l` FROM `dictionary` WHERE LOWER(TRIM(`name_e`)) = LOWER(TRIM('$name_english')) ORDER BY `applied_times` DESC;"));
            
            $rs_result = collect($rs_result);

            // Agar dictionary me koi match nahi mila, toh fallback ke liye ek default object bhej dein
            if ($rs_result->isEmpty()) {$rs_result = collect([
                    (object) ['name_l' => $name_english]
                ]);
            }
              
            return view('admin.dictionary.popup', compact('name_english', 'rs_result', 'condition_type'));   
        } catch (\Exception $e) {$e_method = "correctHindiName";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method,$e->getMessage());
        }
    }

    public function saveOrUpdateDictionary(Request $request)
    {
        try {
            $name_e = trim($request->name_e);
            $name_l = trim($request->name_l);

            if (empty($name_e) || empty($name_l)) {
                return response()->json(['status' => false, 'message' => 'Name cannot be empty']);
            }

            // 1. Check karein kya yeh English aur Hindi combination pehle se dictionary me hai (Raw Select Query)
            $rs_check = DB::select(DB::raw("SELECT `id` FROM `dictionary` WHERE LOWER(TRIM(`name_e`)) = LOWER(TRIM('$name_e')) AND LOWER(TRIM(`name_l`)) = LOWER(TRIM('$name_l')) LIMIT 1;"));
            
            $rs_check = collect($rs_check);

            if ($rs_check->isNotEmpty()) {
                $id =$rs_check[0]->id;
                // 2. Agar pehle se hai, toh applied_times ko 1 se badha do (Raw Update Query)
                DB::statement(DB::raw("UPDATE `dictionary` SET `applied_times` = `applied_times` + 1 WHERE `id` = $id;"));
            } else {
                // 3. Agar naya word hai, toh dictionary me insert kar do (Raw Insert Query)
                DB::statement(DB::raw("INSERT INTO `dictionary` (`name_e`, `name_l`, `applied_times`) VALUES ('$name_e', '$name_l', 1);"));
            }

            return response()->json(['status' => true, 'message' => 'Dictionary updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }


    public function verify_index()
    {
        try {
            $permission_flag = MyFuncs::isPermission_route("18");
            if(!$permission_flag){
                return view('admin.common.error');
            }
            return view('admin.dictionary.verify_index');            
        } catch (\Exception $e) {$e_method = "verify_index";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method,$e->getMessage());
        }
    }

    public function verify_show(Request $request)
    {
        try {
            $permission_flag = MyFuncs::isPermission_route(18);
            if(!$permission_flag){
                $response=['status'=>0,'msg'=>'Something Went Wrong'];
                return response()->json($response);
            }

            $input_value = MyFuncs::removeSpacialChr($request->input_value);

            $condition = "";
            if($input_value != ''){
                $condition = " and `name_e` like '$input_value%' ";
            }

            $rs_result = DB::select(DB::raw("SELECT * from `dictionary` where `name_e` = (select `name_e` from `dictionary` where `verified` = 0 $condition limit 1) order by `verified`, `id`;"));

            $response = array();
            $response['status'] = 1;            
            $response['data'] =view('admin.dictionary.verify_table', compact('rs_result'))->render();
            return response()->json($response);           
        } catch (Exception $e) {
            $e_method = "verify_show";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function verify_update($id)
    {
        try {
            $permission_flag = MyFuncs::isPermission_route(18);
            if(!$permission_flag){
                $response=['status'=>0,'msg'=>'Something Went Wrong'];
                return response()->json($response);
            }

            $l_id = intval(Crypt::decrypt($id));           
            
            $query = "UPDATE `dictionary` set `verified` = 1 where `id` = $l_id limit 1;";       
            
            $rs_records = DB::select(DB::raw("$query"));
            $response=['status'=>1,'msg'=>'Verified Successfully'];
            return response()->json($response);
        } catch (\Exception $e) {
            $e_method = "verify_update";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function verify_delete($id)
    {
        try {
            $permission_flag = MyFuncs::isPermission_route(18);
            if(!$permission_flag){
                $response=['status'=>0,'msg'=>'Something Went Wrong'];
                return response()->json($response);
            }

            $l_id = intval(Crypt::decrypt($id));            
            $query = "DELETE from `dictionary` where `id` = $l_id limit 1;";       
            $rs_records = DB::select(DB::raw("$query"));
            $response=['status'=>1,'msg'=>'Deleted Successfully'];
            return response()->json($response);
        } catch (\Exception $e) {
            $e_method = "verify_delete";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function verify_edit($id)
    {
        try {
            $permission_flag = MyFuncs::isPermission_route(18);
            if(!$permission_flag){
                return view('admin.common.error_popup');
            }
            
            $id = intval(Crypt::decrypt($id));
            $rs_records = DB::select(DB::raw("SELECT * from `dictionary` where `id` = $id limit 1;"));
            $rs_records = reset($rs_records);    
            return view('admin.dictionary.verify_edit',compact('rs_records', 'id'));
        } catch (\Exception $e) {
            $e_method = "verify_edit";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }

    public function verify_save(Request $request, $id)
    {  
        try {
            $permission_flag = MyFuncs::isPermission_route(18);
            if(!$permission_flag){
                $response=['status'=>0,'msg'=>'Something Went Wrong'];
                return response()->json($response);
            }
            
            $rules=[
                'name_e' => 'required',
                'name_l' => 'required',
            ];

            $customMessages = [
                'name_e.required'=> 'Name (English) is Required',
                'name_l.required'=> 'Name (Hindi) is Required',
            ];

            $validator = Validator::make($request->all(),$rules, $customMessages);
            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $response=array();
                $response["status"]=0;
                $response["msg"]=$errors[0];
                return response()->json($response);// response as json
            }

            $l_id = intval(Crypt::decrypt($id));
            $name_e = substr(MyFuncs::removeSpacialChr($request->name_e), 0, 100);
            $name_l = $request->name_e;
            
            $query = "UPDATE `dictionary` set `name_e` = '$name_e', `name_l` = '$name_l' where `id` = $l_id limit 1;";            
            $rs_update = DB::select(DB::raw($query));
            

            $response=['status'=>1,'msg'=>'Updated Successfully'];
            return response()->json($response);        
        } catch (\Exception $e) {
            $e_method = "verify_save";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }
}