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
                        <i class="fa fa-cubes"></i>{{trans('english.UPDATE_BRANCH')}} </div>
                    <div class="tools">
                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    {{ Form::model($target, array('route' => array('branch.update', $target->id), 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'branchUpdate')) }}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-7">
                                
                                <div class="form-group">
                                    <label class="col-md-4 control-label">{{trans('english.NAME')}} :<span class="required"> *</span></label>
                                    <div class="col-md-8">
                                        {{ Form::text('name', Request::get('name'), array('id'=> 'name', 'class' => 'form-control', 'placeholder' => 'Enter Branch Title', 'required' => 'true')) }}
                                        <span class="help-block text-danger"> {{ $errors->first('name') }}</span>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="short_name">{{trans('english.SHORT_NAME')}} :<span class="required"> *</span></label>
                                    <div class="col-md-8">
                                        {{ Form::text('short_name', Request::get('short_name'), array('id'=> 'short_name', 'class' => 'form-control', 'required' => 'true')) }}
                                        <span class="help-block text-danger"> {{ $errors->first('short_name') }}</span>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-md-4 control-label">{{trans('english.ORDER')}} :<span class="required"> *</span></label>
                                    <div class="col-md-8">
                                        {{ Form::number('order', Request::get('order'), array('id'=> 'order', 'min' => 0, 'class' => 'form-control', 'placeholder' => 'Enter Branch Order', 'required' => 'true')) }}
                                        <span class="help-block text-danger"> {{ $errors->first('order') }}</span>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="info">{{trans('english.INFO')}} : </label>
                                    <div class="col-md-8">
                                        {{ Form::textarea('info', Request::get('info'), array('id'=> 'info', 'rows' => 5, 'class' => 'form-control')) }}
                                        <span class="help-block text-danger"> {{ $errors->first('info') }}</span>
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
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" class="btn btn-circle green">{{ trans('english.SUBMIT') }}</button>
                                <a href="{{URL::to('branch')}}">
                                    <button type="button" class="btn btn-circle grey-salsa btn-outline">{{ trans('english.CANCEL') }}</button> 
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

<script type="text/javascript">
	$(document).on("submit", '#branchUpdate', function (e) {
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
