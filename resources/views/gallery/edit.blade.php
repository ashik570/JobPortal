@extends('layouts.default')
@section('content')
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-road"></i>@lang('english.UPDATE_GALLERY_PHOTO')
            </div>
        </div>
        <div class="portlet-body form">
            {!! Form::model($target, ['route' => array('gallery.update', $target->id), 'method' => 'PATCH', 'files'=> true, 'class' => 'form-horizontal'] ) !!}
            {!! Form::hidden('filter', Helper::queryPageStr($qpArr)) !!}
            {{csrf_field()}}
            <div class="form-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label col-md-3" for="caption">@lang('english.CAPTION') :<span class="text-danger"> *</span></label>
                            <div class="col-md-5">
                                {!! Form::text('caption', null, ['id'=> 'caption', 'class' => 'form-control','autocomplete'=>'off']) !!} 
                                <span class="text-danger">{{ $errors->first('caption') }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" for="albumId">@lang('english.ALBUM') :<span class="text-danger"> *</span></label>
                            <div class="col-md-5">
                                {!! Form::select('album_id', $albumList, null, ['id'=> 'albumId', 'class' => 'form-control js-source-states','autocomplete'=>'off']) !!}
                                <span class="text-danger">{{ $errors->first('album_id') }}</span>
                            </div>
                        </div>
                        
                        
                        
                        <div class="form-group last">
                            <label class="control-label col-md-3">@lang('english.GALLERY_IMAGE') :<span class="text-danger"> *</span></label>
                            <div class="col-md-9">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                        @if(!empty($target->photo))
                                        <img src="{{URL::to('/')}}/public/uploads/website/gallery/{{ $target->photo }}" alt=""/>
                                        @else
                                        <img src="{{URL::to('/')}}/public/img/no-image.png" alt=""> 
                                        @endif
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                    <div>
                                        <span class="btn default btn-file">
                                            <span class="fileinput-new"> Select image </span>
                                            <span class="fileinput-exists"> Change </span>
                                            <input type="file" name="gallery_img"> </span>
                                        <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                        <div class=""><span class="text-danger">{{ $errors->first('gallery_img') }}</span></div>
                                    </div>
                                </div>
                                <div class="clearfix margin-top-10">
                                    <span class="label label-danger">@lang('english.NOTE')</span> @lang('english.ACCEPTED_IMAGE_FORMATE_jpg_png_jpeg_gif')
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3" for="userName">@lang('english.ORDER') :<span class="text-danger"> *</span></label>
                            <div class="col-md-5">
                                {!! Form::select('order_id', $orderList, $target->order, ['id'=> 'order_id', 'class' => 'form-control js-source-states','autocomplete'=>'off']) !!}
                                <span class="text-danger">{{ $errors->first('order_id') }}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3" for="statusId">@lang('english.STATUS') :</label>
                            <div class="col-md-5">
                                {!! Form::select('status_id', ['1' => __('english.ACTIVE'), '0' => __('english.INACTIVE')], '1', ['class' => 'form-control', 'id' => 'statusId']) !!}
                                <span class="text-danger">{{ $errors->first('status') }}</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-4 col-md-8">
                        <button class="btn btn-circle green" type="submit" name="submit">
                            <i class="fa fa-check"></i> @lang('english.SUBMIT')
                        </button>
                        <a href="{{ URL::to('/gallery'.Helper::queryPageStr($qpArr)) }}" class="btn btn-circle btn-outline grey-salsa">@lang('english.CANCEL')</a>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>	
    </div>
</div>


<script type="text/javascript">

        $(document).on("click", '#featuredImage', function (e) {
            $(".cv").hide();
        });
        //Added for Cropper use for CoverPhoto
        let result2 = document.querySelector('.result-sign'),
        sign_w = document.querySelector('.sign-w'),
        options2 = document.querySelector('.options2'),
        crop2 = document.querySelector('.crop2'),
        cropped2 = document.querySelector('.cropped2'),
        upload2 = document.querySelector('#featuredImage'),
        cropper2 = '';
        var fileTypes2 = ['jpg', 'jpeg', 'png', 'gif'];
        // on change show image with crop options
        upload2.addEventListener('change', function (f) {

        if (f.target.files.length) {
        // start file reader
        const reader2 = new FileReader();
                var file2 = f.target.files[0]; // Get your file here
                var fileExt2 = file2.type.split('/')[1]; // Get the file extension
                if (fileTypes2.indexOf(fileExt2) !== - 1) {
        reader2.onload = function (f) {
//                    console.log(f.target.result);
        if (f.target.result) {
        // create new image
        let img = document.createElement('img');
                img.id = 'sign';
                img.src = f.target.result
                // clean result before
                result2.innerHTML = '';
                // append new image
                result2.appendChild(img);
                // show crop btn and options
                crop2.classList.remove('hide');
                options2.classList.remove('hide');
                // init cropper2
                cropper2 = new Cropper(img, {
                aspectRatio: 40/25,
                        quality: 1,
                        imageSmoothingQuality : 'high',
                });
        }
        };
                reader2.readAsDataURL(file2);
        } else {
        alert('File not supported');
                return false;
        }
        }
        });
        // crop on click
        crop2.addEventListener('click', function (f) {
        f.preventDefault();
                // get result to data uri
                let imgSrc = cropper2.getCroppedCanvas({
                width: sign_w.value // input value
                }).toDataURL();
                // remove hide class of img
                cropped2.classList.remove('hide');
                // show image cropped
                cropped2.src = imgSrc;
                $('#cropImg2').val(imgSrc);
        });
//crop sign end   
</script>
@stop