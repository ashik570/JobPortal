@include('website.layouts.header')
<!-- gallery section -->
<section id="gallery" class="bg-blue-oleo bg-font-blue-oleo">

    <div class="container">
        <div class="row">
            <div  class="col-sm-12 col-md-12 col-xs-12">
                <h1  id="title" class="middle-heading">{{trans('english.PHOTO_GALLERY')}}</h1>
            </div>

            <div class="bacco-gallery col-xs-12 col-sm-12 col-md-12">
                <ul id="lightgallery" class="list-unstyled row">
                    @if(!empty($galleryArr))
                    @foreach($galleryArr as $gallery)
                    @if ($gallery->status == 'active')
                    <li data-responsive="{{URL::to('/')}}/public/uploads/gallery/originalImage/{{$gallery->photo}} 375, {{URL::to('/')}}/public/uploads/gallery/originalImage/{{$gallery->photo}} 480" data-src="{{URL::to('/')}}/public/uploads/gallery/originalImage/{{$gallery->photo}}" data-sub-html="">
                        <img src="{{URL::to('/')}}/public/uploads/gallery/thumb/{{$gallery->thumb}}" id="galleryimg" width="100%" />
                    </li>
                    @endif
                    @endforeach
                    @else
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                        <p><i class="fa fa-bell-o fa-fw"></i>{{trans('english.NO_PHOTO_AT_GALLERY')}}</p>
                    </div>
                    @endif
                </ul>


            </div>
        </div>
        <div class="row">
            <div class="col-md-5 col-sm-5">
                <div class="dataTables_info" role="status" aria-live="polite">
                    Showing {{($galleryArr->getCurrentPage()-1)*$galleryArr->getPerPage()+1}} to {{$galleryArr->getCurrentPage()*$galleryArr->getPerPage()}}
                    of  {{$galleryArr->getTotal()}} records
                </div>
            </div>
            <div class="col-md-7 col-sm-7">
                {{ $galleryArr->appends(Request::all())->links()}}
            </div>
        </div>
    </div>
</section>
@include('website.layouts.footer')
<!-- end gallery section -->
