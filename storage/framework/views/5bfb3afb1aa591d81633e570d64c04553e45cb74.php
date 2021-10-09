<?php echo $__env->make('website.layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="page-title-container">
    <div class="container">
        <h2 class="page-title first-word"> <?php echo app('translator')->get('english.JOB_LIST'); ?> </h2>
    </div>
</div>
<?php echo e(Form::open(array('role' => 'form', 'url' => '', 'class' => '', 'id' => 'jobList'))); ?>

<?php echo Form::hidden('filter', Helper::queryPageStr($qpArr)); ?>


<?php echo e(Form::close()); ?>

<div class="main-content joblist-a joblist">
    <div class="container">
        <div class="row" style="padding-bottom: 30px;">
            <div class="col-md-12">
                <?php if(!empty($targetArr)): ?>
                <?php
                $page = Request::get('page');
                $page = empty($page) ? 1 : $page;
                $sl = ($page - 1) * trans('english.PAGINATION_COUNT');
                ?>
                <?php $__currentLoopData = $targetArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(URL::to('jobs/details',$value['id'])); ?>">
                    <div class="card w-100">
                        <div class="row card-body">
                            <div class="col-md-7 col-md-offset-4">
                                <?php
                                if (!empty($value['vacancy'])) {
                                    $vacancy = "(" . $value['vacancy'] . ")";
                                } else {
                                    $vacancy = '';
                                }
                                ?>
                                <h5 class="card-title text-success"><?php echo e($value['title']." ".$vacancy); ?></h5>
                                <span class="card-text"><i class="fa fa-graduation-cap"></i>&nbsp;Educational Requirements</span><br>
                                <div class="description-block"><?php echo $value['educational_requirements']; ?></div>

                            </div>

                            <div class="col-md-9">
                                <span>
                                    <?php
                                    $message = '';
                                    $s = '';
                                    if (!empty($value['experience_not_required'])) {
                                        $message = "N/A";
                                    } else {
                                        if (!empty($value['experience_from']) && !empty($value['experience_to']) || !empty($value['experience_to'])) {
                                            if ($value['experience_to'] - $value['experience_from'] >= 1) {
                                                $s = 's';
                                            }
                                            $message = $value['experience_from'] . " to " . $value['experience_to'] . " year" . $s;
                                        } else {
                                            if ($value['experience_from'] > 1) {
                                                $s = 's';
                                            }
                                            $message = "At least " . $value['experience_from'] . " year" . $s;
                                        }
                                    }
                                    ?>
                                    <span><i class="fa fa-briefcase"></i></span> Experience : <?php echo e($message); ?>

                                </span>
                            </div>
                            <div class="col-md-3">
                                <span class="text-danger"><i class="fa fa-calendar-times-o"></i></span> Deadline :<span class='bold'> <?php echo e(date('d F Y',strtotime($value['deadline']))); ?></span>
                            </div>

                        </div>

                    </div>
                </a>
                <br/>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>
            
        </div>
        <?php echo $__env->make('layouts.paginator', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
</div>
<?php echo $__env->make('website.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 
<?php /**PATH D:\xampp\htdocs\dysin\resources\views/website/frontend/template/jobList.blade.php ENDPATH**/ ?>