<?php echo $__env->make('website.layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="page-title-container">
    <div class="container">
        <h2 class="page-title first-word"> <?php echo $targetArr->title ?? ''; ?></h2>
    </div>
</div>
<div class="main-content">
    <div class="container">
        <div class="row" style="padding-bottom: 30px;">
            <div class="col-md-12">
                <?php if(isset($targetArr->featured_image)): ?>
                <div class="featured-image p-f-img">
                    <img src="<?php echo e(asset('public/uploads/website/'.$targetArr->featured_image ?? '')); ?>" alt="featured image">
                </div>
                <?php endif; ?>
                <?php if(isset($targetArr->oc_image)): ?>
                <div class="featured-image p-f-img">
                    <img src="<?php echo e(asset('public/uploads/website/'. $targetArr->oc_image ?? '')); ?>" alt="OC image">
                </div>
                <?php endif; ?>
                <div class="post-content text-justify">
                    <?php echo $targetArr->content ?? ''; ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $__env->make('website.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 
<?php /**PATH D:\xampp\htdocs\swapnoloke\resources\views/website/frontend/template/aboutUs.blade.php ENDPATH**/ ?>