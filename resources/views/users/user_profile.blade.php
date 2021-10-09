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
                        <i class="fa fa-gift"></i>{{trans('english.UPDATE_USER_PROFILE')}} </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                        <a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title=""> </a>
                        <a href="javascript:;" class="reload" data-original-title="" title=""> </a>
                        <a href="javascript:;" class="remove" data-original-title="" title=""> </a>
                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    {{ Form::open(array('role' => 'form', 'url' => 'users/editProfile', 'files'=> true, 'class' => 'form-horizontal', 'id' => 'edit-profile')) }}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-7">
                                
                                <div class="form-group">
                                    <label class="col-md-4 control-label">{{trans('english.FIRST_NAME')}} :<span class="required"> *</span></label>
                                    <div class="col-md-8">
                                        {{ Form::text('first_name',Auth::user()->first_name, array('id'=> 'UserFirstName', 'class' => 'form-control', 'placeholder' => 'Enter First Name')) }}
                                        <span class="help-block text-danger"> {{ $errors->first('first_name') }}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">{{trans('english.LAST_NAME')}} :<span class="required"> *</span></label>
                                    <div class="col-md-8">
                                        {{ Form::text('last_name',Auth::user()->last_name, array('id'=> 'UserLastName', 'class' => 'form-control', 'placeholder' => 'Enter Last Name', 'required' => 'true')) }}
                                        <span class="help-block text-danger"> {{ $errors->first('last_name') }}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">{{trans('english.OFFICIAL_NAME')}} :<span class="required"> *</span></label>
                                    <div class="col-md-8">
                                        {{ Form::text('official_name',Auth::user()->official_name, array('id'=> 'userOfficialName', 'class' => 'form-control', 'placeholder' => 'Enter Official Name', 'required' => 'true')) }}
                                        <span class="help-block text-danger"> {{ $errors->first('official_name') }}</span>
                                    </div>
                                </div>
                                
                                <!--<div class="form-group">
                                    <label class="col-md-4 control-label">{{trans('english.EMAIL')}} :<span class="required"> *</span></label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-envelope"></i>
                                            </span>
                                            {{ Form::email('email',Auth::user()->email, array('id'=> 'UserEmail', 'placeholder' => 'Email Address', 'class' => 'form-control')) }}
                                        </div>
                                        <span class="help-block text-danger"> {{ $errors->first('email') }}</span>
                                    </div>
                                </div>-->
                                <div class="form-group">
                                    <label class="col-md-4 control-label">{{trans('english.PHONE_NUMBER')}} :</label>
                                    <div class="col-md-8">
                                        <div class="input-icon">
                                            <i class="fa fa-mobile-phone"></i>
                                            {{ Form::text('phone_no',Auth::user()->phone_no, array('id'=> 'userPhoneNumber', 'class' => 'form-control', 'placeholder' => 'Enter Phone Number')) }}
                                        </div>
                                        <span class="help-block text-danger"> {{ $errors->first('phone_no') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group last">
                                    <label class="control-label col-md-3"> {{trans('english.PHOTO')}}: </label>
                                    <div class="col-md-9">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                @if(isset(Auth::user()->photo))
                                                    <img src="{{URL::to('/')}}/public/uploads/user/{{Auth::user()->photo}}" alt="{{ Auth::user()->official_name }}"> 
                                                @else
                                                    <img src="{{URL::to('/')}}/public/img/no-image.png" alt="{{ Auth::user()->official_name }}"> 
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
                                            <span class="label label-danger">{{trans('english.NOTE')}}</span> {{trans('english.USER_AND_STUDENT_IMAGE_FOR_IMAGE_DESCRIPTION')}}
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
                                <a href="{{URL::to('dashboard')}}">
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
 <script src="{{asset('public/assets/pages/uses_script/form-user.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
@stop
