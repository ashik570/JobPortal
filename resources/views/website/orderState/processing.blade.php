@extends('layouts.default')
@section('content')
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    @include('layouts.flash')
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-cubes"></i>@lang('english.PROCESSING')
            </div>
            <div class="actions">
            </div>
        </div>
        <div class="portlet-body">
            <!-- Begin Filter-->
            {!! Form::open(array('group' => 'form', 'url' => 'orderSate/processing/processingFilter','class' => 'form-horizontal')) !!}
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-6" for="orderNumber">@lang('english.ORDER_NUMBER') :</label>
                        <div class="col-md-6">
                             {!! Form::text('order_number',  Request::get('order_number'), ['id'=> 'orderNumber', 'class' => 'form-control','autocomplete'=>'off']) !!} 
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label col-md-4" for="phone">@lang('english.PHONE') :</label>
                        <div class="col-md-8">
                             {!! Form::text('phone',  Request::get('phone'), ['id'=> 'phone', 'class' => 'form-control','autocomplete'=>'off']) !!} 
                        </div>
                    </div>
                </div>


                <div class="col-md-4 text-center">
                    <div class="form">
                        <button type="submit" class="btn btn-md green btn-outline filter-submit margin-bottom-20">
                            <i class="fa fa-search"></i> @lang('english.FILTER')
                        </button>
                    </div>
                </div>
            </div>

            {!! Form::close() !!}
            <!-- End Filter -->

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr class="info">
                            <th class="text-center vcenter">@lang('english.SL_NO')</th>

                            <th class="vcenter">@lang('english.ORDER_NUMBER')</th>
                            <th class="vcenter">@lang('english.PRODUCT_IMAGE')</th>
                            <th class="vcenter">@lang('english.PRODUCT_NAME')</th>
                            <th class="vcenter">@lang('english.PHONE')</th>
                            <th class="vcenter">@lang('english.EMAIL')</th>
                            <th class="vcenter">@lang('english.MESSAGE')</th>
                            <th class="vcenter">@lang('english.REQUEST_TIME')</th>
                            <th class="vcenter">@lang('english.PAYMENT_STATUS')</th>
                            <th class="text-center vcenter">@lang('english.ACTION')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!$targetArr->isEmpty())
                        <?php
                        $page = Request::get('page');
                        $page = empty($page) ? 1 : $page;
                        $sl = ($page - 1) * Session::get('paginatorCount');
                        ?>
                        @foreach($targetArr as $target)
                        <tr>
                            <td>
                                {{++$sl}}
                            </td>

                            <td>
                                {{$target->order_number}}
                            </td>
                            <td>
                                <?php
                                $productImageArr = json_decode($target->product_image, true);
                                ?>
                                <img src="{{URL::to('/')}}/public/uploads/website/product/{{ !empty(end($productImageArr)) ? end($productImageArr) : 'demo.jpg'  }}" width="50" height="60" alt="">

                            </td>
                            <td>
                                {{$target->name}}
                            </td>
                            <td>
                                {{$target->phone}}
                            </td>
                            <td>
                                {{$target->email}}
                            </td>
                            <td>
                                {{$target->message}}
                            </td>
                            <td>
                                {{Helper::printDateTime($target->created_at)}}
                            </td>
                            <td>
                                @if($target->payment_status == '2')
                                <span class="label label-sm label-success">@lang('english.PAID')</span>
                                @else
                                <span class="label label-sm label-warning">@lang('english.UNPAID')</span>
                                @endif

                            </td>
                            <td class="td-actions text-center vcenter">
                                <div class="width-inherit">
                                    <a class="btn btn-xs green tooltips vcenter" id="orderStatusChange" data-purchase-request-id="{{$target->id??0}}" data-toggle="modal" data-target="#orderModal" title="@lang('english.SET_ORDER_STATUS')">
                                        <i class="fa fa-retweet"></i>
                                    </a>
                                    <a class="btn btn-xs yellow tooltips vcenter" id="paymentStatusChange" data-purchase-request-id="{{$target->id??0}}" data-toggle="modal" data-target="#paymentModal"  title="@lang('english.SET_PAYMENT_STATUS')">
                                        <i class="fa fa-dollar"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="14" class="vcenter">@lang('english.NO_PRODUCT_FOUND')</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            @include('layouts.paginator')
        </div>
    </div>
</div>

<!-- Modal start -->

<!--set product image modal-->
<div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div id="showOrder">

        </div>
    </div>
</div>
<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div id="showPayment">

        </div>
    </div>
</div>

<!-- Modal end-->

<script type="text/javascript">
    $(document).on('click', '#orderStatusChange', function (e) {
        e.preventDefault();
        var purchaseRequestId = $(this).attr("data-purchase-request-id");
        $.ajax({
            url: "{!! URL::to('orderSate/pending/getOrderFrom') !!}",
            type: "POST",
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                purchase_request_id: purchaseRequestId,
            },
            success: function (res) {
                $('#showOrder').html(res.html);
                $('.js-source-states').select2();
            },
            error: function (jqXhr, ajaxOptions, thrownError) {

            }
        });
    });

    $(document).on("click", "#btn-submit", function () {
        $("#btn-submit").attr("disabled", true);
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

        var formData = new FormData($("#paymentForm")[0]);
        $.ajax({
            url: "{{ URL::to('orderSate/pending/orderSave')}}",
            type: "POST",
            dataType: 'json', // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            beforeSend: function () {
                // App.blockUI({boxed: true});
            },
            success: function (res) {
                toastr.success(res.message, res.heading, options);
                setTimeout(window.location.replace('{{ URL::to("orderSate/processing")}}'), 500);
                $('#orderModal').modal('toggle');
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
                $("#btn-submit").attr("disabled", false);
            }
        }); //ajax
    });
    // payment change 
    $(document).on('click', '#paymentStatusChange', function (e) {
        e.preventDefault();
        var purchaseRequestId = $(this).attr("data-purchase-request-id");
        $.ajax({
            url: "{!! URL::to('orderSate/pending/getPaymentFrom') !!}",
            type: "POST",
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                purchase_request_id: purchaseRequestId,
            },
            success: function (res) {
                $('#showPayment').html(res.html);
                $('.js-source-states').select2();
            },
            error: function (jqXhr, ajaxOptions, thrownError) {

            }
        });
    });

    $(document).on("click", "#btn-submit-payment", function () {
        $("#btn-submit-payment").attr("disabled", true);
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

        var formData = new FormData($("#paymentForm")[0]);
        $.ajax({
            url: "{{ URL::to('orderSate/pending/paymentSave')}}",
            type: "POST",
            dataType: 'json', // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            beforeSend: function () {
                // App.blockUI({boxed: true});
            },
            success: function (res) {
                toastr.success(res.message, res.heading, options);
                setTimeout(window.location.replace('{{ URL::to("orderSate/processing")}}'), 500);
                $('#paymentModal').modal('toggle');
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
                $("#btn-submit-payment").attr("disabled", false);
            }
        }); //ajax
    });
</script>

@stop
