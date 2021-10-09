
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
                        <i class="fa fa-cubes"></i><?php echo e(trans('english.VIEW_JOB_NATURE')); ?>

                    </div>
                    <div class="actions">
                        <a href="<?php echo e(URL::to('jobNature/create')); ?>" class="btn btn-default btn-sm">
                            <i class="fa fa-plus"></i> <?php echo e(trans('english.CREATE_NEW_JOB_NATURE')); ?> </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <?php echo e(Form::open(array('role' => 'form', 'url' => 'jobNature/filter', 'class' => '', 'id' => 'jobNatureFilter'))); ?>

                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="col-md-4 control-label"><?php echo e(trans('english.SEARCH_TEXT')); ?></label>
                                <div class="col-md-8">
                                    <?php echo e(Form::text('search_text', Request::get('search_text'), array('id'=> 'jobNatureSearchText', 'class' => 'form-control', 'placeholder' => 'Enter Search Text'))); ?>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-md green btn-outline filter-submit margin-bottom-20">
                                <i class="fa fa-search"></i> <?php echo e(trans('english.FILTER')); ?>

                            </button>
                        </div>
                    </div>
                    <?php echo e(Form::close()); ?>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th><?php echo e(trans('english.SL_NO')); ?></th>
                                    <th><?php echo e(trans('english.NAME')); ?></th>
                                    <th><?php echo e(trans('english.ORDER')); ?></th>
                                    <th><?php echo e(trans('english.STATUS')); ?></th>
                                    <th class="text-center"><?php echo e(trans('english.ACTION')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!$targetArr->isEmpty()): ?>
                                <?php
                                $page = Request::get('page');
                                $page = empty($page) ? 1 : $page;
                                $sl = ($page - 1) * trans('english.PAGINATION_COUNT');
                                ?>
                                <?php $__currentLoopData = $targetArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <tr class="contain-center">
                                    <td><?php echo e(++$sl); ?></td>
                                    <td><?php echo e($value->name); ?></td>
                                    <td class="text-center"><?php echo e($value->order); ?></td>
                                    <td class="text-center">
                                        <?php if($value->status == '1'): ?>
                                        <span class="label label-success"><?php echo e(trans('english.ACTIVE')); ?></span>
                                        <?php else: ?>
                                        <span class="label label-warning"><?php echo e(trans('english.INACTIVE')); ?></span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="action-center">
                                        <div class='text-center'>
                                            <?php echo e(Form::open(array('url' => 'jobNature/delete/' . $value->id, 'id' => 'delete'))); ?>

                                            <?php echo e(Form::hidden('_method', 'DELETE')); ?>

                                            <a class="btn btn-primary btn-xs tooltips" title="<?php echo e(trans('english.JOB_NATURE_EDIT')); ?>" data-original-title="<?php echo e(trans('english.JOB_NATURE_EDIT')); ?>" href="<?php echo e(URL::to('jobNature/' . $value->id . '/edit')); ?>">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <button class="btn btn-danger btn-xs tooltips" type="submit" data-placement="top" data-rel="tooltip" title="<?php echo e(trans('english.JOB_NATURE_DELETE')); ?>" data-original-title="<?php echo e(trans('english.JOB_NATURE_DELETE')); ?>">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            <?php echo e(Form::close()); ?>

                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="7"><?php echo e(trans('english.EMPTY_DATA')); ?></td>
                                </tr>
                                <?php endif; ?> 
                            </tbody>
                        </table>
                        
                    </div>
                    <?php echo $__env->make('layouts.paginator', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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

<?php echo $__env->make('layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp-7.4.9\htdocs\swapnoloke\resources\views/jobNature/index.blade.php ENDPATH**/ ?>