@extends('layouts.default')
@section('content')
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-road"></i>@lang('english.UPDATE_CONTACT')
            </div>
        </div>
        <div class="portlet-body form">
            {!! Form::model($target, ['route' => array('contact-info.update', $target->id), 'method' => 'PATCH', 'files'=> true, 'class' => 'form-horizontal'] ) !!}
            {!! Form::hidden('filter', Helper::queryPageStr($qpArr)) !!}
            {{csrf_field()}}
            <div class="form-body">
                <div class="row">
                    <div class="col-md-12">

 <div class="form-group">
                            <label class="control-label col-md-3" for="email">@lang('english.EMAIL') :<span class="text-danger"> *</span></label>
                            <div class="col-md-5">
                                {!! Form::text('email', null, ['id'=> 'email', 'class' => 'form-control','autocomplete'=>'off']) !!} 
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" for="website">@lang('english.WEBSITE') :<span class="text-danger"> *</span></label>
                            <div class="col-md-5">
                                {!! Form::text('website', null, ['id'=> 'website', 'class' => 'form-control','autocomplete'=>'off']) !!} 
                                <span class="text-danger">{{ $errors->first('website') }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" for="phone">@lang('english.PHONE') :<span class="text-danger"> *</span></label>
                            <div class="col-md-5">
                                {!! Form::text('phone', null, ['id'=> 'phone', 'class' => 'form-control','autocomplete'=>'off']) !!} 
                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" for="address">@lang('english.ADDRESS') :<span class="text-danger"> *</span></label>
                            <div class="col-md-5">
                                {!! Form::text('address', null, ['id'=> 'address', 'class' => 'form-control','autocomplete'=>'off']) !!} 
                                <span class="text-danger">{{ $errors->first('address') }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" for="status">@lang('english.STATUS') :<span class="text-danger"> *</span></label>
                            <div class="col-md-5">
                                {!! Form::select('status_id', array('1' => 'Active', '0' => 'Inactive'), Request::old('status_id'), ['class' => 'form-control', 'id' => 'status']) !!}
                                
                                <span class="text-danger">{{ $errors->first('status') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-4 col-md-8">
                        <button class="btn btn-circle green" type="submit">
                            <i class="fa fa-check"></i> @lang('english.SUBMIT')
                        </button>
                        <a href="{{ URL::to('/contact-info'.Helper::queryPageStr($qpArr)) }}" class="btn btn-circle btn-outline grey-salsa">@lang('english.CANCEL')</a>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>	
    </div>
</div>



@stop