
<?php $__env->startSection('content'); ?>
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <?php echo $__env->make('layouts.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-bars"></i><?php echo app('translator')->get('english.MENU_MANAGEMENT'); ?>
            </div>
            <div class="actions">
                <a class="btn btn-default btn-sm create-new" href="<?php echo e(URL::to('menu/create'.Helper::queryPageStr($qpArr))); ?>"> <?php echo app('translator')->get('english.CREATE_NEW'); ?>
                    <i class="fa fa-plus create-new"></i>
                </a>
            </div>
        </div>
        
        <div class="portlet-body">
            <div class="row">
                <!-- Begin Filter-->
                <?php echo Form::open(array('group' => 'form', 'url' => 'menu/filter','class' => 'form-horizontal')); ?>

                <?php echo Form::hidden('filter', Helper::queryPageStr($qpArr)); ?>


                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-4" for="search"><?php echo app('translator')->get('english.SEARCH'); ?></label>
                        <div class="col-md-8">
                            <?php echo Form::text('fil_search',  Request::get('fil_search'), ['class' => 'form-control tooltips', 'id' => 'search', 'title' => 'Title', 'placeholder' => 'Title', 'list' => 'title', 'autocomplete' => 'off' ]); ?> 
                            <datalist id="title">
                                <?php if(!$nameArr->isEmpty()): ?>
                                <?php $__currentLoopData = $nameArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($item->title); ?>" />
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </datalist>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-4" for="filTypeId"><?php echo app('translator')->get('english.TYPE'); ?></label>
                        <div class="col-md-8">
                            <?php echo Form::select('fil_type_id', $menuTypeArr,  Request::get('fil_type_id'), ['class' => 'form-control js-source-states', 'id' => 'filTypeId']); ?>

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
                <?php echo Form::close(); ?>

                <!-- End Filter -->
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="vcenter"><?php echo app('translator')->get('english.SL_NO'); ?></th>
                            <th class="vcenter"><?php echo app('translator')->get('english.TITLE'); ?></th>
                        
                            <th class="vcenter"><?php echo app('translator')->get('english.PARENTS'); ?></th>
                            <th class="vcenter"><?php echo app('translator')->get('english.TYPE'); ?></th>
                            <th class="vcenter text-center" style="display: none"><?php echo app('translator')->get('english.CONTENT'); ?></th>
                            <th class="vcenter text-center" style="display: none"><?php echo app('translator')->get('english.URL'); ?></th>
                            <th class="vcenter text-center"><?php echo app('translator')->get('english.REQUIR_LOGIN'); ?></th>
                            <th class="vcenter text-center"><?php echo app('translator')->get('english.NEW_TAB'); ?></th>
                            <th class="text-center vcenter"><?php echo app('translator')->get('english.ORDER'); ?></th>
                            <th class="text-center vcenter"><?php echo app('translator')->get('english.STATUS'); ?></th>
                            <th class="td-actions text-center vcenter"><?php echo app('translator')->get('english.ACTION'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                       
                        <?php if(!empty($menuArr)): ?>
                        <?php
                        $page = Request::get('page');
                        $page = empty($page) ? 1 : $page;
                        $sl = ($page - 1) * __('english.PAGINATION_COUNT');
                        ?>
                        <?php $__currentLoopData = $menuArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $target): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="vcenter"><?php echo e(++$sl); ?></td>
                            <td class="vcenter"><?php echo e($target['title']); ?></td>
                            <td class="vcenter"><?php echo e($target['parent_name']); ?></td>
                            <td class="vcenter"><?php echo e($target['type_name']); ?></td>
                            <td class="text-center vcenter" style="display: none"><?php echo e($target['content_name']); ?></td>
                            <td class="text-center vcenter" style="display: none">
                                <?php if($target['type_id'] == 2 ): ?>
                                <?php echo e($item['url']); ?>	
                                <?php elseif($target['type_id'] == 5): ?>
                                <?php echo e(URL::to('/'.$item['route'].'/'.$item['content_id'])); ?>

                                <?php elseif($target['type_id'] == 16): ?>	
                                <?php echo e(URL::to('/'.$target['type_id'].'/'.$target['pcategory_id'])); ?>

                                <?php else: ?>
                                <?php echo e(URL::to('/')); ?>

                                <?php endif; ?>
                            </td>
                            <td class="text-center vcenter">
                                <?php if($target['login_status'] == '1'): ?>
                                <span class="label label-success"><?php echo app('translator')->get('english.YES'); ?></span>
                                <?php else: ?>
                                <span class="label label-warning"><?php echo app('translator')->get('english.NO'); ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center vcenter">
                                <?php if($target['open_new_tab'] == '1'): ?>
                                <span class="label label-success"><?php echo app('translator')->get('english.YES'); ?></span>
                                <?php else: ?>
                                <span class="label label-warning"><?php echo app('translator')->get('english.NO'); ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center vcenter">
                                <?php if(!empty($target['order'])): ?>
                                <?php echo e($target['order']); ?>

                                <?php endif; ?>
                            </td>
                            <td class="text-center vcenter">
                                <?php if($target['status_id'] == '1'): ?>
                                <span class="label label-sm label-success"><?php echo app('translator')->get('english.ACTIVE'); ?></span>
                                <?php else: ?>
                                <span class="label label-sm label-warning"><?php echo app('translator')->get('english.INACTIVE'); ?></span>
                                <?php endif; ?>
                            </td>
                            <td  class="text-center vcenter">
                                <div>
                                    <?php echo e(Form::open(array('url' => 'menu/' . $target['id'],'id'=>'delete'))); ?>

                                    <?php echo e(Form::hidden('_method', 'DELETE')); ?>

                                    <a class="btn btn-icon-only btn-primary tooltips" title="Edit" href="<?php echo e(URL::to('menu/' . $target['id'] . '/edit'.Helper::queryPageStr($qpArr))); ?>">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <button class="btn btn-icon-only btn-danger btn-xs" type="submit" data-placement="top" data-rel="tooltip" data-original-title="Delete">
                                        <i class='fa fa-trash'></i>
                                    </button>

                                    <?php echo e(Form::close()); ?>

                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="10" class="vcenter"><?php echo app('translator')->get('english.EMPTY_DATA'); ?></td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php echo $__env->make('menu.paginator', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>	
    </div>
</div>

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
<?php echo $__env->make('layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\dysin\resources\views/menu/index.blade.php ENDPATH**/ ?>