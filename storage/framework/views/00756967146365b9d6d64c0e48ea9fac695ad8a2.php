
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
                        <i class="fa fa-user"></i>View User
                    </div>
                    <div class="actions">
                        <a href="<?php echo e(URL::to('users/create')); ?>" class="btn btn-default btn-sm">
                            <i class="fa fa-plus"></i> <?php echo e(trans('english.CREATE_A_USER')); ?> </a>
                    </div>
                </div>
                <div class="portlet-body">

                    <?php echo e(Form::open(array('role' => 'form', 'url' => 'users/filter', 'class' => '', 'id' => 'userFilter'))); ?>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label"><?php echo e(trans('english.SELECT_GROUP')); ?></label>
                                <?php echo e(Form::select('group_id', $groupList, Request::get('group_id'), array('class' => 'form-control dopdownselect', 'id' => 'userGroupId'))); ?>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label"><?php echo e(trans('english.SELECT_RANK')); ?></label>
                                <?php echo e(Form::select('rank_id', $rankList, Request::get('rank_id'), array('class' => 'form-control dopdownselect', 'id' => 'userRankId'))); ?>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label"><?php echo e(trans('english.SELECT_APPROINTMENT')); ?></label>
                                <?php echo e(Form::select('appointment_id', $appointmentList, Request::get('appointment_id'), array('class' => 'form-control dopdownselect', 'id' => 'userApprointmentId'))); ?>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group tooltips" title="Search by Username/First Name/Last Name/Official Name/Service No">
                                <label class="control-label"><?php echo e(trans('english.SEARCH_TEXT')); ?></label>
                                <?php echo e(Form::text('search_text', Request::get('search_text'), array('id'=> 'userSearchText', 'class' => 'form-control', 'placeholder' => 'Enter Search Text'))); ?>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-offset-4 col-md-4">
                            <button type="submit" class="btn btn-md green btn-outline filter-submit margin-bottom-20">
                                <i class="fa fa-search"></i> Filter
                            </button>
                        </div>
                    </div>
                    <?php echo e(Form::close()); ?>

                    <div class="row">
                        <div class="table-responsive">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th><?php echo e(trans('english.SL_NO')); ?></th>
                                            <th><?php echo e(trans('english.USER_GROUP')); ?></th>
                                            <th><?php echo e(trans('english.RANK')); ?></th>
                                            <th><?php echo e(trans('english.APPOINTMENT')); ?></th>
                                            <th><?php echo e(trans('english.BRANCH')); ?></th>
                                            <th><?php echo e(trans('english.NAME')); ?></th>
                                            <th><?php echo e(trans('english.USERNAME')); ?></th>
                                            <th class='text-center'><?php echo e(trans('english.PHOTO')); ?></th>
                                            <th class="text-center"><?php echo e(trans('english.ACCOUNT_CONFIRMED')); ?></th>
                                            <th><?php echo e(trans('english.STATUS')); ?></th>
                                            <th class='text-center'><?php echo e(trans('english.ACTION')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(!$usersArr->isEmpty()): ?>
                                        <?php
                                        $page = Request::get('page');
                                        $page = empty($page) ? 1 : $page;
                                        $sl = ($page - 1) * trans('english.PAGINATION_COUNT');
                                        ?>
                                        <?php $__currentLoopData = $usersArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <tr class="contain-center">
                                            <td><?php echo e(++$sl); ?></td>
                                            <td><?php echo e($value->UserGroup->name); ?></td>
                                            <td><?php echo e($value->rank->title); ?></td>
                                            <td><?php echo e($value->appointment->title); ?></td>
                                            <td><?php echo e(!empty($value->branch->name) ? $value->branch->name: ''); ?></td>
                                            <td><?php echo e($value->first_name); ?> <?php echo e($value->last_name); ?></td>
                                            <td><?php echo e($value->username); ?></td>
                                            <td class="text-center">
                                                <?php if(isset($value->photo)): ?>
                                                <img width="100" height="100" src="<?php echo e(URL::to('/')); ?>/public/uploads/thumbnail/<?php echo e($value->photo); ?>" alt="<?php echo e($value->first_name.' '.$value->last_name); ?>">
                                                <?php else: ?>
                                                <img width="100" height="100" src="<?php echo e(URL::to('/')); ?>/public/img/unknown.png" alt="<?php echo e($value->first_name.' '.$value->last_name); ?>">
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if($value->password_changed == '1'): ?>
                                                <span class="label label-success"><?php echo e(trans('english.YES')); ?></span>
                                                <?php else: ?>
                                                <span class="label label-warning"><?php echo e(trans('english.NO')); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($value->status == 'active'): ?>
                                                <span class="label label-success"><?php echo e($value->status); ?></span>
                                                <?php else: ?>
                                                <span class="label label-warning"><?php echo e($value->status); ?></span>
                                                <?php endif; ?>
                                            </td>

                                            <td class="action-center">
                                                <div class="text-center user-action">
                                                    <?php echo e(Form::open(array('url' => 'users/' . $value->id, 'id' => 'delete'))); ?>

                                                    <?php echo e(Form::hidden('_method', 'DELETE')); ?>


                                                    <?php
                                                    $dd = Request::query();
                                                    if (!empty($dd)) {
                                                        $param = '';
                                                        $sn = 1;

                                                        foreach ($dd as $key => $item) {
                                                            if ($sn === 1) {
                                                                $param .= $key . '=' . $item;
                                                            } else {
                                                                $param .= '&' . $key . '=' . $item;
                                                            }
                                                            $sn++;
                                                        }//foreach
                                                    }
                                                    ?>
                                                    <?php if((Auth::user()->group_id == 1) || (Auth::user()->group_id != $value->group_id)): ?>
                                                    <a class='btn btn-info btn-xs tooltips' href="<?php echo e(URL::to('users/activate/' . $value->id )); ?><?php if(isset($param)): ?><?php echo e('/'.$param); ?> <?php endif; ?>" data-rel="tooltip" title="<?php if($value->status == 'active'): ?> Inactivate <?php else: ?> Activate <?php endif; ?>" data-container="body" data-trigger="hover" data-placement="top">
                                                        <?php if($value->status == 'active'): ?>
                                                        <i class='fa fa-remove'></i>
                                                        <?php else: ?>
                                                        <i class='fa fa-check-circle'></i>
                                                        <?php endif; ?>
                                                    </a>
                                                    <?php endif; ?>
                                                    <a class='btn btn-primary btn-xs tooltips' href="<?php echo e(URL::to('users/' . $value->id . '/edit')); ?>" title="Edit User" data-container="body" data-trigger="hover" data-placement="top">
                                                        <i class='fa fa-edit'></i>
                                                    </a>
                                                    <a class="tooltips" href="<?php echo e(URL::to('users/cp/' . $value->id)); ?><?php if(isset($param)): ?><?php echo e('/'.$param); ?> <?php endif; ?>" data-original-title="Change Password">
                                                        <span class="btn btn-success btn-xs"> 
                                                            <i class="fa fa-key"></i>
                                                        </span>
                                                    </a>
                                                    <a class="tooltips" data-toggle="modal" data-target="#view-modal" data-id="<?php echo e($value->id); ?>" href="#view-modal" id="getStudentInfo" title="Details User Information" data-container="body" data-trigger="hover" data-placement="top">
                                                        <span class="btn btn-success btn-xs"> 
                                                            &nbsp;<i class='fa fa-info'></i>&nbsp;
                                                        </span>
                                                    </a>
                                                    <?php if((Auth::user()->group_id == 1) || (Auth::user()->group_id != $value->group_id)): ?>
                                                    <button class="btn btn-danger btn-xs tooltips" type="submit" title="Delete" data-placement="top" data-rel="tooltip" data-original-title="Delete">
                                                        <i class='fa fa-trash'></i>
                                                    </button>
                                                    <?php endif; ?>
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
                        <div class="col-md-5 col-sm-5">
                            <div class="dataTables_info" role="status" aria-live="polite">

                                <?php
                                $start = empty($usersArr->total()) ? 0 : (($usersArr->currentPage() - 1) * $usersArr->perPage() + 1);
                                $end = ($usersArr->currentPage() * $usersArr->perPage() > $usersArr->total()) ? $usersArr->total() : ($usersArr->currentPage() * $usersArr->perPage());
                                ?> <br />
                                <?php echo app('translator')->get('english.SHOWING'); ?> <?php echo e($start); ?> <?php echo app('translator')->get('english.TO'); ?> <?php echo e($end); ?> <?php echo app('translator')->get('english.OF'); ?>  <?php echo e($usersArr->total()); ?> <?php echo app('translator')->get('english.RECORDS'); ?>
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-7">
                            <?php echo e($usersArr->appends(Request::all())->links()); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END CONTENT BODY -->
<!--This module use for student other information edit-->
<div id="view-modal" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="dynamic-content"><!-- mysql data will load in table -->
        </div>
    </div>
</div>

<script type="text/javascript">
    // ****************** Ajax Code for children edit *****************
    $(document).on('click', '#getStudentInfo', function (e) {
        e.preventDefault();
        var userId = $(this).data('id'); // get id of clicked row

        $('#dynamic-content').html(''); // leave this div blank
        $.ajax({
            url: "<?php echo e(URL::to('ajaxresponse/user-info')); ?>",
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
                $('#dynamic-content').html(''); // blank before load.
                $('#dynamic-content').html(response.html); // load here
                $('.date-picker').datepicker({autoclose: true});
            },
            error: function (jqXhr, ajaxOptions, thrownError) {
                $('#dynamic-content').html('<i class="fa fa-info-sign"></i> Something went wrong, Please try again...');
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

<?php echo $__env->make('layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\dysin\resources\views/users/index.blade.php ENDPATH**/ ?>