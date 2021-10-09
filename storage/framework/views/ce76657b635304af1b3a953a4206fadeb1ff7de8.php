
<?php $__env->startSection('content'); ?>
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <?php echo $__env->make('layouts.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-road"></i><?php echo e($programName); ?> <?php echo app('translator')->get('english.SLIDER'); ?>
            </div>
            <div class="actions">
                <a class="btn btn-default btn-sm create-new" href="<?php echo e(URL::to('programGallery/'.$id.'/create')); ?>"> <?php echo e(trans('english.CREATE_NEW')); ?>

                    <i class="fa fa-plus create-new"></i>
                </a>
            </div>
        </div>
        <div class="portlet-body">
            

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="vcenter" width="80"><?php echo app('translator')->get('english.SL_NO'); ?></th>
                            <th class="text-center vcenter"><?php echo app('translator')->get('english.IMAGE'); ?></th>
                            <th class="text-center vcenter"><?php echo app('translator')->get('english.ORDER'); ?></th>
           
                            <th class=" text-center vcenter"><?php echo app('translator')->get('english.STATUS'); ?></th>
                            <th class="td-actions text-center vcenter"><?php echo app('translator')->get('english.ACTION'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!$targetArr->isEmpty()): ?>
                        <?php $sl=0; ?>
                        <?php $__currentLoopData = $targetArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $target): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="vcenter"><?php echo e(++$sl); ?></td>
                            <td class="text-center vcenter"><img width="80" src="<?php echo e(asset('public/uploads/website/programGallery/'.$target->image)); ?>" alt=""></td>
                            <td class="text-center vcenter"><?php echo e($target->order); ?></td>
                            <td class="text-center vcenter">
                                <?php if($target->status_id == '1'): ?>
                                <span class="label label-sm label-success"><?php echo app('translator')->get('english.ACTIVE'); ?></span>
                                <?php else: ?>
                                <span class="label label-sm label-warning"><?php echo app('translator')->get('english.INACTIVE'); ?></span>
                                <?php endif; ?>
                            </td>
                            <td  class="text-center vcenter">
                                <div>
                                    <?php echo e(Form::open(array('url' => 'programGallery/destroy', 'id'=>'delete'))); ?>

                                    <?php echo e(Form::hidden('_method', 'POST')); ?>

                                    <?php echo e(Form::hidden('id', $target->id)); ?>

                                    <a class="btn btn-icon-only btn-primary tooltips" title="Edit" href="<?php echo e(URL::to('programGallery/' . $target->id . '/edit')); ?>">
                                        <i class="fa fa-edit"></i>
                                    </a>
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
                            <td colspan="9" class="vcenter"><?php echo app('translator')->get('english.NO_DATA_FOUND'); ?></td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
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
<?php echo $__env->make('layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\swapnoloke\resources\views/website/programGallery/index.blade.php ENDPATH**/ ?>