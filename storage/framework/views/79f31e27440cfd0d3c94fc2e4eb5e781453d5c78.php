<?php $__env->startSection('content'); ?>
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <?php echo $__env->make('layouts.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-cubes"></i><?php echo app('translator')->get('english.PRODUCT_LIST'); ?>
            </div>
            <div class="actions">
                <a class="btn btn-default btn-sm create-new" href="<?php echo e(URL::to('product/create'.Helper::queryPageStr($qpArr))); ?>"> <?php echo app('translator')->get('english.CREATE_NEW_PRODUCT'); ?>
                    <i class="fa fa-plus create-new"></i>
                </a>
            </div>
        </div>
        <div class="portlet-body">
            <!-- Begin Filter-->
            <?php echo Form::open(array('group' => 'form', 'url' => 'admin/product/filter','class' => 'form-horizontal')); ?>

            <?php echo Form::hidden('page', Helper::queryPageStr($qpArr)); ?>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-4" for="search"><?php echo app('translator')->get('english.NAME'); ?></label>
                        <div class="col-md-8">
                            <?php echo Form::text('search',  Request::get('search'), ['class' => 'form-control tooltips', 'title' => 'Name', 'placeholder' => 'Name','list' => 'productName','autocomplete' => 'off']); ?>

                            <datalist id="productName">
                                <?php if(!$nameArr->isEmpty()): ?>
                                <?php $__currentLoopData = $nameArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($item->name); ?>" />
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </datalist>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-4" for="productCategory"><?php echo app('translator')->get('english.CATEGORY'); ?></label>
                        <div class="col-md-8">
                            <?php echo Form::select('product_category',array('0' => __('english.SELECT_CATEGORY_OPT')) + $productCategoryArr, Request::get('product_category'), ['class' => 'form-control js-source-states','id'=>'productCategory']); ?>

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
                            <th class="vcenter"><?php echo app('translator')->get('english.NAME'); ?></th>
                            <th class="vcenter"><?php echo app('translator')->get('english.PRODUCT_INFO'); ?></th>
                            <th class="vcenter"><?php echo app('translator')->get('english.PRICE'); ?></th>
                            <th class="vcenter"><?php echo app('translator')->get('english.SPECIAL_PRICE'); ?></th>
                            <th class="vcenter"><?php echo app('translator')->get('english.DESCRIPTION'); ?></th>
                            <th class="vcenter"><?php echo app('translator')->get('english.CATEGORY'); ?></th>
                            <th class="text-center vcenter"><?php echo app('translator')->get('english.STATUS'); ?></th>
                            <th class="text-center vcenter"><?php echo app('translator')->get('english.ACTION'); ?></th>
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
                            <td class="text-center vcenter"><?php echo ++$sl; ?></td>
                            <td class="vcenter"><?php echo $target->name; ?></td>
                            <td class="vcenter"><?php echo $target->product_info; ?></td>
                            <td class="vcenter"><?php echo $target->price; ?></td>
                            <td class="vcenter"><?php echo $target->special_price??''; ?></td>
                            <td class="vcenter"><?php echo $target->description; ?></td>
                            <td class="vcenter"><?php echo $target->product_category; ?></td>
                          
                            <td class="text-center vcenter">
                                <?php if($target->status == '1'): ?>
                                <span class="label label-sm label-success"><?php echo app('translator')->get('english.ACTIVE'); ?></span>
                                <?php else: ?>
                                <span class="label label-sm label-warning"><?php echo app('translator')->get('english.INACTIVE'); ?></span>
                                <?php endif; ?>
                            </td>

                            <td class="td-actions text-center vcenter">
                                <div class="width-inherit">
                                    <a class="btn btn-xs yellow tooltips vcenter set-product-image" href="<?php echo e(URL::to('product/' . $target->id . '/getProductImage'.Helper::queryPageStr($qpArr))); ?>"  title="<?php echo app('translator')->get('english.SET_PRODUCT_IMAGE'); ?>">
                                        <i class="fa fa-file-image-o"></i>
                                    </a>
                                    <a class="btn btn-xs btn-primary tooltips vcenter" title="Edit" href="<?php echo e(URL::to('product/' . $target->id . '/edit'.Helper::queryPageStr($qpArr))); ?>">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <?php echo Form::open(array('url' => '/product/' . $target->id.'/'.Helper::queryPageStr($qpArr), 'class' => 'delete-form-inline','id'=>'delete')); ?>

                                    <?php echo Form::hidden('_method', 'DELETE'); ?>

                                    <button class="btn btn-xs btn-danger tooltips vcenter" title="Delete" type="submit" data-placement="top" data-rel="tooltip" data-original-title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <?php echo Form::close(); ?>

                       
                                </div>
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

<!-- Modal start -->

<!--set product image modal-->
<div class="modal fade" id="modalSetProductImage" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div id="showSetProductImage">
        </div>
    </div>
</div>


<!-- Modal end-->

<script type="text/javascript">
    
     $(document).on("submit", '#delete', function (e) {
        
        //This function use for sweetalert confirm message
        e.preventDefault();
        var form = this;
        swal({
            title: 'Are you sure you want to Delete?',
            text: '',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete",
            closeOnConfirm: false
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

<?php echo $__env->make('layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\swapnoloke\resources\views/website/product/index.blade.php ENDPATH**/ ?>