<?php ?>
<div class="modal-content" id="modal-content">
    <div class="modal-header clone-modal-header">
        <div class="col-md-7 text-right">
            <h4 class="modal-title"><?php echo app('translator')->get('english.APPLICATION_DETAILS'); ?></h4>
        </div>
        <div class="col-md-5">
            <button type="button" data-dismiss="modal" data-placement="left" class="btn red pull-right tooltips" title="<?php echo app('translator')->get('english.CLOSE_THIS_POPUP'); ?>"><?php echo app('translator')->get('english.CLOSE'); ?></button>
        </div>
    </div>
    <div class="modal-body">
        <div class="main-content hr-p-margin-0">
            <div class="container">
                <!--<div class="row">-->
                <div class="col-md-12">
                    <!--<div class="row">-->
                    <div class="col-md-8 modal-css ">
                        <div class="row mb-5 pb-15">
                            <div class="col-md-2">
                                <p class="vcenter font-weight-bold"><?php echo app('translator')->get('english.JOB_TITLE'); ?></p>
                            </div>
                            <div class="col-md-10">
                                <p class="text-success"><?php echo e($data->circular); ?></p>
                            </div>
                        </div>
                        <div class="row pb-15">
                            <div class="col-md-12">
                                <p class="vcenter font-weight-bold"><?php echo app('translator')->get('english.APPLICANT_INFO'); ?></p>
                            </div>
                        </div>
                        <div class="row pb-15">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="vcenter font-weight-bold"><?php echo app('translator')->get('english.NAME'); ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="text-success"><?php echo e($data->name); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="vcenter font-weight-bold"><?php echo app('translator')->get('english.EMAIL'); ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="text-success"><?php echo e($data->email); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="vcenter font-weight-bold"><?php echo app('translator')->get('english.PHONE'); ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="text-success"><?php echo e($data->phone); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row pb-15">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="vcenter font-weight-bold"><?php echo app('translator')->get('english.DATE_OF_SUBMISSION'); ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="text-success"><?php echo date('d F Y',strtotime($data->submission_date)); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="vcenter font-weight-bold"><?php echo app('translator')->get('english.STATUS'); ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <?php if($data->status==6 && $data->last_interaction_status==4): ?>
                                        <span class="text-success"><?php echo e(__('english.NOT_INTERESTED')); ?></span>
                                        <?php elseif($data->status==6): ?>
                                        <span class="text-success"><?php echo e(__('english.DISCARD')); ?></span>
                                        <?php elseif($data->status==0): ?>
                                        <span class="text-success"><?php echo e(__('english.PENDING')); ?></span>
                                        <?php elseif($data->status==1): ?>
                                        <span class="text-success"><?php echo e(__('english.REVIEWED')); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row pb-15">
                            <div class="col-md-12">
                                <p class="vcenter font-weight-bold"><?php echo e(__('english.REMARKS')); ?></p>
                            </div>
                        </div>
                        <div class="row pb-15">
                            <div class="col-md-12">
                                <p class="text-success"><?php echo e($data->remarks); ?></p>
                            </div>
                        </div>



                    </div>
                    <!--</div>-->
                </div>
                <!--</div>-->
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" data-dismiss="modal" data-placement="top" class="btn dark btn-outline tooltips" title="<?php echo app('translator')->get('english.CLOSE_THIS_POPUP'); ?>"><?php echo app('translator')->get('english.CLOSE'); ?></button>
    </div>
</div>

<script src="<?php echo e(asset('public/js/custom.js')); ?>" type="text/javascript"></script>
<script type="text/javascript">
$(function () {
    $(".tooltips").tooltip();
});
</script><?php /**PATH D:\xampp\htdocs\swapnoloke\resources\views/applicant/applicationDetailsModal.blade.php ENDPATH**/ ?>