@include('website.layouts.header')

<section  id="productDetails" class="product-details">
    <div class="container" style="padding-bottom: 30px;">
        <div class="row">

            <div class="col-md-3">

                <?php
                $productImageArr = json_decode($productInfo->product_image, true);
                ?>
                <div id="img-container">
                    <img class="add-main-image" src="{{URL::to('/')}}/public/uploads/website/product/{{ !empty(end($productImageArr)) ? end($productImageArr) : 'demo.jpg'  }}"  alt="">
                </div>

                <ul class="piclist">
                    @foreach($productImageArr as $productName)
                    <li><img src="{{URL::to('/')}}/public/uploads/website/product/{{$productName}}" alt=""></li>
                    @endforeach
                </ul>
            </div>


            <div class="col-md-9 details-div">

                <div class="product-details-info">
                    {{$productInfo->product_info}}
                    <br/>
                </div>
                <div class="regular-price">
                    <p>@lang('english.REGULAR_PRICE') {{$productInfo->price}}  @lang('english.TK')</p>
                    @if(!empty($productInfo->special_price))
                    <p>@lang('english.SPECIAL_PRICE') {{$productInfo->special_price}}  @lang('english.TK')</p>
                    @endif
                </div>
                <div class="product-details-description">
                    {!!$productInfo->description!!}
                </div>
                <div class="purchese-request">
                    <button class="btn btn-success" id="purchaseRequest"  data-product-id="{{$productInfo->id??0}}" data-toggle="modal" data-target="#exampleModal">@lang('english.PURCHASE_REQUEST')</button>
                    <div class="alert alert-success alert-dismissable" id="showSuccessMsg" style="display: none;margin: 15px 0px 0px 0px">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                        <div id="successMsg"><i class="fa fa-bell-o fa-fw"></i></p>
                        </div>
                    </div>
                </div>


            </div>
        </div>

    </div>
</section>


<section  id="productCategories" class="product-details-categories">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4 class="section-heading related-hedding first-word">
                    @lang('english.RELATED_PRODUCTS')
                </h4>
            </div>
        </div>
        <div class="row equal">

            @if(!$productArr->isEmpty())
            @foreach($productArr as $product)
            <div class="col-md-2">
                <div class="item">
                    <a href="{{URL::to('/').'/product-details/'}}{{$product->id}}">
                        <div class="card product-details-block">
                            <div class="card-heading text-center bg-none">
                                <div class="product-image">
                                    <?php
                                    $productImageArr = json_decode($product->product_image, true);
                                    ?>
                                    <img width="100%" src="{{URL::to('/')}}/public/uploads/website/product/{{ !empty(end($productImageArr)) ? end($productImageArr) : 'demo.jpg'  }}" alt = "D-Care"/>
                                </div>

                            </div>
                            <div class="card-body">

                                <div class="text-center product-details-name">
                                    {{ $product->name??'' }}
                                </div>
                                <div class="text-center product-details-content">
                                    {!! $product->product_info??'' !!}
                                </div>
                                <div class="text-center product-details-price-dcare">
                                    @if(!empty($product->check_special_price))
                                    <del> @lang('english.TK').{!! $product->price??'' !!}</del>
                                    @lang('english.TK').{!! $product->special_price??'' !!}
                                    @else
                                    @lang('english.TK').{!! $product->price??'' !!}
                                    @endif
                                </div>

                            </div>
                        </div>
                    </a>    
                </div>
            </div>
            @endforeach
            @endif
        </div>
</section>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div id="showPurchesRequst">

            </div>
        </div>
    </div>
</div>
@include('website.layouts.footer')
<script src="{{asset('public/js/js-image-zoom.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    $(function () {

        $(document).on('click', '#purchaseRequest', function (e) {
            e.preventDefault();

            var productId = $(this).attr("data-product-id");

            $.ajax({
                url: "{!! URL::to('purchase-request') !!}",
                type: "POST",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    product_id: productId,
                },
                success: function (res) {
                    $('#showPurchesRequst').html(res.html);

                },
                error: function (jqXhr, ajaxOptions, thrownError) {

                }
            });
        });
        $(document).on("click", "#btn-submit", function () {
            $("#btn-submit").attr("disabled", true);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var options = {
                closeButton: true,
                debug: false,
                positionClass: "toast-bottom-right",
                onclick: null,
            };

            var formData = new FormData($("#purchaseForm")[0]);
            $.ajax({
                url: "{{ URL::to('purchase-request-save')}}",
                type: "POST",
                dataType: 'json', // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                beforeSend: function () {
                    // App.blockUI({boxed: true});
                },
                success: function (res) {
                    $('#successMsg').html(res.message);
                    $('#showSuccessMsg').show();
                    $('#exampleModal').modal('toggle');
                    $('body').scrollTop(0);
                },
                error: function (jqXhr, ajaxOptions, thrownError) {
                    if (jqXhr.status == 400) {
                        var errorsHtml = '';
                        var errors = jqXhr.responseJSON.message;
                        $.each(errors, function (key, value) {
                            errorsHtml += '<li>' + key + '</li>';
                            $("#" + key).html(value[0]);
                        });

                    }
                    $("#btn-submit").attr("disabled", false);
                }
            }); //ajax
        });


        $('.piclist li').on('click', function (event) {
            var $pic = $(this).find('img');
            $('.add-main-image').attr('src', $pic.attr('src'));
            $(".js-image-zoom__zoomed-image").css("background-image", "url(" + $pic.attr('src') + ")");
        });


    });

    var options1 = {
        width: 400,
        zoomWidth: 500,
        offset: {vertical: 0, horizontal: 10}
    };

    // If the width and height of the image are not known or to adjust the image to the container of it
    var options2 = {};
    new ImageZoom(document.getElementById("img-container"), options2);

</script>