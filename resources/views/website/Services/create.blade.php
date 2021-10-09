@extends('layouts.default')
@section('content')
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-road"></i>@lang('english.CREATE_SERVICES') 
            </div>
        </div>
        <div class="portlet-body form">
            {!! Form::open(array('group' => 'form', 'url' => 'services', 'files'=> true, 'class' => 'form-horizontal')) !!}
            {!! Form::hidden('filter', Helper::queryPageStr($qpArr)) !!}
            {{csrf_field()}}
            <div class="form-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label col-md-3" for="title">@lang('english.TITLE') :<span class="text-danger"> *</span></label>
                            <div class="col-md-5">
                                {!! Form::text('title', null, ['id'=> 'title', 'class' => 'form-control','autocomplete'=>'off']) !!} 
                                <span class="text-danger">{{ $errors->first('title') }}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3" for="image">@lang('english.FEATURED_IMAGE') :<span class="text-danger"> *</span></label>
                            <div class="col-md-7">
                                <div class="cv">
                                    <img src="{{URL::to('/')}}/public/img/no-image.png" alt=""/>
                                </div>
                                <!-- input file -->
                                <div class="box mt-10">
                                    <input type="file" name="featured_image" id="featuredImage">
                                    <span class="text-danger">{{ $errors->first('featured_image') }}</span>
                                    <div class="clearfix margin-top-10">
                                        <span class="label label-danger">@lang('english.NOTE')</span> @lang('english.ACCEPTED_IMAGE_FORMATE_jpg_png_jpeg_gif')
                                    </div>
                                </div>				
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-4">
                                <!-- leftbox -->
                                <div class="result-sign"></div>
                                <!-- crop btn -->
                                <button class="c-btn crop2 btn red mt-ladda-btn ladda-button btn-circle hide" type="button">@lang('english.CROP')</button>
                            </div>

                            <div class="col-md-4">
                                <div class="col-md-offset-1">
                                    <!-- input file -->
                                    <img class="cropped2 view-image" src="" alt="">
                                    <input type="hidden" name="croped_image" id="cropImg2" value="">
                                </div>
                                <div class="box">
                                    <div class="options2 hide">
                                        <input type="hidden" class="sign-w" value="300" min="80" max="1200" />
                                    </div>
                                </div>
                            </div>			
                        </div>



                        <div class="form-group">
                            
                            
                            <style>

                                .image_area {
                                    position: relative;
                                }

                                img {
                                    display: block;
                                    max-width: 100%;
                                }

                                .preview {
                                    overflow: hidden;
                                    width: 160px; 
                                    height: 160px;
                                    margin: 10px;
                                    border: 1px solid red;
                                }

                                

                            </style>
                            <!-- <div class="form-group">
                                <div class="row">
                                    <label class="control-label col-md-3" for="image">@lang('english.FEATURED_ICON') :<span class="text-danger"> *</span></label>
                                    <div class="col-md-4">
                                        <div class="image_area">
                                            <label for="upload_image">
                                                <input type="file" name="icon_image" class="image" id="upload_image" />
                                                <input type="hidden" name="cropped_icon" class="cropped-icon" />
                                            </label>
                                        </div>
                                    </div>
                                    <br style="clear:both">
                                    <label class="control-label col-md-3">&nbsp;</label>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="preview2" style="margin-bottom:15px;">
                                                <img src="" class="prv-img">
                                            </div> 
                                        </div> 
                                    </div>
                                    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Crop Image Before Upload</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="img-container">
                                                        <div class="row">
                                                            <div class="col-md-8">
                                                                <img src="" id="sample_image" />
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="preview"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" id="crop" class="btn btn-primary">Crop</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>			
                                </div>
                            </div> -->


                            <div class="form-group">
                                <label class="control-label col-md-3">{{trans('english.CONTENT')}} :</label>
                                <div class="col-md-9">
                                    {{ Form::textarea('content', null, ['class' => 'form-control summernote_1','size' => '50x5','id'=>'content']) }}                         
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3" for="userName">@lang('english.ORDER') :<span class="text-danger"> *</span></label>
                                <div class="col-md-5">
                                    {!! Form::select('order_id', $orderList, $lastOrderNumber, ['id'=> 'order_id', 'class' => 'form-control js-source-states','autocomplete'=>'off']) !!}
                                    <span class="text-danger">{{ $errors->first('order') }}</span>
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
                            <a href="{{ URL::to('/services'.Helper::queryPageStr($qpArr)) }}" class="btn btn-circle btn-outline grey-salsa">@lang('english.CANCEL')</a>
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
    //          console.log(f.target.result);
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
                    aspectRatio: 40/20,
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


$(document).ready(function() {
    var $modal = $('#modal');
    var image = document.getElementById('sample_image');
    var cropper;
    $('#upload_image').change(function(event) {
        var files = event.target.files;
        var done = function(url) {
            image.src = url;
            $modal.modal('show');
            $('.modal-backdrop').hide();
        };
        if (files && files.length > 0) {
            reader = new FileReader();
            reader.onload = function(event) {
                done(reader.result);
            };
            reader.readAsDataURL(files[0]);
        }
    });
    $modal.on('shown.bs.modal', function() {
        cropper = new Cropper(image, {
            aspectRatio: 1,
            viewMode: 2,
            preview: '.preview'
        });
    }).on('hidden.bs.modal', function() {
        cropper.destroy();
        cropper = null;
    });
    $('#crop').click(function() {
        canvas = cropper.getCroppedCanvas({
            width: 2000,
            height: 2000,
        });
        canvas.toBlob(function(blob) {
            url = URL.createObjectURL(blob);
            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function() {
                var base64data = reader.result;
                $('.prv-img').attr("src", base64data);
                $('.cropped-icon').val(base64data);
                $modal.modal('hide');
                $('#upload_image').replaceWith( $("#upload_image").val('').clone( true ) );
            };
        });
    });
});

    </script>
    @stop