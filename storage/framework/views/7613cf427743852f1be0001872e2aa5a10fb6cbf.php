
<?php $__env->startSection('content'); ?>
<!-- BEGIN CONTENT BODY -->
<div class="page-content">

    <!-- BEGIN PORTLET-->
    <?php echo $__env->make('includes.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- END PORTLET-->
    <div class="row">
        <div class="col-md-12">
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i><?php echo e(trans('english.UPDATE_A_USER')); ?> </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                        <a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title=""> </a>
                        <a href="javascript:;" class="reload" data-original-title="" title=""> </a>
                        <a href="javascript:;" class="remove" data-original-title="" title=""> </a>
                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    <?php echo e(Form::model($user, array('route' => array('users.update', $user->id), 'method' => 'PUT', 'files'=> true, 'class' => 'form-horizontal', 'id' => 'userId'))); ?>

                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label class="col-md-4 control-label"><?php echo e(trans('english.SELECT_GROUP')); ?> :<span class="required"> *</span></label>
                                    <div class="col-md-8">
                                        <?php echo e(Form::select('group_id', $groupList, Request::get('group_id'), array('class' => 'form-control dopdownselect', 'id' => 'userGroupId'))); ?>

                                        <span class="help-block text-danger"><?php echo e($errors->first('group_id')); ?></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label"><?php echo e(trans('english.SELECT_RANK')); ?> :<span class="required"> *</span></label>
                                    <div class="col-md-8">
                                        <?php echo e(Form::select('designation_id', $designationList, Request::get('designation_id'), array('class' => 'form-control dopdownselect', 'id' => 'userDesignationId'))); ?>

                                        <span class="help-block text-danger"><?php echo e($errors->first('designation_id')); ?></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label"><?php echo e(trans('english.SELECT_APPROINTMENT')); ?> :<span class="required"> *</span></label>
                                    <div class="col-md-8">
                                        <?php echo e(Form::select('appointment_id', $appointmentList, Request::get('appointment_id'), array('class' => 'form-control dopdownselect', 'id' => 'userApprointmentId'))); ?>

                                        <span class="help-block text-danger"><?php echo e($errors->first('appointment_id')); ?></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label"><?php echo e(trans('english.FIRST_NAME')); ?> :<span class="required"> *</span></label>
                                    <div class="col-md-8">
                                        <?php echo e(Form::text('first_name', Request::get('first_name'), array('id'=> 'UserFirstName', 'class' => 'form-control', 'placehgeter' => 'Enter First Name'))); ?>

                                        <span class="help-block text-danger"> <?php echo e($errors->first('first_name')); ?></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label"><?php echo e(trans('english.LAST_NAME')); ?> :<span class="required"> *</span></label>
                                    <div class="col-md-8">
                                        <?php echo e(Form::text('last_name', Request::get('last_name'), array('id'=> 'UserLastName', 'class' => 'form-control', 'placehgeter' => 'Enter Last Name', 'required' => 'true'))); ?>

                                        <span class="help-block text-danger"> <?php echo e($errors->first('last_name')); ?></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label"><?php echo e(trans('english.SELECT_BRANCH')); ?> :<span class="required"> *</span></label>
                                    <div class="col-md-8">
                                        <?php echo e(Form::select('branch_id', $branchList, Request::get('branch_id'), array('class' => 'form-control dopdownselect', 'id' => 'userBranchId'))); ?>

                                        <span class="help-block text-danger"><?php echo e($errors->first('branch_id')); ?></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label"><?php echo e(trans('english.OFFICIAL_NAME')); ?> :<span class="required"> *</span></label>
                                    <div class="col-md-8">
                                        <?php echo e(Form::text('official_name', Request::get('official_name'), array('id'=> 'userOfficialName', 'class' => 'form-control', 'placehgeter' => 'Enter Official Name', 'required' => 'true'))); ?>

                                        <span class="help-block text-danger"> <?php echo e($errors->first('official_name')); ?></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label"><?php echo e(trans('english.USERNAME')); ?> :<span class="required"> *</span></label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                            </span>
                                            <?php echo e(Form::text('username', Request::get('username'), array('id'=> 'username', 'placehgeter' => 'Enter Username', 'class' => 'form-control'))); ?>

                                        </div>
                                        <span class="help-block text-danger"> <?php echo e($errors->first('username')); ?></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label"><?php echo e(trans('english.PASSWORD')); ?> :</label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <?php echo e(Form::password('password', array('id'=> 'UserPassword', 'class' => 'form-control', 'placehgeter' => 'Password'))); ?>

                                            <span class="input-group-addon">
                                                <i class="fa fa-key"></i>
                                            </span>
                                        </div>
                                        <span class="help-block"><?php echo e(trans('english.COMPLEX_PASSWORD_INSTRUCTION')); ?></span>
                                        <span class="help-block text-danger"> <?php echo e($errors->first('password')); ?></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label"><?php echo e(trans('english.CONFIRM_PASSWORD')); ?> :</label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <?php echo e(Form::password('password_confirmation', array('id'=> 'UserConfirmPassword', 'class' => 'form-control', 'placehgeter' => 'Confirm Password'))); ?>

                                            <span class="input-group-addon">
                                                <i class="fa fa-key"></i>
                                            </span>
                                        </div>
                                        <span class="help-block text-danger"> <?php echo e($errors->first('password_confirmation')); ?></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label"><?php echo e(trans('english.EMAIL')); ?> :<span class="required"> *</span></label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-envelope"></i>
                                            </span>
                                            <?php echo e(Form::email('email', Request::get('email'), array('id'=> 'UserEmail', 'placehgeter' => 'Email Address', 'class' => 'form-control'))); ?>

                                        </div>
                                        <span class="help-block text-danger"> <?php echo e($errors->first('email')); ?></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label"><?php echo e(trans('english.PHONE_NUMBER')); ?> :</label>
                                    <div class="col-md-8">
                                        <div class="input-icon">
                                            <i class="fa fa-mobile-phone"></i>
                                            <?php echo e(Form::text('phone_no',Request::get('service_no'), array('id'=> 'userPhoneNumber', 'class' => 'form-control', 'placehgeter' => 'Enter Phone Number'))); ?>

                                        </div>
                                        <span class="help-block text-danger"> <?php echo e($errors->first('phone_no')); ?></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label"><?php echo e(trans('english.STATUS')); ?> :<span class="required"> *</span></label>
                                    <div class="col-md-8">
                                        <?php echo e(Form::select('status', $status, Request::get('status'), array('class' => 'form-control dopdownselect-hidden-search', 'id' => 'userStatus'))); ?>

                                        <span class="help-block text-danger"><?php echo e($errors->first('status')); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group last">
                                    <label class="control-label col-md-3"> Photo: </label>
                                    <div class="col-md-9">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                <?php if(isset($user->photo)): ?>
                                                    <img src="<?php echo e(URL::to('/')); ?>/public/uploads/user/<?php echo e($user->photo); ?>" alt="<?php echo e($user->official_name); ?>"> 
                                                <?php else: ?>
                                                    <img src="<?php echo e(URL::to('/')); ?>/public/img/no-image.png" alt=""> 
                                                <?php endif; ?>
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                            <div>
                                                <span class="btn default btn-file">
                                                    <span class="fileinput-new"> Select image </span>
                                                    <span class="fileinput-exists"> Change </span>
                                                    <?php echo e(Form::file('photo', array('id' => 'sortpicture'))); ?>

                                                </span>
                                                <span class="help-block text-danger"><?php echo e($errors->first('photo')); ?></span>
                                                <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> <?php echo e(trans('english.REMOVE')); ?> </a>
                                            </div>
                                        </div>
                                        <div class="clearfix margin-top-10">
                                            <span class="label label-danger"><?php echo e(trans('english.NOTE')); ?></span> <?php echo e(trans('english.USER_AND_STUDENT_IMAGE_FOR_IMAGE_DESCRIPTION')); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" class="btn btn-circle green"><?php echo e(trans('english.SUBMIT')); ?></button>
                                <a href="<?php echo e(URL::to('users')); ?>">
                                    <button type="button" class="btn btn-circle grey-salsa btn-outline"><?php echo e(trans('english.CANCEL')); ?></button> 
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php echo e(Form::close()); ?>

                    <!-- END FORM-->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END CONTENT BODY -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo e(asset('public/assets/pages/uses_script/form-user.js')); ?>" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script type="text/javascript">
	 $(document).on("submit", '#userId', function (e) {
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


<?php echo $__env->make('layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\swapnoloke\resources\views/users/edit.blade.php ENDPATH**/ ?>