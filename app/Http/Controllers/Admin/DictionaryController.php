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
}