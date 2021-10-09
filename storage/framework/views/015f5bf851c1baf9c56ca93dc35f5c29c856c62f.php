
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
                        <i class="fa fa-file-image-o"></i><?php echo e(trans('english.VIEW_GALLERY')); ?>

                    </div>
                    <div class="actions">
                        <a href="<?php echo e(URL::to('gallery/create')); ?>" class="btn btn-default btn-sm">
                            <i class="fa fa-plus"></i> <?php echo e(trans('english.UPLOAD_GALLERY_PHOTO')); ?> </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="table-responsive">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><?php echo e(trans('english.SL_NO')); ?></th>
                                            <th class="text-center"><?php echo e(trans('english.CAPTION')); ?></th>
                                            <th class="text-center"><?php echo e(trans('english.THUMB')); ?></th>
                                            <th class='text-center'><?php echo e(trans('english.IMAGE')); ?></th>
                                            <th class='text-center'><?php echo e(trans('english.ORDER')); ?></th>
                                            <th class='text-center'><?php echo e(trans('english.STATUS')); ?></th>
                                            <th class='text-center'><?php echo e(trans('english.ACTION')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(!$targetArr->isEmpty()): ?>
                                        <?php
                                        $page = Request::get('page');
                                        $page = empty($page) ? 1 : $page;
                                        $sl = ($page - 1) * 10;
                                        ?>
                                        <?php $__currentLoopData = $targetArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <tr class="contain-center">
                                            <td><?php echo e(++$sl); ?></td>
                                            <td><?php echo e($gallery->caption); ?></td>
                                            <td class="text-center">
                                                <?php if(!empty($gallery->thumb)): ?>
                                                <img width="50" height="auto" src="<?php echo e(URL::to('/')); ?>/public/uploads/website/gallery/<?php echo e($gallery->thumb); ?>"}}">
                                                <?php endif; ?>
                                            </td>

                                            <td class="text-center">
                                                <?php if(!empty($gallery->photo)): ?>
                                                    <img width="100" height="auto" src="<?php echo e(URL::to('/')); ?>/public/uploads/website/gallery/<?php echo e($gallery->photo); ?>"}}">
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo e($gallery->order); ?></td>
                                            <td class="text-center">
                                                <?php if($gallery->status_id == '1'): ?>
                                                <span class="label label-sm label-success"><?php echo app('translator')->get('english.ACTIVE'); ?></span>
                                                <?php else: ?>
                                                <span class="label label-sm label-warning"><?php echo app('translator')->get('english.INACTIVE'); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="action-center">
                                                <div class="text-center user-action">
                                                    <?php echo e(Form::open(array('url' => 'gallerymgt/' . $gallery->id, 'id' => 'delete'))); ?>

                                                    <?php echo e(Form::hidden('_method', 'DELETE')); ?>


                                                    <a class='btn btn-primary btn-xs tooltips' href="<?php echo e(URL::to('gallery/' . $gallery->id . '/edit')); ?>" title="Edit Gallery" data-container="body" data-trigger="hover" data-placement="top">
                                                        <i class='fa fa-edit'></i>
                                                    </a>
                                                    <button class="btn btn-danger btn-xs tooltips delete7" type="submit" title="Delete" data-placement="top" data-rel="tooltip" data-original-title="Delete">
                                                        <i class='fa fa-trash'></i>
                                                    </button>

                                                    <?php echo e(Form::close()); ?>

                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                        <tr>
                                            <td colspan="11"><?php echo e(trans('english.EMPTY_DATA')); ?></td>
                                        </tr>
                                        <?php endif; ?> 
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php echo $__env->make('layouts.paginator', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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

<?php echo $__env->make('layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\swapnoloke\resources\views/gallery/index.blade.php ENDPATH**/ ?>