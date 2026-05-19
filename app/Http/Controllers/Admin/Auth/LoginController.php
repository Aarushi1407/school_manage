<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Admin;
use App\Helpers\MailHelper;
use App\Helper\MyFuncs;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use Session;
use Route;
// use Jenssegers\Agent\Agent;
class LoginController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Login Controller
  |--------------------------------------------------------------------------
  |
  | This controller handles authenticating users for the application and
  | redirecting them to your home screen. The controller uses a trait
  | to conveniently provide its functionality to your applications.
  |
  */

  use AuthenticatesUsers;

  /**
  * Where to redirect users after login.
  *
  * @var string
  */

  protected $redirectTo = '/admin/dashboard';

  /**
  * Create a new controller instance.
  *
  * @return void
  */
  public function __construct()
  {
    $this->middleware('admin.guest')->except('logout');
  }

  public function loginTemplate(Request $request)
  {
    $cookie = $request->cookie('login_token');
    
    $user_id = 0;
    if (!empty($cookie)) {
      $user_id = intval(Crypt::decrypt($request->cookie('login_token'))); 
    }
    
    if ($user_id !=0) {
      $user= auth()->guard('admin')->loginUsingId($user_id);
      return redirect()->route('admin.dashboard');
    }
    
    $l_paswword = 1;
    $l_otp = 0;
    $l_2fa = 0;
    $rs_fetch = DB::select(DB::raw("SELECT `configuration_value` from `master_configuration` where `configuration_type` = 4 limit 1;"));
    if(count($rs_fetch) > 0){
      $l_options = $rs_fetch[0]->configuration_value;
      $l_2fa = intval(substr($l_options, 0, 1));
      $l_otp = intval(substr($l_options, 1, 1));
      $l_paswword = intval(substr($l_options, 2, 1));
    }
    
    $rs_fetch = DB::select(DB::raw("SELECT `configuration_value` from `master_configuration` where `configuration_type` = 5 limit 1;"));
    if (count($rs_fetch)>0) {
      $login_template = $rs_fetch[0]->configuration_value;
    }else{
      $login_template = 1;
    }

    if ($login_template == 1) {
      return view('admin.auth.templateLogin');
    }elseif($login_template == 2){
      return view('admin.auth.templateLogin_2');
    }elseif($login_template == 3){
      return view('admin.auth.templateLogin_3', compact('l_2fa', 'l_otp', 'l_paswword'));
    }elseif($login_template == 4){
      return view('admin.auth.templateLoginWithOTP', compact('l_2fa', 'l_otp', 'l_paswword'));
    }elseif($login_template == 5){
      return view('admin.auth.templateLoginWith2FA', compact('l_2fa', 'l_otp', 'l_paswword'));
    }
  }


  public function loginWithPassword(Request $request)
  {
    $cookie = $request->cookie('login_token');
    
    $user_id = 0;
    if (!empty($cookie)) {
      $user_id = intval(Crypt::decrypt($request->cookie('login_token'))); 
    }
    
    if ($user_id !=0) {
      $user= auth()->guard('admin')->loginUsingId($user_id);
      return redirect()->route('admin.dashboard');
    }
    
    $l_paswword = 1;
    $l_otp = 0;
    $l_2fa = 0;
    $rs_fetch = DB::select(DB::raw("SELECT `configuration_value` from `master_configuration` where `configuration_type` = 4 limit 1;"));
    if(count($rs_fetch) > 0){
      $l_options = $rs_fetch[0]->configuration_value;
      $l_2fa = intval(substr($l_options, 0, 1));
      $l_otp = intval(substr($l_options, 1, 1));
      $l_paswword = intval(substr($l_options, 2, 1));
    }
    return view('admin.auth.templateLogin_3', compact('l_2fa', 'l_otp', 'l_paswword'));
  }

  public function loginWithOTP(Request $request)
  {
    $cookie = $request->cookie('login_token');
    
    $user_id = 0;
    if (!empty($cookie)) {
      $user_id = intval(Crypt::decrypt($request->cookie('login_token'))); 
    }
      
    if ($user_id !=0) {
      $user= auth()->guard('admin')->loginUsingId($user_id);
      return redirect()->route('admin.dashboard');
    }
    
    $l_paswword = 1;
    $l_otp = 0;
    $l_2fa = 0;
    $rs_fetch = DB::select(DB::raw("SELECT `configuration_value` from `master_configuration` where `configuration_type` = 4 limit 1;"));
    if(count($rs_fetch) > 0){
      $l_options = $rs_fetch[0]->configuration_value;
      $l_2fa = intval(substr($l_options, 0, 1));
      $l_otp = intval(substr($l_options, 1, 1));
      $l_paswword = intval(substr($l_options, 2, 1));
    }
    return view('admin.auth.templateLoginWithOTP', compact('l_2fa', 'l_otp', 'l_paswword'));
  }

  public function loginWith2FA(Request $request)
  {
    $cookie = $request->cookie('login_token');
    
    $user_id = 0;
    if (!empty($cookie)) {
      $user_id = intval(Crypt::decrypt($request->cookie('login_token'))); 
    }
    
    if ($user_id !=0) {
      $user= auth()->guard('admin')->loginUsingId($user_id);
      return redirect()->route('admin.dashboard');
    }
    
    $l_paswword = 1;
    $l_otp = 0;
    $l_2fa = 0;
    $rs_fetch = DB::select(DB::raw("SELECT `configuration_value` from `master_configuration` where `configuration_type` = 4 limit 1;"));
    if(count($rs_fetch) > 0){
      $l_options = $rs_fetch[0]->configuration_value;
      $l_2fa = intval(substr($l_options, 0, 1));
      $l_otp = intval(substr($l_options, 1, 1));
      $l_paswword = intval(substr($l_options, 2, 1));
    }
    return view('admin.auth.templateLoginWith2FA', compact('l_2fa', 'l_otp', 'l_paswword'));
  }

  public function wop_sendotp(Request $request) 
  {

    $rules = [
      'captcha' => 'required|captcha'
    ];
    
    $validator = \Validator::make($request->all(), $rules);
    if ($validator->fails()) {
      return response()->json(['status' => 0, 'message' => 'Invalid Captcha! Please try again.']);
    }

    $email_mobile = MyFuncs::removeSpacialChr($request->email);
    $from_ip = MyFuncs::getIp();
    if(trim($email_mobile) == ''){
      return response()->json(['status' => 0, 'message' => 'Please Enter User Id/Email Id/Mobile No./Registration No.']);  
    }

    // Check Login Option is Allowed or not
    $fetch_rs = DB::select(DB::raw("SELECT substr(`configuration_value`, 2, 1) as `laopt` from `master_configuration` where `id` = 4;"));  // This is for OTP without password
    if($fetch_rs[0]->laopt == 0){
      return response()->json(['status' => 0, 'message' => 'Something Went Wrong.']); 
    }

    $fetch_rs = DB::select(DB::raw("SELECT `configuration_value` from `master_configuration` where `id` = 6;")); 
    $login_mobile_otp_option = $fetch_rs[0]->configuration_value;

    
    // Check Valid user and blocked user
    $rs_records = DB::select(DB::raw("call `up_check_login_attempt_status`('$email_mobile');"));
    if($rs_records[0]->s_status == 0){
      return response()->json(['status' => 0, 'message' => $rs_records[0]->result]);
    }
    $user_id = $rs_records[0]->user_id;

    $rs_fetch = DB::select(DB::raw("SELECT `usr`.`role_id`, `usr`.`status`, `usr`.`login_status`, `usr`.`mobile` from `admins` `usr` where `usr`.`id` = $user_id limit 1;"));
    $user_status = $rs_fetch[0]->status;
    $role_id = $rs_fetch[0]->role_id;
    $login_status = $rs_fetch[0]->login_status;
    $usr_mobile_no = $rs_fetch[0]->mobile;

    
    //check previous OTP sent time
    $rs_fetch = DB::select(DB::raw("SELECT `ao`.`id`, DATE_ADD(`ao`.`otp_sent_date_time`, INTERVAL 1 MINUTE) as `pre_sent_time`, now() as `cur_time` from `admins_otp` `ao` where `ao`.`admin_id` = $user_id and `ao`.`otp_type` = 4 limit 1;"));
    if(count($rs_fetch) > 0){
      if($rs_fetch[0]->pre_sent_time > $rs_fetch[0]->cur_time){
        return response()->json(['status' => 0, 'message' => 'Please wait 60 seconds before requesting a new OTP.']);  
      }
    }
    $rs_fetch = DB::select(DB::raw("call `up_generate_otp_newuser`($user_id, 4);"));
    $new_otp = $rs_fetch[0]->otp;
    $send_to = '******'.substr($usr_mobile_no, 6 ,10);

    \Artisan::queue('SendLoginOTP:send',['user_id'=>$user_id,'otp'=>$new_otp,'mobile_no'=>$usr_mobile_no,'sent_option'=>$login_mobile_otp_option])->onQueue('high');

    return response()->json(['status' => 1, 'send_to' =>$send_to, 'message' => 'OTP has been sent successfully to your registered mobile']);

  }

  public function sendOtp_2FA(Request $request) 
  {
    // Check Input Validation -------------------
    $validator = \Validator::make($request->all(), [
      'email'   => 'required',
    ]);

    if ($validator->fails()) {
      return response()->json(['status' => 0,'message' => 'Please Enter User ID/Email/Mobile/Registration No.']);
    }

    $validator = \Validator::make($request->all(), [
      'password'     => 'required',
    ]);

    if ($validator->fails()) {
      return response()->json(['status' => 0,'message' => 'Please Enter Password']);
    }

    $validator = \Validator::make($request->all(), [
      'captcha' => 'required|captcha' 
    ]);

    if ($validator->fails()) {
      return response()->json(['status' => 0,'message' => 'Invalid Captcha']);
    }

    // -----------------------------------------------------

    $key = Session::get('CryptoRandom');
    $iv = Session::get('CryptoRandomInfo');
    $data = hex2bin($request['password']);
    $decryptedpass = openssl_decrypt($data, 'DES-CBC', $key, OPENSSL_RAW_DATA, $iv);

    $email_mobile = MyFuncs::removeSpacialChr($request->email);
    $from_ip = MyFuncs::getIp();

    
    // Check Login Option is Allowed or not
    $fetch_rs = DB::select(DB::raw("SELECT substr(`configuration_value`, 1, 1) as `laopt` from `master_configuration` where `id` = 4 limit 1;"));  // This is for 2FA password
    if($fetch_rs[0]->laopt == 0){
      return response()->json(['status' => 0, 'message' => 'Something Went Wrong.']); 
    }

    $fetch_rs = DB::select(DB::raw("SELECT `configuration_value` from `master_configuration` where `id` = 6 limit 1;")); 
    $login_mobile_otp_option = $fetch_rs[0]->configuration_value;

    
    // Check Valid user and blocked user
    $rs_records = DB::select(DB::raw("call `up_check_login_attempt_status`('$email_mobile');"));
    if($rs_records[0]->s_status == 0){
      return response()->json(['status' => 0, 'message' => $rs_records[0]->result]);
    }
    $user_id = $rs_records[0]->user_id;

    $rs_fetch = DB::select(DB::raw("SELECT `usr`.`role_id`, `usr`.`status`, `usr`.`login_status`, `usr`.`mobile`, `password` from `admins` `usr` where `usr`.`id` = $user_id limit 1;"));
    $user_status = $rs_fetch[0]->status;
    $role_id = $rs_fetch[0]->role_id;
    $login_status = $rs_fetch[0]->login_status;
    $usr_mobile_no = $rs_fetch[0]->mobile;
    $usr_password = $rs_fetch[0]->password;

    // Check Password --------------
    if (!Hash::check($decryptedpass, $usr_password)) {
      $rs_update = DB::select(DB::raw("call `up_login_attempt_action`($user_id, '$from_ip', 0);"));
      return response()->json(['status' => 0, 'message' => 'Invalid UserID/Password. Please try again.']);
    }

    
    //check previous OTP sent time
    $rs_fetch = DB::select(DB::raw("SELECT `ao`.`id`, DATE_ADD(`ao`.`otp_sent_date_time`, INTERVAL 1 MINUTE) as `pre_sent_time`, now() as `cur_time` from `admins_otp` `ao` where `ao`.`admin_id` = $user_id and `ao`.`otp_type` = 4 limit 1;"));
    if(count($rs_fetch) > 0){
      if($rs_fetch[0]->pre_sent_time > $rs_fetch[0]->cur_time){
        return response()->json(['status' => 0, 'message' => 'Please wait 60 seconds before requesting a new OTP.']);  
      }
    }
    $rs_fetch = DB::select(DB::raw("call `up_generate_otp_newuser`($user_id, 4);"));
    $new_otp = $rs_fetch[0]->otp;
    $send_to = '******'.substr($usr_mobile_no, 6 ,10);

    \Artisan::queue('SendLoginOTP:send',['user_id'=>$user_id,'otp'=>$new_otp,'mobile_no'=>$usr_mobile_no,'sent_option'=>$login_mobile_otp_option])->onQueue('high');

    return response()->json(['status' => 1, 'send_to' =>$send_to, 'message' => 'OTP has been sent successfully to your registered mobile/email.']);

  }

  public function loginPost(Request $request)
  { 
    $this->validate($request, [
      'email' => 'required', 
      'password' => 'required',
      'captcha' => 'required|captcha' 
    ]);

    // Check Login Option is Allowed or not
    $fetch_rs = DB::select(DB::raw("SELECT substr(`configuration_value`, 3, 1) as `laopt` from `master_configuration` where `id` = 4;"));  // This is With Password Only
    if($fetch_rs[0]->laopt == 0){
      return Redirect()->back()->with(['message'=>'Something Went Wrong','class'=>'error']);
    }

    $key = Session::get('CryptoRandom');
    $iv = Session::get('CryptoRandomInfo');
    $data = hex2bin($request['password']);
    $decryptedpass = openssl_decrypt($data, 'DES-CBC', $key, OPENSSL_RAW_DATA, $iv);
    $email_mobile = MyFuncs::removeSpacialChr($request->email);
    $from_ip = MyFuncs::getIp();

    

    // Check Valid User id or Blocked
    $rs_records = DB::select(DB::raw("call `up_check_login_attempt_status`('$email_mobile');"));
    if($rs_records[0]->s_status == 0){
      return Redirect()->back()->with(['message'=>$rs_records[0]->result,'class'=>'error']);
    }
    $user_id = $rs_records[0]->user_id;

    $rs_fetch = DB::select(DB::raw("SELECT `usr`.`role_id`, `usr`.`status`, `usr`.`mobile` from `admins` `usr` where `usr`.`id` = $user_id limit 1;"));
    $user_status = $rs_fetch[0]->status;
    $role_id = $rs_fetch[0]->role_id;
    $usr_mobile_no = $rs_fetch[0]->mobile;

    $credentials = [
      'id' => $user_id,
      'password' => $decryptedpass,
      'status' => 1,
    ];

    if(auth()->guard('admin')->attempt($credentials)) {
      $user_id = MyFuncs::getUserId();
      $from_ip = MyFuncs::getIp();

      $rs_update = DB::select(DB::raw("call `up_login_attempt_action`($user_id, '$from_ip', 1);"));
      $rs_update = DB::select(DB::raw("call `up_change_login_status`($user_id, '$from_ip');"));
      $this->setPermanentLogin($user_id);
      return redirect()->route('admin.dashboard');     
    }

    $rs_update = DB::select(DB::raw("call `up_login_attempt_action`($user_id, '$from_ip', 0);"));
    return Redirect()->back()->with(['message'=>'Invalid User or Password','class'=>'error']);    
  }

  public function loginOTPPost(Request $request)
  { 
    // Check Input Validation -------------------
    $validator = \Validator::make($request->all(), [
      'email'   => 'required',
    ]);
    if ($validator->fails()) {
      return response()->json(['status' => 0,'message' => 'Please Enter User ID/Email/Mobile/Registration No.']);
    }

    $validator = \Validator::make($request->all(), [
      'otp'     => 'required|numeric',
    ]);
    if ($validator->fails()) {
      return response()->json(['status' => 0,'message' => 'Please Enter OTP']);
    }

    $validator = \Validator::make($request->all(), [
      'captcha' => 'required|captcha' 
    ]);

    if ($validator->fails()) {
      return response()->json(['status' => 0,'message' => 'Invalid Captcha']);
    }

    $email_mobile = MyFuncs::removeSpacialChr($request->email);
    $l_otp = MyFuncs::removeSpacialChr($request->otp);
    $from_ip = MyFuncs::getIp();

    if (strlen($l_otp) != 6){
      return response()->json(['status' => 0,'message' => 'Invalid OTP']);  
    }

    // -----------------------------------------------------


    // Check Login Option is Allowed or not
    $fetch_rs = DB::select(DB::raw("SELECT substr(`configuration_value`, 2, 1) as `laopt` from `master_configuration` where `id` = 4;"));  // This is for OTP without password
    if($fetch_rs[0]->laopt == 0){
      return response()->json(['status' => 0, 'message' => 'Something Went Wrong.']); 
    }

    
    // Check Valid User id or Blocked
    $rs_records = DB::select(DB::raw("call `up_check_login_attempt_status`('$email_mobile');"));
    if($rs_records[0]->s_status == 0){
      return response()->json(['status' => 0, 'message' => $rs_records[0]->result]);
    }
    $user_id = $rs_records[0]->user_id;

    $rs_fetch = DB::select(DB::raw("SELECT `usr`.`role_id`, `usr`.`status`, `usr`.`mobile` from `admins` `usr` where `usr`.`id` = $user_id limit 1;"));
    $user_status = $rs_fetch[0]->status;
    $role_id = $rs_fetch[0]->role_id;
    $usr_mobile_no = $rs_fetch[0]->mobile;

    // Check OTP ---------------------------
    $rs_check = DB::select(DB::raw("call `up_verify_login_otp`($user_id, '$l_otp', 4, '$from_ip');"));
    if($rs_check[0]->s_status <= 1){
      return response()->json(['status' => 0, 'message' => $rs_check[0]->result]);  
    }

    if(auth()->guard('admin')->loginUsingId($user_id)) {
      // Logging and Status Updates
      $user_id = MyFuncs::getUserId();
      
      $rs_update = DB::select(DB::raw("call `up_login_attempt_action`($user_id, '$from_ip', 1);"));
      $rs_update = DB::select(DB::raw("call `up_change_login_status`($user_id, '$from_ip');"));
      
      $this->setPermanentLogin($user_id);

      return response()->json([
        'status' => 1, 
        'message' => 'Login Successful! Redirecting...',
        'url' => route('admin.dashboard')
      ]);
    }

    $rs_update = DB::select(DB::raw("call `up_login_attempt_action`($user_id, '$from_ip', 0);"));
    return response()->json(['status' => 0, 'message' => 'Authentication Failed']);    
  }

  public function loginWith2FAPost(Request $request)
  { 

    // Check Input Validation -------------------
    $validator = \Validator::make($request->all(), [
      'email'   => 'required',
    ]);

    if ($validator->fails()) {
      return response()->json(['status' => 0,'message' => 'Please Enter User ID/Email/Mobile/Registration No.']);
    }

    $validator = \Validator::make($request->all(), [
      'password'     => 'required',
    ]);

    if ($validator->fails()) {
      return response()->json(['status' => 0,'message' => 'Please Enter Password']);
    }

    $validator = \Validator::make($request->all(), [
      'otp'     => 'required|numeric',
    ]);
    if ($validator->fails()) {
      return response()->json(['status' => 0,'message' => 'Please Enter OTP']);
    }

    $validator = \Validator::make($request->all(), [
      'captcha' => 'required|captcha' 
    ]);

    if ($validator->fails()) {
      return response()->json(['status' => 0,'message' => 'Invalid Captcha']);
    }

    // -----------------------------------------------------

    $email_mobile = MyFuncs::removeSpacialChr($request->email);
    $l_otp = MyFuncs::removeSpacialChr($request->otp);
    $from_ip = MyFuncs::getIp();

    if (strlen($l_otp) != 6){
      return response()->json(['status' => 0,'message' => 'Invalid OTP']);  
    }

    $key = Session::get('CryptoRandom');
    $iv = Session::get('CryptoRandomInfo');
    $data = hex2bin($request['password']);
    $decryptedpass = openssl_decrypt($data, 'DES-CBC', $key, OPENSSL_RAW_DATA, $iv);

    // Check Login Option is Allowed or not
    $fetch_rs = DB::select(DB::raw("SELECT substr(`configuration_value`, 1, 1) as `laopt` from `master_configuration` where `id` = 4 limit 1;"));  // This is for 2FA
    if($fetch_rs[0]->laopt == 0){
      return response()->json(['status' => 0, 'message' => 'Something Went Wrong(01)']); 
    }
    
    
    // Check Valid user and blocked user
    $rs_records = DB::select(DB::raw("call `up_check_login_attempt_status`('$email_mobile');"));
    if($rs_records[0]->s_status == 0){
      return response()->json(['status' => 0, 'message' => $rs_records[0]->result]);
    }
    $user_id = $rs_records[0]->user_id;

    $rs_fetch = DB::select(DB::raw("SELECT `usr`.`role_id`, `usr`.`status`, `usr`.`login_status`, `usr`.`mobile`, `password` from `admins` `usr` where `usr`.`id` = $user_id limit 1;"));
    $user_status = $rs_fetch[0]->status;
    $role_id = $rs_fetch[0]->role_id;
    $login_status = $rs_fetch[0]->login_status;
    $usr_mobile_no = $rs_fetch[0]->mobile;
    $usr_password = $rs_fetch[0]->password;

    
    // Check Password --------------
    if (!Hash::check($decryptedpass, $usr_password)) {
      $rs_update = DB::select(DB::raw("call `up_login_attempt_action`($user_id, '$from_ip', 0);"));
      return response()->json(['status' => 0, 'message' => 'Invalid UserID/Password. Please try again.']);
    }


    // Check OTP ---------------------------
    $rs_check = DB::select(DB::raw("call `up_verify_login_otp`($user_id, '$l_otp', 4, '$from_ip');"));
    if($rs_check[0]->s_status <= 1){
      return response()->json(['status' => 0, 'message' => $rs_check[0]->result]);  
    }
    

    if(auth()->guard('admin')->loginUsingId($user_id)) {
      // Logging and Status Updates
      $user_id = MyFuncs::getUserId();
      $from_ip = MyFuncs::getIp();

      $rs_update = DB::select(DB::raw("call `up_login_attempt_action`($user_id, '$from_ip', 1);"));
      $rs_update = DB::select(DB::raw("call `up_change_login_status`($user_id, '$from_ip');"));
      
      $this->setPermanentLogin($user_id);

      return response()->json([
        'status' => 1, 
        'message' => 'Login Successful! Redirecting...',
        'url' => route('admin.dashboard')
      ]);
    }

    $rs_update = DB::select(DB::raw("call `up_login_attempt_action`($user_id, '$from_ip', 0);"));
    return response()->json(['status' => 0, 'message' => 'Authentication Failed']);    
  }

  public function refreshCaptcha()
  {  
    return  captcha_img('math');
  }


  public function setPermanentLogin($user_id)
  {
    $user_id = Crypt::encrypt($user_id);
    Cookie::queue('login_token', $user_id, 131400);    
  }

  // Logout method with guard logout for admin only
  public function logout(Request $request)
  {
    $user_id = MyFuncs::getUserId();
    if($user_id > 0){
      $rs_update = DB::select(DB::raw("call `up_change_logout_status`($user_id);"));
      $this->guard()->logout();
      $request->session()->flush();
      $request->session()->regenerate();

      
      $mainpage = 'admin.login';
      $cookie = Cookie::forget('login_token');
      return redirect()->route($mainpage)->withCookie($cookie);
    }
    
    $mainpage = 'admin.login';
    $cookie = Cookie::forget('login_token');
    return redirect()->route($mainpage)->withCookie($cookie); 
  }

  //    //defining auth  guard
  protected function guard()
  {
    return Auth::guard('admin');
  }

}
