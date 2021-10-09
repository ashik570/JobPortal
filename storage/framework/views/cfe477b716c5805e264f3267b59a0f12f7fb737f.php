
<?php $__env->startSection('content'); ?>
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    

    <!-- BEGIN PORTLET-->
    <?php echo $__env->make('includes.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- END PORTLET-->
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject font-dark sbold uppercase"><?php echo e(trans('english.EDIT_USER_GROUP')); ?></span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <?php echo e(Form::model($userGroup, array('route' => array('userGroup.update', $userGroup->id), 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'userGroupEditForm'))); ?>

                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo e(trans('english.NAME')); ?>  : </label>
                                <div class="col-md-5">
                                    <?php echo e(Form::text('name', $value = null, array('id'=> 'groupName', 'placeholder' => 'Type User Group Name', 'class' => 'form-control', 'data-rule-minlength' => '2', 'data-rule-required' => 'true'))); ?>

                                    <span class="help-block text-danger"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo e(trans('english.INFO')); ?>  : </label>
                                <div class="col-md-5">
                                    <?php echo e(Form::text('info', $value = null, array('id'=> 'groupInfo', 'placeholder' => 'Type User Group Info', 'class' => 'form-control'))); ?>

                                    <span class="help-block text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" class="btn green">Submit</button>
                                    <a href="<?php echo e(URL::to('userGroup')); ?>">
                                        <button type="button" class="btn default">Cancel</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php echo e(Form::close()); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- END CONTENT BODY -->
<script type="text/javascript">
	 $(document).on("submit", '#userGroupEditForm', function (e) {
        //This function use for sweetalert confirm message
		e.preventDefault();
		var form = this;
        swal({
            title: 'Are you sure you want to Submit?',
            text: '<strong></strong>',
            type: 'warning',
            html: true,
            allowOutsideClick: true,
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonClass: 'btn-info',
            cancelButtonClass: 'btn-danger',
            confirmButtonText: 'Yes, I agree',
            cancelButtonText: 'No, I do not agree',
        },
        function (isConfirm) {
			if (isConfirm) {
				toastr.info("Loading...", "Please Wait.", {"closeButton": true});
				 form.submit();
			} else {
				//swal(sa_popupTitleCancel, sa_popupMessageCancel, "error");
				
			}
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\dysin\resources\views/userGroup/edit.blade.php ENDPATH**/ ?>