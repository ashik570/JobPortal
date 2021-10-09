
<?php $__env->startSection('content'); ?>
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-road"></i><?php echo app('translator')->get('english.CREATE_MAJOR_CATEGORIES'); ?>
            </div>
        </div>
        <div class="portlet-body form">
            <?php echo Form::open(array('group' => 'form', 'url' => 'majorCategories', 'files'=> true, 'class' => 'form-horizontal')); ?>

            <?php echo Form::hidden('filter', Helper::queryPageStr($qpArr)); ?>

            <?php echo e(csrf_field()); ?>

            <div class="form-body">
                <div class="row">
                    <div class="col-md-12">


                        <div class="form-group">
                            <label class="control-label col-md-3" for="title"><?php echo app('translator')->get('english.TITLE'); ?> :<span class="text-danger"> *</span></label>
                            <div class="col-md-5">
                                <?php echo Form::text('title', null, ['id'=> 'title', 'class' => 'form-control','autocomplete'=>'off']); ?> 
                                <span class="text-danger"><?php echo e($errors->first('title')); ?></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-md-3" for="postContent"><?php echo app('translator')->get('english.CONTENT'); ?> :</label>
                                    <div class="col-md-9">
                                        <?php echo Form::textarea('content', null, ['id'=> 'postContent', 'class' => 'form-control summernote']); ?>

                                        <span class="text-danger"><?php echo e($errors->first('content')); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="control-label col-md-3" for="userName"><?php echo app('translator')->get('english.ORDER'); ?> :<span class="text-danger"> *</span></label>
                            <div class="col-md-5">
                                <?php echo Form::select('order_id', $orderList, $lastOrderNumber, ['id'=> 'order_id', 'class' => 'form-control js-source-states','autocomplete'=>'off']); ?>

                                <span class="text-danger"><?php echo e($errors->first('order_id')); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3" for="statusId"><?php echo app('translator')->get('english.STATUS'); ?> :</label>
                            <div class="col-md-5">
                                <?php echo Form::select('status_id', ['1' => __('english.ACTIVE'), '0' => __('english.INACTIVE')], '1', ['class' => 'form-control', 'id' => 'statusId']); ?>

                                <span class="text-danger"><?php echo e($errors->first('status')); ?></span>
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
                        <a href="<?php echo e(URL::to('/majorCategories'.Helper::queryPageStr($qpArr))); ?>" class="btn btn-circle btn-outline grey-salsa"><?php echo app('translator')->get('english.CANCEL'); ?></a>
                    </div>
                </div>
            </div>
            <?php echo Form::close(); ?>

        </div>	
    </div>
</div>


<link href="<?php echo e(asset('public/assets/global/plugins/bootstrap-summernote/summernote.css')); ?>" rel="stylesheet" type="text/css" />
<script src="<?php echo e(asset('public/assets/global/plugins/bootstrap-summernote/summernote.min.js')); ?>" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('.summernote').summernote({
            height: 200
        });
    });
    $(document).on("change", '#featuredImage', function (e) {
        readURL(this);
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#prvImg').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\dysin\resources\views/website/MajorCategories/create.blade.php ENDPATH**/ ?>