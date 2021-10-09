<?php echo $__env->make('website.layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="container-fluid no-gutters_cz">
    <div class="row no-gutters">
        <div class="col-xl-12 col-xxl-12">
            <div class="intro-slider-container slider-container-ratio mb-2">
                <div class="intro-slider owl-carousel owl-simple owl-nav-inside" data-toggle="owl" data-owl-options='{
                     "nav": false,
                     "dots": true,
                     "autoplay": true
                     }'>
                    <?php if(!$slider->isEmpty()): ?>
                    <?php $__currentLoopData = $slider; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="intro-slide">
                        <div class="slide">
                            <img width="100%" src="<?php echo e(URL::to('/')); ?>/public/uploads/website/programGallery/<?php echo e(!empty($slide->image) ? $slide->image : 'demo_slide.jpg'); ?>" alt = "D-Care"/>
                        </div>

                    </div><!-- End .intro-slide -->
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div><!-- End .intro-slider owl-carousel owl-simple -->

                <span class="slider-loader"></span><!-- End .slider-loader -->
            </div><!-- End .intro-slider-container -->
        </div><!-- End .col-xl-9 col-xxl-10 -->

    </div><!-- End .row -->
</div><!-- End .container-fluid -->


<!--end banner section -->
<section  id="welcomeDcare" class="welcome-dcare">
    <div class="page-title-container">
        <div class="container">
            <h4 class="page-title welcome-dcare-hedding first-word"> <?php echo $welcomeInfo->title ?? ''; ?></h4>
        </div>
    </div>
    <div class="main-content">
        <div class="container">
            <div class="row" style="padding-bottom: 30px;">
                <div class="col-md-12">
                    <div class="post-content text-justify">
                        <?php echo $welcomeInfo->content ?? ''; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section  id="productCategories" class="product-categories">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4 class="section-heading welcome-dcare-hedding first-word">
                    <?php echo app('translator')->get('english.OUR_PRODUCTS'); ?>
                </h4>
            </div>
        </div>
        <div class="row equal">

            <?php if(!$productArr->isEmpty()): ?>
            <?php $__currentLoopData = $productArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-3 ">
                <div class="item">
                    <a href="<?php echo e(URL::to('/').'/product-details/'); ?><?php echo e($product->id); ?>">
                        <div class="card product-block">
                            <div class="card-heading text-center bg-none">
                                <div class="product-image">
                                    <?php
                                    $productImageArr = json_decode($product->product_image, true);
                                    ?>
                                    <img width="100%" src="<?php echo e(URL::to('/')); ?>/public/uploads/website/product/<?php echo e(!empty(end($productImageArr)) ? end($productImageArr) : 'demo.jpg'); ?>" alt = "D-Care"/>
                                </div>

                            </div>
                            <div class="card-body">

                                <div class="text-center product-name">
                                    <?php echo e($product->name??''); ?>

                                </div>
                                <div class="text-center product-content">
                                    <?php echo $product->product_info??''; ?>

                                </div>
                                <div class="text-center product-price-dcare">
                                    <?php if(!empty($product->check_special_price)): ?>
                                    <del> <?php echo app('translator')->get('english.TK'); ?>.<?php echo $product->price??''; ?></del>
                                    <?php echo app('translator')->get('english.TK'); ?>.<?php echo $product->special_price??''; ?>

                                    <?php else: ?>
                                    <?php echo app('translator')->get('english.TK'); ?>.<?php echo $product->price??''; ?>

                                    <?php endif; ?>
                                </div>

                            </div>
                        </div>
                    </a>    
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
</section>
<?php echo $__env->make('website.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH D:\xampp\htdocs\dysin\resources\views/website/frontend/template/concerns.blade.php ENDPATH**/ ?>