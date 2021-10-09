<?php
$salaryTypeArr = Common::salaryTypes();
//dd($target->salary_type);
//$salaryType = $salaryTypeArr[$target->salary_type];
$message = '';
$s = '';
if (!empty($data->experience_not_required)) {
    $message = "N/A";
} else {
    if (!empty($data->experience_from) && !empty($data->experience_to) || !empty($data->experience_to)) {
        if ($data->experience_to - $data->experience_from >= 1) {
            $s = 's';
        }
        $message = $data->experience_from . " to " . $data->experience_to . " year" . $s;
    } else {
        if ($data->experience_from > 1) {
            $s = 's';
        }
        $message = "At least " . $data->experience_from . " year" . $s;
    }
}

$salaryRange = "";
if (!empty($data->nigotiable)) {
    $salaryRange = "nigotiable";
} else {
    if (!empty($data->salary_from) && !empty($data->salary_to) || !empty($data->salary_to)) {
        if (empty($data->salary_from)) {
            $salaryRange = "0 to " . $data->salary_to." Tk";
        } else {
            $salaryRange = $data->salary_from . " to " . $data->salary_to." Tk";
        }
    } else {
        $salaryRange = $data->salary_from." Tk";
    }
}
?>
<div class="modal-content" id="modal-content">
    <div class="modal-header clone-modal-header">
        <div class="col-md-7 text-right">
            <h4 class="modal-title"><?php echo app('translator')->get('english.CIRCULAR_DETAILS'); ?></h4>
        </div>
        <div class="col-md-5">
            <button type="button" data-dismiss="modal" data-placement="left" class="btn red pull-right tooltips" title="<?php echo app('translator')->get('english.CLOSE_THIS_POPUP'); ?>"><?php echo app('translator')->get('english.CLOSE'); ?></button>
        </div>
    </div>
    <div class="modal-body">
        <div class="main-content hr-p-margin-0">
            <div class="container">
                <!--<div class="row">-->
                <div class="col-md-8 pb-15">
                    <!--<div class="row">-->
                    <div class="col-md-12 modal-css ">
                        <h3 class="text-success"><?php echo e($data->title); ?></h3>
                        <p class="font-weight-bold"><?php echo app('translator')->get('english.VACANCY'); ?></p>
                        <?php if(!empty($data->vacancy)): ?>
                        <span class="ml-5 ml-26"><?php echo e($data->vacancy); ?></span>
                        <?php else: ?>
                        <span class="ml-5 ml-26"><?php echo app('translator')->get('english.NOT_SPECIFIC'); ?></span>
                        <?php endif; ?>
                        <p class="font-weight-bold"><?php echo app('translator')->get('english.JOB_RESPONSIBILITIES'); ?></p>
                        <div class="ml-5 ml-26"><?php echo $data->job_requirements; ?></div>
                        <p class="font-weight-bold"><?php echo app('translator')->get('english.EMPLOYMENT_STATUS'); ?></p>
                        <span class="ml-5 ml-26"><?php echo e($data->jobNature->name); ?></span>
                        <p class="font-weight-bold"><?php echo app('translator')->get('english.EDUCATIONAL_REQUIREMENTS'); ?></p>
                        <div class="ml-5 description-block2 ml-26"><?php echo $data->educational_requirements; ?></div>
                        <p class="font-weight-bold"><?php echo app('translator')->get('english.EXPERIENCE_REQUIREMENTS'); ?></p>
                        <div class="ml-5 ml-26"><?php echo $message; ?></div>
                        <p class="font-weight-bold"><?php echo app('translator')->get('english.SALARY'); ?></p>
                        <div class="ml-5 ml-26"><?php echo $salaryRange; ?></div>
                        <?php if(!empty($data->additional_requirements)): ?>
                        <p class="font-weight-bold"><?php echo app('translator')->get('english.ADDITIONAL_REQUIREMENTS'); ?></p>
                        <?php endif; ?>
                        <div class="ml-5 ml-26"><?php echo $data->additional_requirements; ?></div>
                        <?php if(!empty($data->other_benifits)): ?>
                        <p class="font-weight-bold"><?php echo app('translator')->get('english.OTHER_BENIFITS'); ?></p>
                        <?php endif; ?>
                        <div class="ml-5 ml-26"><?php echo $data->other_benifits; ?></div>
                    </div>
                    <!--</div>-->
                </div>
                <!--</div>-->
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" data-dismiss="modal" data-placement="top" class="btn dark btn-outline tooltips" title="<?php echo app('translator')->get('english.CLOSE_THIS_POPUP'); ?>"><?php echo app('translator')->get('english.CLOSE'); ?></button>
    </div>
</div>

<script src="<?php echo e(asset('public/js/custom.js')); ?>" type="text/javascript"></script>
<script type="text/javascript">
$(function () {
    $(".tooltips").tooltip();
});
</script><?php /**PATH D:\xampp\htdocs\swapnoloke\resources\views/circular/circularDetailsModal.blade.php ENDPATH**/ ?>