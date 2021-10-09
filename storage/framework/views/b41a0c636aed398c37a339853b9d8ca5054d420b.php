
<?php $__env->startSection('content'); ?>
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-list"></i><?php echo app('translator')->get('english.CREATE_PRODUCT_CATEGORY'); ?>
            </div>
        </div>
        <div class="portlet-body form">
            <?php echo Form::open(array('group' => 'form', 'url' => 'productCategory','class' => 'form-horizontal')); ?>

            <?php echo Form::hidden('page', Helper::queryPageStr($qpArr)); ?>

            <?php echo e(csrf_field()); ?>

            <div class="form-body">
                <div class="row">
                    <div class="col-md-offset-1 col-md-7">
                        <div class="form-group">
                            <label class="control-label col-md-4" for="parentId"><?php echo app('translator')->get('english.PARENT_CATEGORY'); ?> :</label>
                            <div class="col-md-8">
                                <?php echo Form::select('parent_id', array('0' => __('english.SELECT_CATEGORY_OPT')) + $parentArr, null, ['class' => 'form-control js-source-states', 'id' => 'parentId']); ?>

                                <span class="text-danger"><?php echo e($errors->first('parent_id')); ?></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4" for="name"><?php echo app('translator')->get('english.NAME'); ?> :<span class="text-danger"> *</span></label>
                            <div class="col-md-8">
                                <?php echo Form::text('name',null, ['id'=> 'name', 'class' => 'form-control','autocomplete' => 'off']); ?> 
                                <span class="text-danger"><?php echo e($errors->first('name')); ?></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4" for="code"><?php echo app('translator')->get('english.CODE'); ?> :<span class="text-danger"> *</span></label>
                            <div class="col-md-8">
                                <?php echo Form::text('code',null, ['id'=> 'code', 'class' => 'form-control','autocomplete' => 'off']); ?> 
                                <span class="text-danger"><?php echo e($errors->first('code')); ?></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4" for="order"><?php echo app('translator')->get('english.ORDER'); ?> :<span class="text-danger"> *</span></label>
                            <div class="col-md-8">
                                <?php echo Form::select('order', $orderList, null, ['class' => 'form-control js-source-states', 'id' => 'order']); ?> 
                                <span class="text-danger"><?php echo e($errors->first('order')); ?></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4" for="status"><?php echo app('translator')->get('english.STATUS'); ?> :</label>
                            <div class="col-md-8">
                                <?php echo Form::select('status', ['1' => __('english.ACTIVE'), '2' => __('english.INACTIVE')], '1', ['class' => 'form-control', 'id' => 'status']); ?>

                                <span class="text-danger"><?php echo e($errors->first('status')); ?></span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-4 col-md-8">
                        <button class="btn btn-circle green" type="submit">
                            <i class="fa fa-check"></i> <?php echo app('translator')->get('english.SUBMIT'); ?>
                        </button>
                        <a href="<?php echo e(URL::to('/productCategory'.Helper::queryPageStr($qpArr))); ?>" class="btn btn-circle btn-outline grey-salsa"><?php echo app('translator')->get('english.CANCEL'); ?></a>
                    </div>
                </div>
            </div>
            <?php echo Form::close(); ?>

        </div>	
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\swapnoloke\resources\views/website/productCategory/create.blade.php ENDPATH**/ ?>