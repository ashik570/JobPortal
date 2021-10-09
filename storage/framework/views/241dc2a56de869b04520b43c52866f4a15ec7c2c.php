<?php echo $__env->make('website.layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('website.frontend.template.home_banner', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php if(!empty($whoWeAre)): ?>
<section id="welcome" class="who-we-are">
    <div class="container">
        <div class="row">
            <div class="col-md-12 wellcome-txt">
                <h2 class="article-title"><?php echo app('translator')->get('english.WHO_WE_ARE'); ?></h2>
            </div>
        </div>
        <div class="row equal pb-5">
            <div class="col-md-12 whoWeAre">
                 <?php echo Helper::limitTextChars($whoWeAre->content, 600, (URL::to('/').'/who-we-are/'.$whoWeAre->slug)); ?>

            </div>
        </div>
    </div>
</section>
<?php endif; ?>



<section  id="atAGlance" class="at-a-glance">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="section-heading ourspeciality-heading first-word text-center">
                    <?php echo app('translator')->get('english.OUR_SPECIALITY'); ?>
				</h2>
            </div>
        </div>
        <div class="row equal pb-5">
            <div class="owl-carousel at-a-glance-content">
                <?php if(!empty($ourSpecialty)): ?>
                <?php $__currentLoopData = $ourSpecialty; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ourSpecialtyData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="item">
                    <div class="card">
                        <div class="card-heading text-center bg-none">
                            <div class="card-icon"><img src="<?php echo e(asset('public/uploads/website/'.(!empty($ourSpecialtyData->featured_image) ? $ourSpecialtyData->featured_image : 'default-featured-img.png'))); ?>" alt="<?php echo $ourSpecialtyData->title; ?>"></div>
                            <h5 class="card-title"><?php echo e($ourSpecialtyData->title); ?></h5>
                        </div>
                        <div class="card-body">
                            <div class="article-text text-center">
                                <?php echo Helper::limitTextChars($ourSpecialtyData->content, 180, (URL::to('/').'/our-specialty/'.$ourSpecialtyData->slug)); ?>

                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<section  id="majorCategories" class="major-categories">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="section-heading major-heading first-word text-center">
                    <?php echo app('translator')->get('english.MAJOR_CATEGORIES'); ?>
				</h2>
            </div>
        </div>
      <div class="row equal">

                <?php if(!empty($majorCategories)): ?>
                <?php 
                $i = 0;
                $majorBgHeader[0] ='major-bg-header-0';
                $majorBgHeader[1] ='major-bg-header-1';
                $majorBgHeader[2] ='major-bg-header-2';
                ?>
                <?php $__currentLoopData = $majorCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ourSpecialtyData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                 <div class="col-md-4 ">
                <div class="item">
                    <div class="card major-block">
                        <div class="card-heading text-center bg-none">
                            <div class="card-icon major-herder <?php echo e($majorBgHeader[$i]??'major-bg-header-0'); ?>"><?php echo e($ourSpecialtyData->title); ?></div>
                         
                        </div>
                        <div class="card-body">
                            <div class="article-text text-center major-content">
                               <?php echo $ourSpecialtyData->content; ?>

                            </div>
                        </div>
                    </div>
                </div>
                </div>
                 <?php 
                $i++;
                ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>
</section>
<section  id="businessSegments" class="businesssegments">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="section-heading ourspeciality-heading first-word text-center">
                    <?php echo app('translator')->get('english.BUSINESS_SEGMENTS'); ?>
				</h2>
            </div>
        </div>
        <div class="aboutus-b animated">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <img class="officer_img" src="<?php echo e(asset('public/uploads/website/businesssegments/'.(!empty($businessSegments->featured_image) ? $businessSegments->featured_image : 'default-oc-img.png'))); ?>" alt="featured image">
                    </div>
                </div>
            </div>
        </div>
</section>
<section id="affiliations" class="affiliations">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="section-heading affiliations-heading first-word text-center">
                    <?php echo app('translator')->get('english.AFFILIATIONS_MEMBERSHIPS'); ?>
				</h2>
            </div>
        </div>
        <div class="row equal  pb-2">
            <?php if(!empty($affiliations)): ?>
            <div class="owl-carousel" id="affiliationCarousel">
                <?php
                $i=0;
                ?>
                <?php $__currentLoopData = $affiliations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $affiliation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="item">
                    <div class="aff-item">
                        <a href="<?php echo e(URL::to('/').'/affiliation-details/'.$affiliation->slug); ?>">
                            <div class="aff-featured-img">
                                <img src="<?php echo e(asset('public/uploads/website/'.$affiliation->featured_image)); ?>" alt="Featured Image">
                            </div>
                            <div class="aff-text-content">
                                <!--<span class="text-center affiliationTitle"><?php echo e($affiliation->title); ?></span>-->
                            </div>
                        </a>
                    </div>
                </div>
                <?php
                $i++;
                ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>


<div class="gallery" id="gallery">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="section-heading gallery-heading first-word text-center">
                    <?php echo app('translator')->get('english.OUR_GALLERY'); ?>
				</h2>
            </div>
        </div>
        <div class="row equal">
            <?php if(!$galleryArr->isEmpty()): ?>
            <ul class="list-unstyled lightgallery ">
                <?php $__currentLoopData = $galleryArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="col-lg-3 col-md-4 col-xs-6 col-sm-6 gallery-list" data-responsive="<?php echo e(asset('public/uploads/website/gallery/'.$gallery->photo)); ?> 375, <?php echo e(asset('public/uploads/website/gallery/'.$gallery->photo)); ?> 480" data-src="<?php echo e(asset('public/uploads/website/gallery/'.$gallery->photo)); ?>" data-sub-html="">
                    <img class="img-thumbnail gallery-thumbnail"
                         src="<?php echo e(asset('public/uploads/website/gallery/'.$gallery->thumb)); ?>"
                         alt="<?php echo e($gallery->caption); ?>">
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>

            <?php endif; ?>
        </div>
    </div>
</div>

<?php if(!$statistics->isEmpty()): ?>

<div class="statistics" id="statistics">
    <div class="container">
        <div class="row equal margin-buttom-20">
            <?php
            $i = 1;
            $bg[1] = 'bg-1';
            $bg[2] = 'bg-2';
            $bg[3] = 'bg-3';
            $bg[4] = 'bg-4';
            ?>
            <?php $__currentLoopData = $statistics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $static): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-3 col-xs-6 col-sm-6 stat_item">
                <div class="dot <?php echo $bg[$i]??''; ?> rounded dot-border-1 margin-bottom-10">
                    <div class="text-center textStatistic">
                        <span class="bold text-center number" data-counter="counterup" data-value="177" style="display:block;">  <?php echo e($static->quantity); ?></span>
                        <span class="bold text-center"> <?php echo e($static->title); ?></span>
                    </div>
                </div>

            </div>
            <?php
            $i++;
            ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>
    </div>
</div>
<?php endif; ?>
<section id="newsAndEvent" class="news-and-events">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="section-heading newsEvents-heading first-word text-center style-2"><?php echo app('translator')->get('english.LATEST_NEWS_EVENTS'); ?></h2>
            </div>
        </div>
        <div class="row">
            <?php if(!$newsAndEvents->isEmpty()): ?>
            <?php $__currentLoopData = $newsAndEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-4 col-lg-4 col-sm-6 pb-2">
                <div class="news-events-content">
                    <?php if(!empty($post->featured_image)): ?>
                    <div class="featured-image">
                        <a class="" href="<?php echo e(URL::to('/')); ?>/news-and-events/<?php echo e($post->slug); ?>"><img class="img-responsive" src="<?php echo e(asset('public/uploads/website/NewsAndEvents/'.$post->featured_image)); ?>" alt="featured image"></a>
                    </div>
                    <?php endif; ?>
                    <h3 class="p-title"><a class="" href="<?php echo e(URL::to('/')); ?>/news-and-events/<?php echo e($post->slug); ?>"><?php echo $post->title; ?></a></h3>
                    <div class="post-date"><i class="fa fa-calendar"></i><?php echo e(Helper::formatDateTimeForPost($post->created_at)); ?> </div>
                    <p class="post-text">
                        <?php echo Helper::limitTextWords($post->content, 20, (URL::to('/').'/news-and-events/'.$post->slug)); ?>

                    </p>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<div class="dysin-map">
    <iframe src="<?php echo app('translator')->get('english.GMAP_URL'); ?>" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
</div>
<script src="<?php echo e(asset('public/js/website/waypoint.js')); ?>" type="text/javascript"></script>

<?php $__env->startSection('page-script'); ?>
<script>
    $(document).ready(function () {
        $('.at-a-glance-content').owlCarousel({
            loop: true,
            autoplay: true,
            margin: 30,
            nav: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    nav: true,
                    loop: true
                },
                600: {
                    items: 3,
                    nav: true,
                    loop: true
                },
                1000: {
                    items: 4,
                    nav: true,
                    loop: true
                }
            }
        });
        $('#ourPrograms').owlCarousel({
            loop: true,
            autoplay: true,
            margin: 30,
            nav: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    nav: true,
                    loop: true
                },
                600: {
                    items: 3,
                    nav: true,
                    loop: true
                },
                1000: {
                    items: 4,
                    nav: true,
                    loop: true
                }
            }
        });

        $('#affiliationCarousel').owlCarousel({
            loop: true,
            autoplay: true,
            margin: 30,
            nav: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    nav: true,
                    loop: true
                },
                600: {
                    items: 4,
                    nav: true,
                    loop: true
                },
                1000: {
                    items: 6,
                    nav: true,
                    loop: true
                }
            }
        });
    });


</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('website.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH E:\xampp-7.4.9\htdocs\swapnoloke\resources\views/website/frontend/template/homePage.blade.php ENDPATH**/ ?>