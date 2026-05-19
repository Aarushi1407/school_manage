<?php

namespace App\Console\Commands;

use App\Admin;
use App\Helper\MyFuncs;
use App\Helper\WhatsApp;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;
use Auth;
use Mail;

class SendLoginOTP extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'SendLoginOTP:send {user_id} {otp} {mobile_no} {sent_option}';    // 1 Whatsapp , 2 SMS


    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'SendLoginOTP';

    /**
    * Create a new command instance.
    *
    * @return void
    */
    public function __construct()
    {
        parent::__construct();
    }

    /**
    * Execute the console command.
    *
    * @return mixed
    */
    public function handle()
    { 
        ini_set('max_execution_time', '3600');
        ini_set('memory_limit','999M');
        ini_set("pcre.backtrack_limit", "100000000");

        $user_id = $this->argument('user_id');
        $otp = $this->argument('otp');
        $mobile_no = $this->argument('mobile_no');
        $sent_option = $this->argument('sent_option');
        $msg_type = 11;

        if(($sent_option == 1) || ($sent_option == 3)){
            return $this->send_on_whatsapp($user_id, $otp, $mobile_no, $msg_type);
        }
        
    }

    public function send_on_whatsapp($user_id, $otp, $mobile_no, $msg_type){
        // $rs_fetch = DB::select(DB::raw("SELECT `online_offline` from `schoolinfo`;"));
        // $online_offline = $rs_fetch[0]->online_offline;
        $online_offline = 1;
        
        $rs_fetch = DB::select(DB::raw("SELECT `template_name`, `language`, `upload_pdf`, `db_query`, `in_paramater_count`, `out_paramenter_count` from `whatsapp_template_detail` where `template_type` = 7 and `status` = 1 limit 1;"));
        if(count($rs_fetch) == 0){
            return;
        }

        $template_name = $rs_fetch[0]->template_name;
        $language = $rs_fetch[0]->language;
        $is_upload_pdf = $rs_fetch[0]->upload_pdf;
        $in_paramater_count = $rs_fetch[0]->in_paramater_count;
        $out_paramenter_count = $rs_fetch[0]->out_paramenter_count;
        $db_query = $rs_fetch[0]->db_query;

        $db_query = str_replace('in_param_1', "$otp", $db_query);
        

        $rs_fetch = DB::select(DB::raw($db_query));

        if($online_offline == 1){
            $mobile_no = "91".$mobile_no;
        }else{
            $mobile_no = "919355805581";    
        }
        
        if($mobile_no == ""){
            return;
        }

        $out_parameters = array();
        $components_parameters = array();
        $counter = 1;
        while ($counter<=$out_paramenter_count) {
            $field_name = "out_param_".$counter;
            $out_parameters[$counter] = $rs_fetch[0]->$field_name;
            $components_parameters[] = array("type" => "text", "text" => $out_parameters[$counter]);
            $counter++;
        }
        
        $rs_fetch = DB::select(DB::raw("SELECT `configuration_value` from `master_configuration` where `configuration_type` = 1;"));
        $whatsapp_phone_id = $rs_fetch[0]->configuration_value;
        $api_url = "https://graph.facebook.com/v22.0/".$whatsapp_phone_id."/messages";

        $rs_fetch = DB::select(DB::raw("SELECT `configuration_value` from `master_configuration` where `configuration_type` = 2;"));
        $access_token = $rs_fetch[0]->configuration_value;

        $data = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $mobile_no,
            'type' => 'template',
            'template' => [
                'name' => $template_name,
                'language' => [
                    'code' => $language,
                ],
                'components' => [
                    [
                        'type' => 'body',
                        "parameters" => $components_parameters,
                    ],
                    [
                        'type' => 'button',
                        'sub_type' => 'url',
                        'index' => '0',
                        "parameters" => $components_parameters,
                    ],
                ],
            ],
        ];
        

        // Initialize cURL session (same as before)
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer " . $access_token,
            "Content-Type: application/json",
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        // Execute the request and capture the response (same as before)
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        } else {
            echo "Response: " . $response;
        }
        curl_close($ch);

        $rs_insert = DB::select(DB::raw("INSERT into `whatsapp_msg_log`(`msg_type`, `mobile_no`, `attachment_send`, `log_date`, `log_date_time`, `log_day`, `log_month`, `log_year`) values ($msg_type, '$mobile_no', $is_upload_pdf, curdate(), now(), day(curdate()), month(curdate()), year(curdate()));"));    
    }

}
