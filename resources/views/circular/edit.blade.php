<?php // dd() ?>
@extends('layouts.default')
@section('content')
<!-- BEGIN CONTENT BODY -->
<div class="page-content">

    <!-- BEGIN PORTLET-->
    @include('includes.flash')
    <!-- END PORTLET-->
    <div class="row">
        <div class="col-md-12">
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i>{{trans('english.UPDATE_CIRCULAR')}} </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                        <a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title=""> </a>
                        <a href="javascript:;" class="reload" data-original-title="" title=""> </a>
                        <a href="javascript:;" class="remove" data-original-title="" title=""> </a>
                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    {{ Form::model($target, array('route' => array('circular.update', $target->id), 'method' => 'PATCH', 'files'=> true, 'class' => 'form-horizontal', 'id' => 'circularId')) }}
                    {!! Form::hidden('filter', Helper::queryPageStr($qpArr)) !!}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">{{trans('english.TITLE')}} :<span class="required"> *</span></label>
                                    <div class="col-md-8">
                                        {{ Form::text('title', Request::get('title'), array('id'=> 'title', 'class' => 'form-control', 'placehgeter' => 'Title')) }}
                                        <span class="help-block text-danger"> {{ $errors->first('title') }}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">{{trans('english.JOB_NATURE')}} :<span class="required"> *</span></label>
                                    <div class="col-md-8">
                                        {{Form::select('job_nature_id', $jobNatureList, Request::get('job_nature_id'), array('class' => 'form-control dopdownselect', 'id' => 'job_nature_id'))}}
                                        <span class="help-block text-danger">{{ $errors->first('job_nature_id') }}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">{{trans('english.VACANCY')}} :</label>
                                    <div class="col-md-8">
                                        {{ Form::text('vacancy', Request::get('vacancy'), array('id'=> 'title', 'class' => 'form-control integer-only', 'placehgeter' => 'Vacancy')) }}
                                        <span class="help-block text-danger"> {{ $errors->first('vacancy') }}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4" for="jobRequirements">@lang('english.JOB_REQUIREMENTS') :<span class="text-danger"> *</span></label>
                                    <div class="col-md-8">
                                        {!! Form::textarea('job_requirements', null, array('id'=> 'jobRequirements', 'class' => 'form-control summernote', 'rows' => '30')) !!}
                                        <span class="text-danger">{{ $errors->first('job_requirements') }}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4" for="additionalRequirements">@lang('english.ADDITIONAL_REQUIREMENTS') :</label>
                                    <div class="col-md-8">
                                        {!! Form::textarea('additional_requirements', null, array('id'=> 'additionalRequirements', 'class' => 'form-control summernote', 'rows' => '30')) !!}
                                        <span class="text-danger">{{ $errors->first('additional_requirements') }}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4" for="educationalRequirements">@lang('english.EDUCATIONAL_REQUIREMENTS') :<span class="text-danger"> *</span></label>
                                    <div class="col-md-8">
                                        {!! Form::textarea('educational_requirements', null, array('id'=> 'educationalRequirements', 'class' => 'form-control summernote', 'rows' => '30')) !!}
                                        <span class="text-danger">{{ $errors->first('educational_requirements') }}</span>
                                    </div>
                                </div>
                                
                                
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="salary">{{trans('english.SALARY_RANGE')}} :</label>
                                    <?php $salaryRangeDisabled = $target->nigotiable == '1'?'disabled':''; ?>
                                    <div class="col-md-8 ">
                                        <div class="col-md-8 padding-0">
                                            <div class="input-group bootstrap-touchspin width-inherit">
                                                <?php 
                                                    $salaryFrom = $target->salary_from > 0.00 ? $target->salary_from : '';
                                                    $salaryTo = $target->salary_to > 0.00 ? $target->salary_to : '';
                                                ?>
                                                {!! Form::text('salary_from', $salaryFrom, [$salaryRangeDisabled,'id'=> 'salaryStart','class' => 'form-control integer-decimal-only text-input-width-100-per text-right not-nigotiable','autocomplete' => 'off']) !!}

                                                <span class="input-group-addon bootstrap-touchspin-postfix bold">&#8211;</span>
                                                {!! Form::text('salary_to', $salaryTo, [$salaryRangeDisabled,'id'=> 'salaryEnd','class' => 'form-control integer-decimal-only text-input-width-100-per text-left not-nigotiable','autocomplete' => 'off']) !!}
                                                <span class="input-group-addon bootstrap-touchspin-postfix bold">&#2547;</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 padding-right-0">
                                            {{Form::select('salary_type', $salaryTypes , Request::get('salary_types'), array($salaryRangeDisabled,'class' => 'form-control dopdownselect-hidden-search not-nigotiable'))}}
                                            <span class="help-block text-danger">{{ $errors->first('salary_types') }}</span>
                                        </div>
                                        <span class="text-danger">{{ $errors->first('salary_range_start') }}</span>
                                        <div class="col-md-12 padding-0">
                                            <div class="md-checkbox vcenter module-check margin-top-10">
                                                {!! Form::checkbox('nigotiable', 1, $target->nigotiable, ['id' => 'nigotiable', 'class'=> 'md-check']) !!}
                                                <label for="nigotiable">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span>
                                                </label>
                                                <span class="vcenter text-view text-success">@lang('english.PUT_TICK_MARK_IF_SALARY_IS_NIGOTIABLE')</span>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                
                                
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="experience">{{trans('english.EXPERIENCE_REQUIREMENTS')}} :</label>
                                    <?php $experienceDisabled = $target->experience_not_required == '1'?'disabled':''; ?>
                                    <div class="col-md-8">
                                        <div class="col-md-12 padding-0">
                                            <div class="input-group bootstrap-touchspin width-inherit">
                                                <?php
                                                    $experienceFrom = !empty($target->experience_from) ? $target->experience_from : '';
                                                    $experienceTo = !empty($target->experience_to) ? $target->experience_to : '';
                                                    
                                                ?>
                                                {!! Form::text('experience_from', $experienceFrom, [$experienceDisabled,'id'=> 'experienceStart','class' => 'form-control integer-decimal-only text-input-width-100-per text-right experience ','autocomplete' => 'off']) !!} 

                                                <span class="input-group-addon bootstrap-touchspin-postfix bold">&#8211;</span>
                                                {!! Form::text('experience_to', $experienceTo, [$experienceDisabled,'id'=> 'experienceEnd','class' => 'form-control integer-decimal-only text-input-width-100-per text-left experience ','autocomplete' => 'off']) !!}
                                                <span class="input-group-addon bootstrap-touchspin-postfix bold">year</span>
                                            </div>
                                        </div>
                                        <span class="text-danger">{{ $errors->first('experience_start') }}</span>
                                        <!--<span class="text-danger">{{ $errors->first('experience_end') }}</span>-->
                                        <div class="col-md-12 padding-0">
                                            <div class="md-checkbox vcenter module-check margin-top-10">
                                                {!! Form::checkbox('experience_not_required', 1, $target->experience_not_required, ['id' => 'notRequired', 'class'=> 'md-check']) !!}
                                                <label for="notRequired">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span>
                                                </label>
                                                <span class="vcenter text-view text-success">@lang('english.NOT_REQUIRED')</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                <div class="form-group">
                                    <label class="col-md-4 control-label">{{ trans('english.SUBMISSION_DATE') }} : <span class="required"> *</span></label>
                                    <div class="col-md-8">
                                        <div class="input-group date datepicker2">
                                            {!! Form::text('submission_date', null, ['id' => 'submissionDate', 'class' =>'form-control', 'placeholder' => 'DD MM YYYY', 'readonly' => '', 'readonly' => '']) !!}
                                            <span class="text-danger">{{ $errors->first('submission_date') }}</span>
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
                                    <label class="col-md-4 control-label">{{ trans('english.DEADLINE') }} : <span class="required"> *</span></label>
                                    <div class="col-md-8">
                                        <div class="input-group date datepicker2">
                                            {!! Form::text('deadline', null, ['id' => 'deadlineDate', 'class' =>'form-control', 'placeholder' => 'DD MM YYYY', 'readonly' => '', 'readonly' => '']) !!}
                                            <span class="text-danger">{{ $errors->first('deadline') }}</span>
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
                                    <label class="control-label col-md-4" for="otherBenifits">@lang('english.OTHER_BENIFITS') :</label>
                                    <div class="col-md-8">
                                        {!! Form::textarea('other_benifits', null, array('id'=> 'otherBenifits', 'class' => 'form-control', 'rows' => '30')) !!}
                                        <span class="text-danger">{{ $errors->first('other_benifits') }}</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-4" for="statusId">@lang('english.STATUS') :</label>
                                    <div class="col-md-8">
                                        {!! Form::select('status', ['1' => __('english.ACTIVE'), '0' => __('english.INACTIVE')], null, ['class' => 'form-control', 'id' => 'status']) !!}

                                        <span class="text-danger">{{ $errors->first('status') }}</span>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="form-group last">
                                    <div class="col-md-8 col-md-offset-2 text-left"> {{trans('english.POSTER')}} </div>
                                    <div class="col-md-8 col-md-offset-2">
                                        <div class="fileinput fileinput-new mt-2" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                @if(!empty($target->poster))
                                                    <img src="{{URL::to('/')}}/public/uploads/website/circular/{{$target->poster}}" alt="{{ $target->title }}"> 
                                                @else
                                                    <img src="{{URL::to('/')}}/public/img/no-image.png" alt=""> 
                                                @endif
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                            <div>
                                                <span class="btn default btn-file">
                                                    <span class="fileinput-new"> Select image </span>
                                                    <span class="fileinput-exists"> Change </span>
                                                    {{Form::file('photo', array('id' => 'sortpicture'))}}
                                                </span>
                                                <span class="help-block text-danger">{{ $errors->first('photo') }}</span>
                                                <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> {{trans('english.REMOVE')}} </a>
                                            </div>
                                        </div>
                                        <div class="clearfix margin-top-10">
                                            <span class="label label-danger">{{trans('english.NOTE')}}</span> {{trans('english.POSTER_IMAGE')}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" class="btn btn-circle green">{{trans('english.SUBMIT')}}</button>
                                <a href="{{URL::to('circular')}}">
                                    <button type="button" class="btn btn-circle grey-salsa btn-outline">{{trans('english.CANCEL')}}</button> 
                                </a>
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
                    <!-- END FORM-->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END CONTENT BODY -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<link href="{{asset('public/css/website/summernote.min.css')}}" rel="stylesheet" type="text/css" />
<script src="{{asset('public/js/website/summernote.min.js')}}" type="text/javascript"></script>
<script src="{{asset('public/assets/pages/uses_script/form-user.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script type="text/javascript">
$(document).on("submit", '#circularId', function (e) {
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
    $('#jobRequirements').summernote({
        height: 200
    });
});
$(document).ready(function () {
    $('#additionalRequirements').summernote({
        height: 200
    });
});
$(document).ready(function () {
    $('#educationalRequirements').summernote({
        height: 200
    });
});
$(document).ready(function () {
    $('#otherBenifits').summernote({
        height: 200
    });
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
@stop

