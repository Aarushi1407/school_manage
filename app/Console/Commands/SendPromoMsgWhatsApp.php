<?php

namespace App\Console\Commands;

use App\Admin;
use App\Helper\MyFuncs;
use App\Helper\WhatsApp;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;
use Auth;
use Mail;

class SendPromoMsgWhatsApp extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'SendPromoMsgWhatsApp:send {mobile_no} {template_id} {from_id} {to_id}';


    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'SendPromoMsgWhatsApp';

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

        $mobile_no = $this->argument('mobile_no');
        $template_id = $this->argument('template_id');
        $from_id = $this->argument('from_id');
        $to_id = $this->argument('to_id');


        $rs_fetch = DB::select(DB::raw("SELECT `template_name`, `language`, `upload_media`, `file_path`, `media_type`, `whatsapp_media_id`, `dynamic_url_btn_indx` from `whatsApp_promo_template_detail` where `id` = $template_id and `status` = 1 limit 1;"));
        if(count($rs_fetch) == 0){
            return;
        }

        $template_name = $rs_fetch[0]->template_name;
        $language = $rs_fetch[0]->language;
        $is_upload_media = $rs_fetch[0]->upload_media;
        $media_type = $rs_fetch[0]->media_type;
        $whatsapp_media_id = $rs_fetch[0]->whatsapp_media_id;
        $dynamic_url_btn_indx = $rs_fetch[0]->dynamic_url_btn_indx;

        $media_object = [
            "id" => $whatsapp_media_id
        ];
        $media_type_name = "";
        if($media_type == 1){
            $media_type_name = "image";  
        }elseif($media_type == 2 || $media_type == 4){
            $media_type_name = "document";
            $media_object["filename"] = "ERPInfo.pdf";
        }elseif($media_type == 3){
            $media_type_name = "video";
        }

        
        $rs_fetch = DB::select(DB::raw("SELECT `configuration_value` from `master_configuration` where `configuration_type` = 1;"));
        $whatsapp_phone_id = $rs_fetch[0]->configuration_value;
        $api_url = "https://graph.facebook.com/v22.0/".$whatsapp_phone_id."/messages";

        $rs_fetch = DB::select(DB::raw("SELECT `configuration_value` from `master_configuration` where `configuration_type` = 2;"));
        $access_token = $rs_fetch[0]->configuration_value;

        $button_objects = "";
        if(strlen($mobile_no) < 10){
            $query = "SELECT `msl`.`id`, `msl`.`mobile_no` from `mst_school_list` `msl` where `msl`.`status` = 1 and `msl`.`id` >= $from_id and `msl`.`id` <= $to_id order by `msl`.`id`;";
        }else{
            $query = "SELECT '0' as `id`, '$mobile_no' as `mobile_no`;";
        }
        $rs_data = DB::select(DB::raw("$query"));
        foreach ($rs_data as $key => $val_data) {
            $rec_id = $val_data->id;
            $mobile_no = $val_data->mobile_no;

            echo "Sending To :: ".$mobile_no;

            if($dynamic_url_btn_indx >= 0){
                $button_objects = [
                    "type" => "button",
                    "sub_type" => "url",
                    "index" => "$dynamic_url_btn_indx", 
                    "parameters" => [
                        [
                            "type" => "text",
                            "text" => "book-demo-promo/".$mobile_no,
                        ],
                    ],
                ];
            }
            $this->send_on_whatsapp($rec_id, $mobile_no, $is_upload_media, $template_name, $language, $media_type_name, $media_object, $api_url, $access_token, $template_id, $button_objects);    
        }
        
        
    }

    public function send_on_whatsapp($rec_id, $mobile_no, $is_upload_media, $template_name, $language, $media_type_name, $media_object, $api_url, $access_token, $template_id, $button_objects)
    {
        $url_mobile = $mobile_no;
        $mobile_no = "91".$mobile_no;
        
        if($is_upload_media == 1){
            $data = [
                "messaging_product" => "whatsapp",
                "to" => $mobile_no,
                "type" => "template",
                "template" => [
                    "name" => $template_name,
                    "language" => [
                        "code" => $language
                    ],
              
                    "components" => [
                        [
                            "type" => "header",
                            "parameters" => [
                                [
                                    "type" => $media_type_name,
                                    $media_type_name => $media_object,
                                ],
                            ],
                        ],

                        $button_objects,

                    ],
                ],
            ];

        }else{
            $data = [
                "messaging_product" => "whatsapp",
                "to" => $mobile_no,
                "type" => "template",
                "template" => [
                    "name" => $template_name,
                    "language" => [
                        "code" => $language
                    ],
                ],
            ];
        }




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

        $rs_insert = DB::select(DB::raw("INSERT into `log_whatsApp_promo_msg`(`mobile_no`, `template_id`, `log_date`, `log_time_stamp`) values ('$mobile_no', $template_id, curdate(), now());"));    
    }

}
