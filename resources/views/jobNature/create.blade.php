@extends('layouts.default')
@section('content')
<div class="page-content">

    @include('includes.flash')

    <div class="row">
        <div class="col-md-12">
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cubes"></i>{{trans('english.CREATE_NEW_JOB_NATURE')}} 
                    </div>
                    <div class="tools">

                    </div>
                </div>
                <div class="portlet-body form">

                    {{ Form::open(array('role' => 'form', 'url' => 'jobNature/store', 'class' => 'form-horizontal', 'id' => 'createJobNature')) }}
                    {!! Form::hidden('filter', Helper::queryPageStr($qpArr)) !!}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-7">

                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="name">{{trans('english.NAME')}} :<span class="required"> *</span></label>
                                    <div class="col-md-8">
                                        {{ Form::text('name', Request::get('name'), array('id'=> 'name', 'class' => 'form-control', 'required' => 'true')) }}
                                        <span class="help-block text-danger"> {{ $errors->first('name') }}</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-4" for="order">@lang('english.ORDER') :<span class="text-danger"> *</span></label>
                                    <div class="col-md-8">
                                        {!! Form::select('order_id', $orderList, $lastOrderNumber, ['id'=> 'orderId', 'class' => 'form-control js-source-states','autocomplete'=>'off']) !!}
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

                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).on("submit", '#createJobNature', function (e) {
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
//                        console.log("error");
                    }
                });
    });

    $("#nigotiable").change(function () {
        if (this.checked) {
            console.log("ok");
        }
    });


</script>
@stop

