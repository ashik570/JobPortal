
<?php $__env->startSection('content'); ?>
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <?php echo $__env->make('layouts.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-file-word-o"></i><?php echo app('translator')->get('english.CREATE_CONTENT'); ?>
            </div>
        </div>
        <div class="portlet-body form">
            <?php echo Form::open(array('group' => 'form', 'url' => 'content', 'files'=> true, 'class' => 'form-horizontal')); ?>

            <?php echo Form::hidden('filter', Helper::queryPageStr($qpArr)); ?>

            <?php echo e(csrf_field()); ?>

            <div class="form-body">
                <div class="row">
                    <div class="col-md-9">

                        <div class="form-group">
                            <label class="control-label col-md-4" for="title"><?php echo app('translator')->get('english.TITLE'); ?> :<span class="text-danger"> *</span></label>
                            <div class="col-md-7">
                                <?php echo Form::text('title', null, ['id'=> 'title', 'class' => 'form-control','autocomplete'=>'off']); ?> 
                                <span class="text-danger"><?php echo e($errors->first('title')); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4" for="shortInfo"><?php echo app('translator')->get('english.SHORT_INFO'); ?> :</label>
                            <div class="col-md-7">
                                <?php echo Form::text('short_info', null, ['id'=> 'shortInfo', 'class' => 'form-control','autocomplete'=>'off']); ?> 
                                <span class="text-danger"><?php echo e($errors->first('short_info')); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4" for="orderId"><?php echo app('translator')->get('english.ORDER'); ?> :<span class="text-danger">* </span>
                            </label>
                            <div class="col-md-7">
                                <?php echo Form::select('order_id',$orderList, $lastOrderNumber, ['id'=> 'orderId', 'class' => 'form-control js-source-states','autocomplete'=>'off']); ?> 
                                <span class="text-danger"><?php echo e($errors->first('order_id')); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4" for="uploadFile"><?php echo app('translator')->get('english.UPLOAD_FILE'); ?> :</label>
                            <div class="col-md-7">
                                <?php echo Form::file('upload_file', null, ['id'=> 'uploadFile', 'class' => 'form-control']); ?>

                                <span class="text-danger"><?php echo e($errors->first('upload_file')); ?></span>
                                <div class="clearfix margin-top-10">
                                    <span class="label label-danger"><?php echo app('translator')->get('english.NOTE'); ?></span> <?php echo app('translator')->get('english.CONTENT_FILE_HINTS'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4" for="statusId"><?php echo app('translator')->get('english.STATUS'); ?> :</label>
                            <div class="col-md-7">

                                <?php echo Form::select('status_id', ['1' => __('english.ACTIVE'), '0' => __('english.INACTIVE')], '1', ['class' => 'form-control', 'id' => 'statusId']); ?>

                                <span class="text-danger"><?php echo e($errors->first('status_id')); ?></span>
                            </div>
                        </div> 
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label col-md-3" for="description"><?php echo app('translator')->get('english.DESCRIPTION'); ?> :<span class="text-danger"> *</span></label>
                            <div class="col-md-9">
                                <?php echo Form::textarea('description', null, array('id'=> 'description', 'class' => 'form-control', 'rows' => '30')); ?>

                                <span class="text-danger"><?php echo e($errors->first('description')); ?></span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-4 col-md-8">
                        <button class="btn btn-circle green" type="submit" name="submit">
                            <i class="fa fa-check"></i> <?php echo app('translator')->get('english.SUBMIT'); ?>
                        </button>
                        <a href="<?php echo e(URL::to('/content'.Helper::queryPageStr($qpArr))); ?>" class="btn btn-circle btn-outline grey-salsa"><?php echo app('translator')->get('english.CANCEL'); ?></a>
                    </div>
                </div>
            </div>
            <?php echo Form::close(); ?>

        </div>	
    </div>
</div>

<link href="<?php echo e(asset('public/css/website/summernote.min.css')); ?>" rel="stylesheet" type="text/css" />
<script src="<?php echo e(asset('public/js/website/summernote.min.js')); ?>" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
  $('#description').summernote();
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\dysin\resources\views/website/content/create.blade.php ENDPATH**/ ?>