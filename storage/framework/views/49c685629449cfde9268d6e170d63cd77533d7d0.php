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
                        <i class="fa fa-cubes"></i><?php echo e(trans('english.VIEW_CIRCULAR')); ?>

                    </div>
                    <div class="actions">
                        <a href="<?php echo e(URL::to('circular/create')); ?>" class="btn btn-default btn-sm">
                            <i class="fa fa-plus"></i> <?php echo e(trans('english.CREATE_NEW_CIRCULAR')); ?> </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <?php echo e(Form::open(array('role' => 'form', 'url' => 'circular/filter', 'class' => '', 'id' => 'circularFilter'))); ?>

                    <?php echo Form::hidden('filter', Helper::queryPageStr($qpArr)); ?>

                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="col-md-4 control-label"><?php echo e(trans('english.SEARCH_TEXT')); ?></label>
                                <div class="col-md-8">
                                    <?php echo e(Form::text('search_text', Request::get('search_text'), array('id'=> 'circularSearchText', 'class' => 'form-control', 'placeholder' => 'Enter Search Text'))); ?>

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
                                    <th><?php echo e(trans('english.TITLE')); ?></th>
                                    <th><?php echo e(trans('english.JOB_NATURE')); ?></th>
                                    <th><?php echo e(trans('english.VACANCY')); ?></th>
                                    <th><?php echo e(trans('english.EXPERIENCE')); ?></th>
                                    <th><?php echo e(trans('english.SALARY')); ?></th>
                                    <th><?php echo e(trans('english.SUBMISSION_DATE')); ?></th>
                                    <th><?php echo e(trans('english.DEADLINE')); ?></th>
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
                                <?php
                                $salaryTypeArr = Common::salaryTypes();
//                                dd($value->salary_type);
                                $salaryType = '';
                                if (!empty($value->salary_type)) {
                                    $salaryType = "(" . $salaryTypeArr[$value->salary_type] . ")";
                                }

                                $salaryRange = "";
                                if (!empty($value->nigotiable)) {
                                    $salaryRange = "nigotiable";
                                } else {
                                    if (!empty($value->salary_from) && !empty($value->salary_to) || !empty($value->salary_to)) {
                                        if (empty($value->salary_from)) {
                                            $salaryRange = "0 to " . $value->salary_to." Tk";
                                        } else {
                                            $salaryRange = $value->salary_from . " to " . $value->salary_to." Tk";
                                        }
                                    } else {
                                        $salaryRange = $value->salary_from." Tk";
                                    }
                                }
                                ?>
                                <tr class="contain-center">
                                    <td><?php echo e(++$sl); ?></td>
                                    <td><?php echo e($value->title); ?></td>
                                    <td><?php echo e($value->jobNature->name); ?></td>
                                    <?php if(!empty($value->vacancy)): ?>
                                    <td class="text-center"><?php echo e($value->vacancy); ?></td>
                                    <?php else: ?>
                                    <td class="text-center">Not Specific</td>
                                    <?php endif; ?>
                                    <?php
                                    $message = '';
                                    $s = '';
                                    if (!empty($value['experience_not_required'])) {
                                        $message = "N/A";
                                    } else {
                                        if (!empty($value['experience_from']) && !empty($value['experience_to']) || !empty($value['experience_to'])) {
                                            if ($value['experience_to'] - $value['experience_from'] >= 1) {
                                                $s = 's';
                                            }
                                            $message = $value['experience_from'] . " to " . $value['experience_to'] . " year" . $s;
                                        } else {
                                            if ($value['experience_from'] > 1) {
                                                $s = 's';
                                            }
                                            $message = "At least " . $value['experience_from'] . " year" . $s;
                                        }
                                    }
                                    ?>
                                    <td class="text-center"><?php echo e($message); ?></td>
                                    <td class="text-center"><?php echo e($salaryRange." ".$salaryType); ?></td>
                                    <td class="text-center"><?php echo date('d F Y',strtotime($value->submission_date)); ?></td>
                                    <td class="text-center"><?php echo date('d F Y',strtotime($value->deadline)); ?></td>
                                    <td class="text-center">
                                        <?php if($value->status == '1'): ?>
                                        <span class="label label-success"><?php echo e(trans('english.ACTIVE')); ?></span>
                                        <?php else: ?>
                                        <span class="label label-warning"><?php echo e(trans('english.INACTIVE')); ?></span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="action-center">
                                        <div class='text-center'>
                                            <?php echo e(Form::open(array('url' => 'circular/delete/' . $value->id, 'id' => 'delete'))); ?>

                                            <?php echo e(Form::hidden('_method', 'DELETE')); ?>

                                            <a class="tooltips btn btn-primary btn-xs" href="<?php echo e(URL::to('circular/' . $value->id . '/edit'.Helper::queryPageStr($qpArr))); ?>" title="<?php echo e(trans('english.EDIT_CIRCULAR')); ?>" data-container="body" data-trigger="hover" data-placement="top">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <a class="tooltips get-circular-info" data-toggle="modal" data-target="#viewModal" data-id="<?php echo e($value->id); ?>" href="#viewModal" id="getCircularInfo_<?php echo e($value->id); ?>" title="<?php echo e(trans('english.CIRCULAR_DETAILS')); ?>" data-container="body" data-trigger="hover" data-placement="top">
                                                <span class="btn btn-success btn-xs"> 
                                                    &nbsp;<i class='fa fa-info'></i>&nbsp;
                                                </span>
                                            </a>
                                            <!--<div class="mb-2"></div>-->
                                            <button class="tooltips btn btn-danger btn-xs" type="submit" data-placement="top" title="<?php echo e(trans('english.CIRCULAR_DELETE')); ?>" data-rel="tooltip" data-original-title="<?php echo e(trans('english.CIRCULAR_DELETE')); ?>">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            <?php echo e(Form::close()); ?>

                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="15"><?php echo e(trans('english.EMPTY_DATA')); ?></td>
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

<!--This module use for student other information edit-->
<div id="viewModal" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="col-md-12" id="dynamicContent">
            <!-- mysql data will load in table -->
            
        </div>
    </div>
</div>
<!-- END CONTENT BODY -->
<script type="text/javascript">
    $(document).on('click', '.get-circular-info', function (e) {
        e.preventDefault();
        var userId = $(this).data('id'); // get id of clicked row

        $('#dynamicContent').html(''); // leave this div blank
        $.ajax({
            url: "<?php echo e(URL::to('circular/circular-info')); ?>",
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                user_id: userId
            },
            cache: false,
            contentType: false,
            success: function (response) {
                $('#dynamicContent').html(''); // blank before load.
                $('#dynamicContent').html(response.html); // load here
                $('.date-picker').datepicker({autoclose: true});
            },
            error: function (jqXhr, ajaxOptions, thrownError) {
                $('#dynamicContent').html('<i class="fa fa-info-sign"></i> Something went wrong, Please try again...');
            }
        });
    });

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

<?php echo $__env->make('layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\swapnoloke\resources\views/circular/index.blade.php ENDPATH**/ ?>