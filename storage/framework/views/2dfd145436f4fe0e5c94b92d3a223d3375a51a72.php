
<?php $__env->startSection('content'); ?>

<!-- BEGIN CONTENT BODY -->
<div class="page-content dashboard-page-content">

    <div class="dashboard-scroller">
        
        <div class="serverDateTime">
            <strong><span class="calendar_icon">&nbsp;</span>  <?php echo date('d F Y '); ?> <span id="timeCountUp"><?php echo date('H:i:s'); ?></span></strong>
        </div>

    </div>

    <?php echo $__env->make('includes.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="row">
        <div class="col-md-12">


            <div class="portlet light dashboard-light ">

                <div class="row">
                    <div class="col-md-3">
                        <div class="profile-userpic">
                            <?php if(isset($userInfoArr->photo)): ?>
                            <img  src="<?php echo e(URL::to('/')); ?>/public/uploads/user/<?php echo e($userInfoArr->photo); ?>" class="img-responsive" alt="<?php echo e($userInfoArr->first_name.' '.$userInfoArr->last_name); ?>">
                            <?php else: ?>
                            <img  src="<?php echo e(URL::to('/')); ?>/public/img/unknown.png" class="img-responsive" alt="<?php echo e($userInfoArr->first_name.' '.$userInfoArr->last_name); ?>">
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-md-3">

                        <div class="dashboard-profile-highlight"> <?php echo e($userInfoArr->first_name.' '.$userInfoArr->last_name); ?> </div>
                        <div class=""> <?php echo e(trans('english.DESIGNATION')); ?> :<?php echo e($userInfoArr->designation->title); ?> </div>
                        <div class=""> <?php echo e(trans('english.APPOINTMENT')); ?> : <?php echo e($userInfoArr->appointment->title); ?></div>

                    </div>

                    <div class="col-md-6">
                        <div id="courseAvailable">

                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

</div>


<link href="<?php echo e(asset('public/assets/pages/css/profile.min.css')); ?>" rel="stylesheet" type="text/css" />
<script src="<?php echo e(asset('public/js/apexchart.js')); ?>"></script>
<script type="text/javascript">
$(function () {

    $(".popovers").popover({html: true});

});
    var timerVar = setInterval(countTimer, 1000);
    var totalSeconds = <?php
                        $time = date("H:i:s");
                        echo strtotime($time) - strtotime('00:00:00');
                        ?>;
    function countTimer() {
        ++totalSeconds;
        var hour = Math.floor(totalSeconds / 3600);
        var minute = Math.floor((totalSeconds - hour * 3600) / 60);
        var seconds = totalSeconds - (hour * 3600 + minute * 60);
        if (hour < 10)
            hour = "0" + hour;
        if (minute < 10)
            minute = "0" + minute;
        if (seconds < 10)
            seconds = "0" + seconds;
        document.getElementById("timeCountUp").innerHTML = hour + ":" + minute + ":" + seconds;
    }
</script>

<style type="text/css">

    .dashboard-stat .visual{
        height: 60px !important;
    }

</style>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\swapnoloke\resources\views/dashboard/super_admin.blade.php ENDPATH**/ ?>