{{ Form::open(array('role' => 'form', 'url' => '', 'class' => 'form-horizontal', 'id' => 'submit')) }}
@lang('english.APPLYING_POSITION', ['title' => $data['title']])
<!-- Progress bar -->
<div class="progressbar">
    <div class="progress" id="progress"></div>

    <div
        class="progress-step progress-step-active"
        data-title="Basic Intro"
        ></div>
    <div class="progress-step" data-title="Verification"></div>
    <div class="progress-step" data-title="Upload CV"></div>
</div>
<div class="form-step">
    <div class="input-group ml-20">
        <label for="cv">{{ trans('english.UPLOAD_CV') }}:<span class="required"> *</span></label>
        <!--<input type="file" name="file" class="">-->
        {!! Form::file('cv',null, ['id'=> 'cv', 'class' => 'cv']) !!}
       
<!--        <div class="clearfix margin-top-10">
            <span class="label label-danger">@lang('english.NOTE')</span><span class="text-danger"> @lang('english.PUBLICATION_FILE_UP')</span>
        </div>-->
        {{ Form::hidden('circular_id', $data['circular_id'], array('id'=>'circularId')) }}
    </div>

    <div class="justify-content-center d-flex mb-5 mt-5 pt-5">
        <button type="button" class="btn btn-primary mr-2 btn-next submit">
            {{ trans('english.SUBMIT') }}
        </button>
        <a href="{{URL::to('jobs/details',$data['circular_id'])}}">
            <button type="button" class="btn btn-outline">{{ trans('english.CANCEL') }}</button> 
        </a>
    </div>
</div>
{{ Form::close() }}

