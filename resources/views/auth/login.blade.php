<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>{{trans('english.DYSIG_GROUP')}}</title>

        <meta content="{{trans('english.DYSIG_GROUP')}}" name="description" />
        <meta content="" name="author" />
         <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="{{asset('public/assets/global/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('public/assets/global/plugins/simple-line-icons/simple-line-icons.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('public/assets/global/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('public/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="{{asset('public/assets/global/css/components.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('public/assets/global/css/plugins.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="{{asset('public/assets/pages/css/login.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" type="image/icon" href="{{URL::to('/')}}/public/img/favicon.ico"/>
        <!-- END HEAD -->

    </head>
    <body class="login">
        <!-- BEGIN LOGO -->
        <!--
<div class="logo">
    <a href="{{URL::to('/')}}">
        <img src="{{URL::to('/')}}/public/img/CSTI-Monogram.png" alt="CSTI Logo" style="width: 150px;height: 150px;"  />
    </a>
</div>
        -->
        <!-- END LOGO -->
        <div class="form-title" style="color: #edf4f8;font-size: 19px;font-weight: 400!important;text-align: center;display: block;">
            <span class="form-title">&nbsp;</span>
        </div>
        <!-- BEGIN LOGIN -->
        <div class="content">
            <!-- BEGIN LOGO -->
            <div class="logo_login_page" style="padding:15px;text-align:center; background-color:#6c7a8d;margin: -10px -40px 0px;">
                <a href="{{URL::to('/')}}">
                    <img src="{{URL::to('/')}}/public/img/logo.png" alt="{{trans('english.DYSIG_GROUP')}}" style="width: 100px;height: auto; border-radius:3px;border:7px solid #ffffff;background-color:#ffffff;" title="{{trans('english.HORIZON_TITLE')}}"  />
                </a>
            </div>
            <!-- END LOGO -->


            <!-- BEGIN LOGIN FORM -->
            <form class="login-form " method="POST" style="padding:0 15px" action="{{ route('login') }}">
                @csrf
                <h3 class="form-title font-green">{{trans('english.LOGIN')}} 
                </h3>
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    <span> {{trans('english.ENTER_ANY_USERNAME_AND_PASSWORD')}}</span>
                </div>
                <?php $sesMessag = Session::has('error'); ?>
                @if (!empty($sesMessag))
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    <p><i class="fa fa-bell-o fa-fw"></i> <?php echo Session::get('error'); ?></p>
                </div>
                @endif
                @error('username')
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    <p><i class="fa fa-bell-o fa-fw"></i>{{$message}}</p>
                </div>
                @enderror
                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">{{trans('english.USERNAME')}}</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="username" /> </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">{{trans('english.PASSWORD')}}</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" />
                    <input type="hidden" autocomplete="off" name="pid" value="{{ !empty(Request::get('pid'))?Request::get('pid'):'' }}"/>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn green uppercase">{!! trans('english.LOGIN') !!}</button>
                    <!--<label class="rememberme check mt-checkbox mt-checkbox-outline">
                        <input type="checkbox" name="remember" value="1" />{{trans('english.REMEMBER')}}
                        <span></span>
                    </label>
                    <a href="javascript:;" id="forget-password" class="forget-password">Forgot Password?</a>-->
                </div>
                <div class="create-account" style="padding: 0px;">
                    <p><a href="{{URL::to('/')}}" class="uppercase">GO TO HOME PAGE</a></p>
                </div>
                {{Form::close()}}
                <!-- END LOGIN FORM -->
                <!-- BEGIN FORGOT PASSWORD FORM -->
                <form class="forget-form">
                    <h3 class="font-green">Forget Password ?</h3>
                    <p> Enter your e-mail address below to reset your password. </p>

                    <div class="form-group font-red" id="recover-response">

                    </div>

                    <div class="form-group">
                        <input class="form-control placeholder-no-fix" id="email" type="text" autocomplete="off" placeholder="Email" name="email" />
                    </div>
                    <div class="form-actions">
                        <button type="button" id="back-btn" class="btn green btn-outline">{{trans('english.BACK')}}</button>
                        <button type="button" id="recover-password" class="btn btn-success uppercase pull-right">{{trans('english.SUBMIT')}}</button>
                    </div>
                </form>
                <!-- END FORGOT PASSWORD FORM -->
        </div>
        <div class="copyright">{!! trans('english.COPYRIGHT') !!}</div>
        <!--[if lt IE 9]>
        <script src="{{URL::to('/')}}/public/assets/global/plugins/respond.min.js"></script>
        <script src="{{URL::to('/')}}/public/assets/global/plugins/excanvas.min.js"></script>
        <script src="{{URL::to('/')}}/public/assets/global/plugins/ie8.fix.min.js"></script>
        <![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="{{asset('public/assets/global/plugins/jquery.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('public/assets/global/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('public/assets/global/plugins/js.cookie.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('public/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('public/assets/global/plugins/jquery.blockui.min.js')}}" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{asset('public/assets/global/plugins/jquery-validation/js/jquery.validate.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('public/assets/global/plugins/jquery-validation/js/additional-methods.min.js')}}" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="{{asset('public/assets/global/scripts/app.min.js')}}" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="{{asset('public/assets/pages/scripts/login.min.js')}}" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <!-- END THEME LAYOUT SCRIPTS -->


        <script type="text/javascript">

$(document).ready(function () {

    $('#recover-password').on("click", function () {

        var email = $('#email').val();

        $.ajax({
            url: "{{ URL::to('forgotPassword')}}",
            type: "POST",
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            data: {"email": email},
            dataType: 'html',
            cache: false,
            beforeSend: function () {

            },
        }).done(function (response) {
            var data = $.parseJSON(response);
            $('#recover-response').html(data.response_text);
        });
    });
});

        </script>

    </body>

</html>
