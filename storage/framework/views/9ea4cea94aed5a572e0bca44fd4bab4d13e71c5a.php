<div class="modal-content" >
    <div class="modal-header clone-modal-header" >
        <button type="button" data-dismiss="modal" data-placement="left" class="btn red pull-right tooltips" title="<?php echo app('translator')->get('english.CLOSE_THIS_POPUP'); ?>"><?php echo app('translator')->get('english.CLOSE'); ?></button>
        <h3 class="modal-title text-center">
            <?php echo app('translator')->get('english.INTERACTION_LOG'); ?>
        </h3>
    </div>
    <?php echo Form::open(array('group' => 'form', 'url' => '#','class' => 'form-horizontal' ,'id' => 'submitActivityForm')); ?>

    <div class="modal-body">

        <!--condition-->

        <div class="row">
            <div class="col-md-12">
                <div class="tabbable-line">
                    <ul class="nav nav-tabs ">
                        <li class="active" id="logHistory">
                            <a href="#tab_15_1" id="logBtn" data-toggle="tab"> <?php echo app('translator')->get('english.LOG_HISTORY'); ?> </a>
                        </li>

                        <li id="setActivityLog_">
                            <a href="#tab_15_2" id="activitySetBtn" data-toggle="tab"> <?php echo app('translator')->get('english.SET_ACTIVITY_LOG'); ?> </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <!-- Start:: Activity Log tab -->
                        <div class="tab-pane active" id="tab_15_1">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive max-height-500 padding-top-10 webkit-scrollbar">
                                        <table class="table table-bordered table-hover">
                                            <tbody>
                                            <div class="portlet-body">
                                                <?php if(!empty($finalArr)): ?>
                                                <div class="mt-timeline-2">
                                                    <div class="mt-timeline-line border-grey-steel"></div>
                                                    <ul class="mt-container">
                                                        <?php $__currentLoopData = $finalArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $infoArr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php
                                                        $i = 0;
                                                        ?>
                                                        <?php $__currentLoopData = $infoArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $logItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                        <li class="mt-item">
                                                            <?php
                                                            $bgColor = !empty($logItem['background']) ? $logItem['background'] : '';
                                                            $bgFont = !empty($logItem['font']) ? $logItem['font'] : '';
                                                            $labelColor = !empty($logItem['label']) ? $logItem['label'] : 'label-danger';
                                                            $ribbonColor = !empty($logItem['ribbon']) ? $logItem['ribbon'] : 'ribbon-color-danger';
                                                            $iconShape = !empty($logItem['icon']) ? $logItem['icon'] : '';
                                                            ?>
                                                            <div class="mt-timeline-icon border-grey-steel <?php echo e($bgColor); ?>">
                                                                <i class="<?php echo e($iconShape); ?>"></i>
                                                            </div>
                                                            <div class="mt-timeline-content">
                                                                <div class="mt-content-container track-history">
                                                                    <div class="portlet mt-element-ribbon light portlet-fit portlet-box-background bordered margin-bottom-0">
                                                                        <?php if(!empty($logItem['updated_by'])): ?>
                                                                        <?php
                                                                        $updatedBy = $logItem['updated_by'];
                                                                        $col1 = '3';
                                                                        $col2 = '9';
                                                                        if (!empty($logItem['updated_at'])) {
                                                                            $col1 = '2';
                                                                            $col2 = '10';
                                                                        }
                                                                        ?>
                                                                        <?php if(!empty($userArr)): ?>
                                                                        <?php if(array_key_exists($updatedBy, $userArr)): ?>
                                                                        <?php $user = $userArr[$updatedBy]; ?>
                                                                        <div class="portlet-title portlet-title-border">
                                                                            <div class="caption">
                                                                                <div class="row">
                                                                                    <div class="col-md-<?php echo e($col1); ?>">
                                                                                        <?php if(!empty($user['photo']) && File::exists('public/uploads/user/'.$user['photo'])): ?>
                                                                                        <img width="40" height="40" src="<?php echo e(URL::to('/')); ?>/public/uploads/user/<?php echo e($user['photo']); ?>" alt="<?php echo e($user['full_name']); ?>"/>
                                                                                        <?php else: ?>
                                                                                        <img width="40" height="40" src="<?php echo e(URL::to('/')); ?>/public/img/unknown.png" alt="<?php echo e($user['full_name']); ?>"/>
                                                                                        <?php endif; ?>
                                                                                    </div>
                                                                                    <div class="col-md-<?php echo e($col2); ?>">
                                                                                        <span class="caption-subject <?php echo e($bgFont); ?> bold font-size-14"><?php echo $user['full_name']; ?></span><br/>
                                                                                        <span class="caption-subject <?php echo e($bgFont); ?> bold font-size-14"><?php echo __('english.EMPLOYEE_ID').' : '.$user['employee_id']; ?></span>
                                                                                        <?php if(!empty($logItem['updated_at'])): ?>
                                                                                        <br/><i class="fa fa-clock-o <?php echo e($bgFont); ?>"> </i><span class="caption-subject <?php echo e($bgFont); ?> bold font-size-14"><?php echo Helper::formatDateTime($logItem['updated_at']); ?></span>
                                                                                        <?php endif; ?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <?php endif; ?>
                                                                        <?php endif; ?>
                                                                        <?php endif; ?>
                                                                        <div class="portlet-title portlet-no-css">
                                                                            <div class="caption">
                                                                                <i class=" icon-calendar <?php echo e($bgFont); ?>"></i>
                                                                                <span class="caption-subject <?php echo e($bgFont); ?> bold font-size-14"><?php echo $logItem['date']; ?></span>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="ribbon ribbon-right ribbon-shadow ribbon-round ribbon-border-dash-hor <?php echo e($ribbonColor); ?>">
                                                                            <div class="ribbon-sub ribbon-clip ribbon-right ribbon-round"></div>
                                                                            <i class="<?php echo e($iconShape); ?>"></i>&nbsp;<?php echo (!empty($logItem['activity_status'])) ? $logItem['activity_status'] : __('english.N_A'); ?> 
                                                                        </div>
                                                                        
                                                                        <div class="portlet-body portlet-body-padding">
                                                                            <p class="track-text font-size-14">
                                                                                <span class="caption-subject <?php echo e($bgFont); ?> bold font-size-14"><?php echo app('translator')->get('english.REMARKS'); ?> : </span> <?php echo $logItem['remarks']; ?>

                                                                            </p>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <?php
                                                        $i++;
                                                        ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                        <li class="mt-item">
                                                            <div class="mt-timeline-icon bg-grey-mint bg-font-grey-mint">
                                                                <i class="icon-arrow-up"></i>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <?php else: ?>
                                                <div class="col-md-12 text-center">
                                                    <div class="alert alert-danger">
                                                        <p>
                                                            <i class="fa fa-warning"></i>
                                                            <?php echo app('translator')->get('english.ACTIVITY_LOG_IS_NOT_AVAILABLE'); ?> <a href="#tab_15_2" id="setLogWhenEmpty" data-toggle="tab"> <?php echo app('translator')->get('english.CLICK_TO_SET_ACTIVITY_LOG'); ?> </a>
                                                        </p>
                                                    </div>
                                                </div>
                                                <?php endif; ?>
                                                <!--endif-->
                                            </div>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- EOF:: Activity Log tab -->

                        <!-- START:: set follow up tab -->
                        <div class="tab-pane" id="tab_15_2">
                            <?php echo Form::open(array('group' => 'form', 'url' => '', 'id' => '', 'class' => 'form-horizontal','files' => true)); ?>

                            <?php echo e(csrf_field()); ?>

                            <?php echo Form::hidden('applicant_id', $jobApplicantId,Request::get('applicant_id')); ?>

                            <div class="row margin-top-10">
                                <div class="col-md-6 col-lg-6 col-sm-6 form-body confirm-order-border">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"><?php echo e(trans('english.DATE')); ?> :</label>
                                        <div class="col-md-9">
                                            <div class="input-group date datepicker2">
                                                <?php echo Form::text('date', Request::get('date'), ['id'=> 'date', 'class' => 'form-control', 'placeholder' =>'DD-MM-YYYY', 'readonly' => '','autocomplete' => 'off']); ?> 
                                                <span class="input-group-btn">
                                                    <button class="btn default reset-date" type="button" remove="date">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                    <button class="btn default date-set" type="button">
                                                        <i class="fa fa-calendar"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3" for="activityStatus"><?php echo app('translator')->get('english.STATUS'); ?> :<span class="text-danger"> *</span></label>
                                        <div class="col-md-9">
                                            <?php echo Form::select('activity_status', $activityStatusArr, Request::get('activity_status'), ['class' => 'form-control js-source-states ','id'=>'activityStatus']); ?>

                                            <span class="text-danger"><?php echo e($errors->first('activity_status')); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 col-sm-6 form-body">

                                    <div class="form-group">
                                        <label class="control-label col-md-3" for="remarks"><?php echo app('translator')->get('english.REMARKS'); ?> :<span class="text-danger"> *</span></label>
                                        <div class="col-md-9">
                                            <?php echo Form::textarea('remarks', null, ['id'=> 'remarks', 'class' => 'form-control','cols'=>'20','rows' => '3']); ?> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--PRODUCT DETAILS-->
                            <!--END OF PRODUCT DETAILS-->
                            <?php echo Form::close(); ?>

                            <!-- START:: set follow up tab -->
                        </div>
                    </div>
                    <!-- EOF:: set follow up tab -->
                </div>
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn green"  id="saveActivityLog">
            <i class="fa fa-check"></i> <?php echo app('translator')->get('english.SAVE'); ?>
        </button>
        <button type="button" data-dismiss="modal" data-placement="left" class="btn dark btn-inline tooltips" title="<?php echo app('translator')->get('english.CLOSE_THIS_POPUP'); ?>"><?php echo app('translator')->get('english.CLOSE'); ?></button>
    </div>
    <?php echo Form::close(); ?>

</div>

<!-- END:: Contact Person Information-->
<script src="<?php echo e(asset('public/js/custom.js')); ?>" type="text/javascript"></script>
<script>
$(document).ready(function () {
    if ($("#setActivityLog").hasClass('active')) {
        $("#saveActivityLog").show();
    } else {
        $("#saveActivityLog").hide();
    }

    //******* Start :: Show/hide opportunity details *********//
    $('.opportunity-details-block').hide();
    $('.btn-hide-opportunity-details-block').hide();
    $('.btn-show-opportunity-details-block').show();
    $('.product-details-block').hide();

    $('.btn-show-opportunity-details-block').on('click', function () {
        $('.opportunity-details-block').show();
        $('.btn-hide-opportunity-details-block').show();
        $('.btn-show-opportunity-details-block').hide();
    });
    $('.btn-hide-opportunity-details-block').on('click', function () {
        $('.opportunity-details-block').hide();
        $('.btn-hide-opportunity-details-block').hide();
        $('.btn-show-opportunity-details-block').show();
    });

    //******* End :: Show/hide opportunity details ***********//

    $("#logBtn").on("click", function () {
        $("#saveActivityLog").hide();
    });
    $("#activitySetBtn").on("click", function () {
        $("#saveActivityLog").show();
    });

    $('#setLogWhenEmpty').on('click', function () {
        $('#logHistory').removeClass();
        $('#setActivityLog').addClass('active');
        $("#saveActivityLog").show();
    });

    //START:: Ajax for Allow User for CRM  
    $('#hasSchedule').on('click', function () {
        if ($(this).prop("checked") == true) {
            $('#scheduleForm').show();
        } else {
            $('#scheduleForm').hide();
        }
    });
    //END:: Ajax for Allow User for CRM

    //START:: Product details hide/show for activity BOOKED status 
    $(document).on("change", '#activityStatus', function () {
        $status = $(this).val();
        if ($status == 7) {
            $('.product-details-block').show();
        } else {
            $('.product-details-block').hide();
        }
    });


});
</script>
<?php /**PATH D:\xampp\htdocs\dysin\resources\views/selectForInterview/showActivityLogModal.blade.php ENDPATH**/ ?>