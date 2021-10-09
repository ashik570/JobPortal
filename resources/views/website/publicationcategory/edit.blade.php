@extends('layouts.default')
@section('content')
<div class="page-content">
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-clone"></i>@lang('english.UPDATE_PUBLICATION_CATEGORY')
            </div>
        </div>
        <div class="portlet-body form">
            {!! Form::model($target, ['route' => array('catpublication.update', $target->id), 'method' => 'PATCH', 'class' => 'form-horizontal'] ) !!}
            {!! Form::hidden('filter', Helper::queryPageStr($qpArr)) !!}
            {{csrf_field()}}
            <div class="form-body">
                <div class="row">
                    <div class="col-md-offset-1 col-md-7">

                        <div class="form-group">
                            <label class="control-label col-md-4" for="name">@lang('english.NAME') :<span class="text-danger"> *</span></label>
                            <div class="col-md-8">
                               {!! Form::text('name',null , ['id'=> 'name', 'class' => 'form-control','autocomplete'=>'off']) !!} 
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4" for="groupId">@lang('english.ORDER') :<span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                {!! Form::select('order',$orderList, $target->order, ['id'=> 'order', 'class' => 'form-control js-source-states  integer-only','autocomplete'=>'off']) !!}
                                <span class="text-danger">{{ $errors->first('order') }}</span>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="control-label col-md-4" for="statusId">@lang('english.STATUS') :</label>
                            <div class="col-md-8">
                                {!! Form::select('status_id', ['1' => __('english.ACTIVE'), '2' => __('english.INACTIVE')], null, ['class' => 'form-control', 'id' => 'statusId']) !!}
                                <span class="text-danger">{{ $errors->first('status_id') }}</span>
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
                        <a href="{{ URL::to('/catpublication'.Helper::queryPageStr($qpArr)) }}" class="btn btn-circle btn-outline grey-salsa">@lang('english.CANCEL')</a>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>	
    </div>
</div>
@stop