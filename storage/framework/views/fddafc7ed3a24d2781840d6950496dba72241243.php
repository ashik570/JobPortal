


<?php $__env->startSection('content'); ?>
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-road"></i><?php echo app('translator')->get('english.CREATE_AFFILIATION'); ?>
            </div>
        </div>
        <div class="portlet-body form">
            <?php echo Form::open(array('group' => 'form', 'url' => 'affiliations', 'files'=> true, 'class' => 'form-horizontal')); ?>

            <?php echo Form::hidden('filter', Helper::queryPageStr($qpArr)); ?>

            <?php echo e(csrf_field()); ?>

            <div class="form-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label col-md-3" for="title"><?php echo app('translator')->get('english.TITLE'); ?> :<span class="text-danger"> *</span></label>
                            <div class="col-md-5">
                                <?php echo Form::text('title', null, ['id'=> 'title', 'class' => 'form-control','autocomplete'=>'off']); ?>

                                <span class="text-danger"><?php echo e($errors->first('title')); ?></span>
                            </div>
                        </div>

                        <div class="form-group last">
                            <label class="control-label col-md-3"><?php echo app('translator')->get('english.FEATURED_IMAGE'); ?> :<span class="text-danger"> *</span></label>
                            <div class="col-md-9">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                        <img src="<?php echo e(URL::to('/')); ?>/public/img/no-image.png" alt=""> </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                    <div>
                                        <span class="btn default btn-file">
                                            <span class="fileinput-new"> Select image </span>
                                            <span class="fileinput-exists"> Change </span>
                                            <input type="file" name="featured_image" id="featuredImage"> </span>
                                        <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                        <div class=""><span class="text-danger"><?php echo e($errors->first('featured_image')); ?></span></div>
                                    </div>
                                </div>
                                <div class="clearfix margin-top-10">
                                    <span class="label label-danger"><?php echo app('translator')->get('english.NOTE'); ?></span> <?php echo app('translator')->get('english.ACCEPTED_IMAGE_FORMATE_jpg_png_jpeg_gif'); ?>
                                </div>
                            </div>
                        </div>



                        <div class="form-group">
                            <label class="control-label col-md-3"><?php echo e(trans('english.CONTENT')); ?> :</label>
                            <div class="col-md-9">
                                <?php echo e(Form::textarea('content', null, ['class' => 'form-control summernote_1','size' => '50x5','id'=>'content'])); ?>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3" for="userName"><?php echo app('translator')->get('english.ORDER'); ?> :<span class="text-danger"> *</span></label>
                            <div class="col-md-5">
                                <?php echo Form::select('order_id', $orderList, $lastOrderNumber, ['id'=> 'order_id', 'class' => 'form-control js-source-states','autocomplete'=>'off']); ?>

                                <span class="text-danger"><?php echo e($errors->first('order')); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3" for="statusId"><?php echo app('translator')->get('english.STATUS'); ?> :</label>
                            <div class="col-md-5">
                                <?php echo Form::select('status_id', ['1' => __('english.ACTIVE'), '0' => __('english.INACTIVE')], '1', ['class' => 'form-control', 'id' => 'statusId']); ?>

                                <span class="text-danger"><?php echo e($errors->first('status')); ?></span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-4 col-md-8">
                        <button class="btn btn-circle green" type="submit" name="submit">
                            <i class="fa fa-check"></i> <?php echo app('translator')->get('english.SUBMIT'); ?>
                        </button>
                        <a href="<?php echo e(URL::to('/affiliations'.Helper::queryPageStr($qpArr))); ?>" class="btn btn-circle btn-outline grey-salsa"><?php echo app('translator')->get('english.CANCEL'); ?></a>
                    </div>
                </div>
            </div>
            <?php echo Form::close(); ?>

        </div>
    </div>
</div>


<link href="<?php echo e(asset('public/assets/global/plugins/bootstrap-summernote/summernote.css')); ?>" rel="stylesheet" type="text/css" />
<script src="<?php echo e(asset('public/assets/pages/scripts/components-editors.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/assets/global/plugins/bootstrap-summernote/summernote.min.js')); ?>" type="text/javascript"></script>
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
//          console.log(f.target.result);
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
    aspectRatio: 40 / 25,
            quality: 1,
            imageSmoothingQuality : 'high',
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


    $(document).ready(function() {
    var $modal = $('#modal');
    var image = document.getElementById('sample_image');
    var cropper;
    $('#upload_image').change(function(event) {
    var files = event.target.files;
    var done = function(url) {
    image.src = url;
    $modal.modal('show');
    $('.modal-backdrop').hide();
    };
    if (files && files.length > 0) {
    reader = new FileReader();
    reader.onload = function(event) {
    done(reader.result);
    };
    reader.readAsDataURL(files[0]);
    }
    });
    $modal.on('shown.bs.modal', function() {
    cropper = new Cropper(image, {
    aspectRatio: 1,
            viewMode: 2,
            preview: '.preview'
    });
    }).on('hidden.bs.modal', function() {
    cropper.destroy();
    cropper = null;
    });
    $('#crop').click(function() {
    canvas = cropper.getCroppedCanvas({
    width: 2000,
            height: 2000,
    });
    canvas.toBlob(function(blob) {
    url = URL.createObjectURL(blob);
    var reader = new FileReader();
    reader.readAsDataURL(blob);
    reader.onloadend = function() {
    var base64data = reader.result;
    $('.prv-img').attr("src", base64data);
    $('.cropped-icon').val(base64data);
    $modal.modal('hide');
    $('#upload_image').replaceWith($("#upload_image").val('').clone(true));
    };
    });
    });
    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\swapnoloke\resources\views/website/Affiliations/create.blade.php ENDPATH**/ ?>