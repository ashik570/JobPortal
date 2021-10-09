
<?php $__env->startSection('content'); ?>
<div class="page-content">

    <?php echo $__env->make('includes.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cubes"></i><?php echo e(trans('english.CREATE_NEW_BRANCH')); ?> 
                    </div>
                    <div class="tools">

                    </div>
                </div>
                <div class="portlet-body form">

                    <?php echo e(Form::open(array('role' => 'form', 'url' => 'branch', 'class' => 'form-horizontal', 'id'=>'createBranch'))); ?>

                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-7">
                                
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="name"><?php echo e(trans('english.NAME')); ?> :<span class="required"> *</span></label>
                                    <div class="col-md-8">
                                        <?php echo e(Form::text('name', Request::get('name'), array('id'=> 'name', 'class' => 'form-control', 'required' => 'true'))); ?>

                                        <span class="help-block text-danger"> <?php echo e($errors->first('name')); ?></span>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="short_name"><?php echo e(trans('english.SHORT_NAME')); ?> :<span class="required"> *</span></label>
                                    <div class="col-md-8">
                                        <?php echo e(Form::text('short_name', Request::get('short_name'), array('id'=> 'short_name', 'class' => 'form-control', 'required' => 'true'))); ?>

                                        <span class="help-block text-danger"> <?php echo e($errors->first('short_name')); ?></span>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="order"><?php echo e(trans('english.ORDER')); ?> : </label>
                                    <div class="col-md-8">
                                        <?php echo e(Form::number('order', Request::get('order'), array('id'=> 'order', 'class' => 'form-control', 'required' => 'true'))); ?>

                                        <span class="help-block text-danger"> <?php echo e($errors->first('order')); ?></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="info"><?php echo e(trans('english.INFO')); ?> : </label>
                                    <div class="col-md-8">
                                        <?php echo e(Form::textarea('info', Request::get('info'), array('id'=> 'info', 'rows' => 5, 'class' => 'form-control'))); ?>

                                        <span class="help-block text-danger"> <?php echo e($errors->first('info')); ?></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label"><?php echo e(trans('english.STATUS')); ?> : </label>
                                    <div class="col-md-8">
                                        <?php echo e(Form::select('status', array('1' => trans('english.ACTIVE'), '0' => trans('english.INACTIVE')), Request::get('status'), array('class' => 'form-control dopdownselect-hidden-search'))); ?>

                                        <span class="help-block text-danger"><?php echo e($errors->first('status')); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" class="btn btn-circle green"><?php echo e(trans('english.SUBMIT')); ?></button>
                                <a href="<?php echo e(URL::to('branch')); ?>">
                                    <button type="button" class="btn btn-circle grey-salsa btn-outline"><?php echo e(trans('english.CANCEL')); ?></button> 
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

<script type="text/javascript">
	$(document).on("submit", '#createBranch', function (e) {
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


<?php echo $__env->make('layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\dysin\resources\views/branch/create.blade.php ENDPATH**/ ?>