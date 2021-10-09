<div class="modal-content">
    <div class="modal-header">
        <div class="col-md-6">
            <h5 class="modal-title" id="orderModalLabel">@lang('english.SET_PAYMENT_STATUS')</h5> 
        </div>
        <div class="col-md-6">
            <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">@lang('english.CLOSE')</button>
        </div>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">   
                <form class="" id="paymentForm">
                      {{ Form::hidden('purchase_request_id',$purchaseRequesrId) }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label col-md-4" for="paymentStatus">@lang('english.SELECT_ORDER_STATUS'):</label>
                                <div class="col-md-6">
                                    {!! Form::select('payment_status',$paymentStatus,$target->payment_status, ['class' => 'form-control js-source-states','id'=>'paymentStatus']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal-footer">
       
        <button type="button" class="btn btn-danger" data-dismiss="modal">@lang('english.CLOSE')</button>
        <button type="button" class="btn btn-success" id="btn-submit-payment">@lang('english.SUBMIT')</button>
    </div>
</div>
<script type="text/javascript">
    $(function () {
    });
</script>