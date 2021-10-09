@extends('layouts.default')
@section('content')
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-road"></i>@lang('english.CREATE_PROGRAM')
            </div>
        </div>
        <div class="portlet-body form">
            {!! Form::open(array('group' => 'form', 'url' => 'programFeatures/store', 'files'=> true, 'class' => 'form-horizontal')) !!}
            
            {{csrf_field()}}
            {!! Form::hidden('program_id', $programId) !!}
            <div class="form-body">
                <div class="row">
                    <div class="col-md-12">


                        <div class="form-group">
                            <label class="control-label col-md-3" for="title">@lang('english.CAPTION') :<span class="text-danger"> *</span></label>
                            <div class="col-md-5">
                                {!! Form::text('title', null, ['id'=> 'title', 'class' => 'form-control','autocomplete'=>'off']) !!} 
                                <span class="text-danger">{{ $errors->first('title') }}</span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-3" for="featureType">@lang('english.FEATURE_TYPE') :<span class="text-danger"> *</span></label>
                            <div class="col-md-5">
                                {!! Form::select('feature_type', ['1'=>'Content','2'=>'Course Module', '3'=>'Faculty', '4'=>'Archive', '5'=>'COAS TROPHY'], '1', ['id'=> 'featureType', 'class' => 'form-control js-source-states','autocomplete'=>'off']) !!}
                                <span class="text-danger">{{ $errors->first('feature_type') }}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">{{trans('english.CONTENT')}} :</label>
                            <div class="col-md-9">
                                {{ Form::textarea('content', null, ['class' => 'form-control summernote_1','size' => '50x5','id'=>'content']) }}                         
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-3" for="userName">@lang('english.ORDER') :<span class="text-danger"> *</span></label>
                            <div class="col-md-5">
                                {!! Form::select('order_id', $orderList, $lastOrderNumber, ['id'=> 'order_id', 'class' => 'form-control js-source-states','autocomplete'=>'off']) !!}
                                <span class="text-danger">{{ $errors->first('order') }}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3" for="statusId">@lang('english.STATUS') :</label>
                            <div class="col-md-5">
                                {!! Form::select('status_id', ['1' => __('english.ACTIVE'), '0' => __('english.INACTIVE')], '1', ['class' => 'form-control', 'id' => 'statusId']) !!}
                                <span class="text-danger">{{ $errors->first('status') }}</span>
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
                        <a href="{{ URL::to('/ourPrograms') }}" class="btn btn-circle btn-outline grey-salsa">@lang('english.CANCEL')</a>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>	
    </div>
</div>


<link href="{{asset('public/assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
 <script src="{{asset('public/assets/pages/scripts/components-editors.min.js')}}" type="text/javascript"></script>
 <script src="{{asset('public/assets/global/plugins/bootstrap-summernote/summernote.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    
    $(document).on("click", '#featuredImage', function (e) {
         $(".cv").hide();
     });
 
</script>
@stop