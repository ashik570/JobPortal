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
                        <i class="icon-badge"></i>{{trans('english.UPDATE_DESIGNATION')}} </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                        <a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title=""> </a>
                        <a href="javascript:;" class="reload" data-original-title="" title=""> </a>
                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    {{ Form::model($designation, array('route' => array('designation.update', $designation->id), 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'designationUpdate')) }}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">{{trans('english.TITLE')}} :<span class="required"> *</span></label>
                                    <div class="col-md-8">
                                        {{ Form::text('title', Request::get('title'), array('id'=> 'designationTitle', 'class' => 'form-control', 'placeholder' => 'Enter designation Title')) }}
                                        <span class="help-block text-danger"> {{ $errors->first('title') }}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">{{trans('english.SHORT_NAME')}} :<span class="required"> *</span></label>
                                    <div class="col-md-8">
                                        {{ Form::text('short_name', Request::get('short_name'), array('id'=> 'short_name', 'class' => 'form-control', 'placeholder' => 'Enter Short Name')) }}
                                        <span class="help-block text-danger"> {{ $errors->first('short_name') }}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">{{trans('english.ORDER')}} :<span class="required"> *</span></label>
                                    <div class="col-md-8">
                                        {{ Form::number('order', Request::get('order'), array('id'=> 'designationOrder', 'min' => 0, 'class' => 'form-control', 'placeholder' => 'Enter Designation Order', 'required' => 'true')) }}
                                        <span class="help-block text-danger"> {{ $errors->first('order') }}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">{{trans('english.STATUS')}} : </label>
                                    <div class="col-md-8">
                                        {{Form::select('status', array('active' => 'Active', 'inactive' => 'Inactive'), Request::get('status'), array('class' => 'form-control dopdownselect-hidden-search', 'id' => 'designationStatus'))}}
                                        <span class="help-block text-danger">{{ $errors->first('status') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" class="btn btn-circle green">Submit</button>
                                <a href="{{URL::to('designation')}}">
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

<script type="text/javascript">
$(document).on("submit", '#designationUpdate', function (e) {
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
