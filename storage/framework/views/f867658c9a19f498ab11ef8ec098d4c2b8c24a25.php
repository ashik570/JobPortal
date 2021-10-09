
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
                        <i class="fa fa-gift"></i><?php echo e(trans('english.BUSINESS_SEGMENTS')); ?> </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                        <a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title=""> </a>
                        <a href="javascript:;" class="reload" data-original-title="" title=""> </a>
                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    <?php echo e(Form::model($businessSegments, array('route' => array('businessSegments.update'), 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'missionAndVision', 'files' => true))); ?>

                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-2 control-label"><?php echo e(trans('english.TITLE')); ?> :</label>
                                    <div class="col-md-10">
                                        <?php echo e(Form::text('title', !empty($businessSegments->title) ? $businessSegments->title : '', array('id'=> 'title', 'class' => 'form-control', 'placeholder' => 'Type Title'))); ?>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2"><?php echo app('translator')->get('english.IMAGE_FOR_SLIDER'); ?> :<span class="text-danger"> *</span></label>
                                    <div class="col-md-10">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                <?php if(!empty($target->featured_image)): ?>
                                                <img src="<?php echo e(asset('public/uploads/website/slider').'/'.$target->featured_image); ?>" alt=""/>
                                                <?php else: ?>
                                                <img src="<?php echo e(URL::to('/')); ?>/public/img/no-image.png" alt=""/>
                                                <?php endif; ?>
                                            </div>   
                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                            <div>
                                                <span class="btn default btn-file">
                                                    <span class="fileinput-new"> Select image </span>
                                                    <span class="fileinput-exists"> Change </span>
                                                    <input type="file" name="featured_image"> </span>
                                                <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                <div class=""><span class="text-danger"><?php echo e($errors->first('featured_image')); ?></span></div>
                                            </div>
                                        </div>
                                        <div class="clearfix margin-top-10">
                                            <span class="label label-danger"><?php echo app('translator')->get('english.NOTE'); ?></span> <?php echo app('translator')->get('english.ACCEPTED_IMAGE_FORMATE_jpg_png_jpeg_gif'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit" class="btn btn-circle green">Submit</button>

                                        </div>
                                    </div>
                                </div>
                                <?php echo e(Form::close()); ?>

                                <!-- END FORM-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <link href="<?php echo e(asset('public/assets/global/plugins/bootstrap-summernote/summernote.css')); ?>" rel="stylesheet" type="text/css" />
            <script src="<?php echo e(asset('public/assets/pages/scripts/components-editors.min.js')); ?>" type="text/javascript"></script>
            <script src="<?php echo e(asset('public/assets/global/plugins/bootstrap-summernote/summernote.min.js')); ?>" type="text/javascript"></script>

            <style>


            </style>
            <script type="text/javascript">

                $(document).on("click", '#featuredImage', function (e) {
                $(".cv").hide();
                });
                //Added for Cropper use for CoverPhoto
                let result2 = document.querySelector('.result-sign'),
                        sign_w = document.querySelector('.sign-w'),
                        options2 = document.querySelector('.options2'),
                        crop2 = document.querySelector('.crop2'),
                        cropped2 = document.querySelector('.cropped2'),
                        upload2 = document.querySelector('#featuredImage'),
                        cropper2 = '';
                var fileTypes2 = ['jpg', 'jpeg', 'png', 'gif'];
                // on change show image with crop options
                upload2.addEventListener('change', function (f) {

                if (f.target.files.length) {
                // start file reader
                const reader2 = new FileReader();
                var file2 = f.target.files[0]; // Get your file here
                var fileExt2 = file2.type.split('/')[1]; // Get the file extension
                if (fileTypes2.indexOf(fileExt2) !== - 1) {
                reader2.onload = function (f) {
            //                    console.log(f.target.result);
                if (f.target.result) {
                // create new image
                let img = document.createElement('img');
                img.id = 'sign';
                img.src = f.target.result
                        // clean result before
                        result2.innerHTML = '';
                // append new image
                result2.appendChild(img);
                // show crop btn and options
                crop2.classList.remove('hide');
                options2.classList.remove('hide');
                // init cropper2
                cropper2 = new Cropper(img, {
                maxWidth: 3072,
                        maxHeight: 3072,
                        aspectRatio: 40 / 22,
                });
                }
                };
                reader2.readAsDataURL(file2);
                } else {
                alert('File not supported');
                return false;
                }
                }
                });
                // crop on click
                crop2.addEventListener('click', function (f) {
                f.preventDefault();
                // get result to data uri
                let imgSrc = cropper2.getCroppedCanvas({
                width: sign_w.value // input value
                }).toDataURL();
                // remove hide class of img
                cropped2.classList.remove('hide');
                // show image cropped
                cropped2.src = imgSrc;
                $('#cropImg2').val(imgSrc);
                });
            //crop sign end   
            </script>



            <script type="text/javascript">
                $(document).on("submit", '#configurationUpdate', function (e) {
                //This function use for sweetalert confirm message
                e.preventDefault();
                var form = this;
                swal({
                title: 'Are you sure you want to Submit?',
                        text: '<strong></strong>',
                        type: 'warning',
                        html: true,
                        allowOutsideClick: true,
                        showConfirmButton: true,
                        showCancelButton: true,
                        confirmButtonClass: 'btn-info',
                        cancelButtonClass: 'btn-danger',
                        confirmButtonText: 'Yes, I agree',
                        cancelButtonText: 'No, I do not agree',
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

<?php echo $__env->make('layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\dysin\resources\views/website/businessSegments/index.blade.php ENDPATH**/ ?>