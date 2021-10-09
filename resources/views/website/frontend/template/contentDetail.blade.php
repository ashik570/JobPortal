@include('website.layouts.header')

<div class="main-content post-detail">

    <div class="container mb-3" style="padding-bottom: 30px;">
        <div class="row">
            <div  class="col-md-12">
                <header class="page-head">
                    <h2 class="heading mt-3 color2 first-word">{{ $target->title }}</h2>
                    <hr class="small">
                </header>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <article>
                    <p>
                        {!! $target->description !!}
                    </p>
                </article>
            </div>
        </div>
        @if($target->upload_file != '')
        <div class="text-center load-more pull-left fullwidth mt-4">
            <a href="{{URL::to('/')}}/public/uploads/website/content/{{$target->upload_file}}" class="btn btn-primary btn-sm" download>DOWNLOAD <i class="arrow-down fa fa fa-download color"></i></a>
        </div>
        @endif
    </div>
</div>
@include('website.layouts.footer')
