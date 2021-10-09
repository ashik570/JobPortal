<?php $__env->startSection('content'); ?>
<div class="page-content">

    <?php echo $__env->make('includes.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cubes"></i><?php echo e(trans('english.CREATE_NEW_CIRCULAR')); ?> 
                    </div>
                    <div class="tools">

                    </div>
                </div>
                <div class="portlet-body form">

                    <?php echo e(Form::open(array('role' => 'form', 'url' => 'circular/store', 'class' => 'form-horizontal', 'id'=>'createCircular','files'=>true))); ?>

                    <?php echo Form::hidden('filter', Helper::queryPageStr($qpArr)); ?>

                    <div class="form-body">

                        <div class="row">
                            <div class="col-md-8">

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="title"><?php echo e(trans('english.TITLE')); ?> :<span class='required'> *</span></label>
                                    <div class="col-md-8">
                                        <?php echo e(Form::text('title', Request::get('title'), array('id'=> 'title', 'class' => 'form-control'))); ?>

                                        <span class="help-block text-danger"> <?php echo e($errors->first('title')); ?></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-4" for="jobNature"><?php echo app('translator')->get('english.JOB_NATURE'); ?> :<span class="required"> *</span></label>
                                    <div class="col-md-8">
                                        <?php echo Form::select('job_nature', $jobNatureArr, null, ['class' => 'form-control js-source-states', 'id' => 'jobNature']); ?> 
                                        <span class="text-danger"><?php echo e($errors->first('job_nature')); ?></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-4" for="numberOfVacancies"><?php echo app('translator')->get('english.NUMBER_OF_VACANCIES'); ?> :</label>
                                    <div class="col-md-8">
                                        <?php echo Form::text('number_of_vacancies', null, array('id'=> 'numberOfVacancies', 'class' => 'form-control integer-only')); ?>

                                        <span class="text-danger"><?php echo e($errors->first('number_of_vacancies')); ?></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-4" for="jobRequirements"><?php echo app('translator')->get('english.JOB_REQUIREMENTS'); ?> :<span class="text-danger"> *</span></label>
                                    <div class="col-md-8">
                                        <?php echo Form::textarea('job_requirements', null, array('id'=> 'jobRequirements', 'class' => 'form-control', 'rows' => '30')); ?>

                                        <span class="text-danger"><?php echo e($errors->first('job_requirements')); ?></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-4" for="additionalRequirements"><?php echo app('translator')->get('english.ADDITIONAL_REQUIREMENTS'); ?> :</label>
                                    <div class="col-md-8">
                                        <?php echo Form::textarea('additional_requirements', null, array('id'=> 'additionalRequirements', 'class' => 'form-control', 'rows' => '30')); ?>

                                        <span class="text-danger"><?php echo e($errors->first('additional_requirements')); ?></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-4" for="educationalRequirements"><?php echo app('translator')->get('english.EDUCATIONAL_REQUIREMENTS'); ?> :<span class="text-danger"> *</span></label>
                                    <div class="col-md-8">
                                        <?php echo Form::textarea('educational_requirements', null, array('id'=> 'educationalRequirements', 'class' => 'form-control', 'rows' => '30')); ?>

                                        <span class="text-danger"><?php echo e($errors->first('educational_requirements')); ?></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="salary"><?php echo e(trans('english.SALARY_RANGE')); ?> :</label>

                                    <div class="col-md-8 ">
                                        <div class="col-md-8 padding-0">
                                            <div class="input-group bootstrap-touchspin width-inherit">
                                                <?php echo Form::text('salary_range_start', null, ['id'=> 'salaryStart','class' => 'form-control integer-decimal-only text-input-width-100-per text-right not-nigotiable','autocomplete' => 'off']); ?>

                                                
                                                <span class="input-group-addon bootstrap-touchspin-postfix bold">&#8211;</span>
                                                <?php echo Form::text('salary_range_end', null, ['id'=> 'salaryEnd','class' => 'form-control integer-decimal-only text-input-width-100-per text-left not-nigotiable','autocomplete' => 'off']); ?>

                                                <span class="input-group-addon bootstrap-touchspin-postfix bold">&#2547;</span>
                                            </div>
                                        </div>
                                        

                                        <div class="col-md-4 padding-right-0">
                                            <?php echo e(Form::select('salary_types', $salaryTypes , Request::get('salary_types'), array('class' => 'form-control dopdownselect-hidden-search not-nigotiable'))); ?>

                                            <span class="help-block text-danger"><?php echo e($errors->first('salary_types')); ?></span>
                                        </div>
                                        <span class="text-danger"><?php echo e($errors->first('salary_range_start')); ?></span>
                                        <span class="text-danger"><?php echo e($errors->first('salary_range_end')); ?></span>
                                        
                                        <div class="col-md-12 padding-0">
                                            <div class="md-checkbox vcenter module-check margin-top-10">
                                                <?php echo Form::checkbox('nigotiable', 1, false, ['id' => 'nigotiable', 'class'=> 'md-check']); ?>

                                                <label for="nigotiable">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span>
                                                </label>
                                                <span class="vcenter text-view text-success"><?php echo app('translator')->get('english.PUT_TICK_MARK_IF_SALARY_IS_NIGOTIABLE'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="experience"><?php echo e(trans('english.EXPERIENCE_REQUIREMENTS')); ?> :</label>

                                    <div class="col-md-8">
                                        <div class="col-md-12 padding-0">
                                            <div class="input-group bootstrap-touchspin width-inherit">
                                                <?php echo Form::text('experience_start', null, ['id'=> 'experienceStart','class' => 'form-control integer-decimal-only text-input-width-100-per text-right experience','autocomplete' => 'off']); ?> 
                                                
                                                <span class="input-group-addon bootstrap-touchspin-postfix bold">&#8211;</span>
                                                <?php echo Form::text('experience_end', null, ['id'=> 'experienceEnd','class' => 'form-control integer-decimal-only text-input-width-100-per text-left experience','autocomplete' => 'off']); ?>

                                                <span class="input-group-addon bootstrap-touchspin-postfix bold">year</span>
                                            </div>
                                        </div>
                                        <span class="text-danger"><?php echo e($errors->first('experience_start')); ?></span>
                                        <span class="text-danger"><?php echo e($errors->first('experience_end')); ?></span>
                                        <!--<span class="text-danger"><?php echo e($errors->first('experience_end')); ?></span>-->

                                        <div class="col-md-12 padding-0">

                                            <div class="md-checkbox vcenter module-check margin-top-10">
                                                <?php echo Form::checkbox('not_required', 1, false, ['id' => 'notRequired', 'class'=> 'md-check']); ?>

                                                <label for="notRequired">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span>
                                                </label>
                                                <span class="vcenter text-view text-success"><?php echo app('translator')->get('english.NOT_REQUIRED'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label"><?php echo e(trans('english.SUBMISSION_DATE')); ?> : <span class="required"> *</span></label>
                                    <div class="col-md-8">
                                        <div class="input-group date datepicker2">
                                            <?php echo Form::text('submission_date', null, ['id' => 'submissionDate', 'class' =>'form-control', 'placeholder' => 'DD MM YYYY', 'readonly' => '', 'readonly' => '']); ?>

                                            <span class="text-danger"><?php echo e($errors->first('submission_date')); ?></span>
                                            <span class="input-group-btn">
                                                <button class="btn default reset-date" id="submissionReset" type="button" remove="submissionDate">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                                <button class="btn default date-set" type="button" id="submissionSet">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label"><?php echo e(trans('english.DEADLINE')); ?> : <span class="required"> *</span></label>
                                    <div class="col-md-8">
                                        <div class="input-group date datepicker2">
                                            <?php echo Form::text('deadline', null, ['id' => 'deadlineDate', 'class' =>'form-control', 'placeholder' => 'DD MM YYYY', 'readonly' => '', 'readonly' => '']); ?>

                                            <span class="text-danger"><?php echo e($errors->first('deadline')); ?></span>
                                            <span class="input-group-btn">
                                                <button class="btn default reset-date" id="deadlineReset" type="button" remove="deadlineDate">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                                <button class="btn default date-set" type="button" id="deadlineSet">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-4" for="otherBenifits"><?php echo app('translator')->get('english.OTHER_BENIFITS'); ?> :</label>
                                    <div class="col-md-8">
                                        <?php echo Form::textarea('other_benifits', null, array('id'=> 'otherBenifits', 'class' => 'form-control', 'rows' => '30')); ?>

                                        <span class="text-danger"><?php echo e($errors->first('other_benifits')); ?></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label"><?php echo e(trans('english.STATUS')); ?> : </label>
                                    <div class="col-md-8">
                                        <?php echo e(Form::select('status', array('1' => trans('english.ACTIVE'), '0' => trans('english.INACTIVE')), Request::get('status'), array('class' => 'form-control dopdownselect-hidden-search'))); ?>

                                        <span class="help-block text-danger"><?php echo e($errors->first('status')); ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group last">
                                    <div class="col-md-8 col-md-offset-2 text-left mb-2"> <?php echo e(trans('english.POSTER')); ?> </div>
                                    <div class="col-md-8 col-md-offset-2">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                <img src="<?php echo e(URL::to('/')); ?>/public/img/no-image.png" alt=""> </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                            <div>
                                                <span class="btn default btn-file">
                                                    <span class="fileinput-new"> Select image </span>
                                                    <span class="fileinput-exists"> Change </span>
                                                    <?php echo e(Form::file('photo', array('id' => 'sortpicture'))); ?>

                                                </span>
                                                <span class="help-block text-danger"><?php echo e($errors->first('photo')); ?></span>
                                                <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> <?php echo e(trans('english.REMOVE')); ?> </a>
                                            </div>
                                        </div>
                                        <div class="clearfix margin-top-10">
                                            <span class="label label-danger"><?php echo e(trans('english.NOTE')); ?></span> <?php echo e(trans('english.POSTER_IMAGE')); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" class="btn btn-circle green"><?php echo e(trans('english.SUBMIT')); ?></button>
                                <a href="<?php echo e(URL::to('circular')); ?>">
                                    <button type="button" class="btn btn-circle grey-salsa btn-outline"><?php echo e(trans('english.CANCEL')); ?></button> 
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php echo e(Form::close()); ?>


                </div>
            </div>
        </div>
    </div>
</div>

<link href="<?php echo e(asset('public/css/website/summernote.min.css')); ?>" rel="stylesheet" type="text/css" />
<script src="<?php echo e(asset('public/js/website/summernote.min.js')); ?>" type="text/javascript"></script>
<script type="text/javascript">
$(document).on("submit", '#createCircular', function (e) {
    console.log('ok');
    //This function use for sweetalert confirm message
    e.preventDefault();
    var form = this;
    swal({
        title: 'Are you sure you want to Submit?',
        text: '<strong></strong>',
        type: 'warning',
        html: true,
        allowOutsideClick: true,
        showConfirmButton: true,
        showCancelButton: true,
        confirmButtonClass: 'btn-info',
        cancelButtonClass: 'btn-danger',
        confirmButtonText: 'Yes, I agree',
        cancelButtonText: 'No, I do not agree',
    },
            function (isConfirm) {
                if (isConfirm) {
                    toastr.info("Loading...", "Please Wait.", {"closeButton": true});
                    form.submit();
                } else {
                    //swal(sa_popupTitleCancel, sa_popupMessageCancel, "error");

                }
            });
});

$(document).ready(function () {
    $('#jobRequirements').summernote();
});
$(document).ready(function () {
    $('#additionalRequirements').summernote();
});
$(document).ready(function () {
    $('#educationalRequirements').summernote();
});
$(document).ready(function () {
    $('#otherBenifits').summernote();
});

$("#nigotiable").change(function () {
    if (this.checked) {
        $('.not-nigotiable').prop("disabled", true);
    } else {
        $('.not-nigotiable').prop("disabled", false);
    }

});

$("#notRequired").change(function () {
    if (this.checked) {
        $('.experience').prop("disabled", true);
    } else {
        $('.experience').prop("disabled", false);
    }
});
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\swapnoloke\resources\views/circular/create.blade.php ENDPATH**/ ?>