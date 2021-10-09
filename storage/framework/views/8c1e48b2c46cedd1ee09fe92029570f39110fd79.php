
<?php $__env->startSection('content'); ?>
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <?php echo $__env->make('layouts.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-road"></i><?php echo app('translator')->get('english.CONTACT'); ?>
            </div>
        </div>
        <div class="portlet-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="vcenter" width="80"><?php echo app('translator')->get('english.SL_NO'); ?></th>
                            <th class="vcenter"><?php echo app('translator')->get('english.EMAIL'); ?></th>
                            <th class="text-center vcenter"><?php echo app('translator')->get('english.WEBSITE'); ?></th>
                            <th class="text-center vcenter"><?php echo app('translator')->get('english.PHONE'); ?></th>
                            <th class="text-center vcenter"><?php echo app('translator')->get('english.ADDRESS'); ?></th>
                            <th class=" text-center vcenter"><?php echo app('translator')->get('english.STATUS'); ?></th>
                            <th class="td-actions text-center vcenter"><?php echo app('translator')->get('english.ACTION'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!$targetArr->isEmpty()): ?>
                        <?php
                        $page = Request::get('page');
                        $page = empty($page) ? 1 : $page;
                        $sl = ($page - 1) * (Session::get('paginatorCount'));
                        ?>
                        <?php $__currentLoopData = $targetArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $target): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="vcenter"><?php echo e(++$sl); ?></td>
                           <td class="vcenter"><?php echo e($target->email); ?></td>
                           <td class="vcenter"><?php echo e($target->website); ?></td>
                           <td class="vcenter"><?php echo e($target->phone); ?></td>
                           <td class="vcenter"><?php echo $target->address; ?></td>
              
                            <td class="text-center vcenter">
                                <?php if($target->status_id == '1'): ?>
                                <span class="label label-sm label-success"><?php echo app('translator')->get('english.ACTIVE'); ?></span>
                                <?php else: ?>
                                <span class="label label-sm label-warning"><?php echo app('translator')->get('english.INACTIVE'); ?></span>
                                <?php endif; ?>
                            </td>
                            <td  class="text-center vcenter">
                                <div>
                                    <a class="btn btn-icon-only btn-primary tooltips" title="Edit" href="<?php echo e(URL::to('contact-info/' . $target->id . '/edit'.Helper::queryPageStr($qpArr))); ?>">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                 
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="9" class="vcenter"><?php echo app('translator')->get('english.NO_DATA_FOUND'); ?></td>
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
        alert
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
<?php echo $__env->make('layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\swapnoloke\resources\views/website/contactInfo/index.blade.php ENDPATH**/ ?>