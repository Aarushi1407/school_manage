<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Helper\MyFuncs;

class BookDemoRequestController extends Controller
{
    protected $e_controller = "BookDemoRequestController";

    public function index()
    {
        try {
            $permission_flag = MyFuncs::isPermission_route(33);
            if(!$permission_flag){
                return view('admin.common.error');
            }
            $rs_records = DB::select(DB::raw("SELECT `dr`.`id`, `dr`.`mobile_no`, `dr`.`institute_name`, `dr`.`c_name`, `dr`.`designation`, `dr`.`institute_name`, `dr`.`email`, `dr`.`state_name`, `dr`.`city_name`, `dr`.`address_1`, `dr`.`address_2`, `dr`.`pin_code`, `dr`.`msg_text`, date_format(`dr`.`request_date`, '%d-%m-%Y') as `r_date`, `uf_get_other_request_count`(`dr`.`id`, `dr`.`mobile_no`) as `r_count` from `demo_requests` `dr` where `dr`.`status` = 0 order by `dr`.`id` desc;"));
            return view('admin.BookDemoRequest.index',compact('rs_records'));    
        } catch (\Exception $e) {
            $e_method = "index";
            return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
        }
    }
}
