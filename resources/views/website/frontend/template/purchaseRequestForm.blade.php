<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">@lang('english.PURCHASE_REQUEST')</h5>
    <button type="button" class="btn btn-danger" data-dismiss="modal">@lang('english.CLOSE')</button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-3">
            <div class="purchese-from-image">
                <?php
                $productImageArr = json_decode($productInfo->product_image, true);
                ?>
                <img width="100px" height="110px" src="{{URL::to('/')}}/public/uploads/website/product/{{ !empty(end($productImageArr)) ? end($productImageArr) : 'demo.jpg'  }}" alt = "D-Care"/>
            </div>
        </div>
        <div class="col-md-8">

            <div class="margin-top-10">
                <strong>{{ $productInfo->name??'' }}</strong>
            </div>
            <div class="margin-top-10">
                {!! $productInfo->product_info??'' !!}
            </div>
            <div class="purchese-regular-price">
                <p>@lang('english.REGULAR_PRICE') {{$productInfo->price}}  @lang('english.TK')</p>

                @if(!empty($productInfo->special_price))
                <p>@lang('english.SPECIAL_PRICE') {{$productInfo->special_price}}  @lang('english.TK')</p>
                @endif

            </div>
        </div>
        <div class="col-md-12">   
            <form class="" id="purchaseForm">
               
                <div class="row">
                    <div class="col-md-12">
                         {{Form::hidden('sum',$sum)}}
                         {{Form::hidden('product_id',$productInfo->id)}}
                        <label for="message-text" class="col-form-label"><strong>@lang('english.MESSAGE')</strong><span class="text-danger"> *</span></label>
                        <textarea class="form-control" id="message-text" name="message" required></textarea>
                        <span class="text-danger" id="message"></span>
                    </div>
                    <div class="col">
                        <label for="message-text" class="col-form-label"><strong>@lang('english.EMAIL')</strong><span class="text-danger"> *</span></label>
                        <input type="text" class="form-control" placeholder="abc@gmail.com" name="email" required>
                        <span class="text-danger" id="email"></span>
                    </div>
                    <div class="col">
                        <label for="message-text" class="col-form-label"><strong>@lang('english.PHONE')</strong><span class="text-danger"> *</span></label>
                        <input type="text" maxlength="11"  class="form-control integer-only" placeholder="01711XXXXXX" name="phone" required>
                        <span class="text-danger" id="phone"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="total_sum" class="col-md-1 col-form-label"><strong>{{$firstNumber}}+{{$secondNumber}}=</strong></label>
                    <div class="col-md-5">
                        <input type="text" maxlength="11"  class="form-control integer-only" placeholder="" name="total_sum" required>
                        <span class="text-danger" id="total_sum"></span>
                    </div>
                     <div class="col-md-5">
                    <button type="button" class="btn btn-success" id="btn-submit">@lang('english.SUBMIT')</button>
                     </div>
                </div>
                   
            </form>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal">@lang('english.CLOSE')</button>
</div>
<script type="text/javascript">
    $(function () {
        $(".integer-only").each(function () {
            $(this).keypress(function (e) {
                var code = e.charCode;
                if (((code >= 48) && (code <= 57)) || code == 0) {
                    return true;
                } else {
                    return false;
                }
            });
        });
    });
</script>