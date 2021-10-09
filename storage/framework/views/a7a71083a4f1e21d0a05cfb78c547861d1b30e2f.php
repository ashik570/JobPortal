
<?php $__env->startSection('content'); ?>
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <?php echo $__env->make('layouts.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-list"></i><?php echo app('translator')->get('english.PRODUCT_CATEGORY_LIST'); ?>
            </div>
            <div class="actions">
                <a class="btn btn-default btn-sm create-new" href="<?php echo e(URL::to('productCategory/create'.Helper::queryPageStr($qpArr))); ?>"> <?php echo app('translator')->get('english.CREATE_NEW_PRODUCT_CATEGORY'); ?>
                    <i class="fa fa-plus create-new"></i>
                </a>
            </div>
        </div>
        <div class="portlet-body">
            <div class="row">
                <!-- Begin Filter-->
                <?php echo Form::open(array('group' => 'form', 'url' => 'productCategory/filter','class' => 'form-horizontal')); ?>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label col-md-4" for="search"><?php echo app('translator')->get('english.SEARCH'); ?></label>
                            <div class="col-md-8">
                                <?php echo Form::text('search',  Request::get('search'), ['class' => 'form-control tooltips', 'title' => 'Name', 'placeholder' => 'Name', 'list'=>'search', 'autocomplete'=>'off']); ?> 
                                <datalist id="search">
                                    <?php if(!empty($nameArr)): ?>
                                    <?php $__currentLoopData = $nameArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($name->name); ?>"></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </datalist>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form">
                            <button type="submit" class="btn btn-md green btn-outline filter-submit margin-bottom-20">
                                <i class="fa fa-search"></i> <?php echo app('translator')->get('english.FILTER'); ?>
                            </button>
                        </div>
                    </div>
                </div>
                <?php echo Form::close(); ?>

                <!-- End Filter -->
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="vcenter text-center"><?php echo app('translator')->get('english.SL_NO'); ?></th>
                            <th class="vcenter text-center"><?php echo app('translator')->get('english.NAME'); ?></th>
                            <th class="vcenter text-center"><?php echo app('translator')->get('english.CODE'); ?></th>
                            <th class="vcenter text-center"><?php echo app('translator')->get('english.PARENT_CATEGORY'); ?></th>
                            <th class="vcenter text-center"><?php echo app('translator')->get('english.ORDER'); ?></th>
                            <th class="vcenter text-center"><?php echo app('translator')->get('english.STATUS'); ?></th>
                            <th class="vcenter text-center"><?php echo app('translator')->get('english.ACTION'); ?></th>
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
                            <td class="vcenter text-center"><?php echo e(++$sl); ?></td>
                            <td class="vcenter"><?php echo e($target->name); ?></td>
                            <td class="vcenter"><?php echo e($target->code); ?></td>
                            <td class="vcenter">
                                <?php
                                if (isset($parentArr[$target->id])) {
                                    echo $parentArr[$target->id];
                                } else {
                                    echo '';
                                }
                                ?>
                            </td>
                            <td class="vcenter text-center"><?php echo e($target->order); ?></td>
                            <td class="vcenter text-center">
                                <?php if($target->status == '1'): ?>
                                <span class="label label-sm label-success"><?php echo app('translator')->get('english.ACTIVE'); ?></span>
                                <?php else: ?>
                                <span class="label label-sm label-warning"><?php echo app('translator')->get('english.INACTIVE'); ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="td-actions text-center vcenter">
                                <div class="width-inherit">
               
                                    <a class="btn btn-icon-only btn-primary tooltips" title="Edit" href="<?php echo e(URL::to('content/' . $target->id . '/edit'.Helper::queryPageStr($qpArr))); ?>">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <?php echo e(Form::open(array('url' => 'productCategory/' . $target->id.'/'.Helper::queryPageStr($qpArr), 'class' => 'delete-form-inline' ,'id'=>'delete'))); ?>

                                    <?php echo e(Form::hidden('_method', 'DELETE')); ?>

                                      <button class="btn btn-icon-only btn-danger tooltips" title="Delete" type="submit" data-placement="top" data-rel="tooltip" data-original-title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <?php echo e(Form::close()); ?>

                        
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="8"><?php echo app('translator')->get('english.NO_PRODUCT_CATEGORY_FOUND'); ?></td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php echo $__env->make('layouts.paginator', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>	
    </div>
</div>
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
<?php echo $__env->make('layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\swapnoloke\resources\views/website/productCategory/index.blade.php ENDPATH**/ ?>