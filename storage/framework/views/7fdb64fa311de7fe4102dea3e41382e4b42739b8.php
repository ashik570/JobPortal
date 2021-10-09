<?php $__env->startSection('content'); ?>
<div class="page-content">

    <?php echo $__env->make('includes.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cubes"></i><?php echo e(trans('english.CREATE_NEW_JOB_NATURE')); ?> 
                    </div>
                    <div class="tools">

                    </div>
                </div>
                <div class="portlet-body form">

                    <?php echo e(Form::open(array('role' => 'form', 'url' => 'jobNature/store', 'class' => 'form-horizontal', 'id' => 'createJobNature'))); ?>

                    <?php echo Form::hidden('filter', Helper::queryPageStr($qpArr)); ?>

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
                                    <label class="control-label col-md-4" for="order"><?php echo app('translator')->get('english.ORDER'); ?> :<span class="text-danger"> *</span></label>
                                    <div class="col-md-8">
                                        <?php echo Form::select('order_id', $orderList, $lastOrderNumber, ['id'=> 'orderId', 'class' => 'form-control js-source-states','autocomplete'=>'off']); ?>

                                        <span class="text-danger"><?php echo e($errors->first('order')); ?></span>
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
                                <a href="<?php echo e(URL::to('jobNature')); ?>">
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
    $(document).on("submit", '#createJobNature', function (e) {
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
//                        console.log("error");
                    }
                });
    });

    $("#nigotiable").change(function () {
        if (this.checked) {
            console.log("ok");
        }
    });


</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\swapnoloke\resources\views/jobNature/create.blade.php ENDPATH**/ ?>