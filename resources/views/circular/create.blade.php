@extends('layouts.default')
@section('content')
<div class="page-content">

    @include('includes.flash')

    <div class="row">
        <div class="col-md-12">
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cubes"></i>{{trans('english.CREATE_NEW_CIRCULAR')}} 
                    </div>
                    <div class="tools">

                    </div>
                </div>
                <div class="portlet-body form">

                    {{ Form::open(array('role' => 'form', 'url' => 'circular/store', 'class' => 'form-horizontal', 'id'=>'createCircular','files'=>true)) }}
                    {!! Form::hidden('filter', Helper::queryPageStr($qpArr)) !!}
                    <div class="form-body">

                        <div class="row">
                            <div class="col-md-8">

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="title">{{trans('english.TITLE')}} :<span class='required'> *</span></label>
                                    <div class="col-md-8">
                                        {{ Form::text('title', Request::get('title'), array('id'=> 'title', 'class' => 'form-control')) }}
                                        <span class="help-block text-danger"> {{ $errors->first('title') }}</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-4" for="jobNature">@lang('english.JOB_NATURE') :<span class="required"> *</span></label>
                                    <div class="col-md-8">
                                        {!! Form::select('job_nature', $jobNatureArr, null, ['class' => 'form-control js-source-states', 'id' => 'jobNature']) !!} 
                                        <span class="text-danger">{{ $errors->first('job_nature') }}</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-4" for="numberOfVacancies">@lang('english.NUMBER_OF_VACANCIES') :</label>
                                    <div class="col-md-8">
                                        {!! Form::text('number_of_vacancies', null, array('id'=> 'numberOfVacancies', 'class' => 'form-control integer-only')) !!}
                                        <span class="text-danger">{{ $errors->first('number_of_vacancies') }}</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-4" for="jobRequirements">@lang('english.JOB_REQUIREMENTS') :<span class="text-danger"> *</span></label>
                                    <div class="col-md-8">
                                        {!! Form::textarea('job_requirements', null, array('id'=> 'jobRequirements', 'class' => 'form-control', 'rows' => '30')) !!}
                                        <span class="text-danger">{{ $errors->first('job_requirements') }}</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-4" for="additionalRequirements">@lang('english.ADDITIONAL_REQUIREMENTS') :</label>
                                    <div class="col-md-8">
                                        {!! Form::textarea('additional_requirements', null, array('id'=> 'additionalRequirements', 'class' => 'form-control', 'rows' => '30')) !!}
                                        <span class="text-danger">{{ $errors->first('additional_requirements') }}</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-4" for="educationalRequirements">@lang('english.EDUCATIONAL_REQUIREMENTS') :<span class="text-danger"> *</span></label>
                                    <div class="col-md-8">
                                        {!! Form::textarea('educational_requirements', null, array('id'=> 'educationalRequirements', 'class' => 'form-control', 'rows' => '30')) !!}
                                        <span class="text-danger">{{ $errors->first('educational_requirements') }}</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="salary">{{trans('english.SALARY_RANGE')}} :</label>

                                    <div class="col-md-8 ">
                                        <div class="col-md-8 padding-0">
                                            <div class="input-group bootstrap-touchspin width-inherit">
                                                {!! Form::text('salary_range_start', null, ['id'=> 'salaryStart','class' => 'form-control integer-decimal-only text-input-width-100-per text-right not-nigotiable','autocomplete' => 'off']) !!}
                                                
                                                <span class="input-group-addon bootstrap-touchspin-postfix bold">&#8211;</span>
                                                {!! Form::text('salary_range_end', null, ['id'=> 'salaryEnd','class' => 'form-control integer-decimal-only text-input-width-100-per text-left not-nigotiable','autocomplete' => 'off']) !!}
                                                <span class="input-group-addon bootstrap-touchspin-postfix bold">&#2547;</span>
                                            </div>
                                        </div>
                                        

                                        <div class="col-md-4 padding-right-0">
                                            {{Form::select('salary_types', $salaryTypes , Request::get('salary_types'), array('class' => 'form-control dopdownselect-hidden-search not-nigotiable'))}}
                                            <span class="help-block text-danger">{{ $errors->first('salary_types') }}</span>
                                        </div>
                                        <span class="text-danger">{{ $errors->first('salary_range_start') }}</span>
                                        <span class="text-danger">{{ $errors->first('salary_range_end') }}</span>
                                        
                                        <div class="col-md-12 padding-0">
                                            <div class="md-checkbox vcenter module-check margin-top-10">
                                                {!! Form::checkbox('nigotiable', 1, false, ['id' => 'nigotiable', 'class'=> 'md-check']) !!}
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

                                    <div class="col-md-8">
                                        <div class="col-md-12 padding-0">
                                            <div class="input-group bootstrap-touchspin width-inherit">
                                                {!! Form::text('experience_start', null, ['id'=> 'experienceStart','class' => 'form-control integer-decimal-only text-input-width-100-per text-right experience','autocomplete' => 'off']) !!} 
                                                
                                                <span class="input-group-addon bootstrap-touchspin-postfix bold">&#8211;</span>
                                                {!! Form::text('experience_end', null, ['id'=> 'experienceEnd','class' => 'form-control integer-decimal-only text-input-width-100-per text-left experience','autocomplete' => 'off']) !!}
                                                <span class="input-group-addon bootstrap-touchspin-postfix bold">year</span>
                                            </div>
                                        </div>
                                        <span class="text-danger">{{ $errors->first('experience_start') }}</span>
                                        <span class="text-danger">{{ $errors->first('experience_end') }}</span>
                                        <!--<span class="text-danger">{{ $errors->first('experience_end') }}</span>-->

                                        <div class="col-md-12 padding-0">

                                            <div class="md-checkbox vcenter module-check margin-top-10">
                                                {!! Form::checkbox('not_required', 1, false, ['id' => 'notRequired', 'class'=> 'md-check']) !!}
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
                                    <label class="col-md-4 control-label">{{ trans('english.STATUS') }} : </label>
                                    <div class="col-md-8">
                                        {{Form::select('status', array('1' => trans('english.ACTIVE'), '0' => trans('english.INACTIVE')), Request::get('status'), array('class' => 'form-control dopdownselect-hidden-search'))}}
                                        <span class="help-block text-danger">{{ $errors->first('status') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group last">
                                    <div class="col-md-8 col-md-offset-2 text-left mb-2"> {{trans('english.POSTER')}} </div>
                                    <div class="col-md-8 col-md-offset-2">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                <img src="{{URL::to('/')}}/public/img/no-image.png" alt=""> </div>
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
                                <button type="submit" class="btn btn-circle green">{{ trans('english.SUBMIT') }}</button>
                                <a href="{{URL::to('circular')}}">
                                    <button type="button" class="btn btn-circle grey-salsa btn-outline">{{ trans('english.CANCEL') }}</button> 
                                </a>
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}

                </div>
            </div>
        </div>
    </div>
</div>

<link href="{{asset('public/css/website/summernote.min.css')}}" rel="stylesheet" type="text/css" />
<script src="{{asset('public/js/website/summernote.min.js')}}" type="text/javascript"></script>
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
@stop

