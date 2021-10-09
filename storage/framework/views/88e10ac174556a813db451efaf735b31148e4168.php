
<?php $__env->startSection('content'); ?>
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-bars"></i><?php echo app('translator')->get('english.CREATE_MENU'); ?>
            </div>
        </div>
        <div class="portlet-body form">
            <?php echo Form::open(array('group' => 'form', 'url' => 'menu', 'files'=> true, 'class' => 'form-horizontal')); ?>

            <?php echo Form::hidden('filter', Helper::queryPageStr($qpArr)); ?>

            <?php echo e(csrf_field()); ?>

            <div class="form-body">
                <div class="row">
                    <div class=" col-md-12">

                        <div class="form-group">
                            <label class="control-label col-md-3" for="title"><?php echo app('translator')->get('english.TITLE'); ?> :<span class="text-danger"> *</span></label>
                            <div class="col-md-5">
                                <?php echo Form::text('title', null, ['id'=> 'title', 'class' => 'form-control','autocomplete'=>'off']); ?> 
                                <span class="text-danger"><?php echo e($errors->first('title')); ?></span>
                            </div>
                        </div>
                      

                        <div class="form-group">
                            <label class="control-label col-md-3" for="parentId"><?php echo app('translator')->get('english.PARENTS'); ?> :</label>
                            <div class="col-md-5">
                                <?php echo Form::select('parent_id', $parentsArr, null, ['class' => 'form-control js-source-states', 'id' => 'parentId']); ?> 
                                <span class="text-danger"><?php echo e($errors->first('parent_id')); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3" for="typeId"><?php echo app('translator')->get('english.TYPE'); ?> :<span class="text-danger"> *</span></label>
                            <div class="col-md-5">
                                <?php echo Form::select('type_id', $typeArr, null, ['class' => 'form-control js-source-states', 'id' => 'typeId']); ?>


                                <span class="text-danger"><?php echo e($errors->first('type_id')); ?></span>
                            </div>
                        </div>
                        <div id="display">
                            <?php if($typeId == 2): ?>
                            <div class="form-group">
                                <label class="control-label col-md-3" for="url"><?php echo app('translator')->get('english.URL'); ?> :</label>
                                <div class="col-md-5">
                                    <?php echo Form::text('url', null, ['id'=> 'title', 'class' => 'form-control', 'autocomplete'=>'off']); ?> 
                                    <span class="text-danger"><?php echo e($errors->first('url')); ?></span>
                                </div>
                            </div>
                            <?php elseif($typeId == 5): ?>
                            <div class="form-group">
                                <label class="control-label col-md-3" for="content"><?php echo app('translator')->get('english.CONTENT'); ?> :<span class="text-danger"> *</span></label>
                                <div class="col-md-5">
                                    <?php echo Form::select('content_id', $contentList, null, ['class' => 'form-control js-source-states', 'id' => 'content']); ?> 
                                </div>
                            </div>
                            <table id="bootstrap-data-table-export" class="table table-responsive table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th><?php echo e(__('messages.SL')); ?></th>
                                        <th><?php echo e(__('messages.PRODUCT')); ?></th>
                                        <th><?php echo e(__('messages.UNIT')); ?></th>
                                        <th><?php echo e(__('messages.QUANTITY')); ?></th>
                                        <th><?php echo e(__('messages.UNIT_PRICE')); ?></th>
                                        <th><?php echo e(__('messages.TOTAL_PRICE')); ?></th>
                                        <th><?php echo e(__('messages.ACTION')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php elseif($typeId == 16): ?>
                            <div class="form-group">
                                <label class="control-label col-md-3" for="pcategoryId"><?php echo app('translator')->get('english.SELECT_PUBLICATION_CATEGORY'); ?> :<span class="text-danger"> *</span></label>
                                <div class="col-md-5">
                                    <?php echo Form::select('pcategory_id', $pcategory, null, ['class' => 'form-control js-source-states', 'id' => 'pcategoryId']); ?> 
                                </div>
                            </div>
                            
                            <?php else: ?>
                            <div></div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 mt-checkbox" for="openNewTab"><?php echo app('translator')->get('english.OPEN_NEW_TAB'); ?> :</label>
                            <div class="col-md-5 checkbox-center md-checkbox has-success" style="margin: 0 15px">
                                <input type="hidden" name="open_new_tab" value="0">
                                <?php echo Form::checkbox('open_new_tab',1,false, ['id' => 'openNewTab', 'class'=> 'md-check']); ?>

                                <label for="openNewTab">
                                    <span class="inc"></span>
                                    <span class="check mark-caheck"></span>
                                    <span class="box mark-caheck"></span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-3 mt-checkbox" for="loginStatus"><?php echo app('translator')->get('english.FOR_LOGGED_IN_USERS'); ?> :</label>
                            <div class="col-md-5 checkbox-center md-checkbox has-success" style="margin: 0 15px">
                                <input type="hidden" name="login_status" value="0">
                                <?php echo Form::checkbox('login_status',1,false, ['id' => 'loginStatus', 'class'=> 'md-check']); ?>

                                <label for="loginStatus">
                                    <span class="inc"></span>
                                    <span class="check mark-caheck"></span>
                                    <span class="box mark-caheck"></span>
                                </label>
                            </div>
                        </div>

                        <div id="order">
                            <div class="form-group">
                                <label class="control-label col-md-3" for="orderId"><?php echo app('translator')->get('english.ORDER'); ?> :</label>
                                <div class="col-md-5">
                                    <?php echo Form::select('order_id', $orderList, $lastOrderNumber, ['id'=> 'orderId', 'class' => 'form-control js-source-states','autocomplete'=>'off']); ?> 
                                    <span class="text-danger"><?php echo e($errors->first('order_id')); ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3" for="statusId"><?php echo app('translator')->get('english.STATUS'); ?> :</label>
                            <div class="col-md-5">
                                <?php echo Form::select('status_id', ['1' => __('english.ACTIVE'), '2' => __('english.INACTIVE')], '1', ['class' => 'form-control', 'id' => 'statusId']); ?>

                                <span class="text-danger"><?php echo e($errors->first('status_id')); ?></span>
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
                        <a href="<?php echo e(URL::to('/menu'.Helper::queryPageStr($qpArr))); ?>" class="btn btn-circle btn-outline grey-salsa"><?php echo app('translator')->get('english.CANCEL'); ?></a>
                    </div>
                </div>
            </div>
            <?php echo Form::close(); ?>

        </div>	
    </div>
</div>
<script type="text/javascript">

    $(document).on('change', '#typeId', function () {

        var typeId = $('#typeId').val();

        if (typeId == '0') {
            $('#display').html('');
            return false;
        }

        $.ajax({
            url: "<?php echo e(URL::to('menu/getTypeWiseField')); ?>",
            type: 'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                type_id: typeId
            },
            beforeSend: function () {
                $('#display').html('');
                App.blockUI({boxed: true});
            },
            success: function (res) {
                $('#display').html(res.html);
                $(".js-source-states").select2();
                App.unblockUI();
                //alert(url);
            },
        });
    });

</script>

<script type="text/javascript">
//    $(function () {
//        $(document).on("change", "#typeId", function () {
//            var typeId = $("#typeId").val();
//            $.ajax({
//                url: " <?php echo e(URL::to('/menu/getOrder')); ?>",
//                type: "POST",
//                headers: {
//                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                },
//                data: {
//                    type_id: typeId,
//                    operation: 1,
//                },
//                
//                dataType: "json",
//                success: function (response) {
//                    $('#order').html(response.html);
//                    $('.js-source-states').select2();
//                },
//                error: function (jqXhr, ajaxOptions, thrownError) {
//                }
//            });//ajax
//        });
//
//
//    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\dysin\resources\views/menu/create.blade.php ENDPATH**/ ?>