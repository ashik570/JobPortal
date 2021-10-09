@extends('layouts.default')
@section('content')
<div class="page-content">
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-clone"></i>@lang('english.CREATE_PUBLICATION_CATEGORY')
            </div>
        </div>
        <div class="portlet-body form">
            {!! Form::open(['group' => 'form', 'url' => 'catpublication','method'=>'post', 'class' => 'form-horizontal']) !!}
            {!! Form::hidden('filter', Helper::queryPageStr($qpArr)) !!}
            {{csrf_field()}}
            <div class="form-body">
                <div class="row">
                    <div class="col-md-offset-1 col-md-7">

                        <div class="form-group">
                            <label class="control-label col-md-4" for="name">@lang('english.NAME') :<span class="text-danger"> *</span></label>
                            <div class="col-md-8">
                                {!! Form::text('name', null, ['id'=> 'name', 'class' => 'form-control','autocomplete'=>'off']) !!} 
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4" for="orderId">@lang('english.ORDER') :<span class="text-danger">*</span>
                            </label>
                            <div class="col-md-8">
                                {!! Form::select('order_id',$orderList, $lastOrderNumber, ['id'=> 'orderId', 'class' => 'form-control js-source-states integer-only','autocomplete'=>'off']) !!}
                                <span class="text-danger">{{ $errors->first('order_id') }}</span>
                            </div>
                        </div>


                       
                        <div class="form-group">
                            <label class="control-label col-md-4" for="statusId">@lang('english.STATUS') :<span class="text-danger"> </span></label>
                            <div class="col-md-8">
                                {!!  Form::select('status_id', ['1' => 'Active', '0' => 'Inactive'],null,['id'=> 'statusId', 'class' => 'form-control']) !!} 
                                
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
                        <a href="{{ URL::to('/catpublication'.Helper::queryPageStr($qpArr)) }}" class="btn btn-circle btn-outline grey-salsa">@lang('english.CANCEL')</a>
                        
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>	
    </div>
</div>
@stop