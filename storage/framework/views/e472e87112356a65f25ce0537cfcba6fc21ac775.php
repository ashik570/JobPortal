<?php echo $__env->make('website.layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="main-content">
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="page-title-container">
                    <h2 class="article-title first-word mt-15 mb-15 text-center pt-15"> </h2>
                </div>
                <?php if(!$targetArr->isEmpty()): ?>
                <div class="row pt-15">
                    <?php $__currentLoopData = $targetArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $target): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-2 col-sm-3 col-sx-4">
                        <a href="<?php echo e(asset('public/uploads/website/publication/upload_file/'.$target->upload_file)); ?>" class="pfile" download data-toggle="tooltip" data-placement="top" title="<?php echo app('translator')->get('english.DOWNLOAD'); ?>">
                            <img src="<?php echo e(asset('public/uploads/website/publication/'.$target->image)); ?>" alt="<?php echo e($target->image??''); ?>" height="160" width="225">
                            <h3 class="pbl-title"><?php echo $target->title ?? ''; ?></h3>
                        </a>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>

<?php echo $__env->make('website.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH D:\xampp\htdocs\dysin\resources\views/website/frontend/template/publication.blade.php ENDPATH**/ ?>