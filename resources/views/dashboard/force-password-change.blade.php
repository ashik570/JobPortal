@extends('layouts.default')
@section('content')
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="javascript:void[0];">{{trans('english.CHANGE_PASSWORD')}}</a>
                <i class="fa fa-circle"></i>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title">{{trans('english.CHANGE_PASSWORD')}}</h1>
    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->

    <!-- BEGIN PORTLET-->
    @include('includes.flash')
    <!-- END PORTLET-->
    <div class="row">
        <div class="col-md-12">
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i>{{trans('english.CHANGE_PASSWORD')}} 
                    </div>
                    <div class="tools">
                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    {{ Form::open(array('role' => 'form', 'url' => 'forcePasswordChange', 'files'=> true, 'class' => 'form-horizontal')) }}			
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">{{trans('english.PASSWORD')}} :</label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            {{ Form::password('password', array('id'=> 'userPassword', 'required', 'class' => 'form-control', 'placeholder' => 'Password')) }}
                                            <span class="input-group-addon">
                                                <i class="fa fa-key"></i>
                                            </span>
                                        </div>
                                        <span class="help-block">{{ trans('english.COMPLEX_PASSWORD_INSTRUCTION') }}</span>
                                        <span class="help-block text-danger"> {{ $errors->first('password') }}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">{{trans('english.CONFIRM_PASSWORD')}} :</label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            {{ Form::password('password_confirmation', array('id'=> 'userConfirmPassword', 'required', 'class' => 'form-control', 'placeholder' => 'Confirm Password')) }}
                                            <span class="input-group-addon">
                                                <i class="fa fa-key"></i>
                                            </span>
                                        </div>
                                        <span class="help-block text-danger"> {{ $errors->first('password_confirmation') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" class="btn btn-circle green">{{ trans('english.UPDATE_PASSWORD') }}</button>
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
@stop
