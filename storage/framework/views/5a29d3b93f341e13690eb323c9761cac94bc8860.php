<?php echo $__env->make('website.layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="main-content post-detail">

    <div class="container mb-3" style="padding-bottom: 30px;">
        <div class="row">
            <div  class="col-md-12">
                <header class="page-head">
                    <h2 class="heading mt-3 color2 first-word"><?php echo e($target->title); ?></h2>
                    <hr class="small">
                </header>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <article>
                    <p>
                        <?php echo $target->description; ?>

                    </p>
                </article>
            </div>
        </div>
        <?php if($target->upload_file != ''): ?>
        <div class="text-center load-more pull-left fullwidth mt-4">
            <a href="<?php echo e(URL::to('/')); ?>/public/uploads/website/content/<?php echo e($target->upload_file); ?>" class="btn btn-primary btn-sm" download>DOWNLOAD <i class="arrow-down fa fa fa-download color"></i></a>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php echo $__env->make('website.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH D:\xampp\htdocs\dysin\resources\views/website/frontend/template/contentDetail.blade.php ENDPATH**/ ?>