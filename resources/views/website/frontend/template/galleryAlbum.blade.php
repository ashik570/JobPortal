@include('website.layouts.header')
<div class="page-title-container">
    <div class="container">
        <h2 class="page-title first-word"> @lang('english.ALBUM') </h2>
    </div>
</div>
<div class="main-content">
    <div class="container">
        <div class="row">
            @if(!$targetArr->isEmpty())
                @foreach($targetArr as $target)
                <div class="col-md-3">
                    <a class="album-item" href="{{ URL::to('/').'/galleryweb/'.$target->slug }}">
                        @if(!empty($target->cover_photo))
                            <img src="{{ asset('public/uploads/website/gallery/album/'. $target->cover_photo) }}" alt="">
                        @else
                            <img src="{{ asset('public/uploads/website/gallery/album/demo-cover-photo.png') }}" alt="">
                        @endif

                        @if(!empty($target->title))
                        <h3 class="album-caption"><span>{{ $target->title ?? '' }}</span></h3>
                        @endif
                    </a>
                </div>
                @endforeach
            @endif

        </div>
    </div>
</div>
@include('website.layouts.footer')
