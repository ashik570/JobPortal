<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>{{trans('english.COMMAND_AND_STAFF_TRAINING_INSTITUTE_CSTI_BAF')}}</title>

        <meta content="Command and Staff Training Institute (CSTI), BAF" name="description" />
        <meta content="" name="author" />
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
        <link href="{{asset('public/assets/pages/css/error.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" type="image/icon" href="{{URL::to('/')}}/public/img/favicon.ico"/>
        <!-- END HEAD -->

    </head>
    <body class=" page-404-full-page">
        <div class="row">
            <div class="col-md-12 page-404">
                <div class="number font-red"> 404 </div>
                <div class="details">
                    <h3>Oops! You're lost.</h3>
                    <p> We can not find the page you're looking for.
                        <br/>
                        <?php
                        if (Auth::guest()) {
                            //If not LoggedIn, Show home Page 
                            ?>
                            <a href="{{URL::to('/')}}"> Return home </a></p>
                        <?php
                    } else {
                        //If LoggedIn, show "DASHBOARD" 
                        ?>
                        <a href="{{URL::to('dashboard')}}">{{ trans('english.DASHBOARD') }}</a></p>
                        <?php
                    }
                    ?>



                </div>
            </div>
        </div> 
        <div class="row">
            <div class="col-md-12 page-404">
                <div class="number font-red"></div>
                <div class="details">
                    <footer>
                        <div class="copyright">{!!trans('english.COPYRIGHT')!!}</div> <!--[if lt IE 9]>-->
                    </footer>
                </div>
            </div>
        </div>

        <script src="{{URL::to('/')}}/public/assets/global/plugins/respond.min.js"></script>
        <script src="{{URL::to('/')}}/public/assets/global/plugins/excanvas.min.js"></script> 
        <script src="{{URL::to('/')}}/public/assets/global/plugins/ie8.fix.min.js"></script> 
        <!--[endif]-->
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


    </body>

</html>
