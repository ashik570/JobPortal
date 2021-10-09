<?php echo $__env->make('website.layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="main-content post-detail">
    <div class="container mb-3" style="padding-bottom: 30px;">
        <div class="row">
            <!-- Boxes de Acoes -->
            <div class="col-md-12">
                <header class="page-head">
                    <h2 class="heading mt-3 color2 first-word">Contact Us</h2>
                    <hr class="small">
                </header>
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-4">
                <div class="box">
                    <div class="icon">
                        <div class="image"><i class="fa fa-envelope" aria-hidden="true"></i></div>
                        <div class="info">
                            <h3 class="title"><?php echo app('translator')->get('english.MAIL_AND_WEBSITE'); ?></h3>
                            <p>
                                <i class="fa fa-envelope" aria-hidden="true"></i> &nbsp; <?php echo e($targetInfo->email??''); ?>

                                <br/>
                                <i class="fa fa-globe" aria-hidden="true"></i> &nbsp
                                <?php echo e($targetInfo->website??''); ?>

                            </p>

                        </div>
                    </div>
                    <div class="space"></div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-lg-4">
                <div class="box">
                    <div class="icon">
                        <div class="image"><i class="fa fa-mobile" aria-hidden="true"></i></div>
                        <div class="info">
                            <h3 class="title"><?php echo app('translator')->get('english.CONTACT'); ?></h3>
                            <?php
                            $phoneArr = explode(",", $targetInfo->phone)
                            ?>
                            <p>
                                <?php $__currentLoopData = $phoneArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <i class="fa fa-phone" aria-hidden="true"></i> &nbsp;<?php echo e($phone); ?><br/>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </p>
                        </div>
                    </div>
                    <div class="space"></div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-lg-4">
                <div class="box">
                    <div class="icon">
                        <div class="image"><i class="fa fa-map-marker" aria-hidden="true"></i></div>
                        <div class="info">
                            <h3 class="title"><?php echo app('translator')->get('english.ADDRESS'); ?></h3>
                            <p>
                                <i class="fa fa-map-marker" aria-hidden="true"></i> &nbsp; <?php echo $targetInfo->address??''; ?>

                            </p>
                        </div>
                    </div>
                    <div class="space"></div>
                </div>
            </div>
            <!-- /Boxes de Acoes -->

            <!--My Portfolio  dont Copy this -->

        </div>
    </div>
</div>

<div class="csti-map">
    <iframe src="<?php echo app('translator')->get('english.GMAP_URL'); ?>" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
</div>

<?php echo $__env->make('website.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH D:\xampp\htdocs\swapnoloke\resources\views/website/frontend/template/contactUs.blade.php ENDPATH**/ ?>