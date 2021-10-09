@extends('layouts.default')
@section('content')
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    @include('layouts.flash')
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-road"></i>@lang('english.TORCH_BEARER')
            </div>
            <div class="actions">
                <a class="btn btn-default btn-sm create-new" href="{{ URL::to('torchbearer/create'.Helper::queryPageStr($qpArr)) }}"> {{trans('english.CREATE_NEW')}}
                    <i class="fa fa-plus create-new"></i>
                </a>
            </div>
        </div>
        <div class="portlet-body">
            {{ Form::open(array('role' => 'form', 'url' => 'torchbearer/filter', 'class' => '', 'id' => 'coasTrophyFilter')) }}
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group tooltips" title="Search by Username/First Name/Last Name/Official Name/Service No">
                        <label class="control-label">{{trans('english.SEARCH_TEXT')}}</label>
                        {{ Form::text('search_text', Request::get('search_text'), array('id'=> 'userSearchText', 'class' => 'form-control', 'placeholder' => 'Enter Search Text')) }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label">{{trans('english.SELECT_RANK')}}</label>
                        {{Form::select('rank_id', $rankList, Request::get('rank_id'), array('class' => 'form-control dopdownselect', 'id' => 'userRankId'))}}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label">{{trans('english.SELECT_BRANCH')}}</label>
                        {{Form::select('branch_id', $branchList, Request::get('branch_id'), array('class' => 'form-control dopdownselect', 'id' => 'branchId'))}}
                    </div>
                </div>
                <div class="col-md-3" style="margin-top: 25px">
                    <button type="submit" class="btn btn-md green btn-outline filter-submit margin-bottom-20">
                        <i class="fa fa-search"></i> Filter
                    </button>
                </div>
            </div>



            {{Form::close()}}

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="vcenter" width="80">@lang('english.SL_NO')</th>
                            <th class="text-center vcenter" width="120">@lang('english.IMAGE')</th>
                            <th class="text-center vcenter">@lang('english.NAME')</th>
                            <th class="text-center vcenter">@lang('english.RANK')</th>
                            <th class="text-center vcenter">@lang('english.BRANCH')</th>
                            <th class="text-center vcenter">@lang('english.FROM')</th>
                            <th class="text-center vcenter">@lang('english.TO')</th>
                            <th class="text-center vcenter">@lang('english.CONDUCTED_PLACE')</th>
                            <th class="text-center vcenter">@lang('english.ORDER')</th>
                            <th class=" text-center vcenter">@lang('english.STATUS')</th>
                            <th class="td-actions text-center vcenter">@lang('english.ACTION')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!$targetArr->isEmpty())
                        <?php
                        $page = Request::get('page');
                        $page = empty($page) ? 1 : $page;
                        $sl = ($page - 1) * (Session::get('paginatorCount'));
                        ?>
                        @foreach($targetArr as $target)
                        <tr>
                            <td class="vcenter">{{ ++$sl }}</td>
                            <td class="text-center vcenter">
                                <?php if (!empty($target->oc_image)) { ?>
                                    <img width="70"  src="{{URL::to('/')}}/public/uploads/website/{{$target->oc_image}}" alt="{{$target->name}}"/>
                                <?php } else { ?>
                                    <img width="70"  src="{{URL::to('/')}}/public/img/no-image.png" alt="{{ $target->name}}"/>
                                <?php } ?>
                            </td>
                            
                            <td class="text-center vcenter">{{ $target->name }}</td>
                            <td class="text-center vcenter">{{ $target->rank_shortname }}</td>
                            <td class="text-center vcenter">{{ $target->branch_name }}</td>
                            <td class="text-center vcenter">{{ $target->from }}</td>
                            <td class="text-center vcenter">{{ $target->to }}</td>
                            <td class="text-center vcenter">{{ $target->conducted_place }}</td>
                            <td class="text-center vcenter">{{ $target->order }}</td>
                            <td class="text-center vcenter">
                                @if($target->status_id == '1')
                                <span class="label label-sm label-success">@lang('english.ACTIVE')</span>
                                @else
                                <span class="label label-sm label-warning">@lang('english.INACTIVE')</span>
                                @endif
                            </td>
                            <td  class="text-center vcenter">
                                <div>
                                    {{ Form::open(array('url' => 'torchbearer/' . $target->id, 'id'=>'delete')) }}
                                    {{ Form::hidden('_method', 'DELETE') }}
                                    <a class="btn btn-icon-only btn-primary tooltips" title="Edit" href="{{ URL::to('torchbearer/' . $target->id . '/edit'.Helper::queryPageStr($qpArr)) }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <button class="btn btn-icon-only btn-danger tooltips" title="Delete" type="submit" data-placement="top" data-rel="tooltip" data-original-title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    {{ Form::close() }}
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="11" class="vcenter">@lang('english.NO_DATA_FOUND')</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            @include('layouts.paginator')
        </div>	
    </div>
</div>


<script type="text/javascript">
    $(document).on("submit", '#delete', function (e) {
        alert
        //This function use for sweetalert confirm message
        e.preventDefault();
        var form = this;
        swal({
            title: 'Are you sure you want to Delete?',
            text: '',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete",
            closeOnConfirm: false
        },
        function (isConfirm) {
            if (isConfirm) {
                toastr.info("Loading...", "Please Wait.", {"closeButton": true});
                form.submit();
            } else {
                //swal(sa_popupTitleCancel, sa_popupMessageCancel, "error");

            }
        });
    });
</script>
@stop