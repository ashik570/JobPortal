<?php echo e(Form::open(array('role' => 'form', 'url' => '', 'class' => 'form-horizontal', 'id' => 'verify'))); ?>


<!--<h5 class="text-center">Applying for position of<span class="text-success"><?php echo e($data['title']); ?></span> Post</h5>-->
<?php echo app('translator')->get('english.APPLYING_POSITION', ['title' => $data['title']]); ?>
<!-- Progress bar -->
<div class="progressbar">
    <div class="progress" id="progress"></div>
    <div class="progress-step progress-step-active" data-title="Basic Intro"></div>
    <div class="progress-step" data-title="Verification"></div>
    <div class="progress-step" data-title="Upload CV"></div>
</div>
<div class="form-step">
    <div class="input-group ml-20 mb-5">
        <label for="code"><?php echo e(trans('english.CODE')); ?>:<span class="required"> *</span></label>
        <?php echo e(Form::hidden('circular_id', $data['circular_id'] , array('id'=>'circularId'))); ?>

        <?php echo e(Form::text('code', Request::get('code'), array('id'=> 'code', 'class' => ''))); ?>

        <?php echo e(Form::hidden('title', $data['title'], array('id'=>'title'))); ?>

        <?php echo e(Form::hidden('circular_id', $data['circular_id'], array('id'=>'circularId'))); ?>

        <!--<input type="code" name="code" id="code" />-->
    </div>

    <div class="input-group mb-5">
        <div class="col-md-10" id="timer">
            <span class="time-text text-success"><?php echo e(trans('english.VERIFY_WITHIN_REMAINING_TIME')); ?></span>
        </div>
        <div class="col-md-2">
            <span class="time font-weight-bold text-success"></span>
        </div>
    </div>

    <div class="justify-content-center d-flex mb-5 mt-5 pt-5">
        <button type="button" class="btn mr-2 btn-primary btn-next verify">
            <?php echo e(trans('english.VERIFY')); ?>

        </button>
        <a href="<?php echo e(URL::to('jobs/details',$data['circular_id'])); ?>">
            <button type="button" class="btn btn-outline"><?php echo e(trans('english.CANCEL')); ?></button> 
        </a>
    </div>
</div>

<script type="text/javascript">
    

</script>

<?php echo e(Form::close()); ?><?php /**PATH D:\xampp\htdocs\dysin\resources\views/website/frontend/template/verify.blade.php ENDPATH**/ ?>