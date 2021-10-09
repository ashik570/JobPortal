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
                        <i class="fa fa-cubes"></i><?php echo e(trans('english.DISCARDED_APPLICATION')); ?>

                    </div>
                </div>
                <div class="portlet-body">
                    <?php echo e(Form::open(array('role' => 'form', 'url' => 'discarded/filter', 'class' => '', 'id' => 'jobTitleFilter'))); ?>

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
                                    <th class="text-center vcenter" colspan="5"><?php echo e(trans('english.APPLICANT_INFO')); ?></th>
                                    <!--<th><?php echo e(trans('english.STATUS')); ?></th>-->
                                    <th class="text-center vcenter" rowspan="2" class="text-center"><?php echo e(trans('english.ACTION')); ?></th>
                                </tr>
                                <tr>
                                    <th class="text-center vcenter"><?php echo e(trans('english.NAME')); ?></th>
                                    <th class="text-center vcenter"><?php echo e(trans('english.EMAIL')); ?></th>
                                    <th class="text-center vcenter"><?php echo e(trans('english.PHONE')); ?></th>
                                    <th class="text-center vcenter"><?php echo e(trans('english.CV')); ?></th>
                                    <th class="text-center vcenter"><?php echo e(trans('english.STATUS')); ?></th>
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
                                    <td class="text-center">
                                        <?php if($value->status==6 && $value->last_interaction_status==4): ?>
                                        <span class="label bold label-sm  label-yellow-mint"><?php echo e(trans('english.NOT_INTERESTED')); ?></span>
                                        <?php else: ?>
                                        <span class="label label-sm label-red-soft"><?php echo e(trans('english.DISCARDED')); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <?php if(!empty($value->last_interaction_status)): ?>
                                    <td class="action-center">
                                        <div class='text-center'>
                                            <a class="btn btn-warning btn-xs tooltips" data-toggle="modal" data-target="#view-modal" href="#view-modal" data-placement="top" data-rel="tooltip" data-original-title="View Application Details" data-id ="<?php echo e($value->id); ?>" title="View Application Details" id="applicationDetails" data-container="body" data-trigger="hover" data-placement="top">
                                                <i class="fa fa-bars"></i>
                                            </a>
                                        </div>
                                    </td>
                                    <?php else: ?>
                                    <td class="action-center">
                                        <div class='text-center'>
                                            <a class="btn btn-danger btn-xs tooltips" data-placement="top" data-rel="tooltip" data-original-title="Pending" data-id ="<?php echo e($value->id); ?>" title="Pending" id="Pending" data-container="body" data-trigger="hover" data-placement="top">
                                                <i class="fa fa-power-off"></i>
                                            </a>
                                            <a class="btn btn-warning btn-xs tooltips" data-toggle="modal" data-target="#view-modal" href="#view-modal" data-placement="top" data-rel="tooltip" data-original-title="View Application Details" data-id ="<?php echo e($value->id); ?>" title="View Application Details" id="applicationDetails" data-container="body" data-trigger="hover" data-placement="top">
                                                <i class="fa fa-bars"></i>
                                            </a>
                                        </div>
                                    </td>
                                    <?php endif; ?>

                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="8"><?php echo e(trans('english.EMPTY_DATA')); ?></td>
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
<div id="view-modal" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="col-md-12" id="application-content">
            <!-- mysql data will load in table -->
            
        </div>
    </div>
</div>
<!-- END CONTENT BODY -->

<script type="text/javascript">
    $(document).on('click', '#applicationDetails', function (e) {
        e.preventDefault();
        var applicationId = $(this).data('id'); // get id of clicked row

        $('#application-content').html(''); // leave this div blank
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
                $('#application-content').html(''); // blank before load.
                $('#application-content').html(response.html); // load here
                $('.date-picker').datepicker({autoclose: true});
            },
            error: function (jqXhr, ajaxOptions, thrownError) {
                $('#application-content').html('<i class="fa fa-info-sign"></i> Something went wrong, Please try again...');
            }
        });
    });
    
    
    $(document).on('click', "#Pending", function (e) {
        var jobId = $(this).data('id');
        e.preventDefault();
        swal({
            title: "Are you sure?",
            text: "This application will be pending!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, pending it",
            cancelButtonText: "No, Don't pending it",
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
                    url: "<?php echo e(URL::to('applicant/applicant-pending')); ?>",
                    type: "POST",
                    dataType: 'json', // what to expect back from the PHP script, if anything
//                    cache: false,
//                    contentType: false,
//                    processData: false,
                    data: {
                        job_applicant_id: jobId
                    },
                    beforeSend: function () {
                        $("#Pending").prop('disabled', true);
                        App.blockUI({boxed: true});
                    },
                    success: function (res) {
                        toastr.success(res.message, res.heading, options);
                        location = "<?php echo e(URL::to('/discarded')); ?>";
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
                        $("#Pending").prop('disabled', false);
                        App.unblockUI();
                    }
                }); //ajax
            }
        });
    });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\dysin\resources\views/discarded/index.blade.php ENDPATH**/ ?>