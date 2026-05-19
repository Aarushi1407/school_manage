<?php

namespace App\Helper;
use Illuminate\Support\Facades\DB;
use App\Helper\MyFuncs;
class WhatsApp {

  
  public static function uploadWhatsAppMedia($media_file_path, $phone_number_id, $access_token) 
  {
    $upload_url = "https://graph.facebook.com/v22.0/" . $phone_number_id . "/media";

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $media_file_path);
    finfo_close($finfo);

    // Prepare POST fields
    $post_fields = [
      "file" => curl_file_create($media_file_path, $mime_type, basename($media_file_path)),
      "type" => $mime_type,
      "messaging_product" => "whatsapp"
    ];

    $ch = curl_init($upload_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer " . $access_token
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $error_message = 'cURL Error: ' . curl_error($ch);
        curl_close($ch);
        return ["success" => false, "error" => $error_message];
    } else {
        curl_close($ch);
        $decoded_response = json_decode($response, true);
        if (isset($decoded_response['error'])) {
            return ["success" => false, "error" => $decoded_response['error']];
        }
        return ["success" => true, "media_id" => $decoded_response['id']];
    }
  }

}