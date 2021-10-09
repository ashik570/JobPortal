
<?php $__env->startSection('content'); ?>
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <?php echo $__env->make('layouts.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-road"></i><?php echo app('translator')->get('english.CREATE_SLIDER'); ?>
            </div>
        </div>
        <div class="portlet-body form">
            <?php echo Form::open(array('group' => 'form', 'url' => 'slider', 'files'=> true, 'class' => 'form-horizontal')); ?>

            <?php echo Form::hidden('filter', Helper::queryPageStr($qpArr)); ?>

            <?php echo e(csrf_field()); ?>

            <div class="form-body">
                <div class="row">
                    <div class="col-md-12">

                        
                        <div class="form-group" style="display: none">
                            <label class="control-label col-md-3" for="caption"><?php echo app('translator')->get('english.CAPTION'); ?> :</label>
                            <div class="col-md-5">
                                <?php echo Form::text('caption', null, ['id'=> 'caption', 'class' => 'form-control','autocomplete'=>'off']); ?> 
                                <span class="text-danger"><?php echo e($errors->first('caption')); ?></span>
                            </div>
                        </div>

                        
                        
                        <div class="form-group last">
                            <label class="control-label col-md-3"><?php echo app('translator')->get('english.IMAGE_FOR_SLIDER'); ?> :<span class="text-danger"> *</span></label>
                            <div class="col-md-9">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                        <img src="<?php echo e(URL::to('/')); ?>/public/img/no-image.png" alt=""> </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                    <div>
                                        <span class="btn default btn-file">
                                            <span class="fileinput-new"> Select image </span>
                                            <span class="fileinput-exists"> Change </span>
                                            <input type="file" name="slider_image"> </span>
                                        <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                        <div class=""><span class="text-danger"><?php echo e($errors->first('slider_image')); ?></span></div>
                                    </div>
                                </div>
                               <div class="clearfix margin-top-10">
                                        <span class="label label-danger"><?php echo app('translator')->get('english.NOTE'); ?></span> <?php echo app('translator')->get('english.ACCEPTED_IMAGE_FORMATE_jpg_png_jpeg_gif'); ?>
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
                        <a href="<?php echo e(URL::to('/slider'.Helper::queryPageStr($qpArr))); ?>" class="btn btn-circle btn-outline grey-salsa"><?php echo app('translator')->get('english.CANCEL'); ?></a>
                    </div>
                </div>
            </div>
            <?php echo Form::close(); ?>

        </div>	
    </div>
</div>



<script type="text/javascript">
    $(document).on("change", '#slideImage', function (e) {
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
<?php echo $__env->make('layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\dysin\resources\views/website/slider/create.blade.php ENDPATH**/ ?>