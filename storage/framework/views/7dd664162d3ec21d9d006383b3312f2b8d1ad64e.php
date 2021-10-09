
<?php $__env->startSection('content'); ?>
<!-- BEGIN CONTENT BODY -->
<div class="page-content"> 
    <?php echo $__env->make('layouts.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-book"></i><?php echo app('translator')->get('english.PUBLICATION_MANAGEMENT'); ?>
            </div>
            <div class="actions">
                <a class="btn btn-default btn-sm create-new" href="<?php echo e(URL::to('publication/create'.Helper::queryPageStr($qpArr))); ?>"> <?php echo app('translator')->get('english.CREATE_NEW'); ?>
                    <i class="fa fa-plus create-new"></i>
                </a>
            </div>
        </div>
        <div class="portlet-body">
            <div class="row">
                <!-- Begin Filter-->
                <?php echo Form::open(array('group' => 'form', 'url' => 'publication/filter','class' => 'form-horizontal')); ?>

                <?php echo Form::hidden('filter', Helper::queryPageStr($qpArr)); ?>

                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-4" for="search"><?php echo app('translator')->get('english.SEARCH'); ?></label>
                        <div class="col-md-8">
                            <?php echo Form::text('fil_search',  Request::get('fil_search'), ['class' => 'form-control tooltips', 'title' => 'Title', 'placeholder' => 'Title', 'list' => 'Title', 'autocomplete' => 'off' ]); ?>


                            <datalist id="Title">
                                <?php if(!$nameArr->isEmpty()): ?>
                                <?php $__currentLoopData = $nameArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($item->title); ?>" />
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
                <?php echo e(Form::close()); ?>

                <!-- End Filter -->
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="text-center vcenter"><?php echo app('translator')->get('english.SL_NO'); ?></th>
                            <th class="text-center vcenter"><?php echo app('translator')->get('english.TITLE'); ?></th>

                            <th class="text-center vcenter"><?php echo app('translator')->get('english.ORDER'); ?></th>
                            <th class="text-center vcenter"><?php echo app('translator')->get('english.PHOTO'); ?></th>
                            <th class="text-center vcenter"><?php echo app('translator')->get('english.STATUS'); ?></th>
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
                        <?php $__currentLoopData = $targetArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e(++$sl); ?></td>                    
                            <td><?php echo e($item->title); ?></td>              
                            <td class='text-center vcenter'><?php echo e($item->order); ?></td>
                            <td class="text-center vcenter">
                                <?php if (!empty($item->image)) { ?>
                                    <img width="50" height="60" src="<?php echo e(URL::to('/')); ?>/public/uploads/website/publication/<?php echo e($item->image); ?>" alt="<?php echo e($item->title); ?>"/>
                                <?php } else { ?>
                                    <img width="50" height="60" src="<?php echo e(URL::to('/')); ?>/public/img/no-img.png" alt="<?php echo e($item->title); ?>"/>
                                <?php } ?>
                            </td>  
                            <td class='text-center vcenter'>
                                <?php if($item->status_id=='1'): ?>  
                                <span class="label label-success">
                                    <?php echo app('translator')->get('english.ACTIVE'); ?>

                                </span>
                                <?php else: ?>
                                <span class="label label-warning">
                                    <?php echo app('translator')->get('english.INACTIVE'); ?>
                                </span>
                                <?php endif; ?>
                            </td>  
                            <td class="action-center text-center vcenter">
                                <?php echo e(Form::open(array('url' => 'publication/' .$item->id.'/'.Helper::queryPageStr($qpArr), 'class' => 'delete-publication'))); ?>

                                <?php echo e(Form::hidden('_method', 'DELETE')); ?>

                                
                                <a title="EDIT" class="btn btn-warning btn-md has-tooltip" href="<?php echo e(URL::to('publication/'.$item->id.'/edit/'.Helper::queryPageStr($qpArr) )); ?>"><span class="fa fa-edit"></span></a>&nbsp;&nbsp;
                                
                                <?php if(!empty($item->upload_file)): ?>
                                <a href ="<?php echo e(URL::to('publication/download',$item->id)); ?>"  title="<?php echo app('translator')->get('english.DOWNLOAD_ATTACHEMENT'); ?>" class="btn btn-success tooltips"> 
                                    <i class = "fa fa-download"></i>
                                </a>
                                <?php endif; ?>
                                
                                <button title="Delete" class="btn btn-danger btn-md has-tooltip" type="submit" data-placement="top"  data-original-title="Delete">
                                    <span class="fa fa-trash"></span>
                                </button>
                                <?php echo e(Form::close()); ?>

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
    $(document).on("submit", '.delete-publication', function (e) {
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
<?php echo $__env->make('layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\dysin\resources\views/website/publication/index.blade.php ENDPATH**/ ?>