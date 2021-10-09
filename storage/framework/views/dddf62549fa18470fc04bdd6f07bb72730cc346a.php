<!-- banner section -->
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
                                      <img width="100%" src="<?php echo e(URL::to('/')); ?>/public/uploads/website/slider/<?php echo e(!empty($slide->img_d_x) ? $slide->img_d_x : 'demo_slide.jpg'); ?>" alt = "CSTI"/>
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
<?php /**PATH D:\xampp\htdocs\swapnoloke\resources\views/website/frontend/template/home_banner.blade.php ENDPATH**/ ?>