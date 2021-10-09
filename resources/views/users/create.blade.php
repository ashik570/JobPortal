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
                        <i class="fa fa-gift"></i>{{trans('english.CREATE_NEW_USER')}} </div>
                    <div class="tools">
                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    {{ Form::open(array('role' => 'form', 'url' => 'users', 'files'=> true, 'class' => 'form-horizontal', 'id'=>'userCreate')) }}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">{{trans('english.SELECT_GROUP')}} :<span class="required"> *</span></label>
                                    <div class="col-md-8">
                                        {{Form::select('group_id', $groupList, Request::old('group_id'), array('class' => 'form-control dopdownselect', 'id' => 'userGroupId'))}}
                                        <span class="help-block text-danger">{{ $errors->first('group_id') }}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">{{trans('english.SELECT_RANK')}} :<span class="required"> *</span></label>
                                    <div class="col-md-8">
                                        {{Form::select('designation_id', $designationList, Request::old('designation_id'), array('class' => 'form-control dopdownselect', 'id' => 'userRankId'))}}
                                        <span class="help-block text-danger">{{ $errors->first('designation_id') }}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">{{trans('english.SELECT_APPROINTMENT')}} :<span class="required"> *</span></label>
                                    <div class="col-md-8">
                                        {{Form::select('appointment_id', $appointmentList, Request::old('appointment_id'), array('class' => 'form-control dopdownselect', 'id' => 'userApprointmentId'))}}
                                        <span class="help-block text-danger">{{ $errors->first('appointment_id') }}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">{{trans('english.FIRST_NAME')}} :<span class="required"> *</span></label>
                                    <div class="col-md-8">
                                        {{ Form::text('first_name', Request::old('first_name'), array('id'=> 'UserFirstName', 'class' => 'form-control', 'placeholder' => 'Enter First Name')) }}
                                        <span class="help-block text-danger"> {{ $errors->first('first_name') }}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">{{trans('english.LAST_NAME')}} :<span class="required"> *</span></label>
                                    <div class="col-md-8">
                                        {{ Form::text('last_name', Request::old('last_name'), array('id'=> 'UserLastName', 'class' => 'form-control', 'placeholder' => 'Enter Last Name', 'required' => 'true')) }}
                                        <span class="help-block text-danger"> {{ $errors->first('last_name') }}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">{{trans('english.SELECT_BRANCH')}} :<span class="required"> *</span></label>
                                    <div class="col-md-8">
                                        {{Form::select('branch_id', $branchList, Request::old('branch_id'), array('class' => 'form-control dopdownselect', 'id' => 'userBranchId'))}}
                                        <span class="help-block text-danger">{{ $errors->first('branch_id') }}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">{{trans('english.OFFICIAL_NAME')}} :<span class="required"> *</span></label>
                                    <div class="col-md-8">
                                        {{ Form::text('official_name', Request::old('official_name'), array('id'=> 'userOfficialName', 'class' => 'form-control', 'placeholder' => 'Enter Official Name', 'required' => 'true')) }}
                                        <span class="help-block text-danger"> {{ $errors->first('official_name') }}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">{{trans('english.USERNAME')}} :<span class="required"> *</span></label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                            </span>
                                            {{ Form::text('username', Request::old('username'), array('id'=> 'username', 'placeholder' => 'Enter Username', 'class' => 'form-control')) }}
                                        </div>
                                        <span class="help-block text-danger"> {{ $errors->first('username') }}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">{{trans('english.PASSWORD')}} :<span class="required"> *</span></label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            {{ Form::password('password', array('id'=> 'UserPassword', 'class' => 'form-control', 'placeholder' => 'Password', 'required' => 'true')) }}
                                            <span class="input-group-addon">
                                                <i class="fa fa-key"></i>
                                            </span>
                                        </div>
                                        <span class="help-block">{{ trans('english.COMPLEX_PASSWORD_INSTRUCTION') }}</span>
                                        <span class="help-block text-danger"> {{ $errors->first('password') }}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">{{trans('english.CONFIRM_PASSWORD')}} :<span class="required"> *</span></label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            {{ Form::password('password_confirmation', array('id'=> 'UserConfirmPassword', 'class' => 'form-control', 'placeholder' => 'Confirm Password', 'required' => 'true')) }}
                                            <span class="input-group-addon">
                                                <i class="fa fa-key"></i>
                                            </span>
                                        </div>
                                        <span class="help-block text-danger"> {{ $errors->first('password_confirmation') }}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">{{trans('english.EMAIL')}} :<span class="required"> *</span></label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-envelope"></i>
                                            </span>
                                            {{ Form::email('email', Request::old('email'), array('id'=> 'UserEmail', 'placeholder' => 'Email Address', 'class' => 'form-control')) }}
                                        </div>
                                        <span class="help-block text-danger"> {{ $errors->first('email') }}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">{{trans('english.PHONE_NUMBER')}} :</label>
                                    <div class="col-md-8">
                                        <div class="input-icon">
                                            <i class="fa fa-mobile-phone"></i>
                                            {{ Form::text('phone_no',Request::old('service_no'), array('id'=> 'userPhoneNumber', 'class' => 'form-control', 'placeholder' => 'Enter Phone Number')) }}
                                        </div>
                                        <span class="help-block text-danger"> {{ $errors->first('phone_no') }}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">{{trans('english.STATUS')}} :<span class="required"> *</span></label>
                                    <div class="col-md-8">
                                        {{Form::select('status', $status, Request::old('status'), array('class' => 'form-control dopdownselect-hidden-search', 'id' => 'userStatus'))}}
                                        <span class="help-block text-danger">{{ $errors->first('status') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group last">
                                    <label class="control-label col-md-3"> Photo: </label>
                                    <div class="col-md-9">
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
                                <button type="submit" class="btn btn-circle green">Submit</button>
                                <a href="{{URL::to('users')}}">
                                    <button type="button" class="btn btn-circle grey-salsa btn-outline">Cancel</button> 
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
<script type="text/javascript">
	 $(document).on("submit", '#userCreate', function (e) {
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
</script>
@stop

