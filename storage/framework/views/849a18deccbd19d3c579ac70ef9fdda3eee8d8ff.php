<?php
//dd($targetArr[0]['id']);
?>

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
                        <i class="fa fa-cubes"></i><?php echo e(trans('english.VIEW_CONFIRMED_APPLICATION')); ?>

                    </div>
                    <!--                    <div class="actions">
                                            <a href="<?php echo e(URL::to('jobNature/create')); ?>" class="btn btn-default btn-sm">
                                                <i class="fa fa-plus"></i> <?php echo e(trans('english.CREATE_NEW_JOB_NATURE')); ?> </a>
                                        </div>-->
                </div>
                <div class="portlet-body">
                    <?php echo e(Form::open(array('role' => 'form', 'url' => 'confirmedApplication/filter', 'class' => '', 'id' => 'jobTitleFilter'))); ?>

                    <?php echo Form::hidden('filter', Helper::queryPageStr($qpArr)); ?>

                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="col-md-4 control-label"><?php echo e(trans('english.JOB_TITLE')); ?></label>
                                <div class="col-md-8">
                                    <?php echo Form::select('circular_id', $circularList, Request::get('circular_id'), array('id'=> 'jobTitle', 'class' => 'form-control dopdownselect')); ?>

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
                                    <th class="text-center vcenter" rowspan="2"><?php echo e(trans('english.SL_NO')); ?></th>
                                    <th class="text-center vcenter" rowspan="2"><?php echo e(trans('english.JOB_TITLE')); ?></th>
                                    <th class="text-center vcenter" colspan="4"><?php echo e(trans('english.APPLICANT_INFO')); ?></th>
                                    <!--<th><?php echo e(trans('english.STATUS')); ?></th>-->
                                    <th class="text-center vcenter" rowspan="2" class="text-center"><?php echo e(trans('english.ACTION')); ?></th>
                                </tr>
                                <tr>
                                    <th class="text-center vcenter"><?php echo e(trans('english.NAME')); ?></th>
                                    <th class="text-center vcenter"><?php echo e(trans('english.EMAIL')); ?></th>
                                    <th class="text-center vcenter"><?php echo e(trans('english.PHONE')); ?></th>
                                    <th class="text-center vcenter"><?php echo e(trans('english.CV')); ?></th>
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
                                    <td><?php echo e($value->circular); ?></td>
                                    <td><?php echo e($value->name); ?></td>
                                    <td class="text-center"><?php echo e($value->email); ?></td>
                                    <td class="text-center"><?php echo e($value->phone); ?></td>
                                    <td class="text-center"><a href="<?php echo e(URL::to('public/uploads/website/cv/' . $value->cv)); ?>" download="<?php echo e($value->name); ?>"><i class="fa fa-download"></i></a></td>
<!--                                    <td class="text-center">
                                        <?php if($value->status == '1'): ?>
                                        <span class="label label-success"><?php echo e(trans('english.ACTIVE')); ?></span>
                                        <?php else: ?>
                                        <span class="label label-warning"><?php echo e(trans('english.INACTIVE')); ?></span>
                                        <?php endif; ?>
                                    </td>-->

                                    <td class="action-center">
                                        <div class='text-center'>
                                            <a class="btn btn-success btn-xs tooltips participated" data-placement="top" data-rel="tooltip" data-original-title="<?php echo e(trans('english.PARTICIPATED')); ?>" data-id ="<?php echo e($value->id); ?>" title="<?php echo e(trans('english.PARTICIPATED')); ?>" id="participated_<?php echo e($value->id); ?>" data-container="body" data-trigger="hover" data-placement="top">
                                                <i class="fa fa-hand-paper-o"></i>
                                            </a>

                                            <a class="btn btn-warning btn-xs tooltips application-details" data-toggle="modal" data-target="#viewModal" href="#viewModal" data-placement="top" data-rel="tooltip" data-original-title="<?php echo e(trans('english.VIEW_APPLICATION_DETAILS')); ?>" data-id ="<?php echo e($value->id); ?>" title="<?php echo e(trans('english.VIEW_APPLICATION_DETAILS')); ?>" id="applicationDetails_<?php echo e($value->id); ?>" data-container="body" data-trigger="hover" data-placement="top">
                                                <i class="fa fa-bars"></i>
                                            </a>
                                            
                                            <a class="btn btn-warning btn-xs tooltips view-activity-log" data-placement="top" data-rel="tooltip" data-original-title="<?php echo e(trans('english.CLICK_HERE_TO_VIEW_ACTIVITY_LOG')); ?>" data-toggle="modal" data-id ="<?php echo e($value->id); ?>" href="#modalSetActivity" title="<?php echo e(trans('english.CLICK_HERE_TO_VIEW_ACTIVITY_LOG')); ?>" id="setActivityLog_<?php echo e($value->id); ?>" data-container="body" data-trigger="hover" data-placement="top">
                                                <i class="fa fa-plus"></i>
                                            </a>
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
                    <!--Paginator-->
                    <?php echo $__env->make('layouts.paginator', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!--This module use for student other information edit-->
<div class="modal fade" id="modalSetActivity" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="col-md-12" id="showActivityLog">
            <!--mysql data will load in table-->

        </div>
    </div>
</div>


<div id="viewModal" class="modal fade" role="basic" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="col-md-12" id="applicationContent">
            mysql data will load in table 

        </div>
    </div>
</div>
<script type="text/javascript">

    $(document).on('click', ".participated", function (e) {
        var jobId = $(this).data('id');
        e.preventDefault();
        swal({
            title: "Are you sure?",
            text: "This applicant Participated the interview!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, Participated",
            cancelButtonText: "No, Don't Participated",
            closeOnConfirm: true,
            closeOnCancel: true
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var options = {
                    closeButton: true,
                    debug: false,
                    positionClass: "toast-bottom-right",
                    onclick: null,
                };

//                var formData = new FormData($("#discardApplicationForm")[0]);
//                    var jobId = $(this).data('id');
//                    console.log(jobId);

                $.ajax({
                    url: "<?php echo e(URL::to('applicant/applicant-participated')); ?>",
                    type: "POST",
                    dataType: 'json', // what to expect back from the PHP script, if anything
//                    cache: false,
//                    contentType: false,
//                    processData: false,
                    data: {
                        job_applicant_id: jobId
                    },
                    beforeSend: function () {
                        $(".participated").prop('disabled', true);
                        App.blockUI({boxed: true});
                    },
                    success: function (res) {
                        toastr.success(res.message, res.heading, options);
                        location = "<?php echo e(URL::to('/confirmedApplication')); ?>";
                    },
                    error: function (jqXhr, ajaxOptions, thrownError) {
                        if (jqXhr.status == 400) {
                            var errorsHtml = '';
                            var errors = jqXhr.responseJSON.message;
                            $.each(errors, function (key, value) {
                                errorsHtml += '<li>' + value[0] + '</li>';
                            });
                            toastr.error(errorsHtml, jqXhr.responseJSON.heading, options);
                        } else if (jqXhr.status == 401) {
                            toastr.error(jqXhr.responseJSON.message, '', options);
                        } else {
                            toastr.error('Error', 'Something went wrong', options);
                        }
                        $(".participated").prop('disabled', false);
                        App.unblockUI();
                    }
                }); //ajax
            }
        });
    });

    $(document).on('click', '.application-details', function (e) {
        e.preventDefault();
        var applicationId = $(this).data('id'); // get id of clicked row

        $('#applicationContent').html(''); // leave this div blank
        $.ajax({
            url: "<?php echo e(URL::to('applicant/applicantion-info')); ?>",
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                application_id: applicationId
            },
            cache: false,
            contentType: false,
            success: function (response) {
                $('#applicationContent').html(''); // blank before load.
                $('#applicationContent').html(response.html); // load here
                $('.date-picker').datepicker({autoclose: true});
            },
            error: function (jqXhr, ajaxOptions, thrownError) {
                if (jqXhr.status == 400) {
                    var errorsHtml = '';
                    var errors = jqXhr.responseJSON.message;
                    $.each(errors, function (key, value) {
                        errorsHtml += '<li>' + value[0] + '</li>';
                    });
                    toastr.error(errorsHtml, jqXhr.responseJSON.heading, options);
                } else if (jqXhr.status == 401) {
                    toastr.error(jqXhr.responseJSON.message, '', options);
                } else {
                    toastr.error('Error', 'Something went wrong', options);
                }
                $(".application-details").prop('disabled', false);
                App.unblockUI();
            }
        });
    });
    
    $(document).on('click', '.view-activity-log', function (e) {
        e.preventDefault();
        var jobId = $(this).data('id'); // get id of clicked row
//        console.log(jobId);
        $('#showActivityLog').html(''); // leave this div blank
        $.ajax({
            url: "<?php echo e(URL::to('applicant/view-activity-log-modal')); ?>",
            type: "POST",
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                job_applicant_id: jobId
            },

            success: function (response) {
                $('#showActivityLog').html(''); // blank before load.
                $('#showActivityLog').html(response.html); // load here
                $('.date-picker').datepicker({autoclose: true});
            },
            error: function (jqXhr, ajaxOptions, thrownError) {
                $('#showActivityLog').html('<i class="fa fa-info-sign"></i> Something went wrong, Please try again...');
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\swapnoloke\resources\views/confirmed/index.blade.php ENDPATH**/ ?>