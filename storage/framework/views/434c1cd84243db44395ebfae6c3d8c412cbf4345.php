<?php $__env->startSection('content'); ?>
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-cubes"></i><?php echo app('translator')->get('english.CREATE_PRODUCT'); ?>
            </div>
        </div>
        <div class="portlet-body form">
            <?php echo Form::open(array('group' => 'form', 'url' => '', 'class' => 'form-horizontal','files' => true,'id'=>'productCreateForm')); ?>

            <?php echo Form::hidden('filter', Helper::queryPageStr($qpArr)); ?>

            <?php echo e(csrf_field()); ?>

            <div class="form-body">
                <div class="row">
                    <div class="col-md-offset-1 col-md-7">
                        <div class="form-group">
                            <label class="control-label col-md-4" for="productCatId"><?php echo app('translator')->get('english.PRODUCT_CATEGORY'); ?> :<span class="text-danger"> *</span></label>
                            <div class="col-md-8">
                                <?php echo Form::select('product_category_id', array('0' => __('english.SELECT_CATEGORY_OPT')) + $productCategoryArr, null, ['class' => 'form-control js-source-states', 'id' => 'productCatId']); ?>

                                <span class="text-danger"><?php echo e($errors->first('product_category_id')); ?></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4" for="name"><?php echo app('translator')->get('english.NAME'); ?> :<span class="text-danger"> *</span></label>
                            <div class="col-md-8">
                                <?php echo Form::text('name', null, ['id'=> 'name', 'class' => 'form-control','autocomplete' => 'off']); ?>

                                <span class="text-danger"><?php echo e($errors->first('name')); ?></span>
                                <div id="productName"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4" for="productInfo"><?php echo app('translator')->get('english.PRODUCT_INFO'); ?> :<span class="text-danger"> *</span></label>
                            <div class="col-md-8">
                                <?php echo Form::text('product_info', null, ['id'=> 'productInfo', 'class' => 'form-control','autocomplete' => 'off']); ?>

                                <span class="text-danger"><?php echo e($errors->first('product_info')); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4" for="price"><?php echo app('translator')->get('english.PRICE'); ?> :<span class="text-danger"> *</span></label>
                            <div class="col-md-8">
                                <?php echo Form::text('price', null, ['id'=> 'price', 'class' => 'form-control','autocomplete' => 'off']); ?>

                                <span class="text-danger"><?php echo e($errors->first('price')); ?></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4 mt-checkbox" for="specialPrice"><?php echo app('translator')->get('english.SPECIAL_PRICE'); ?> :</label>
                            <div class="col-md-4 checkbox-center md-checkbox has-success" style="margin: 0 15px">
                                <input type="hidden" name="check_special_price" value="0">
                                <?php echo Form::checkbox('check_special_price',1,false, ['id' => 'specialPrice', 'class'=> 'md-check']); ?>

                                <label for="specialPrice">
                                    <span class="inc"></span>
                                    <span class="check mark-caheck"></span>
                                    <span class="box mark-caheck"></span>
                                </label>
                            </div>
                        </div>
                        <div id="divSpecialPrice" style="display: none;">
                            <div class="form-group">
                                <label class="control-label col-md-4" for="special_price"><?php echo app('translator')->get('english.SPECIAL_PRICE'); ?> :<span class="text-danger"> *</span></label>
                                <div class="col-md-8">
                                    <?php echo Form::text('special_price', null, ['id'=> 'special_price', 'class' => 'form-control','autocomplete' => 'off']); ?>

                                    <span class="text-danger"><?php echo e($errors->first('special_price')); ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4" for="fullDescription"><?php echo app('translator')->get('english.DESCRIPTION'); ?> :<span class="text-danger"> *</span></label>
                            <div class="col-md-8">
                                <?php echo Form::textarea('description', null, ['id'=> 'description', 'class' => 'form-control full-name-text-area','cols'=>'20','rows' => '8']); ?>


                                <span class="text-danger"><?php echo e($errors->first('description')); ?></span>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4" for="status"><?php echo app('translator')->get('english.STATUS'); ?> :</label>
                            <div class="col-md-8">
                                <?php echo Form::select('status', ['1' => __('english.ACTIVE'), '2' => __('english.INACTIVE')], '1', ['class' => 'form-control', 'id' => 'status']); ?>

                                <span class="text-danger"><?php echo e($errors->first('status')); ?></span>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-4 col-md-8">
                            <button class="btn green btn-submit" type="button">
                                <i class="fa fa-check"></i> <?php echo app('translator')->get('english.SUBMIT'); ?>
                            </button>
                            <a href="<?php echo e(URL::to('/product'.Helper::queryPageStr($qpArr))); ?>" class="btn btn-outline grey-salsa"><?php echo app('translator')->get('english.CANCEL'); ?></a>
                        </div>
                    </div>
                </div>
            </div>

            <?php echo Form::close(); ?>

        </div>
    </div>
</div>
<link href="<?php echo e(asset('public/css/website/summernote.min.css')); ?>" rel="stylesheet" type="text/css" />
<script src="<?php echo e(asset('public/js/website/summernote.min.js')); ?>" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {

        $('#description').summernote({
            placeholder: 'Product Description',
            tabsize: 2,
            height: 100
        });

        $(document).on("click", "#specialPrice", function () {
            if ($(this).prop("checked") == true) {
                $("#divSpecialPrice").show();
            } else if ($(this).prop("checked") == false) {
                $("#divSpecialPrice").hide();
            }
        });
        $(document).on("click", ".btn-submit", function () {
            swal({
                title: "Are you sure, <?php echo app('translator')->get('english.YOU_WANT_TO_SAVE'); ?>?",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "<?php echo app('translator')->get('english.YES_SAVE'); ?>",
                closeOnConfirm: true,
                closeOnCancel: true,
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

                    var formData = new FormData($("#productCreateForm")[0]);
                    $.ajax({
                        url: "<?php echo e(URL::to('/product/store')); ?>",
                        type: "POST",
                        dataType: 'json', // what to expect back from the PHP script, if anything
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        beforeSend: function () {
                            App.blockUI({boxed: true});
                        },
                        success: function (res) {
                            toastr.success(res.message, res.heading, options);
                            setTimeout(window.location.replace('<?php echo e(URL::to("/product")); ?>'), 1000);
                            App.unblockUI();
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
                            App.unblockUI();
                        }
                    }); //ajax
                }
            });
        });
    });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\swapnoloke\resources\views/website/product/create.blade.php ENDPATH**/ ?>