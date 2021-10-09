@extends('layouts.default')
@section('content')
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-book"></i>@lang('english.CREATE_PUBLICATION')
            </div>
        </div>
        <div class="portlet-body form">
            {!! Form::open(['group' => 'form', 'url' => 'publication','method'=>'post','files'=> true,'class' => 'form-horizontal']) !!}
            {!! Form::hidden('filter', Helper::queryPageStr($qpArr)) !!}
            {{csrf_field()}}
            <div class="form-body">
                <div class="row">
                    <div class="col-md-9">

                        <div class="form-group">
                            <label class="control-label col-md-4" for="groupId">@lang('english.TITLE') :<span class="text-danger"> *</span></label>
                            <div class="col-md-7">
                                {!! Form::text('title',null , ['id'=> 'name', 'class' => 'form-control','autocomplete'=>'off']) !!} 
                                <span class="text-danger">{{ $errors->first('title') }}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="control-label col-md-4" for="image">@lang('english.COVER_PHOTO') :<span class="text-danger"> *</span></label>
                                <div class="col-md-7">
                                    <div class="image_area">
                                        <label for="upload_image">
                                            <input type="file" name="cover_photo" class="image" id="upload_image" accept="image/*" />
                                            <input type="hidden" name="cropped_cover_photo" class="cropped-icon" />
                                            <span class="text-danger">{{ $errors->first('cropped_cover_photo') }}</span>
                                        </label>
                                    </div>
                                    <div class="clearfix margin-top-10">
                                        <span class="label label-danger">@lang('english.NOTE')</span><span class="text-danger"> @lang('english.IMAGE_SUPPORTED_SIZE')</span>
                                    </div>
                                </div>
                                <br style="clear:both">
                                <label class="control-label col-md-4">&nbsp;</label>
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
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4" for="file">@lang('english.UPLOAD_FILE') :<span class="text-danger"> *</span></label>
                            <div class="col-md-7">
                                {!! Form::file('file', null, ['id'=> 'file', 'class' => 'form-control']) !!}
                                <span class="text-danger">{{ $errors->first('file') }}</span>
                                <div class="clearfix margin-top-10">
                                    <span class="label label-danger">@lang('english.NOTE')</span><span class="text-danger"> @lang('english.PUBLICATION_FILE_UP')</span>
                                </div>
                            </div>
                        </div>

                        <div id="order">
                            <div class="form-group">
                                <label class="control-label col-md-4" for="orderId">@lang('english.ORDER') :</label>
                                <div class="col-md-7">
                                    {!! Form::select('order_id', $orderList, $lastOrderNumber, ['id'=> 'orderId', 'class' => 'form-control js-source-states','autocomplete'=>'off']) !!}  
                                    <span class="text-danger">{{ $errors->first('order_id') }}</span>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="control-label col-md-4" for="status">@lang('english.STATUS') :</label>
                            <div class="col-md-7">
                                {!! Form::select('status_id', ['1' => __('english.ACTIVE'), '0' => __('english.INACTIVE')], null, ['class' => 'form-control', 'id' => 'status']) !!}
                                <span class="text-danger">{{ $errors->first('status_id') }}</span>
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
                        <a href="{{ URL::to('/publication'.Helper::queryPageStr($qpArr)) }}" class="btn btn-circle btn-outline grey-salsa">@lang('english.CANCEL')</a>

                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>	
    </div>
</div>

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
<link href="{{asset('public/assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet" type="text/css" />
<script src="{{asset('public/assets/global/plugins/bootstrap-summernote/summernote.min.js')}}" type="text/javascript"></script>

<script>
$(document).ready(function () {
    $('.summernote').summernote({
        height: 200
    });
});

$(document).ready(function () {
    var $modal = $('#modal');
    var image = document.getElementById('sample_image');
    var cropper;
    $('#upload_image').change(function (event) {
        var files = event.target.files;
        var done = function (url) {
            image.src = url;
            $modal.modal('show');
            $('.modal-backdrop').hide();
        };
        if (files && files.length > 0) {
            reader = new FileReader();
            reader.onload = function (event) {
                done(reader.result);
            };
            reader.readAsDataURL(files[0]);
        }
    });
    $modal.on('shown.bs.modal', function () {
        cropper = new Cropper(image, {
            aspectRatio: 20 / 30,
            viewMode: 2,
            preview: '.preview'
        });
    }).on('hidden.bs.modal', function () {
        cropper.destroy();
        cropper = null;
    });
    $('#crop').click(function () {
        canvas = cropper.getCroppedCanvas({
            width: 2000,
            height: 2000,
        });
        canvas.toBlob(function (blob) {
            url = URL.createObjectURL(blob);
            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function () {
                var base64data = reader.result;
                $('.prv-img').attr("src", base64data);
                $('.cropped-icon').val(base64data);
                $modal.modal('hide');
                $('#upload_image').replaceWith($("#upload_image").val('').clone(true));
            };
        });
    });
});
</script>
@stop