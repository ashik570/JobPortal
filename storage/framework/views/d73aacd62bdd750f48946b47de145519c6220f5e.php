<?php $__env->startSection('content'); ?>
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <?php echo $__env->make('layouts.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-cubes"></i><?php echo app('translator')->get('english.CLOSE'); ?>
            </div>
            <div class="actions">
            </div>
        </div>
        <div class="portlet-body">
            <!-- Begin Filter-->
            <?php echo Form::open(array('group' => 'form', 'url' => 'orderSate/close/closeFilter','class' => 'form-horizontal')); ?>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-6" for="orderNumber"><?php echo app('translator')->get('english.ORDER_NUMBER'); ?> :</label>
                        <div class="col-md-6">
                             <?php echo Form::text('order_number',  Request::get('order_number'), ['id'=> 'orderNumber', 'class' => 'form-control','autocomplete'=>'off']); ?> 
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label col-md-4" for="phone"><?php echo app('translator')->get('english.PHONE'); ?> :</label>
                        <div class="col-md-8">
                             <?php echo Form::text('phone',  Request::get('phone'), ['id'=> 'phone', 'class' => 'form-control','autocomplete'=>'off']); ?> 
                        </div>
                    </div>
                </div>


                <div class="col-md-4 text-center">
                    <div class="form">
                        <button type="submit" class="btn btn-md green btn-outline filter-submit margin-bottom-20">
                            <i class="fa fa-search"></i> <?php echo app('translator')->get('english.FILTER'); ?>
                        </button>
                    </div>
                </div>
            </div>

            <?php echo Form::close(); ?>

            <!-- End Filter -->

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr class="info">
                            <th class="text-center vcenter"><?php echo app('translator')->get('english.SL_NO'); ?></th>

                            <th class="vcenter"><?php echo app('translator')->get('english.ORDER_NUMBER'); ?></th>
                            <th class="vcenter"><?php echo app('translator')->get('english.PRODUCT_IMAGE'); ?></th>
                            <th class="vcenter"><?php echo app('translator')->get('english.PRODUCT_NAME'); ?></th>
                            <th class="vcenter"><?php echo app('translator')->get('english.PHONE'); ?></th>
                            <th class="vcenter"><?php echo app('translator')->get('english.EMAIL'); ?></th>
                            <th class="vcenter"><?php echo app('translator')->get('english.MESSAGE'); ?></th>
                            <th class="vcenter"><?php echo app('translator')->get('english.REQUEST_TIME'); ?></th>
                            <th class="vcenter"><?php echo app('translator')->get('english.PAYMENT_STATUS'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!$targetArr->isEmpty()): ?>
                        <?php
                        $page = Request::get('page');
                        $page = empty($page) ? 1 : $page;
                        $sl = ($page - 1) * Session::get('paginatorCount');
                        ?>
                        <?php $__currentLoopData = $targetArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $target): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <?php echo e(++$sl); ?>

                            </td>

                            <td>
                                <?php echo e($target->order_number); ?>

                            </td>
                            <td>
                                <?php
                                $productImageArr = json_decode($target->product_image, true);
                                ?>
                                <img src="<?php echo e(URL::to('/')); ?>/public/uploads/website/product/<?php echo e(!empty(end($productImageArr)) ? end($productImageArr) : 'demo.jpg'); ?>" width="50" height="60" alt="">

                            </td>
                            <td>
                                <?php echo e($target->name); ?>

                            </td>
                            <td>
                                <?php echo e($target->phone); ?>

                            </td>
                            <td>
                                <?php echo e($target->email); ?>

                            </td>
                            <td>
                                <?php echo e($target->message); ?>

                            </td>
                            <td>
                                <?php echo e(Helper::printDateTime($target->created_at)); ?>

                            </td>
                            <td>
                                <?php if($target->payment_status == '2'): ?>
                                <span class="label label-sm label-success"><?php echo app('translator')->get('english.PAID'); ?></span>
                                <?php else: ?>
                                <span class="label label-sm label-warning"><?php echo app('translator')->get('english.UNPAID'); ?></span>
                                <?php endif; ?>

                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="14" class="vcenter"><?php echo app('translator')->get('english.NO_PRODUCT_FOUND'); ?></td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php echo $__env->make('layouts.paginator', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
</div>


<!-- Modal end-->

<script type="text/javascript">

</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\swapnoloke\resources\views/website/orderState/close.blade.php ENDPATH**/ ?>