<?php echo $__env->make('website.layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="main-content post-detail">
    <div class="page-title-container">
    <div class="container">
        <h2 class="article-title first-word"><?php echo $postDetail->title ?? ''; ?></h2>
		<hr class="small">
        <div class="post-date"><i class="fa fa-calendar"></i><?php echo e(Helper::formatDateTimeForPost($postDetail->created_at)); ?> </div>
    </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php if(isset($postDetail->featured_image)): ?>
                <div class="featured-image pull-left col-md-4">
                    <img src="<?php echo e(asset('public/uploads/website/NewsAndEvents/'.$postDetail->featured_image ?? 'demo-featured-img.png')); ?>" alt="featured image">
                </div>
                <?php endif; ?>
                <div class="post-content text-justify">
                    <?php echo $postDetail->content ?? ''; ?>

                </div>
            </div>
            <div class="col-md-12 pb-15 text-center mt-15">
                <?php if(!empty(Helper::prevPost('news_and_events', $postDetail->order))): ?>                
				<a class="btn btn-md btn-info" href="<?php echo URL::to('/').'/news-and-events/'. Helper::prevPost('news_and_events', $postDetail->order)->slug; ?>"><i class="fa fa-backward"></i><?php echo e(trans('english.PREV')); ?></a>
                <?php endif; ?>
                <?php if(!empty(Helper::nextPost('news_and_events', $postDetail->order))): ?>
                <a class="btn btn-md btn-info" href="<?php echo URL::to('/').'/news-and-events/'. Helper::nextPost('news_and_events', $postDetail->order)->slug; ?>"><?php echo e(trans('english.NEXT')); ?> <i class="fa fa-forward"></i></a>
				
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php echo $__env->make('website.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH D:\xampp\htdocs\swapnoloke\resources\views/website/frontend/template/postDetail.blade.php ENDPATH**/ ?>