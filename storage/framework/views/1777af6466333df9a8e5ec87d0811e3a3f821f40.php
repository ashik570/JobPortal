<?php $__env->startSection('content'); ?>
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <?php echo $__env->make('layouts.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-cubes"></i><?php echo app('translator')->get('english.TRACKING_ORDER'); ?>
            </div>
            <div class="actions">
            </div>
        </div>
        <div class="portlet-body">
            <!-- Begin Filter-->
            <?php echo Form::open(array('group' => 'form', 'url' => 'orderSate/trackingOrder/trackingOrderFilter','class' => 'form-horizontal')); ?>

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
                <div class="col-md-5">
                    <div class="form-group">
                        <label class="col-md-4 control-label"><?php echo e(trans('english.REQUEST_DATE')); ?> :</label>
                        <div class="col-md-7">
                            <div class="input-group date datepicker">
                                <?php echo e(Form::text('request_date', Request::get('request_date'), array('id'=> 'epeExamDate', 'class' => 'form-control', 'placeholder' => trans('english.REQUEST_DATE'), 'size' => '16', 'readonly' => true))); ?>

                                <span class="input-group-btn">
                                    <button class="btn default date-set" type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span>
                                <span class="input-group-btn">
                                    <button class="btn default date-remove" onclick="remove_date('epeExamDate');" remove="epeExamDate" type="button">
                                        <i class="fa fa-remove"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-4 text-center">
                    <div class="form">
                        <button type="submit" class="btn btn-md green btn-outline filter-submit margin-bottom-20">
                            <i class="fa fa-search"></i> <?php echo app('translator')->get('english.SEARCH'); ?>
                        </button>
                    </div>
                </div>
            </div>

            <?php echo Form::close(); ?>

            <!-- End Filter -->
            <?php if(Request::get('search') == true): ?>
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
                            <th class="vcenter"><?php echo app('translator')->get('english.ORDER_STATUS'); ?></th>
                            <th class="text-center vcenter"><?php echo app('translator')->get('english.PAYMENT_STATUS'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($targetArr)): ?>
                        <?php
                        $sl = 0;
                        ?>
                        <?php $__currentLoopData = $targetArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $target): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <?php echo e(++$sl); ?>

                            </td>

                            <td>
                                <?php echo e($target['order_number']); ?>

                            </td>
                            <td>
                                <?php
                                $productImageArr = json_decode($target['product_image'], true);
                                ?>
                                <img src="<?php echo e(URL::to('/')); ?>/public/uploads/website/product/<?php echo e(!empty(end($productImageArr)) ? end($productImageArr) : 'demo.jpg'); ?>" width="50" height="60" alt="">

                            </td>
                            <td>
                                <?php echo e($target['name']); ?>

                            </td>
                            <td>
                                <?php echo e($target['phone']); ?>

                            </td>
                            <td>
                                <?php echo e($target['email']); ?>

                            </td>
                            <td>
                                <?php echo e($target['message']); ?>

                            </td>
                            <td>
                                <?php echo e(Helper::printDateTime($target['created_at'])); ?>

                            </td>
                            <td>
                                <?php if($target['order_status'] == '1'): ?>
                                <span class="label label-sm label-warning"><?php echo app('translator')->get('english.PENDING'); ?></span>
                                <?php elseif($target['order_status'] == '2'): ?>
                                <span class="label label-sm label-info"><?php echo app('translator')->get('english.PROCESSING'); ?></span>
                                <?php elseif($target['order_status'] == '3'): ?>
                                <span class="label label-sm label-success"><?php echo app('translator')->get('english.DELIVERED'); ?></span>
                                <?php elseif($target['order_status'] == '4'): ?>
                                <span class="label label-sm label-danger"><?php echo app('translator')->get('english.CLOSE'); ?></span>
                                <?php endif; ?>

                            </td>
                            <td>
                                <?php if($target['payment_status'] == '2'): ?>
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
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal start -->

<!--set product image modal-->
<div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div id="showOrder">

        </div>
    </div>
</div>
<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div id="showPayment">

        </div>
    </div>
</div>

<!-- Modal end-->

<script type="text/javascript">
    $(document).ready(function () {
        $("body").tooltip({selector: '[data-tooltip=tooltip]'});
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });


    });
        function remove_date(e) {
            var id = e;
            $("#" + id).val('');
        }
</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\swapnoloke\resources\views/website/orderState/trackingOrder.blade.php ENDPATH**/ ?>