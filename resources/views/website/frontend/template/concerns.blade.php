@include('website.layouts.header')
<div class="container-fluid no-gutters_cz">
    <div class="row no-gutters">
        <div class="col-xl-12 col-xxl-12">
            <div class="intro-slider-container slider-container-ratio mb-2">
                <div class="intro-slider owl-carousel owl-simple owl-nav-inside" data-toggle="owl" data-owl-options='{
                     "nav": false,
                     "dots": true,
                     "autoplay": true
                     }'>
                    @if(!$slider->isEmpty())
                    @foreach($slider as $slide)
                    <div class="intro-slide">
                        <div class="slide">
                            <img width="100%" src="{{URL::to('/')}}/public/uploads/website/programGallery/{{ !empty($slide->image) ? $slide->image : 'demo_slide.jpg'  }}" alt = "D-Care"/>
                        </div>

                    </div><!-- End .intro-slide -->
                    @endforeach
                    @endif
                </div><!-- End .intro-slider owl-carousel owl-simple -->

                <span class="slider-loader"></span><!-- End .slider-loader -->
            </div><!-- End .intro-slider-container -->
        </div><!-- End .col-xl-9 col-xxl-10 -->

    </div><!-- End .row -->
</div><!-- End .container-fluid -->


<!--end banner section -->
<section  id="welcomeDcare" class="welcome-dcare">
    <div class="page-title-container">
        <div class="container">
            <h4 class="page-title welcome-dcare-hedding first-word"> {!! $welcomeInfo->title ?? '' !!}</h4>
        </div>
    </div>
    <div class="main-content">
        <div class="container">
            <div class="row" style="padding-bottom: 30px;">
                <div class="col-md-12">
                    <div class="post-content text-justify">
                        {!! $welcomeInfo->content ?? '' !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section  id="productCategories" class="product-categories">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4 class="section-heading welcome-dcare-hedding first-word">
                    @lang('english.OUR_PRODUCTS')
                </h4>
            </div>
        </div>
        <div class="row equal">

            @if(!$productArr->isEmpty())
            @foreach($productArr as $product)
            <div class="col-md-3 ">
                <div class="item">
                    <a href="{{URL::to('/').'/product-details/'}}{{$product->id}}">
                        <div class="card product-block">
                            <div class="card-heading text-center bg-none">
                                <div class="product-image">
                                    <?php
                                    $productImageArr = json_decode($product->product_image, true);
                                    ?>
                                    <img width="100%" src="{{URL::to('/')}}/public/uploads/website/product/{{ !empty(end($productImageArr)) ? end($productImageArr) : 'demo.jpg'  }}" alt = "D-Care"/>
                                </div>

                            </div>
                            <div class="card-body">

                                <div class="text-center product-name">
                                    {{ $product->name??'' }}
                                </div>
                                <div class="text-center product-content">
                                    {!! $product->product_info??'' !!}
                                </div>
                                <div class="text-center product-price-dcare">
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
@include('website.layouts.footer')
