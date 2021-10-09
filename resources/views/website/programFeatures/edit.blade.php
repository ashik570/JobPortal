@extends('layouts.default')
@section('content')
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-road"></i>@lang('english.UPDATE_FEATURE')
            </div>
        </div>
        <div class="portlet-body form">
            {!! Form::model($target, ['url' => 'programFeatures/update', 'method' => 'POST', 'files'=> true, 'class' => 'form-horizontal'] ) !!}
            
            {{csrf_field()}}
            {!! Form::hidden('id', $target->id) !!}
            {!! Form::hidden('program_id', $target->program_id) !!}
            <div class="form-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label col-md-3" for="title">@lang('english.TITLE') :</label>
                            <div class="col-md-7">
                                {!! Form::text('title', null, ['id'=> 'title', 'class' => 'form-control','autocomplete'=>'off']) !!}
                                <span class="text-danger">{{ $errors->first('title') }}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3" for="featureType">@lang('english.FEATURE_TYPE') :<span class="text-danger"> *</span></label>
                            
                            <div class="col-md-5">
                                {!! Form::select('feature_type', ['1'=>'Content','2'=>'Course Module', '3'=>'Faculty', '4'=>'Archive', '5'=>'COAS TROPHY'], $target->feature_type, ['id'=> 'featureType', 'class' => 'form-control js-source-states','autocomplete'=>'off']) !!}
                                <span class="text-danger">{{ $errors->first('feature_type') }}</span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-3" for="orderId">@lang('english.CONTENT') :<span class="text-danger"> *</span></label>
                            <div class="col-md-9">
                                {{ Form::textarea('content', !empty($target->content) ? $target->content : null, ['class' => 'form-control summernote','size' => '50x5','id'=>'content']) }}                         
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" for="orderId">@lang('english.ORDER') :<span class="text-danger"> *</span></label>
                            <div class="col-md-8">
                                {!! Form::select('order', $orderList, $target->order, ['id'=> 'orderId', 'class' => 'form-control js-source-states','autocomplete'=>'off']) !!}
                                <span class="text-danger">{{ $errors->first('order') }}</span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-3" for="status">@lang('english.STATUS') :<span class="text-danger"> *</span></label>
                            <div class="col-md-8">
                                {!! Form::select('status_id', array('1' => 'Active', '0' => 'Inactive'), Request::old('status_id'), ['class' => 'form-control', 'id' => 'status']) !!}
                                
                                <span class="text-danger">{{ $errors->first('status_id') }}</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-4 col-md-8">
                        <button class="btn btn-circle green" type="submit">
                            <i class="fa fa-check"></i> @lang('english.SUBMIT')
                        </button>
                        <a href="{{ URL::to('/ourPrograms'.Helper::queryPageStr($qpArr)) }}" class="btn btn-circle btn-outline grey-salsa">@lang('english.CANCEL')</a>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>	
    </div>
</div>


<link href="{{asset('public/assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
 <script src="{{asset('public/assets/pages/scripts/components-editors.min.js')}}" type="text/javascript"></script>
 <script src="{{asset('public/assets/global/plugins/bootstrap-summernote/summernote.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('.summernote').summernote({
       lineHeights: ['0.2', '0.3', '0.4', '0.5', '0.6', '0.8', '1.0', '1.2', '1.4', '1.5', '2.0', '3.0']
    });
});
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
    var fileTypes2 = ['jpg', 'jpeg', 'png' , 'gif'];
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
            cropper2 = new Cropper(img,{
                aspectRatio: 40 / 20,
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