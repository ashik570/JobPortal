@include('website.layouts.header')
<div class="page-title-container">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h2 class="page-title first-word"><span class="style-1"> {!! $albumInfo->title ?? '' !!}</span></h2>
            </div>
            <div class="col-md-4">
                <span class="breadcrumb-custom"><a href="{{URL::to('/').'/gallery-album'}}">@lang('english.ALBUM')</a> / {!! $albumInfo->title !!}</span>
            </div>
        </div>    
    </div>    
</div>
<div class="main-content">
    <div class="container">
        <div class="row equal" id="gallery">
            @if(!$targetArr->isEmpty())
            <ul class="list-unstyled lightgallery ">
                @foreach($targetArr as $gallery)
                <li class="col-lg-3 col-md-4 col-xs-6 gallery-list" data-responsive="{{asset('public/uploads/website/gallery/'.$gallery->photo)}} 375, {{asset('public/uploads/website/gallery/'.$gallery->photo)}} 480" data-src="{{asset('public/uploads/website/gallery/'.$gallery->photo)}}" data-sub-html="">
                    <img class="img-thumbnail"
                         src="{{ asset('public/uploads/website/gallery/'.$gallery->thumb) }}"
                         alt="{{$gallery->caption}}">
                </li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>
</div>
@include('website.layouts.footer')
