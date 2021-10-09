<?php
$salaryTypeArr = Common::salaryTypes();
//dd($target->salary_type);
//$salaryType = $salaryTypeArr[$target->salary_type];
$message = '';
$s = '';
if (!empty($target->experience_not_required)) {
    $message = "N/A";
} else {
    if (!empty($target->experience_from) && !empty($target->experience_to) || !empty($target->experience_to)) {
        if ($target->experience_to - $target->experience_from >= 1) {
            $s = 's';
        }
        $message = $target->experience_from . " to " . $target->experience_to . " year" . $s;
    } else {
        if ($target->experience_from > 1) {
            $s = 's';
        }
        $message = "At least " . $target->experience_from . " year" . $s;
    }
}

$salaryRange = "";
if(!empty($target->nigotiable)){
    $salaryRange="nigotiable";
}else{
    if(!empty($target->salary_from) && !empty($target->salary_to) || !empty($target->salary_to)){
        if(empty($target->salary_from)){
            $salaryRange = "0 to ".$target->salary_to." Tk";
        }else{
            $salaryRange = $target->salary_from." to ".$target->salary_to." Tk";
        }
        
    }else{
        $salaryRange = $target->salary_from." Tk";
    }
}

?>
<?php echo $__env->make('website.layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="page-title-container">
    <div class="container">
        <h2 class="page-title first-word ml-3"> <?php echo app('translator')->get('english.JOB_DETAILS'); ?> </h2>
    </div>
</div>
<div class="main-content hr-p-margin-0 job-details">
    <div class="container">
        <div class="row">
            <div class="col-md-12 pb-15">
                <div class="row">
                    <div class="col-md-8 paper-shadow ">
                        <h3 class="text-success"><?php echo e($target->title); ?></h3>
                        <p class="font-weight-bold"><?php echo app('translator')->get('english.VACANCY'); ?></p>
                        <?php if(!empty($target->vacancy)): ?>
                        <span class="ml-5 ml-26"><?php echo e($target->vacancy); ?></span>
                        <?php else: ?>
                        <span class="ml-5 ml-26"><?php echo app('translator')->get('english.NOT_SPECIFIC'); ?></span>
                        <?php endif; ?>
                        <p class="font-weight-bold"><?php echo app('translator')->get('english.JOB_RESPONSIBILITIES'); ?></p>
                        <div class="ml-5"><?php echo $target->job_requirements; ?></div>
                        <p class="font-weight-bold"><?php echo app('translator')->get('english.EMPLOYMENT_STATUS'); ?></p>
                        <span class="ml-5"><?php echo e($target->jobNature->name); ?></span>
                        <p class="font-weight-bold"><?php echo app('translator')->get('english.EDUCATIONAL_REQUIREMENTS'); ?></p>
                        <div class="ml-5"><?php echo $target->educational_requirements; ?></div>
                        <p class="font-weight-bold"><?php echo app('translator')->get('english.EXPERIENCE_REQUIREMENTS'); ?></p>
                        <div class="ml-5"><?php echo $message; ?></div>
                        <p class="font-weight-bold"><?php echo app('translator')->get('english.SALARY'); ?></p>
                        <div class="ml-5"><?php echo $salaryRange; ?></div>
                        <?php if(!empty($data->additional_requirements)): ?>
                        <p class="font-weight-bold"><?php echo app('translator')->get('english.ADDITIONAL_REQUIREMENTS'); ?></p>
                        <?php endif; ?>
                        <div class="ml-5"><?php echo $target->additional_requirements; ?></div>
                        <?php if(!empty($data->other_benifits)): ?>
                        <p class="font-weight-bold"><?php echo app('translator')->get('english.OTHER_BENIFITS'); ?></p>
                        <?php endif; ?>
                        <div class="ml-5"><?php echo $target->other_benifits; ?></div>
                        
                        <div class="text-center">
                            <a class="btn btn-success" href="<?php echo e(URL::to('jobs/apply',$target->id)); ?>" onclick=""><?php echo app('translator')->get('english.APPLY_ONLINE'); ?></a>
                        </div>
                        
                    </div>
                    <div class="col-md-4">
                        <div class="right job-summary">
                            <div class="card card-default">
                                <div class="card-header bg-dark text-light font-weight-bold" role="heading"><?php echo app('translator')->get('english.JOB_SUMMARY'); ?></div>
                                <div class="card-body bg-gray">
                                    <h6>
                                        <strong><?php echo app('translator')->get('english.PUBLISHED_ON'); ?></strong>&nbsp;<?php echo e(date('F d, Y',strtotime($target->submission_date))); ?>

                                    </h6>
                                    <h6>
                                        <strong><?php echo app('translator')->get('english.VACANCY_C'); ?></strong>&nbsp;
                                        <?php echo e($target->vacancy); ?>

                                    </h6>
                                    <h6>
                                        <strong><?php echo app('translator')->get('english.EMPLOYMENT_STATUS:'); ?></strong>&nbsp;<?php echo e($target->jobNature->name); ?>

                                    </h6>
                                    <h6>
                                        <strong><?php echo app('translator')->get('english.EXPERIENCE'); ?></strong>&nbsp;<?php echo e($message); ?>

                                    </h6>
                                    <h6>
                                        <strong><?php echo app('translator')->get('english.GENDER_C'); ?></strong>&nbsp;<?php echo app('translator')->get('english.ALL_ALLOWED'); ?>
                                    </h6>
                                    <h6>
                                        <strong><?php echo app('translator')->get('english.SALARY'); ?></strong>&nbsp;<?php echo e($salaryRange); ?>

                                    </h6>
                                    <h6>
                                        <strong><?php echo app('translator')->get('english.APPLICATION_DEADLINE'); ?></strong>&nbsp;<?php echo e(date('F d, Y',strtotime($target->deadline))); ?>

                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
<!--                    <div class="col-md-12 text-center">
                        <div class="text-center">
                            <a class="btn btn-success" href="" onclick="">Apply Online</a>
                        </div>
                    </div>-->
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $__env->make('website.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 
<?php /**PATH D:\xampp\htdocs\swapnoloke\resources\views/website/frontend/template/jobDetails.blade.php ENDPATH**/ ?>