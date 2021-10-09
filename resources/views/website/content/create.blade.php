@extends('layouts.default')
@section('content')
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    @include('layouts.flash')
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-file-word-o"></i>@lang('english.CREATE_CONTENT')
            </div>
        </div>
        <div class="portlet-body form">
            {!! Form::open(array('group' => 'form', 'url' => 'content', 'files'=> true, 'class' => 'form-horizontal')) !!}
            {!! Form::hidden('filter', Helper::queryPageStr($qpArr)) !!}
            {{csrf_field()}}
            <div class="form-body">
                <div class="row">
                    <div class="col-md-9">

                        <div class="form-group">
                            <label class="control-label col-md-4" for="title">@lang('english.TITLE') :<span class="text-danger"> *</span></label>
                            <div class="col-md-7">
                                {!! Form::text('title', null, ['id'=> 'title', 'class' => 'form-control','autocomplete'=>'off']) !!} 
                                <span class="text-danger">{{ $errors->first('title') }}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4" for="shortInfo">@lang('english.SHORT_INFO') :</label>
                            <div class="col-md-7">
                                {!! Form::text('short_info', null, ['id'=> 'shortInfo', 'class' => 'form-control','autocomplete'=>'off']) !!} 
                                <span class="text-danger">{{ $errors->first('short_info') }}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4" for="orderId">@lang('english.ORDER') :<span class="text-danger">* </span>
                            </label>
                            <div class="col-md-7">
                                {!! Form::select('order_id',$orderList, $lastOrderNumber, ['id'=> 'orderId', 'class' => 'form-control js-source-states','autocomplete'=>'off']) !!} 
                                <span class="text-danger">{{ $errors->first('order_id') }}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4" for="uploadFile">@lang('english.UPLOAD_FILE') :</label>
                            <div class="col-md-7">
                                {!! Form::file('upload_file', null, ['id'=> 'uploadFile', 'class' => 'form-control']) !!}
                                <span class="text-danger">{{ $errors->first('upload_file') }}</span>
                                <div class="clearfix margin-top-10">
                                    <span class="label label-danger">@lang('english.NOTE')</span> @lang('english.CONTENT_FILE_HINTS')
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4" for="statusId">@lang('english.STATUS') :</label>
                            <div class="col-md-7">

                                {!! Form::select('status_id', ['1' => __('english.ACTIVE'), '0' => __('english.INACTIVE')], '1', ['class' => 'form-control', 'id' => 'statusId']) !!}
                                <span class="text-danger">{{ $errors->first('status_id') }}</span>
                            </div>
                        </div> 
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label col-md-3" for="description">@lang('english.DESCRIPTION') :<span class="text-danger"> *</span></label>
                            <div class="col-md-9">
                                {!! Form::textarea('description', null, array('id'=> 'description', 'class' => 'form-control', 'rows' => '30')) !!}
                                <span class="text-danger">{{ $errors->first('description') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-4 col-md-8">
                        <button class="btn btn-circle green" type="submit" name="submit">
                            <i class="fa fa-check"></i> @lang('english.SUBMIT')
                        </button>
                        <a href="{{ URL::to('/content'.Helper::queryPageStr($qpArr)) }}" class="btn btn-circle btn-outline grey-salsa">@lang('english.CANCEL')</a>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>	
    </div>
</div>

<link href="{{asset('public/css/website/summernote.min.css')}}" rel="stylesheet" type="text/css" />
<script src="{{asset('public/js/website/summernote.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
  $('#description').summernote();
});
</script>
@stop