@include('website.layouts.header')

<div class="main-content">
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="page-title-container">
                    <h2 class="article-title first-word mt-15 mb-15 text-center pt-15"> </h2>
                </div>
                @if(!$targetArr->isEmpty())
                <div class="row pt-15">
                    @foreach($targetArr as $target)
                    <div class="col-md-2 col-sm-3 col-sx-4">
                        <a href="{{ asset('public/uploads/website/publication/upload_file/'.$target->upload_file) }}" class="pfile" download data-toggle="tooltip" data-placement="top" title="@lang('english.DOWNLOAD')">
                            <img src="{{ asset('public/uploads/website/publication/'.$target->image) }}" alt="{{$target->image??''}}" height="160" width="225">
                            <h3 class="pbl-title">{!! $target->title ?? '' !!}</h3>
                        </a>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>

@include('website.layouts.footer')
