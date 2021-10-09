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
                        <i class="fa fa-cubes"></i>{{trans('english.UPDATE_JOB_NATURE')}} </div>
                    <div class="tools">
                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    {{ Form::model($target, array('route' => array('jobNature.update', $target->id), 'method' => 'PATCH', 'class' => 'form-horizontal', 'id' => 'jobNatureUpdate')) }}
                    {!! Form::hidden('filter', Helper::queryPageStr($qpArr)) !!}
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
                                    <label class="control-label col-md-4" for="orderId">@lang('english.ORDER') :<span class="text-danger">* </span>
                                    </label>
                                    <div class="col-md-8">
                                        {!! Form::select('order_id',$orderList, $target->order, ['id'=> 'orderId', 'class' => 'form-control js-source-states','autocomplete'=>'off']) !!} 
                                        <span class="text-danger">{{ $errors->first('order') }}</span>
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
                                <a href="{{URL::to('jobNature')}}">
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
    $(document).on("submit", '#jobNatureUpdate', function (e) {
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
