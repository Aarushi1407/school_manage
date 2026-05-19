<?php

namespace App\Helper;
use App\Admin;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Route;
use Illuminate\Support\Facades\DB;

class WebHelper {

  protected $e_controller = "WebHelper";

  // public function exception_handler()
  // {
  //   try {
        
  //   } catch (\Exception $e) {
  //     $e_method = "imageShowPath";
  //     return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
  //   }
  // }

    
  // public static function db_update_date_time()
  // {
  //   try {
  //     $save = DB::select(DB::raw("UPDATE `school_details` set `update_date_time` = now() limit 1;"));    
  //   } catch (\Exception $e) {
  //     $e_method = "db_update_date_time";
  //     return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
  //   }
    
  // }

  // public static function getSchoolDetail($l_lang_type)
  // {
  //   try {
  //     $field_names = "";
  //     if($l_lang_type == 1){
  //       $field_names = ", `name` as `school_name`, `opening_time` as `lang_open_time`, `address` as `uni_address`, `footer_description` as `uni_footer` "; 
  //     }elseif($l_lang_type == 2){
  //       $field_names = ", `name_l` as `school_name`, `opening_time_l` as `lang_open_time`, `address_l` as `uni_address`, `footer_description_l` as `uni_footer` "; 
  //     }
  //     $result_rs = DB::select(DB::raw("SELECT `id`, `email`, `mobile`, `contact`, `name`, `name_l`, `url_icon`, `logo`, `update_date_time`, `facebook_link`, `twitter_link`, `youtube_link`, `banner_size`, `reg_length`, `map`, `c_map` $field_names from `school_details` limit 1;"));  
  //     return $result_rs;  
  //   } catch (\Exception $e) {
  //     $e_method = "getSchoolDetail";
  //     return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
  //   }
      
  // }

  // public static function getHomeBannerImage($l_lang_type)
  // {
  //   try {
  //     $field_names = "";
  //     if($l_lang_type == 1){
  //       $field_names = ", `description` as `banner_discription` "; 
  //     }elseif($l_lang_type == 2){
  //       $field_names = ", `description_l` as `banner_discription` "; 
  //     }
  //     $result_rs = DB::select(DB::raw("SELECT `id`, `category_id`, `image`, `description`, `display_order`, `status`, `description_l` $field_names from `web_gallery` where `status` = 1 order by `display_order`, `id`;"));  
  //     return $result_rs;  
  //   } catch (\Exception $e) {
  //     $e_method = "getHomeBannerImage";
  //     return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
  //   }
      
  // }

  // public static function getFeatures($l_lang_type, $limit_val, $rec_id)
  // {
  //   try {
  //     $limit_cond = "";
  //     if ($limit_val > 0) {
  //       $limit_cond = "limit $limit_val"; 
  //     }
  //     $condition = "";
  //     if($rec_id > 0){
  //       $condition = " where `f`.`id` = $rec_id ";
  //     }
  //     $field_names = "";
  //     if($l_lang_type == 1){
  //       $field_names = ", `f`.`title` as `uni_title`, `f`.`sub_title` as `uni_sub_title` "; 
  //     }elseif($l_lang_type == 2){
  //       $field_names = ", `f`.`title_l` as `uni_title`, `f`.`sub_title_l` as `uni_sub_title` "; 
  //     }
      
  //     $result_rs = DB::select(DB::raw("SELECT `f`.`id`, `f`.`title`, `f`.`title_l`, `f`.`sub_title`, `f`.`sub_title_l`, `it`.`icon`, `it`.`icon_color`, `it`.`text_color` $field_names from `features` `f` inner join `icon_type` `it` on `it`.`id` = `f`.`icon_id` $condition order by `f`.`display_order`, `f`.`id` $limit_cond;"));  
  //     return $result_rs;  
  //   } catch (\Exception $e) {
  //     $e_method = "getFeatures";
  //     return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
  //   }
      
  // }

  // public static function getFeaturesDetail($l_lang_type, $feature_id)
  // {
  //   try {
  //     $condition = "";
  //     if($feature_id > 0){
  //       $condition = " where `fd`.`features_id` = $feature_id ";
  //     }
  //     $field_names = "";
  //     if($l_lang_type == 1){
  //       $field_names = ", `fd`.`description` as `uni_detail` "; 
  //     }elseif($l_lang_type == 2){
  //       $field_names = ", `fd`.`description_l` as `uni_detail` "; 
  //     }
      
  //     $result_rs = DB::select(DB::raw("SELECT `fd`.`id`, `fd`.`image` $field_names from `features_detail` `fd` $condition;"));  
  //     return $result_rs;  
  //   } catch (\Exception $e) {
  //     $e_method = "getFeaturesDetail";
  //     return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
  //   }
      
  // }

  // public static function getInfrastructure($l_lang_type, $limit_val)
  // {
  //   try {
  //     $condition = "";
  //     if ($limit_val > 0) {
  //       $condition = "limit $limit_val"; 
  //     }

  //     $field_names = "";
  //     if($l_lang_type == 1){
  //       $field_names = ", `f`.`title` as `uni_title`, `f`.`sub_title` as `uni_sub_title` "; 
  //     }elseif($l_lang_type == 2){
  //       $field_names = ", `f`.`title_l` as `uni_title`, `f`.`sub_title_l` as `uni_sub_title` "; 
  //     }
  //     $result_rs = DB::select(DB::raw("SELECT `f`.`image`, `f`.`title`, `f`.`title_l`, `f`.`sub_title`, `f`.`sub_title_l`, `it`.`text_color` $field_names from `infrastructure` `f` left join `icon_type` `it` on `it`.`id` = `f`.`text_color` order by `f`.`display_order`, `f`.`id` $condition;"));  
  //     return $result_rs;  
  //   } catch (\Exception $e) {
  //     $e_method = "getInfrastructure";
  //     return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
  //   }
  // }

  // public static function getTeacher($l_lang_type, $limit_val)
  // {
  //   try {
  //     $condition = "";
  //     if ($limit_val > 0) {
  //       $condition = "limit $limit_val"; 
  //     }

  //     $field_names = "";
  //     if($l_lang_type == 1){
  //       $field_names = ", `emp`.`name` as `uni_name`, `desg`.`sub_desig_name` as `uni_designation` "; 
  //     }elseif($l_lang_type == 2){
  //       $field_names = ", case `emp`.`name_l` when '' then `emp`.`name` else `emp`.`name_l` end as `uni_name`, case `desg`.`sub_desig_name_l` when '' then `desg`.`sub_desig_name` else `desg`.`sub_desig_name_l` end as `uni_designation` "; 
  //     }
  //     $result_rs = DB::select(DB::raw("SELECT `emp`.`id`, `emp`.`image` $field_names from `employee_details` `emp` inner join `designations` `desg` on `desg`.`id` = `emp`.`designation_id` where `emp`.`desig_category_id` = 1 and `emp`.`status` = 1 $condition;"));
  //     return $result_rs;    
  //   } catch (\Exception $e) {
  //     $e_method = "getTeacher";
  //     return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
  //   }
  // }

  // public static function getGellery($l_lang_type, $limit_val)
  // {
  //   try {
  //     $condition = "";
  //     if ($limit_val > 0) {
  //       $condition = "limit $limit_val"; 
  //     }
  //     $field_names = "";
  //     if($l_lang_type == 1){
  //       $field_names = ", `gy`.`title` as `uni_title` "; 
  //     }elseif($l_lang_type == 2){
  //       $field_names = ", `gy`.`title_l` as `uni_title` "; 
  //     }
  //     $result_rs = DB::select(DB::raw("SELECT `gy`.`id`, `gy`.`image` $field_names from `gallery` `gy` order by `gy`.`display_order` $condition;"));  
  //     return $result_rs;    
  //   } catch (\Exception $e) {
  //     $e_method = "getGellery";
  //     return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
  //   }
  // }

  // public static function getEvents($l_lang_type, $limit_val, $rec_id)
  // {
  //   try {
  //     $limit_cond = "";
  //     if ($limit_val > 0) {
  //       $limit_cond = "limit $limit_val"; 
  //     }
  //     $condition = "";
  //     if($rec_id > 0){
  //       $condition = " where `f`.`id` = $rec_id ";
  //     }

  //     $field_names = "";
  //     if($l_lang_type == 1){
  //       $field_names = ", `f`.`title` as `uni_title`, `f`.`sub_title` as `uni_sub_title`, `f`.`description` as `uni_description` "; 
  //     }elseif($l_lang_type == 2){
  //       $field_names = ", `f`.`title_l` as `uni_title`, `f`.`sub_title_l` as `uni_sub_title`, `f`.`description_l` as `uni_description` ";
  //     }
  //     $result_rs = DB::select(DB::raw("SELECT `f`.`id`, `f`.`image`, `f`.`date`, `f`.`time`, `it`.`icon_color` as `text_color` $field_names from `web_page_event` `f` left join `icon_type` `it` on `it`.`id` = `f`.`text_color` $condition order by `f`.`display_order`, `f`.`id` $limit_cond;"));  
  //     return $result_rs;    
  //   } catch (\Exception $e) {
  //     $e_method = "getEvents";
  //     return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
  //   }
  // }

  // public static function getAbout($l_lang_type)
  // {
  //   try {
  //     $field_names = "";
  //     if($l_lang_type == 1){
  //       $field_names = ", `wpa`.`description` as `uni_description` "; 
  //     }elseif($l_lang_type == 2){
  //       $field_names = ", `wpa`.`description_l` as `uni_description` "; 
  //     }
  //     $result_rs = DB::select(DB::raw("SELECT `wpa`.`id`, `wpa`.`image`, `wpa`.`description`, `wpa`.`description_l` $field_names from `web_page_about` `wpa`;"));  
  //     return $result_rs;    
  //   } catch (\Exception $e) {
  //     $e_method = "getAbout";
  //     return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
  //   }
  // }

  // public static function getFacts($l_lang_type)
  // {
  //   try {
  //     $field_names = "";
  //     if($l_lang_type == 1){
  //       $field_names = ", `wpf`.`title` as `uni_title`, `wpf`.`sub_title` as `uni_sub_title`, `wpf`.`caption_1` as `uni_caption_1`, `wpf`.`caption_2` as `uni_caption_2`, `wpf`.`caption_3` as `uni_caption_3`, `wpf`.`caption_4` as `uni_caption_4` "; 
  //     }elseif($l_lang_type == 2){
  //       $field_names = ", `wpf`.`title_l` as `uni_title`, `wpf`.`sub_title_l` as `uni_sub_title`, `wpf`.`caption_1_l` as `uni_caption_1`, `wpf`.`caption_2_l` as `uni_caption_2`, `wpf`.`caption_3_l` as `uni_caption_3`, `wpf`.`caption_4_l` as `uni_caption_4` ";
  //     }
  //     $result_rs = DB::select(DB::raw("SELECT `wpf`.`id`, `wpf`.`val_1`, `wpf`.`val_2`, `wpf`.`val_3`, `wpf`.`val_4` $field_names from `web_page_facts` `wpf`;"));
  //     return $result_rs;    
  //   } catch (\Exception $e) {
  //     $e_method = "getFacts";
  //     return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
  //   }
  // }

  // public static function getMorePage($l_lang_type)
  // {
  //   try {
  //     $field_names = "";
  //     if($l_lang_type == 1){
  //       $field_names = ", `link_name` as `link_text` "; 
  //     }elseif($l_lang_type == 2){
  //       $field_names = ", `link_name_l` as `link_text` "; 
  //     }
      
  //     $result_rs = DB::select(DB::raw("SELECT `id`, `link_name`, `link_name_l` $field_names from `more_page` order by `display_order`;"));  
  //     return $result_rs;    
  //   } catch (\Exception $e) {
  //     $e_method = "getMorePage";
  //     return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
  //   }
  // }

  // public static function getMorePageDetail($l_lang_type, $page_id)
  // {
  //   try {
  //     $field_names = "";
  //     if($l_lang_type == 1){
  //       $field_names = ", `link_name` as `link_text`, `page_heading` as `uni_heading`, `page_content` as `uni_content` "; 
  //     }elseif($l_lang_type == 2){
  //       $field_names = ", `link_name_l` as `link_text`, `page_heading_l` as `uni_heading`, `page_content_l` as `uni_content` "; 
  //     }
      
  //     $result_rs = DB::select(DB::raw("SELECT `id`, `link_type`, `file_path` $field_names, `status` from `more_page` where `id` = $page_id limit 1;"));  
  //     return $result_rs;    
  //   } catch (\Exception $e) {
  //     $e_method = "getMorePageDetail";
  //     return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
  //   }
  // }

  // public static function getWhosWho($l_lang_type, $limit_val, $rec_id)
  // {
  //   try {
  //     $limit_cond = "";
  //     if ($limit_val > 0) {
  //       $limit_cond = "limit $limit_val"; 
  //     }
  //     $condition = "";
  //     if($rec_id > 0){
  //       $condition = " where `pww`.`id` = $rec_id ";
  //     }
  //     $field_names = "";
  //     if($l_lang_type == 1){
  //       $field_names = ", `pww`.`name` as `uni_name`, `pww`.`designation` as `uni_desig`, `pww`.`message` as `uni_message` "; 
  //     }elseif($l_lang_type == 2){
  //       $field_names = ", `pww`.`name_l` as `uni_name`, `pww`.`designation_l` as `uni_desig`, `pww`.`message_l` as `uni_message` "; 
  //     }
      
  //     $result_rs = DB::select(DB::raw("SELECT `pww`.`id`, `pww`.`image` $field_names from `web_page_whos_who` `pww` $condition order by `pww`.`display_order` $limit_cond;"));  
  //     return $result_rs;    
  //   } catch (\Exception $e) {
  //     $e_method = "getWhosWho";
  //     return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
  //   }
  // }

  // public static function getPopupFlash()
  // {
  //   try {
  //     $result_rs = DB::select(DB::raw("SELECT * from `popup_flash` where `from_date` <= curdate() and `to_date` >= curdate() and `status` = 1 ;"));  
  //     return $result_rs;    
  //   } catch (\Exception $e) {
  //     $e_method = "getPopupFlash";
  //     return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
  //   }
  // }

  // public static function getNoticeboard($l_lang_type)
  // {
  //   try {
  //     $field_names = "";
  //     if($l_lang_type == 1){
  //       $field_names = ", `title` as `uni_title`, `sub_title` as `uni_subtitle` "; 
  //     }elseif($l_lang_type == 2){
  //       $field_names = ", `title_l` as `uni_title`, `sub_title_l` as `uni_subtitle` "; 
  //     }
      
  //     $result_rs = DB::select(DB::raw("SELECT `nb`.`id`, `nb`.`title`, `nb`.`title_l`, `nb`.`sub_title`, `nb`.`sub_title_l`, `nb`.`notice_detail`, `nb`.`file_path`, `nb`.`post_date` $field_names from `notice_board` `nb` where `nb`.`from_date` <= curdate() and `nb`.`to_date` >= curdate() and `nb`.`status` = 1 order by `nb`.`display_order`;"));  
  //     return $result_rs;    
  //   } catch (\Exception $e) {
  //     $e_method = "getNoticeboard";
  //     return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
  //   }
  // }
  
  // public static function getMandatoryDisclousre($l_lang_type)
  // {
  //   try {
  //     $field_names = "";
  //     if($l_lang_type == 1){
  //       $field_names = ", `link_name` as `uni_link_name` "; 
  //     }elseif($l_lang_type == 2){
  //       $field_names = ", `link_name_l` as `uni_link_name` "; 
  //     }
      
  //     $result_rs = DB::select(DB::raw("SELECT `id`, `file_path` $field_names from `mandatory_disclosure` order by `display_order`;"));  
  //     return $result_rs;    
  //   } catch (\Exception $e) {
  //     $e_method = "getMandatoryDisclousre";
  //     return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
  //   }
  // }
  
  // public static function getCaptionDictionary($l_lang_type)
  // {
  //   try {
  //     $word_dictionary = array();
  //     // Hindi English Values
  //     if($l_lang_type == 1){
  //       $word_dictionary['home_page_title'] = "Welcome To";
  //       $word_dictionary['c_open_time'] = "Opening Time";
  //       $word_dictionary['change_language'] = 2;
  //       $word_dictionary['c_change_language'] = "हिंदी में देखें";
  //       $word_dictionary['c_login'] = "Login";
  //       $word_dictionary['c_admission'] = "Admission";
  //       $word_dictionary['c_feepay'] = "Fee Payment";
  //       $word_dictionary['c_certificate'] = "Certificate";
  //       $word_dictionary['c_slc'] = "School Living Certificate";
  //       $word_dictionary['c_character'] = "Character Certificate";
  //       $word_dictionary['f_character'] = "Fee/CEA Certificate";
  //       $word_dictionary['check_character'] = "Check Certificate";
  //       $word_dictionary['c_home'] = "Home";
  //       $word_dictionary['c_menu_about'] = "About";
  //       $word_dictionary['c_about_us'] = "About US";
  //       $word_dictionary['c_office_bearear'] = "Office Bearers";
  //       $word_dictionary['c_gallery'] = "Gallery";
  //       $word_dictionary['c_image'] = "Images";
  //       $word_dictionary['c_video'] = "Videos";
  //       $word_dictionary['c_teachers'] = "Teachers";
  //       $word_dictionary['c_events'] = "Events";
  //       $word_dictionary['c_more'] = "More";
  //       $word_dictionary['c_feature'] = "Features";
  //       $word_dictionary['c_infrastructure'] = "Infrastructure";
  //       $word_dictionary['c_calender'] = "Calendar";
  //       $word_dictionary['c_cbsc_mandate'] = "CBSE Mandatory Disclosure";
  //       $word_dictionary['c_library'] = "Library";
  //       $word_dictionary['c_contacts'] = "Contact Us";
  //       $word_dictionary['c_notice'] = "Notice";
  //       $word_dictionary['c_board'] = "Board";
  //       $word_dictionary['c_view_all'] = "View All";
  //       $word_dictionary['c_read_more'] = "Read More";
  //       $word_dictionary['c_address'] = "Address";
  //       $word_dictionary['c_name'] = "Name";
  //       $word_dictionary['c_email'] = "Email";
  //       $word_dictionary['c_mobile'] = "Mobile";
  //       $word_dictionary['c_number'] = "Number";
  //       $word_dictionary['c_subject'] = "Subject";
  //       $word_dictionary['c_message'] = "Message";
  //       $word_dictionary['c_send'] = "Send";
  //       $word_dictionary['c_close'] = "Close";
  //       $word_dictionary['c_useful'] = "Useful";
  //       $word_dictionary['c_link'] = "Links";
  //       $word_dictionary['c_map'] = "Map";
  //       $word_dictionary['c_web_designed_by'] = "Designed By EAGESKOOL";
  //       $word_dictionary['c_last_update'] = "Last Update On";
  //       $word_dictionary['download'] = "Download";
  //     }elseif($l_lang_type == 2){
  //       $word_dictionary['home_page_title'] = "आपका स्वागत है";
  //       $word_dictionary['c_open_time'] = "स्कूल खुलने का समय";
  //       $word_dictionary['change_language'] = 1;
  //       $word_dictionary['c_change_language'] = "View in English";
  //       $word_dictionary['c_login'] = "लॉग इन करें";
  //       $word_dictionary['c_admission'] = "प्रवेश";
  //       $word_dictionary['c_feepay'] = "शुल्क भुगतान";
  //       $word_dictionary['c_certificate'] = "प्रमाणपत्र";
  //       $word_dictionary['c_slc'] = "विद्यालय छोड़ने का प्रमाणपत्र";
  //       $word_dictionary['c_character'] = "चरित्र प्रमाणपत्र";
  //       $word_dictionary['f_character'] = "शुल्क/सीईए प्रमाणपत्र";
  //       $word_dictionary['check_character'] = "प्रमाण पत्र की जांच करें";
  //       $word_dictionary['c_home'] = "मुख्य पृष्ठ";
  //       $word_dictionary['c_menu_about'] = "जानकरी";
  //       $word_dictionary['c_about_us'] = "हमारे बारे में";
  //       $word_dictionary['c_office_bearear'] = "पदाधिकारी";
  //       $word_dictionary['c_gallery'] = "गैलरी";
  //       $word_dictionary['c_image'] = "छवि";
  //       $word_dictionary['c_video'] = "वीडियो";
  //       $word_dictionary['c_teachers'] = "शिक्षक";
  //       $word_dictionary['c_events'] = "आयोजन";
  //       $word_dictionary['c_more'] = "अतिरिक्त";
  //       $word_dictionary['c_feature'] = "विशेषताएँ";
  //       $word_dictionary['c_infrastructure'] = "आधारभूत संरचना";
  //       $word_dictionary['c_calender'] = "पंचांग";
  //       $word_dictionary['c_cbsc_mandate'] = "सीबीएसई अनिवार्य प्रकटीकरण";
  //       $word_dictionary['c_library'] = "पुस्तकालय";
  //       $word_dictionary['c_contacts'] = "संपर्क करें";
  //       $word_dictionary['c_notice'] = "सूचना";
  //       $word_dictionary['c_board'] = "पट्ट";
  //       $word_dictionary['c_view_all'] = "सभी को देखें";
  //       $word_dictionary['c_read_more'] = "इस बारे में अधिक पढ़ें";
  //       $word_dictionary['c_address'] = "पता";
  //       $word_dictionary['c_name'] = "नाम";
  //       $word_dictionary['c_email'] = "ईमेल";
  //       $word_dictionary['c_mobile'] = "मोबाइल";
  //       $word_dictionary['c_number'] = "नंबर";
  //       $word_dictionary['c_subject'] = "विषय";
  //       $word_dictionary['c_message'] = "संदेश";
  //       $word_dictionary['c_send'] = "भेजें";
  //       $word_dictionary['c_close'] = "बंद करें";
  //       $word_dictionary['c_useful'] = "उपयोगी";
  //       $word_dictionary['c_link'] = "कड़ियां";
  //       $word_dictionary['c_map'] = "नक्शा";
  //       $word_dictionary['c_web_designed_by'] = "EAGESKOOL द्वारा डिज़ाइन किया गया";
  //       $word_dictionary['c_last_update'] = "अंतिम अद्यतन दिनांक";
  //       $word_dictionary['download'] = "प्राप्त करे";
  //     }

  //     return $word_dictionary;    
  //   } catch (\Exception $e) {
  //     $e_method = "getCaptionDictionary";
  //     return MyFuncs::Exception_error_handler($this->e_controller, $e_method, $e->getMessage());
  //   }
  // }
  
}