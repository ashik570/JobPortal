@extends('layouts.default')
@section('content')
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    @include('layouts.flash')
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-cubes"></i>@lang('english.TRACKING_ORDER')
            </div>
            <div class="actions">
            </div>
        </div>
        <div class="portlet-body">
            <!-- Begin Filter-->
            {!! Form::open(array('group' => 'form', 'url' => 'orderSate/trackingOrder/trackingOrderFilter','class' => 'form-horizontal')) !!}
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
                <div class="col-md-5">
                    <div class="form-group">
                        <label class="col-md-4 control-label">{{trans('english.REQUEST_DATE')}} :</label>
                        <div class="col-md-7">
                            <div class="input-group date datepicker">
                                {{ Form::text('request_date', Request::get('request_date'), array('id'=> 'epeExamDate', 'class' => 'form-control', 'placeholder' => trans('english.REQUEST_DATE'), 'size' => '16', 'readonly' => true)) }}
                                <span class="input-group-btn">
                                    <button class="btn default date-set" type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span>
                                <span class="input-group-btn">
                                    <button class="btn default date-remove" onclick="remove_date('epeExamDate');" remove="epeExamDate" type="button">
                                        <i class="fa fa-remove"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-4 text-center">
                    <div class="form">
                        <button type="submit" class="btn btn-md green btn-outline filter-submit margin-bottom-20">
                            <i class="fa fa-search"></i> @lang('english.SEARCH')
                        </button>
                    </div>
                </div>
            </div>

            {!! Form::close() !!}
            <!-- End Filter -->
            @if(Request::get('search') == true)
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
                            <th class="vcenter">@lang('english.ORDER_STATUS')</th>
                            <th class="text-center vcenter">@lang('english.PAYMENT_STATUS')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($targetArr))
                        <?php
                        $sl = 0;
                        ?>
                        @foreach($targetArr as $target)
                        <tr>
                            <td>
                                {{++$sl}}
                            </td>

                            <td>
                                {{$target['order_number']}}
                            </td>
                            <td>
                                <?php
                                $productImageArr = json_decode($target['product_image'], true);
                                ?>
                                <img src="{{URL::to('/')}}/public/uploads/website/product/{{ !empty(end($productImageArr)) ? end($productImageArr) : 'demo.jpg'  }}" width="50" height="60" alt="">

                            </td>
                            <td>
                                {{$target['name']}}
                            </td>
                            <td>
                                {{$target['phone']}}
                            </td>
                            <td>
                                {{$target['email']}}
                            </td>
                            <td>
                                {{$target['message']}}
                            </td>
                            <td>
                                {{Helper::printDateTime($target['created_at'])}}
                            </td>
                            <td>
                                @if($target['order_status'] == '1')
                                <span class="label label-sm label-warning">@lang('english.PENDING')</span>
                                @elseif($target['order_status'] == '2')
                                <span class="label label-sm label-info">@lang('english.PROCESSING')</span>
                                @elseif($target['order_status'] == '3')
                                <span class="label label-sm label-success">@lang('english.DELIVERED')</span>
                                @elseif($target['order_status'] == '4')
                                <span class="label label-sm label-danger">@lang('english.CLOSE')</span>
                                @endif

                            </td>
                            <td>
                                @if($target['payment_status'] == '2')
                                <span class="label label-sm label-success">@lang('english.PAID')</span>
                                @else
                                <span class="label label-sm label-warning">@lang('english.UNPAID')</span>
                                @endif

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
            @endif
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
    $(document).ready(function () {
        $("body").tooltip({selector: '[data-tooltip=tooltip]'});
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });


    });
        function remove_date(e) {
            var id = e;
            $("#" + id).val('');
        }
</script>


@stop
