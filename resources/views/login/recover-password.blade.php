<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>{{trans('english.CSTI_FULL')}}</title>

        <meta content="Command and Staff Training Institute (CSTI) " name="description" />
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
        <div class="logo">
            <a href="{{URL::to('/')}}">
                <img src="{{URL::to('/')}}/public/img/CSTI-Monogram.png" alt="CSTI Logo" style="width: 150px;height: 150px;"  /> 
            </a>
        </div>
        <!-- END LOGO -->
        <div class="form-title" style="color: #edf4f8;font-size: 19px;font-weight: 400!important;text-align: center;display: block;">
            <span class="form-title">{{trans('english.CSTI_FULL')}}</span>
        </div>
        <!-- BEGIN LOGIN -->
        <div class="content">
            <!-- BEGIN LOGIN FORM -->

            <h3 class="form-title font-green">{{trans('english.SET_NEW_PASSWORD')}}</h3>


            <div class="form-group font-red" id="recover-response">

            </div>

            <div id="password-group">
                <div class="form-group">
                    <input class="form-control placeholder-no-fix" id="password" type="password" autocomplete="off" placeholder="New Password" name="password" /> 
                    <span class="help-block">{{ trans('english.COMPLEX_PASSWORD_INSTRUCTION') }}</span>
                </div>

                <div class="form-group">
                    <input class="form-control placeholder-no-fix" id="confirm-password" type="password" autocomplete="off" placeholder="Confirm Password" name="confirm_password" /> 
                </div>

                <div class="form-actions">
                    <input type="hidden" name="ref" id="ref" value="{{$ref}}" />
                    <button type="button" id="back-btn" class="btn green btn-outline">{{trans('english.BACK')}}</button>
                    <button type="submit" id="recover-password" class="btn btn-success uppercase pull-right">{{trans('english.SAVE')}}</button>
                </div>
            </div>

            <!-- END FORGOT PASSWORD FORM -->
        </div>
        <div class="copyright"> Copyright &COPY; <?php echo date("Y"); ?>. All Rights Reserved. | Powered By <a target="_blank" href="http://www.swapnoloke.com/">{{trans('english.SWAPNOLOKE')}}</a> </div>
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

                    var password = $('#password').val();
                    var confirm_password = $('#confirm-password').val();
                    var ref = $('#ref').val();

                    //alert(ref);

                    $.ajax({
                        url: "{{ URL::to('resetPassword')}}",
                        type: "POST",
                         headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {"password": password, "confirm_password": confirm_password, "ref": ref},
                        dataType: 'html',
                        cache: false,
                        beforeSend: function () {

                        },
                    }).done(function (response) {
                        var data = $.parseJSON(response);
                        $('#recover-response').html(data.response_text);

                        if (data.response == true) {
                            $('#password-group').html('');

                            setTimeout(function () {
                                window.location = "{{ URL::to('/login') }}";
                            }, 3000);
                        }

                    });
                });
            });

        </script>

    </body>

</html>




<?php /*

{{ Form::open(array('url' => 'doRecoverPassword', 'class' => 'validate-form form-horizontal', 'autocomplete'=>'off')) }}


<div class="row">
    <div class="col-md-8 col-md-offset-2 custom-box">

        <div class="row">
            <div class="col-md-12 text-center confirmation-text">
                {{trans('bangla.SET_NEW_PASSWORD')}}
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 text-center">
                @if(Session::has('error'))
                <div class="text-danger confirmation-error">{{ Session::get('error') }}</div>
                <?php Session::forget('error'); ?>
                @endif
            </div>
        </div>


        <div class="row custom-input-reg">
            <div class="col-md-1">&nbsp;</div>
            <div class="col-md-4"> {{trans('bangla.NEW_PASSWORD')}}</div>
            <div class="col-md-6">                                  
                <input type="password" name="password" class="form-control custom-input" placeholder="{{trans('english.PASSWORD_INSTRUCTION')}}" id="password" value="" required="required" />
                <span class="text-danger">{{  $errors->first('password') }} </span>
            </div>
        </div>
        <div class="row custom-input-reg">
            <div class="col-md-1">&nbsp;</div>
            <div class="col-md-4">  {{trans('bangla.CONFIRM_PASSWORD')}} </div>
            <div class="col-md-6">                                    
                <input type="password" name="confirm_password" class="form-control custom-input" id="confirm_password" value="" required="required" />
                <span class="text-danger">{{  $errors->first('confirm_password') }} </span>
            </div>
        </div>

        <div class="row custom-input-div">
            <div class="col-md-12 text-center">
                
                <button type="submit" id="reg-next" class="btn btn-custom2">{{trans('bangla.RESET')}}</button>
            </div>
        </div>

    </div>
</div>


{{Form::close()}}
