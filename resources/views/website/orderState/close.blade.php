@extends('layouts.default')
@section('content')
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    @include('layouts.flash')
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-cubes"></i>@lang('english.CLOSE')
            </div>
            <div class="actions">
            </div>
        </div>
        <div class="portlet-body">
            <!-- Begin Filter-->
            {!! Form::open(array('group' => 'form', 'url' => 'orderSate/close/closeFilter','class' => 'form-horizontal')) !!}
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


<!-- Modal end-->

<script type="text/javascript">

</script>

@stop
