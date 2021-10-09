<?php echo $__env->make('website.layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="page-title-container">
    <div class="container">
        <h2 class="page-title first-word"><?php echo e(trans('english.NEWS_AND_EVENTS')); ?></h2>
		<hr class="small">
    </div>
</div>
<div class="container">
    <div class="row">

            <?php if(!$targetArr->isEmpty()): ?>
            <?php $__currentLoopData = $targetArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $target): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="item  col-md-4">
                <div class="post-thumbnail image-cover">
                    <a  href="<?php echo e(URL::to('/news-and-events').'/'.$target->slug); ?>" class="post-featured-img image-cover">
                        <?php if(!empty($target->featured_image)): ?>
                        <img class="group list-group-image " src="<?php echo e(asset('public/uploads/website/NewsAndEvents/'. $target->featured_image)); ?>" alt="featured Image" />
                        <?php else: ?>
                        <img class="group list-group-image" src="http://placehold.it/400x250/000/fff" alt="" />
                        <?php endif; ?>
                    </a>
                    <div class="post-caption">
                        <a href="<?php echo e(URL::to('/').'/news-and-events/'.$target->slug); ?>" class="group inner list-group-item-heading"><?php echo $target->title ?? ''; ?></a>
                    </div>
                    <h3 class="post-date group inner"><i class="fa fa-calendar"></i><?php echo e(Helper::formatDateTimeForPost($target->created_at)); ?> </h3>
                    <?php if(!empty($target->featured_image)): ?>
                    <div class="post-content group inner list-group-item-text text-justify">
                        <?php echo Helper::limitTextWords($target->content, 50, (URL::to('/').'/news-and-events/'.$target->slug)); ?>

                    </div>
                    <?php endif; ?>

                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            <div class="col-md-12">
               <?php echo e($targetArr->links()); ?>

            </div>
    </div>

</div>

<style>
    .glyphicon { margin-right:5px; }
    .post-thumbnail
    {
        margin-bottom: 20px;
        padding: 0px;
        -webkit-border-radius: 0px;
        -moz-border-radius: 0px;
        border-radius: 0px;
    }

    .item.list-group-item
    {
        float: none;
        width: calc(100% - 30px);
        background-color: #fff;
        margin: 10px 0 0 15px;
    }


    .item.list-group-item .list-group-image
    {
        margin-right: 10px;
    }
    .item.list-group-item .post-thumbnail
    {
        margin-bottom: 0px;
    }
    .item.list-group-item .post-caption,.item.list-group-item h3.post-date,.item.list-group-item .post-content
    {
        padding: 9px 9px 0px 15px;
    }
    .item.list-group-item:nth-of-type(odd)
    {
        background: #eeeeee;
    }

    .item.list-group-item:before, .item.list-group-item:after
    {
        display: table;
        content: " ";
    }

    .item.list-group-item img
    {
        float: left;
    }
    .item.list-group-item:after
    {
        clear: both;
    }
    .list-group-item-text
    {
        margin: 0 0 11px;
    }

    .post-thumbnail {
/*        margin: 1em 0;*/

    }
    .grid-group-item{
        margin: 15px 0;
    }
    .post-thumbnail img {
        width: 100%;
        height: 13vw;
    }

    .post-thumbnail img {
        object-fit: cover;
    }
    .list-group-item a.post-featured-img{
        float:left;
        width:30%;
    }
    .list-group-item{
        margin:0 15px;
        box-sizing: border-box;
    }
    .list-group-item div.post-caption{
        display: flow-root;
    }
    .post-caption a{
        color:#666666;
        font-size: 18px;
        font-weight: 600;
        margin-top: 10px;
        display: block;
        transition: all 0.5s ease;
    }
    .post-caption a:hover{
        text-decoration: none;
        color:#000000;
    }
    .item.list-group-item .post-caption a{
        margin-top: 0;
    }
    .post-date, .post-content{
        margin:5px 0 10px 0;
        font-size: 16px;
        display: flow-root;
    }

    .post-content{
        margin:5px 0 10px 0;
        font-size: 14px;
        line-height: 20px;
        display: flow-root;
    }
    .well{
        margin-bottom: 0px !important;
    }






</style>
<script type="text/javascript">
$(document).ready(function () {
    $('#list').click(function (event) {
        event.preventDefault();
        $('#posts .item').addClass('list-group-item');
        $('#posts .item').removeClass('grid-group-item');

        var maxHeight = 0;
        $(".list-group-item").css('height','auto');
        $(".list-group-item").each(function(){
           if ($(this).height() > maxHeight) { maxHeight = $(this).height(); }
        });
        $(".list-group-item").height(maxHeight);
    });
    $('#grid').click(function (event) {
        event.preventDefault();
        $('#posts .item').removeClass('list-group-item');
        $('#posts .item').addClass('grid-group-item');
        var maxHeight = 0;
        $(".grid-group-item").css('height','auto');
        $(".grid-group-item").each(function(){
           if ($(this).height() > maxHeight) { maxHeight = $(this).height(); }
        });
        $(".grid-group-item").height(maxHeight);
    });
});

$(document).ready(function(){
    var maxHeight = 0;
    $(".grid-group-item").each(function(){
       if ($(this).height() > maxHeight) { maxHeight = $(this).height(); }
    });
    $(".grid-group-item").height(maxHeight);
});
</script>
<?php echo $__env->make('website.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH D:\xampp\htdocs\swapnoloke\resources\views/website/frontend/template/posts.blade.php ENDPATH**/ ?>