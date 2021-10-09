@include('website.layouts.header')
@include('website.frontend.template.home_banner')
@if(!empty($whoWeAre))
<section id="welcome" class="who-we-are">
    <div class="container">
        <div class="row">
            <div class="col-md-12 wellcome-txt">
                <h2 class="article-title">@lang('english.WHO_WE_ARE')</h2>
            </div>
        </div>
        <div class="row equal pb-5">
            <div class="col-md-12 whoWeAre">
                 {!! Helper::limitTextChars($whoWeAre->content, 600, (URL::to('/').'/who-we-are/'.$whoWeAre->slug)) !!}
            </div>
        </div>
    </div>
</section>
@endif



<section  id="atAGlance" class="at-a-glance">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="section-heading ourspeciality-heading first-word text-center">
                    @lang('english.OUR_SPECIALITY')
				</h2>
            </div>
        </div>
        <div class="row equal pb-5">
            <div class="owl-carousel at-a-glance-content">
                @if(!empty($ourSpecialty))
                @foreach($ourSpecialty as $ourSpecialtyData)
                <div class="item">
                    <div class="card">
                        <div class="card-heading text-center bg-none">
                            <div class="card-icon"><img src="{{asset('public/uploads/website/'.(!empty($ourSpecialtyData->featured_image) ? $ourSpecialtyData->featured_image : 'default-featured-img.png'))}}" alt="{!! $ourSpecialtyData->title !!}"></div>
                            <h5 class="card-title">{{ $ourSpecialtyData->title }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="article-text text-center">
                                {!! Helper::limitTextChars($ourSpecialtyData->content, 180, (URL::to('/').'/our-specialty/'.$ourSpecialtyData->slug)) !!}
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</section>
<section  id="majorCategories" class="major-categories">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="section-heading major-heading first-word text-center">
                    @lang('english.MAJOR_CATEGORIES')
				</h2>
            </div>
        </div>
      <div class="row equal">

                @if(!empty($majorCategories))
                <?php 
                $i = 0;
                $majorBgHeader[0] ='major-bg-header-0';
                $majorBgHeader[1] ='major-bg-header-1';
                $majorBgHeader[2] ='major-bg-header-2';
                ?>
                @foreach($majorCategories as $ourSpecialtyData)
                 <div class="col-md-4 ">
                <div class="item">
                    <div class="card major-block">
                        <div class="card-heading text-center bg-none">
                            <div class="card-icon major-herder {{$majorBgHeader[$i]??'major-bg-header-0'}}">{{ $ourSpecialtyData->title }}</div>
                         
                        </div>
                        <div class="card-body">
                            <div class="article-text text-center major-content">
                               {!! $ourSpecialtyData->content !!}
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                 <?php 
                $i++;
                ?>
                @endforeach
                @endif
            </div>
</section>
<section  id="businessSegments" class="businesssegments">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="section-heading ourspeciality-heading first-word text-center">
                    @lang('english.BUSINESS_SEGMENTS')
				</h2>
            </div>
        </div>
        <div class="aboutus-b animated">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <img class="officer_img" src="{{asset('public/uploads/website/businesssegments/'.(!empty($businessSegments->featured_image) ? $businessSegments->featured_image : 'default-oc-img.png'))}}" alt="featured image">
                    </div>
                </div>
            </div>
        </div>
</section>
<section id="affiliations" class="affiliations">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="section-heading affiliations-heading first-word text-center">
                    @lang('english.AFFILIATIONS_MEMBERSHIPS')
				</h2>
            </div>
        </div>
        <div class="row equal  pb-2">
            @if(!empty($affiliations))
            <div class="owl-carousel" id="affiliationCarousel">
                @php
                $i=0;
                @endphp
                @foreach($affiliations as $affiliation)
                <div class="item">
                    <div class="aff-item">
                        <a href="{{URL::to('/').'/affiliation-details/'.$affiliation->slug}}">
                            <div class="aff-featured-img">
                                <img src="{{asset('public/uploads/website/'.$affiliation->featured_image)}}" alt="Featured Image">
                            </div>
                            <div class="aff-text-content">
                                <!--<span class="text-center affiliationTitle">{{ $affiliation->title }}</span>-->
                            </div>
                        </a>
                    </div>
                </div>
                @php
                $i++;
                @endphp
                @endforeach
            </div>
            @endif
        </div>
    </div>
</section>


<div class="gallery" id="gallery">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="section-heading gallery-heading first-word text-center">
                    @lang('english.OUR_GALLERY')
				</h2>
            </div>
        </div>
        <div class="row equal">
            @if(!$galleryArr->isEmpty())
            <ul class="list-unstyled lightgallery ">
                @foreach($galleryArr as $gallery)
                <li class="col-lg-3 col-md-4 col-xs-6 col-sm-6 gallery-list" data-responsive="{{asset('public/uploads/website/gallery/'.$gallery->photo)}} 375, {{asset('public/uploads/website/gallery/'.$gallery->photo)}} 480" data-src="{{asset('public/uploads/website/gallery/'.$gallery->photo)}}" data-sub-html="">
                    <img class="img-thumbnail gallery-thumbnail"
                         src="{{ asset('public/uploads/website/gallery/'.$gallery->thumb) }}"
                         alt="{{$gallery->caption}}">
                </li>
                @endforeach
            </ul>

            @endif
        </div>
    </div>
</div>

@if(!$statistics->isEmpty())

<div class="statistics" id="statistics">
    <div class="container">
        <div class="row equal margin-buttom-20">
            <?php
            $i = 1;
            $bg[1] = 'bg-1';
            $bg[2] = 'bg-2';
            $bg[3] = 'bg-3';
            $bg[4] = 'bg-4';
            ?>
            @foreach($statistics as $static)
            <div class="col-md-3 col-xs-6 col-sm-6 stat_item">
                <div class="dot {!!$bg[$i]??''!!} rounded dot-border-1 margin-bottom-10">
                    <div class="text-center textStatistic">
                        <span class="bold text-center number" data-counter="counterup" data-value="177" style="display:block;">  {{$static->quantity }}</span>
                        <span class="bold text-center"> {{$static->title }}</span>
                    </div>
                </div>

            </div>
            <?php
            $i++;
            ?>
            @endforeach

        </div>
    </div>
</div>
@endif
<section id="newsAndEvent" class="news-and-events">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="section-heading newsEvents-heading first-word text-center style-2">@lang('english.LATEST_NEWS_EVENTS')</h2>
            </div>
        </div>
        <div class="row">
            @if(!$newsAndEvents->isEmpty())
            @foreach($newsAndEvents as $post)
            <div class="col-md-4 col-lg-4 col-sm-6 pb-2">
                <div class="news-events-content">
                    @if(!empty($post->featured_image))
                    <div class="featured-image">
                        <a class="" href="{{ URL::to('/') }}/news-and-events/{{ $post->slug }}"><img class="img-responsive" src="{{asset('public/uploads/website/NewsAndEvents/'.$post->featured_image)}}" alt="featured image"></a>
                    </div>
                    @endif
                    <h3 class="p-title"><a class="" href="{{ URL::to('/') }}/news-and-events/{{ $post->slug }}">{!! $post->title !!}</a></h3>
                    <div class="post-date"><i class="fa fa-calendar"></i>{{ Helper::formatDateTimeForPost($post->created_at) }} </div>
                    <p class="post-text">
                        {!! Helper::limitTextWords($post->content, 20, (URL::to('/').'/news-and-events/'.$post->slug)) !!}
                    </p>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</section>

<div class="dysin-map">
    <iframe src="@lang('english.GMAP_URL')" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
</div>
<script src="{{asset('public/js/website/waypoint.js')}}" type="text/javascript"></script>

@section('page-script')
<script>
    $(document).ready(function () {
        $('.at-a-glance-content').owlCarousel({
            loop: true,
            autoplay: true,
            margin: 30,
            nav: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    nav: true,
                    loop: true
                },
                600: {
                    items: 3,
                    nav: true,
                    loop: true
                },
                1000: {
                    items: 4,
                    nav: true,
                    loop: true
                }
            }
        });
        $('#ourPrograms').owlCarousel({
            loop: true,
            autoplay: true,
            margin: 30,
            nav: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    nav: true,
                    loop: true
                },
                600: {
                    items: 3,
                    nav: true,
                    loop: true
                },
                1000: {
                    items: 4,
                    nav: true,
                    loop: true
                }
            }
        });

        $('#affiliationCarousel').owlCarousel({
            loop: true,
            autoplay: true,
            margin: 30,
            nav: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    nav: true,
                    loop: true
                },
                600: {
                    items: 4,
                    nav: true,
                    loop: true
                },
                1000: {
                    items: 6,
                    nav: true,
                    loop: true
                }
            }
        });
    });


</script>
@endsection
@include('website.layouts.footer')
