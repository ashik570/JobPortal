@extends('layouts.default')
@section('content')
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    @include('layouts.flash')
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-bars"></i>@lang('english.MENU_MANAGEMENT')
            </div>
            <div class="actions">
                <a class="btn btn-default btn-sm create-new" href="{{ URL::to('menu/create'.Helper::queryPageStr($qpArr)) }}"> @lang('english.CREATE_NEW')
                    <i class="fa fa-plus create-new"></i>
                </a>
            </div>
        </div>
        
        <div class="portlet-body">
            <div class="row">
                <!-- Begin Filter-->
                {!! Form::open(array('group' => 'form', 'url' => 'menu/filter','class' => 'form-horizontal')) !!}
                {!! Form::hidden('filter', Helper::queryPageStr($qpArr)) !!}

                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-4" for="search">@lang('english.SEARCH')</label>
                        <div class="col-md-8">
                            {!! Form::text('fil_search',  Request::get('fil_search'), ['class' => 'form-control tooltips', 'id' => 'search', 'title' => 'Title', 'placeholder' => 'Title', 'list' => 'title', 'autocomplete' => 'off' ]) !!} 
                            <datalist id="title">
                                @if (!$nameArr->isEmpty())
                                @foreach($nameArr as $item)
                                <option value="{{$item->title}}" />
                                @endforeach
                                @endif
                            </datalist>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-4" for="filTypeId">@lang('english.TYPE')</label>
                        <div class="col-md-8">
                            {!! Form::select('fil_type_id', $menuTypeArr,  Request::get('fil_type_id'), ['class' => 'form-control js-source-states', 'id' => 'filTypeId']) !!}
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form">
                        <button type="submit" class="btn btn-md green btn-outline filter-submit margin-bottom-20">
                            <i class="fa fa-search"></i> @lang('english.FILTER')
                        </button>
                    </div>
                </div>
                {!! Form::close() !!}
                <!-- End Filter -->
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="vcenter">@lang('english.SL_NO')</th>
                            <th class="vcenter">@lang('english.TITLE')</th>
                        
                            <th class="vcenter">@lang('english.PARENTS')</th>
                            <th class="vcenter">@lang('english.TYPE')</th>
                            <th class="vcenter text-center" style="display: none">@lang('english.CONTENT')</th>
                            <th class="vcenter text-center" style="display: none">@lang('english.URL')</th>
                            <th class="vcenter text-center">@lang('english.REQUIR_LOGIN')</th>
                            <th class="vcenter text-center">@lang('english.NEW_TAB')</th>
                            <th class="text-center vcenter">@lang('english.ORDER')</th>
                            <th class="text-center vcenter">@lang('english.STATUS')</th>
                            <th class="td-actions text-center vcenter">@lang('english.ACTION')</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                        @if (!empty($menuArr))
                        <?php
                        $page = Request::get('page');
                        $page = empty($page) ? 1 : $page;
                        $sl = ($page - 1) * __('english.PAGINATION_COUNT');
                        ?>
                        @foreach($menuArr as $target)
                        <tr>
                            <td class="vcenter">{{ ++$sl }}</td>
                            <td class="vcenter">{{ $target['title'] }}</td>
                            <td class="vcenter">{{ $target['parent_name'] }}</td>
                            <td class="vcenter">{{ $target['type_name'] }}</td>
                            <td class="text-center vcenter" style="display: none">{{ $target['content_name'] }}</td>
                            <td class="text-center vcenter" style="display: none">
                                @if($target['type_id'] == 2 )
                                {{ $item['url'] }}	
                                @elseif($target['type_id'] == 5)
                                {{ URL::to('/'.$item['route'].'/'.$item['content_id']) }}
                                @elseif($target['type_id'] == 16)	
                                {{ URL::to('/'.$target['type_id'].'/'.$target['pcategory_id']) }}
                                @else
                                {{ URL::to('/') }}
                                @endif
                            </td>
                            <td class="text-center vcenter">
                                @if($target['login_status'] == '1')
                                <span class="label label-success">@lang('english.YES')</span>
                                @else
                                <span class="label label-warning">@lang('english.NO')</span>
                                @endif
                            </td>
                            <td class="text-center vcenter">
                                @if($target['open_new_tab'] == '1')
                                <span class="label label-success">@lang('english.YES')</span>
                                @else
                                <span class="label label-warning">@lang('english.NO')</span>
                                @endif
                            </td>
                            <td class="text-center vcenter">
                                @if(!empty($target['order']))
                                {{ $target['order'] }}
                                @endif
                            </td>
                            <td class="text-center vcenter">
                                @if($target['status_id'] == '1')
                                <span class="label label-sm label-success">@lang('english.ACTIVE')</span>
                                @else
                                <span class="label label-sm label-warning">@lang('english.INACTIVE')</span>
                                @endif
                            </td>
                            <td  class="text-center vcenter">
                                <div>
                                    {{ Form::open(array('url' => 'menu/' . $target['id'],'id'=>'delete')) }}
                                    {{ Form::hidden('_method', 'DELETE') }}
                                    <a class="btn btn-icon-only btn-primary tooltips" title="Edit" href="{{ URL::to('menu/' . $target['id'] . '/edit'.Helper::queryPageStr($qpArr)) }}">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <button class="btn btn-icon-only btn-danger btn-xs" type="submit" data-placement="top" data-rel="tooltip" data-original-title="Delete">
                                        <i class='fa fa-trash'></i>
                                    </button>

                                    {{ Form::close() }}
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="10" class="vcenter">@lang('english.EMPTY_DATA')</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            @include('menu.paginator')
        </div>	
    </div>
</div>

<script type="text/javascript">
    $(document).on("submit", '#delete', function (e) {
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