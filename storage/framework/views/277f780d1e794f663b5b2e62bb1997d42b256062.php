<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?php echo app('translator')->get('english.SWAPNOLOKE_JOB_VACANCY'); ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="<?php echo app('translator')->get('label.DYSIG_GROUP'); ?>" name="description" />
        <meta content="" name="author" />
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <!-- BEGIN GLOBAL MANDATORY STYLES
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />-->
        <link href="<?php echo e(asset('public/assets/global/plugins/font-awesome/css/font-awesome.min.css')); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(asset('public/assets/global/plugins/simple-line-icons/simple-line-icons.min.css')); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(asset('public/assets/global/plugins/bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(asset('public/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')); ?>" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->

        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="<?php echo e(asset('public/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css')); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(asset('public/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(asset('public/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(asset('public/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(asset('public/assets/global/plugins/morris/morris.css')); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(asset('public/assets/global/plugins/fullcalendar/fullcalendar.min.css')); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(asset('public/assets/global/plugins/jqvmap/jqvmap/jqvmap.css')); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(asset('public/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(asset('public/assets/global/plugins/bootstrap-toastr/toastr.min.css')); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(asset('public/assets/global/plugins/bootstrap-multiselect/css/bootstrap-multiselect.css')); ?>" rel="stylesheet" type="text/css" />


        <!--FOR Jquery DataTable-->
        <link href="<?php echo e(asset('public/assets/global/plugins/datatables/datatables.min.css')); ?>" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->

         <!-- BEGIN select2 LEVEL PLUGINS -->
        <link href="<?php echo e(asset('public/assets/global/plugins/select2/css/select2.min.css')); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(asset('public/assets/global/plugins/select2/css/select2-bootstrap.min.css')); ?>" rel="stylesheet" type="text/css" />
        <!-- END select2 LEVEL PLUGINS -->

        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="<?php echo e(asset('public/assets/global/css/components.min.css')); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(asset('public/assets/global/css/plugins.min.css')); ?>" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->

        <!-- BEGIN PAGE LEVEL STYLES FOR DASHBOARD-->
        <link href="<?php echo e(asset('public/assets/pages/css/pricing.css')); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(asset('public/assets/global/plugins/bootstrap-sweetalert/sweetalert.css')); ?>" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->

        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="<?php echo e(asset('public/assets/layouts/layout/css/layout.min.css')); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(asset('public/assets/layouts/layout/css/themes/darkblue.min.css')); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(asset('public/css/cropper.css')); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(asset('public/assets/layouts/layout/css/custom.css')); ?>" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="<?php echo e(asset('public/frontend/assets/css/custom.css')); ?>"  type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" type="image/icon" href="<?php echo e(URL::to('/')); ?>/public/img/swapnoloke.png"/>
        <?php
        $currentControllerName = Request::segment(1);
        $action = Request::segment(2);
        ?>
        <?php if(($currentControllerName == 'tae' && $action == '') ||
        ($currentControllerName == 'taetostudent' && $action == '') ||
        ($currentControllerName == 'taetostudent' && $action == 'finalsubmission') ||
        ($currentControllerName == 'taeassignmarks' && $action == '')): ?>
        <link href="<?php echo e(asset('public/css/jquery-ui.css')); ?>" rel="stylesheet" type="text/css" />
       <script src="<?php echo e(asset('public/js/jquery-1.11.1.min.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/js/jquery-ui.min.js')); ?>" type="text/javascript"></script>
        <?php else: ?>
         <!-- BEGIN CORE PLUGINS -->
       <script src="<?php echo e(asset('public/assets/global/plugins/jquery.min.js')); ?>" type="text/javascript"></script>
        <?php endif; ?>
       <script src="<?php echo e(asset('public/assets/global/plugins/bootstrap/js/bootstrap.min.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/global/plugins/js.cookie.min.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/global/plugins/jquery.blockui.min.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')); ?>" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
       <script src="<?php echo e(asset('public/js/jquery.mCustomScrollbar.min.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/js/jquery.newsTicker.js')); ?>" type="text/javascript"></script>
    </head>

    <body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-content-white">
        <div class="page-wrapper">
            <!-- BEGIN HEADER -->
            <?php echo $__env->make('includes.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <!-- END HEADER -->

            <!-- BEGIN CONTAINER -->
            <div class="page-container">
                <!-- BEGIN SIDEBAR -->
                <?php echo $__env->make('includes.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <!-- END SIDEBAR -->

                <!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <?php echo $__env->yieldContent('content'); ?>
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->

                <!-- BEGIN QUICK SIDEBAR -->
                <!--<?php echo $__env->make('includes.quicksidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>-->
                <!-- END QUICK SIDEBAR -->
            </div>
            <!-- END CONTAINER -->

            <!-- BEGIN FOOTER -->
            <?php echo $__env->make('includes.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <!-- END FOOTER -->
        </div>
        <!-- BEGIN QUICK NAV -->
        <!--<?php echo $__env->make('includes.quicknav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>-->
        <!-- END QUICK NAV -->

        <!-- BEGIN PAGE LEVEL PLUGINS -->
       <script src="<?php echo e(asset('public/assets/global/plugins/moment.min.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/global/plugins/morris/morris.min.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/global/plugins/morris/raphael-min.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/global/plugins/counterup/jquery.waypoints.min.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/global/plugins/counterup/jquery.counterup.min.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/global/plugins/amcharts/amcharts/amcharts.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/global/plugins/amcharts/amcharts/serial.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/global/plugins/amcharts/amcharts/pie.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/global/plugins/amcharts/amcharts/radar.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/global/plugins/amcharts/amcharts/themes/light.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/global/plugins/amcharts/amcharts/themes/patterns.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/global/plugins/amcharts/amcharts/themes/chalk.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/global/plugins/amcharts/ammap/ammap.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/global/plugins/amcharts/ammap/maps/js/worldLow.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/global/plugins/amcharts/amstockcharts/amstock.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/global/plugins/fullcalendar/fullcalendar.min.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/global/plugins/horizontal-timeline/horizontal-timeline.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/global/plugins/flot/jquery.flot.min.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/global/plugins/flot/jquery.flot.resize.min.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/global/plugins/flot/jquery.flot.categories.min.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/global/plugins/jquery.sparkline.min.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js')); ?>" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->

         <!--BEGIN FOR DATERANGE & DATE PICKER PLUGINS-->
       <script src="<?php echo e(asset('public/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')); ?>" type="text/javascript"></script>
        <!--END FOR DATERANGE & DATE PICKER PLUGINS-->

        <!--BEGIN FOR JQUERY REPEATER PLUGINS-->
        <!--BEGIN FOR JQUERY REPEATER PLUGINS-->

       <script src="<?php echo e(asset('public/assets/global/plugins/select2/js/select2.full.min.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/global/plugins/bootstrap-multiselect/js/bootstrap-multiselect.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/pages/scripts/components-bootstrap-multiselect.min.js')); ?>" type="text/javascript"></script>
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
       <script src="<?php echo e(asset('public/assets/global/scripts/app.min.js')); ?>" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->

        <!-- BEGIN PAGE LEVEL SCRIPTS -->
       <script src="<?php echo e(asset('public/js/jquery.marquee.min.js')); ?>" type="text/javascript"></script>

       <script src="<?php echo e(asset('public/assets/pages/scripts/custom.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/global/plugins/datatables/datatables.min.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/pages/scripts/table-datatables-managed.min.js')); ?>" type="text/javascript"></script>

       <script src="<?php echo e(asset('public/assets/pages/scripts/components-date-time-pickers.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/pages/scripts/dashboard.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/global/plugins/bootstrap-toastr/toastr.min.js')); ?>" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->

        <!-- BEGIN THEME LAYOUT SCRIPTS -->
       <script src="<?php echo e(asset('public/assets/layouts/layout/scripts/layout.min.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/layouts/layout/scripts/demo.min.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/assets/layouts/global/scripts/quick-sidebar.min.js')); ?>" type="text/javascript"></script>
       <script src="<?php echo e(asset('public/js/cropper.js')); ?>" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
        <script type="text/javascript">
        $(document).ready(function(){
            var heightx = $(".page-container").height();
            $('.page-sidebar').attr('style', 'min-height: '+ heightx + 'px !important' );
        });

        $(document).on('click', '.note-btn', function(){
            $('.modal-backdrop').hide();
            $('.modal.in .modal-dialog').css('top', '15%');
        });
        </script>
    </body>
</html>
<?php /**PATH D:\xampp\htdocs\swapnoloke\resources\views/layouts/default.blade.php ENDPATH**/ ?>