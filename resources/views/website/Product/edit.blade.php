@extends('layouts.default')
@section('content')
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-cubes"></i>@lang('english.EDIT_PRODUCT')
            </div>
        </div>
        <div class="portlet-body form">
            {!! Form::model($target, [ 'files'=> true, 'class' => 'form-horizontal','id' => 'productEditForm'] ) !!}
            {!! Form::hidden('filter', Helper::queryPageStr($qpArr)) !!}
            {!! Form::hidden('id', $target->id) !!}
            {{csrf_field()}}
            <div class="form-body">
                <div class="row">
                    <div class="col-md-offset-1 col-md-7">
                        <div class="form-group">
                            <label class="control-label col-md-4" for="productCatId">@lang('english.PRODUCT_CATEGORY') :<span class="text-danger"> *</span></label>
                            <div class="col-md-8">
                                {!! Form::select('product_category_id',array('0' => __('english.SELECT_CATEGORY_OPT')) + $productCategoryArr, null, ['class' => 'form-control js-source-states', 'id' => 'productCatId']) !!}
                                <span class="text-danger">{{ $errors->first('product_category_id') }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4" for="name">@lang('english.NAME') :<span class="text-danger"> *</span></label>
                            <div class="col-md-8">
                                {!! Form::text('name', null, ['id'=> 'name', 'class' => 'form-control','autocomplete' => 'off']) !!}
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                <div id="productName"></div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-4" for="productInfo">@lang('english.PRODUCT_INFO') :<span class="text-danger"> *</span></label>
                            <div class="col-md-8">
                                {!! Form::text('product_info', null, ['id'=> 'productInfo', 'class' => 'form-control','autocomplete' => 'off']) !!}
                                <span class="text-danger">{{ $errors->first('product_info') }}</span>
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="control-label col-md-4" for="price">@lang('english.PRICE') :<span class="text-danger"> *</span></label>
                            <div class="col-md-8">
                                {!! Form::text('price', null, ['id'=> 'price', 'class' => 'form-control','autocomplete' => 'off']) !!}
                                <span class="text-danger">{{ $errors->first('price') }}</span>
                            </div>
                        </div>
                        <?php 
                        $checkStyle = 'display:none;';
                        $check = 0;
                        if($target->check_special_price =='1'){
                            $checkStyle = '';
                            $check = 1;
                        }
                       
                        ?>
                        <div class="form-group">
                            <label class="control-label col-md-4 mt-checkbox" for="specialPrice">@lang('english.SPECIAL_PRICE') :</label>
                            <div class="col-md-4 checkbox-center md-checkbox has-success" style="margin: 0 15px">
                                <input type="hidden" name="check_special_price" value="0">
                                {!! Form::checkbox('check_special_price',1,$check, ['id' => 'specialPrice', 'class'=> 'md-check']) !!}
                                <label for="specialPrice">
                                    <span class="inc"></span>
                                    <span class="check mark-caheck"></span>
                                    <span class="box mark-caheck"></span>
                                </label>
                            </div>
                        </div>
                       
                        <div id="divSpecialPrice" style="{{$checkStyle}}">
                            
                            <div class="form-group">
                                <label class="control-label col-md-4" for="special_price">@lang('english.SPECIAL_PRICE') :<span class="text-danger"> *</span></label>
                                <div class="col-md-8">
                                    {!! Form::text('special_price', null, ['id'=> 'special_price', 'class' => 'form-control','autocomplete' => 'off']) !!}
                                    <span class="text-danger">{{ $errors->first('special_price') }}</span>
                                </div>
                            </div>
                            
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4" for="fullDescription">@lang('english.DESCRIPTION') :<span class="text-danger"> *</span></label>
                            <div class="col-md-8">
                                {!! Form::textarea('description', null, ['id'=> 'description', 'class' => 'form-control full-name-text-area','cols'=>'20','rows' => '8']) !!}
                                <span class="text-danger">{{ $errors->first('description') }}</span>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4" for="status">@lang('english.STATUS') :</label>
                            <div class="col-md-8">
                                {!! Form::select('status', ['1' => __('english.ACTIVE'), '2' => __('english.INACTIVE')], null, ['class' => 'form-control', 'id' => 'status']) !!}
                                <span class="text-danger">{{ $errors->first('status') }}</span>
                            </div>
                        </div>

                        
                    </div>
                </div>

                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-4 col-md-8">
                            <button class="btn green btn-submit" type="button">
                                <i class="fa fa-check"></i> @lang('english.SUBMIT')
                            </button>
                            <a href="{{ URL::to('/product'.Helper::queryPageStr($qpArr)) }}" class="btn btn-outline grey-salsa">@lang('english.CANCEL')</a>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<link href="{{asset('public/css/website/summernote.min.css')}}" rel="stylesheet" type="text/css" />
<script src="{{asset('public/js/website/summernote.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {

        $('#description').summernote({
            placeholder: 'Product Description',
            tabsize: 2,
            height: 100
        });
        $(document).on("click", "#specialPrice", function () {
            if ($(this).prop("checked") == true) {
                $("#divSpecialPrice").show();
            } else if ($(this).prop("checked") == false) {
                $("#divSpecialPrice").hide();
            }
        });
        $(document).on("click", ".btn-submit", function () {
            swal({
                title: "Are you sure,@lang('english.YOU_WANT_TO_SAVE')?",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "@lang('english.YES_SAVE')",
                closeOnConfirm: true,
                closeOnCancel: true,
            }, function (isConfirm) {
                if (isConfirm) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var options = {
                        closeButton: true,
                        debug: false,
                        positionClass: "toast-bottom-right",
                        onclick: null,
                    };

                    var formData = new FormData($("#productEditForm")[0]);
                    $.ajax({
                        url: "{{ URL::to('/product/update')}}",
                        type: "POST",
                        dataType: 'json', // what to expect back from the PHP script, if anything
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        beforeSend: function () {
                            App.blockUI({boxed: true});
                        },
                        success: function (res) {
                            toastr.success(res.message, res.heading, options);
                            setTimeout(window.location.replace('{{ URL::to("/product")}}'), 1000);
                            App.unblockUI();
                        },
                        error: function (jqXhr, ajaxOptions, thrownError) {
                            if (jqXhr.status == 400) {
                                var errorsHtml = '';
                                var errors = jqXhr.responseJSON.message;
                                $.each(errors, function (key, value) {
                                    errorsHtml += '<li>' + value[0] + '</li>';
                                });
                                toastr.error(errorsHtml, jqXhr.responseJSON.heading, options);
                            } else if (jqXhr.status == 401) {
                                toastr.error(jqXhr.responseJSON.message, '', options);
                            } else {
                                toastr.error('Error', 'Something went wrong', options);
                            }
                            App.unblockUI();
                        }
                    }); //ajax
                }
            });
        });
    });
</script>
@stop
