<!DOCTYPE html>
<html>
@php
    $url_icon = "app/blank.jpg";
    $school_logo = "app/blank.jpg";
    
  // $SchoolDetail = Illuminate\Support\Facades\DB::select("SELECT * from `school_details` limit 1;");
  // $url_icon = count($SchoolDetail) > 0 ? "app/".$SchoolDetail[0]->url_icon : "app/blank.jpg";
  // $school_logo = count($SchoolDetail) > 0 ? "app/".$SchoolDetail[0]->logo : "app/blank.jpg";
  // $rs_school_detail = App\Helper\WebHelper::getSchoolDetail(1);
@endphp
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Manage Schools ERP | Log in</title>
    <link href="{{ route('admin.common.imageShow.path', Crypt::encrypt($url_icon)) }}" rel="shortcut icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="{{ asset('admin_asset/plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{ asset('admin_asset/dist/css/AdminLTE.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin_asset/dist/css/toastr.min.css')}}">

    <style type="text/css">
        body { background: linear-gradient(135deg,#1d2671,#c33764); min-height:100vh; }
        .login-box { width: 400px; }
        .card { border-radius: 15px; overflow: hidden; }
        .form-control { border-radius: 1rem; height: 45px; }
        .input-group-prepend .input-group-text { border-radius: 1rem 0 0 1rem !important; width: 45px; justify-content: center; }
        .input-group > .form-control { border-radius: 0 1rem 1rem 0 !important; }
        .btn-round { border-radius: 1rem; padding: 10px; font-weight: bold; transition: 0.3s; }
        

        /* Radio Button Styling */
        .method-container {display: flex;justify-content: space-around;background: #f4f6f9;padding: 10px;border-radius: 1rem;margin-bottom: 1.5rem;border: 1px solid #ddd;}
        .method-item { cursor: pointer; text-align: center; flex: 1; }
        .method-item input { display: none; }
        .method-item span {display: block;padding: 5px;font-size: 11px;font-weight: bold;color: #666;transition: 0.3s;border-radius: 0.7rem;}
        .method-item input:checked + span {background: #fff;color: #ff416c;box-shadow: 0 2px 5px rgba(0,0,0,0.1);}
        .btn-otp-action {background: linear-gradient(135deg, #17a2b8, #007bff);color: #fff !important;border: none;border-radius: 0.8rem;padding: 4px 12px;font-size: 10px;font-weight: 700;text-transform: uppercase;letter-spacing: 0.5px;}
        .method-item a {display: block;padding: 8px;font-size: 12px;font-weight: 600;color: #666;text-decoration: none;border-radius: 0.7rem;transition: 0.3s;}
        .method-item a.active {background: #fff;color: #ff416c;box-shadow: 0 2px 6px rgba(0,0,0,0.15);font-weight: 700;}

        .otp_section { display: none; margin-top: 20px; border-top: 1px dashed #ddd; padding-top: 20px; }
        #resend_link { color: #007bff; cursor: pointer; text-decoration: underline; display: none; }
        #timer_display { color: #dc3545; font-weight: bold; }
        .edit-link { font-size: 12px; cursor: pointer; color: #fff; text-decoration: underline; margin-left: 10px; }
    </style>
</head>

<body class="hold-transition login-page" style="background: linear-gradient(135deg,#1d2671,#c33764);">

<div class="login-box">
    <div class="card shadow-lg border-0">
        <div class="text-center p-4 text-white" style="background: linear-gradient(45deg,#ff416c,#ff4b2b);">
            <img src="{{ asset('images/logo_1.jpg') }}" style="height:80px;width:80px;border-radius:50%;border:3px solid #fff; margin-bottom: 10px; object-fit: cover;">
            <h5 class="mt-2 mb-0">School Management ERP</h5>
            <div class="d-flex justify-content-center align-items-center">
                <small style="display: block; letter-spacing: 1.5px; font-size: 10px; opacity: 0.8; text-transform: uppercase;"> ERP ACCESS • LOGIN TO CONTINUE • OTP </small>
            </div>
        </div>

        <div class="card-body px-4 py-4">
            <form action="{{ route('login.loginOTPPost') }}" method="post" autocomplete="off" id="loginForm">
            {{ csrf_field() }}
                @if (($l_2fa == 1) || ($l_paswword == 1))
                    <label class="small text-muted font-weight-bold ml-1 mb-2">Login Method</label>
                    <div class="method-container">
                        @if ($l_2fa == 1)
                            <label class="method-item">
                                <a href="{{ route('admin.login.with.2FA') }}">🛡️ 2FA</a>
                            </label>
                        @endif
                        @if ($l_paswword == 1)
                            <label class="method-item">
                                <a type="button" href="{{ route('admin.login.with.password') }}">🔐 Password</a>
                            </label>
                        @endif
                    </div>
                @endif
                <div id="input_area">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
                        <input type="text" name="email" id="email" class="form-control" placeholder="Email or Phone" required>
                    </div>
                    <div class="otp_section">
                        <p class="text-center small text-muted">
                            OTP sent to: <strong id="send_to" class="text-dark"></strong>
                        </p>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-key text-primary"></i></span></div>
                            <input type="text" name="otp" id="otp_input" class="form-control" placeholder="Enter 6-digit OTP" required minlength="6" maxlength="6" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-10">
                            <div class="captcha border rounded bg-light p-1 text-center" style="height: 45px; display: flex; align-items: center; justify-content: center;">
                                <span id="captcha_box">{!! captcha_img('math') !!}</span>
                            </div>
                        </div>
                        <div class="col-2">
                            <button type="button" class="btn btn-light btn-block border h-100" id="refresh_captcha">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                    </div>
                    <input type="text" class="form-control mb-3" placeholder="Enter Captcha Result" id="captcha_input" name="captcha" required>

                    <button type="button" class="btn btn-info btn-block btn-round shadow" onclick="sendOTP('normal')" id="otp_btn">
                        GET OTP
                    </button>
                </div>

                <div class="otp_section">
                    {{-- <div class="input-group mb-2">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-key text-primary"></i></span></div>
                        <input type="text" name="otp" id="otp_input" class="form-control" placeholder="Enter 6-digit OTP" maxlength="6" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                    </div> --}}

                    <div class="text-center mb-3">
                        <span class="resend-text">
                            <span id="timer_container">Wait for Resend <span id="timer_display">60</span>s</span>
                            <span id="resend_link" onclick="sendOTP('resend')">Resend OTP</span>
                        </span>
                        <div id="resend_status" class="small text-muted mt-1"></div>
                    </div>

                    <button type="submit" class="btn btn-block btn-round text-white shadow-lg" style="background:linear-gradient(45deg,#ff416c,#ff4b2b); border:none;">
                        SIGN IN NOW
                    </button>
                </div>
                {{-- <div class="text-center mt-3">
                    <a href="{{ route('template.index',[1,1]) }}" class="text-muted small" style="text-decoration: none;">
                        <i class="fas fa-arrow-left mr-1"></i> Back to Home
                    </a>
                </div> --}}
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('admin_asset/plugins/jQuery/jquery.min.js') }}"></script>
<script src="{{ asset('admin_asset/dist/js/toastr.min.js') }}"></script>

<script>
    var timeLeft = 60;
    var timerId;
    var resendCount = 0;
    const MAX_RESEND = 3;

    function startTimer() {
        timeLeft = 60;
        $('#resend_link').hide();
        $('#timer_container').show();
        clearInterval(timerId);
        timerId = setInterval(function() {
            timeLeft--;
            $('#timer_display').text(timeLeft);
            if (timeLeft <= 0) {
                clearInterval(timerId);
                $('#timer_container').hide();
                if (resendCount < MAX_RESEND) {
                    $('#resend_link').fadeIn();
                } else {
                    $('#resend_status').text('Maximum resend limit reached.');
                }
            }
        }, 1000);
    }

    function reloadCaptcha() {
        $.get('{{ route("admin.refresh.captcha") }}', function(data){
            $("#captcha_box").html(data);
            $('#otp_input').val('').focus();
            $('#captcha_input').val('');
        });
    }

    function sendOTP(type) {
        const email = $('#email').val();
        const captcha = $('#captcha_input').val();

        if(!email) { toastr.error('Email/Phone is required'); return; }
        if(!captcha) { toastr.error('Please Enter the captcha first'); return; }
        
        if(type === 'resend' && resendCount >= MAX_RESEND) {
            toastr.error('Max resend limit reached');
            return;
        }

        let originalBtnText = $('#otp_btn').text();
        $('#otp_btn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');
        
        $.ajax({
            type: "POST",
            url: "{{ route('admin.login.wop_sendotp') }}",
            data: { email: email, captcha: captcha, _token: '{{ csrf_token() }}' },
            success: function(res) {
                if(res.status == 1) {
                    toastr.success('OTP Sent Successfully');
                    if(type === 'resend') resendCount++;
                    
                    $('.otp_section').slideDown();
                    $('#otp_btn').hide();
                    $('#email').prop('readonly', true);
                    $('#edit_email').fadeIn();
                    
                    $('#resend_status').text(`Attempts: ${resendCount}/${MAX_RESEND}`);
                    $('#send_to').text(res.send_to);
                    startTimer();
                    reloadCaptcha(); // Naya captcha Sign-in ke liye
                } else {
                    toastr.error(res.message || 'Invalid Captcha');
                    $('#otp_btn').prop('disabled', false).text('GET OTP');
                    reloadCaptcha();
                }
            },
            error: function() {
                toastr.error('Server error. Try again.');
                $('#otp_btn').prop('disabled', false).text('GET OTP');
                reloadCaptcha();
            }
        });
    }

    function editLoginDetails() {
        $('.otp_section').slideUp();
        $('#email').prop('readonly', false).focus();
        $('#otp_btn').show().prop('disabled', false).text('GET OTP');
        $('#edit_email').hide();
        resendCount = 0; // Reset count on edit
        reloadCaptcha();
    }

    $('#refresh_captcha').click(reloadCaptcha);

    $('#loginForm').on('submit', function(e) {
        e.preventDefault(); // Page refresh rokne ke liye

        // Check agar OTP 6 digit ka nahi hai
        if($('#otp_input').val().length != 6) {
            toastr.error('Please enter a valid 6-digit OTP');
            return false;
        }

        if($('#captcha_input').val() === "") {
            toastr.error('Captcha is required for Sign In');
            reloadCaptcha();
            return false;
        }

        let form = $(this);
        let btn = form.find('button[type="submit"]');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Authenticating...');

        $.ajax({
            type: "POST",
            url: form.attr('action'),
            data: form.serialize(),
            success: function(res) {
                if(res.status == 1) {
                    toastr.success(res.message);
                    window.location.href = res.url; 
                } else {
                    toastr.error(res.message);
                    btn.prop('disabled', false).text('SIGN IN NOW');
                    reloadCaptcha(); // Galat OTP ya Captcha par naya captcha load karein
                }
            },
            error: function() {
                toastr.error('Server Error. Please try again.');
                btn.prop('disabled', false).text('SIGN IN NOW');
                reloadCaptcha();
            }
        });
    });
</script>
</body>
</html>