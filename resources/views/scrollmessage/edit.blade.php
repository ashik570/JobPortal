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
                        <i class="fa fa-gift"></i>{{trans('english.UPDATE_SCROLL_MESSAGE')}} </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                        <a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title=""> </a>
                        <a href="javascript:;" class="reload" data-original-title="" title=""> </a>
                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    {{ Form::model($message, array('route' => array('scrollmessage.update', $message->id), 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'messageUpdate')) }}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">{{trans('english.SELECT_SCOPE')}} : <span class="required"> *</span></label>
                                     <div class="col-md-5">
										<div class="md-checkbox margin-bottom-10">
											<input type="checkbox" name="scope[]" class="checkboxes" id="home" <?php echo (!empty($selectedArr[3]))? 'checked' :'';?> value="3">
											<label for="home">
												<span class="inc"></span>
												<span class="check"></span>
												<span class="box"></span> {{trans('english.HOME_PAGE')}} 
											</label>
										</div>
										<div class="md-checkbox margin-bottom-10">
											<input type="checkbox" name="scope[]" class="checkboxes" id="issp" <?php echo (!empty($selectedArr[1]))? 'checked' :'';?> value="1">
											<label for="issp">
												<span class="inc"></span>
												<span class="check"></span>
												<span class="box"></span>{{trans('english.ISSP_DASHBOARD')}} 
											</label>
										</div>
										<div class="md-checkbox margin-bottom-10">
											<input type="checkbox" name="scope[]" class="checkboxes" id="jcsc" <?php echo (!empty($selectedArr[2]))? 'checked' :'';?> value="2">
											<label for="jcsc">
												<span class="inc"></span>
												<span class="check"></span>
												<span class="box"></span>{{trans('english.JCSC_DASHBOARD')}} 
											</label>
										</div>
									</div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">{{trans('english.MESSAGE')}} :</label>
                                    <div class="col-md-8">
										{{ Form::text('message', null, ['class' => 'form-control input-large']) }}
										<span class="help-block text-danger">{{ $errors->first('message') }}</span>
                                    </div>
                                </div>
								<div class="form-group">
									<label class="col-md-4 control-label">{{trans('english.PUBLISH')}} : <span class="required"> *</span></label>
									<div class="col-md-8">
										<div class="input-group input-large date-picker input-daterange" data-date="2017-01-01" data-date-format="yyyy-mm-dd">
											{{ Form::text('from_date', Request::get('from_date'), array('id'=> 'courseFromDate', 'class' => 'form-control', 'placeholder' => 'Enter From Date', 'readonly' => true)) }}
											<span class="input-group-addon"> to </span>
											{{ Form::text('to_date', Request::get('to_date'), array('id'=> 'courseToDate', 'class' => 'form-control', 'placeholder' => 'Enter To Date', 'readonly' => true)) }}
										</div>
										<span class="help-block text-danger">{{ $errors->first('from_date') }}</span>
										<span class="help-block text-danger">{{ $errors->first('to_date') }}</span>
									</div>
								</div>
								<div class="form-group">
                                    <label class="col-md-4 control-label">{{trans('english.STATUS')}} : <span class="required"> *</span></label>
                                    <div class="col-md-5">
                                        {{Form::select('status', $statusList, Request::get('status'),array('class' => 'form-control dopdownselect-hidden-search', 'id' => 'courseStatus'))}}
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
                                <a href="{{URL::to('scrollmessage')}}">
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
<link href="{{asset('public/assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
 <script src="{{asset('public/assets/pages/scripts/components-editors.min.js')}}" type="text/javascript"></script>
 <script src="{{asset('public/assets/global/plugins/bootstrap-summernote/summernote.min.js')}}" type="text/javascript"></script>


<script type="text/javascript">
	$(document).on("submit", '#messageUpdate', function (e) {
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
