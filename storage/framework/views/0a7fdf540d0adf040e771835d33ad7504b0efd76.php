
<?php $__env->startSection('content'); ?>
<!-- BEGIN CONTENT BODY -->
<div class="page-content">

    <!-- BEGIN PORTLET-->
    <?php echo $__env->make('includes.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- END PORTLET-->
    <div class="row">
        <div class="col-md-12">
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-badge"></i><?php echo e(trans('english.VIEW_DESIGNATION_LIST')); ?>

                    </div>
                    <div class="actions">
                        <a href="<?php echo e(URL::to('designation/create')); ?>" class="btn btn-default btn-sm">
                            <i class="fa fa-plus"></i> <?php echo e(trans('english.CREATE_A_DESIGNATION')); ?> </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th><?php echo e(trans('english.SL_NO')); ?></th>
                                    <th><?php echo e(trans('english.TITLE')); ?></th>
                                    <th><?php echo e(trans('english.SHORT_NAME')); ?></th>
                                    <th class="text-center"><?php echo e(trans('english.ORDER')); ?></th>
                                    <th class='text-center'><?php echo e(trans('english.STATUS')); ?></th>
                                    <th class='text-center'><?php echo e(trans('english.ACTION')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!$designationArr->isEmpty()): ?>
                                <?php
                                $page = Request::get('page');
                                $page = empty($page) ? 1 : $page;
                                $sl = ($page - 1) * trans('english.PAGINATION_COUNT');
                                ?>
                                <?php $__currentLoopData = $designationArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <tr class="contain-center">
                                    <td><?php echo e(++$sl); ?></td>
                                    <td><?php echo e($value->title); ?></td>
                                    <td><?php echo e($value->short_name); ?></td>
                                    <td class="text-center"><?php echo e($value->order); ?></td>
                                    <td class="text-center">
                                        <?php if($value->status == 'active'): ?>
                                        <span class="label label-success"><?php echo e($value->status); ?></span>
                                        <?php else: ?>
                                        <span class="label label-warning"><?php echo e($value->status); ?></span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="action-center">
                                        <div class='text-center'>
                                            <?php echo e(Form::open(array('url' => 'designation/' . $value->id, 'id' => 'delete'))); ?>

                                            <?php echo e(Form::hidden('_method', 'DELETE')); ?>

                                            <a class='btn btn-primary btn-xs' href="<?php echo e(URL::to('designation/' . $value->id . '/edit')); ?>">
                                                <i class='fa fa-edit'></i>
                                            </a>
                                            <button class="btn btn-danger btn-xs" type="submit" data-placement="top" data-rel="tooltip" data-original-title="Delete">
                                                <i class='fa fa-trash'></i>
                                            </button>
                                            <?php echo e(Form::close()); ?>

                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="4"><?php echo e(trans('english.EMPTY_DATA')); ?></td>
                                </tr>
                                <?php endif; ?> 
                            </tbody>
                        </table>

                    </div>
                    <div class="row">
                        <div class="col-md-5 col-sm-5">
                            <div class="dataTables_info" role="status" aria-live="polite">
                                <?php
                                $start = empty($designationArr->total()) ? 0 : (($designationArr->currentPage() - 1) * $designationArr->perPage() + 1);
                                $end = ($designationArr->currentPage() * $designationArr->perPage() > $designationArr->total()) ? $designationArr->total() : ($designationArr->currentPage() * $designationArr->perPage());
                                ?> <br />
                                <?php echo app('translator')->get('english.SHOWING'); ?> <?php echo e($start); ?> <?php echo app('translator')->get('english.TO'); ?> <?php echo e($end); ?> <?php echo app('translator')->get('english.OF'); ?>  <?php echo e($designationArr->total()); ?> <?php echo app('translator')->get('english.RECORDS'); ?>
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-7">
                            <?php echo e($designationArr->appends(Request::all())->links()); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END CONTENT BODY -->

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

<?php echo $__env->make('layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\swapnoloke\resources\views/designation/index.blade.php ENDPATH**/ ?>