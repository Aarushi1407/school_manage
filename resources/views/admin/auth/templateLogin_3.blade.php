<!DOCTYPE html>
<html>
@php
    $url_icon = "app/blank.jpg";
    $school_logo = "app/blank.jpg";
  
  Session::put('CryptoRandom', App\Helper\MyFuncs::generateId());
  Session::put('CryptoRandomInfo', App\Helper\MyFuncs::generateRandomIV());
@endphp
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Manage Schools ERP | Log in</title>
    <link href="{{ route('admin.common.imageShow.path', Crypt::encrypt($url_icon)) }}" rel="shortcut icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('admin_asset/plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{ asset('admin_asset/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('admin_asset/dist/css/AdminLTE.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin_asset/dist/css/toastr.min.css')}}">
    <style type="text/css">
        .form-control { border-radius: 1rem; height: calc(2.25rem + 2px); }
        .input-group-prepend .input-group-text {border-radius: 1rem 0 0 1rem !important;background-color: #f8f9fa;width: 45px;justify-content: center;}
        .input-group > .form-control { border-radius: 0 1rem 1rem 0 !important; }
        .btn { border-radius: 0.90rem; }
        
        /* Radio Button Styling */
        .method-container {display: flex;justify-content: space-around;background: #f4f6f9;padding: 10px;border-radius: 1rem;margin-bottom: 1.5rem;border: 1px solid #ddd;}
        .method-item { cursor: pointer; text-align: center; flex: 1; }
        .method-item input { display: none; }
        .method-item span {display: block;padding: 5px;font-size: 11px;font-weight: bold;color: #666;transition: 0.3s;border-radius: 0.7rem;}
        .method-item input:checked + span {background: #fff;color: #ff416c;box-shadow: 0 2px 5px rgba(0,0,0,0.1);}
        .btn-otp-action {background: linear-gradient(135deg, #17a2b8, #007bff);color: #fff !important;border: none;border-radius: 0.8rem;padding: 4px 12px;font-size: 10px;font-weight: 700;text-transform: uppercase;letter-spacing: 0.5px;}
        .method-item a {display: block;padding: 8px;font-size: 12px;font-weight: 600;color: #666;text-decoration: none;border-radius: 0.7rem;transition: 0.3s;}
        .method-item a.active {background: #fff;color: #ff416c;box-shadow: 0 2px 6px rgba(0,0,0,0.15);font-weight: 700;}
    </style>
</head>
<body class="hold-transition login-page" style="background: linear-gradient(135deg,#1d2671,#c33764); min-height:100vh;">

<div class="login-box" style="width:420px;">
    <div class="card shadow-lg border-0" style="border-radius:15px; overflow:hidden;">
        
        <div class="text-center p-4 text-white" style="background: linear-gradient(45deg,#ff416c,#ff4b2b);">
            <img src="{{ asset('images/logo_1.jpg') }}" style="height:80px;width:80px;border-radius:50%;border:3px solid #fff; margin-bottom: 10px; object-fit: cover;">
            <h5 class="mt-2 mb-1 font-weight-bold" style="letter-spacing: 0.5px;">School Management ERP</h5>
            <small style="display: block; letter-spacing: 1.5px; font-size: 10px; opacity: 0.8; text-transform: uppercase;"> ERP ACCESS • LOGIN TO CONTINUE </small>
        </div>

        <div class="card-body px-4 py-4">
            <form action="{{ route('login.post') }}" method="post" class="add_form" autocomplete="off" onsubmit="return hashPasswordEncryption();">
                {{ csrf_field() }}
                @if (($l_2fa == 1) || ($l_otp == 1))
                    <label class="small text-muted font-weight-bold ml-1 mb-2">Login Method</label>
                    <div class="method-container">
                        @if ($l_2fa == 1)
                            <label class="method-item">
                                <a href="{{ route('admin.login.with.2FA') }}">🛡️ 2FA</a>
                            </label>
                        @endif
                        @if ($l_otp == 1)
                            <label class="method-item">
                                <a href="{{ route('admin.login.with.otp') }}">📲 OTP</a>
                            </label>
                        @endif  
                    </div>
                @endif
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input type="text" name="email" id="email" class="form-control" placeholder="Email or Phone" required>
                </div>

                <div id="pw_grp" class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    </div>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password">
                </div>

                <div class="row align-items-center mb-3">
                    <div class="col-10">
                        <div class="captcha border rounded bg-light p-1 text-center" style="height: 45px; display: flex; align-items: center; justify-content: center;">
                            <span>{!! captcha_img('math') !!}</span>
                        </div>
                    </div>
                    <div class="col-2">
                        <button type="button" class="btn btn-light btn-block border shadow-sm" id="refresh" style="height: 45px;">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                </div>
                
                <input type="text" class="form-control mb-4 shadow-sm" placeholder="Enter Captcha Result" name="captcha" required>

                <button type="submit" class="btn btn-block text-white font-weight-bold shadow-lg" style="background:linear-gradient(45deg,#ff416c,#ff4b2b); border:none; padding: 12px; font-size: 16px;">
                    SIGN IN
                </button>

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
    <script src="{{ asset('admin_asset/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin_asset/dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('admin_asset/dist/js/toastr.min.js') }}"></script>
    <script src={!! asset('admin_asset/dist/js/crypto-js.min.js?ver=') !!}{{date('Y-m-d')}}></script>

    @include('admin.include.message')
    <script type="text/javascript">
        $('#refresh').click(function(){
            $.ajax({
                type:'GET',
                url:'{{ route('admin.refresh.captcha') }}',
                success:function(data){
                    $(".captcha span").html(data);
                }
            });
        });
    </script>
    <script>
        function hashPasswordEncryption(){
            var password = jQuery("#password").val();
            var Cryptoksduid = '<?php echo Session::get('CryptoRandom');?>';
            var Cryptoikeywords = '<?php echo Session::get('CryptoRandomInfo');?>';
            var Cryptokfydsdyg = CryptoJS.enc.Utf8.parse(Cryptoksduid);
            var encrypted = CryptoJS.DES.encrypt(password,
            Cryptokfydsdyg, {
                mode: CryptoJS.mode.CBC,
                padding: CryptoJS.pad.Pkcs7,
                iv: CryptoJS.enc.Utf8.parse(Cryptoikeywords)
            });
            var hexstr = encrypted.ciphertext.toString();
            jQuery("#password").val(hexstr);
        }
    </script>
</body>
</html>