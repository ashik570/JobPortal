<?php echo $__env->make('website.layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="page-title-container">
    <div class="container">
        <h2 class="page-title first-word"> <?php echo app('translator')->get('english.ALBUM'); ?> </h2>
    </div>
</div>
<div class="main-content">
    <div class="container">
        <div class="row">
            <?php if(!$targetArr->isEmpty()): ?>
                <?php $__currentLoopData = $targetArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $target): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-3">
                    <a class="album-item" href="<?php echo e(URL::to('/').'/galleryweb/'.$target->slug); ?>">
                        <?php if(!empty($target->cover_photo)): ?>
                            <img src="<?php echo e(asset('public/uploads/website/gallery/album/'. $target->cover_photo)); ?>" alt="">
                        <?php else: ?>
                            <img src="<?php echo e(asset('public/uploads/website/gallery/album/demo-cover-photo.png')); ?>" alt="">
                        <?php endif; ?>

                        <?php if(!empty($target->title)): ?>
                        <h3 class="album-caption"><span><?php echo e($target->title ?? ''); ?></span></h3>
                        <?php endif; ?>
                    </a>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>

        </div>
    </div>
</div>
<?php echo $__env->make('website.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH D:\xampp\htdocs\swapnoloke\resources\views/website/frontend/template/galleryAlbum.blade.php ENDPATH**/ ?>