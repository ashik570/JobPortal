<div class="form-group">
    <label class="control-label col-md-4" for="orderId">@lang('english.ORDER') :</label>
    <div class="col-md-7">
        {!! Form::select('order_id', $orderList, null, ['id'=> 'orderId', 'class' => 'form-control js-source-states','autocomplete'=>'off']) !!}  
        <span class="text-danger">{{ $errors->first('order_id') }}</span>
    </div>
</div>