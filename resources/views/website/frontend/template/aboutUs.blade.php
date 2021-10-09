@include('website.layouts.header')
<div class="page-title-container">
    <div class="container">
        <h2 class="page-title first-word"> {!! $targetArr->title ?? '' !!}</h2>
    </div>
</div>
<div class="main-content">
    <div class="container">
        <div class="row" style="padding-bottom: 30px;">
            <div class="col-md-12">
                @if(isset($targetArr->featured_image))
                <div class="featured-image p-f-img">
                    <img src="{{ asset('public/uploads/website/'.$targetArr->featured_image ?? '') }}" alt="featured image">
                </div>
                @endif
                @if(isset($targetArr->oc_image))
                <div class="featured-image p-f-img">
                    <img src="{{ asset('public/uploads/website/'. $targetArr->oc_image ?? '') }}" alt="OC image">
                </div>
                @endif
                <div class="post-content text-justify">
                    {!! $targetArr->content ?? '' !!}
                </div>
            </div>
        </div>
    </div>
</div>
@include('website.layouts.footer') 
