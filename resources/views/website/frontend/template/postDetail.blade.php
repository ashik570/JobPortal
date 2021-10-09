@include('website.layouts.header')

<div class="main-content post-detail">
    <div class="page-title-container">
    <div class="container">
        <h2 class="article-title first-word">{!! $postDetail->title ?? '' !!}</h2>
		<hr class="small">
        <div class="post-date"><i class="fa fa-calendar"></i>{{ Helper::formatDateTimeForPost($postDetail->created_at) }} </div>
    </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if(isset($postDetail->featured_image))
                <div class="featured-image pull-left col-md-4">
                    <img src="{{ asset('public/uploads/website/NewsAndEvents/'.$postDetail->featured_image ?? 'demo-featured-img.png') }}" alt="featured image">
                </div>
                @endif
                <div class="post-content text-justify">
                    {!! $postDetail->content ?? '' !!}
                </div>
            </div>
            <div class="col-md-12 pb-15 text-center mt-15">
                @if(!empty(Helper::prevPost('news_and_events', $postDetail->order)))                
				<a class="btn btn-md btn-info" href="{!! URL::to('/').'/news-and-events/'. Helper::prevPost('news_and_events', $postDetail->order)->slug !!}"><i class="fa fa-backward"></i>{{trans('english.PREV')}}</a>
                @endif
                @if(!empty(Helper::nextPost('news_and_events', $postDetail->order)))
                <a class="btn btn-md btn-info" href="{!! URL::to('/').'/news-and-events/'. Helper::nextPost('news_and_events', $postDetail->order)->slug !!}">{{trans('english.NEXT')}} <i class="fa fa-forward"></i></a>
				
                @endif
            </div>
        </div>
    </div>
</div>
@include('website.layouts.footer')
