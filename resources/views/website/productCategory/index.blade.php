@extends('layouts.default')
@section('content')
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    @include('layouts.flash')
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-list"></i>@lang('english.PRODUCT_CATEGORY_LIST')
            </div>
            <div class="actions">
                <a class="btn btn-default btn-sm create-new" href="{{ URL::to('productCategory/create'.Helper::queryPageStr($qpArr)) }}"> @lang('english.CREATE_NEW_PRODUCT_CATEGORY')
                    <i class="fa fa-plus create-new"></i>
                </a>
            </div>
        </div>
        <div class="portlet-body">
            <div class="row">
                <!-- Begin Filter-->
                {!! Form::open(array('group' => 'form', 'url' => 'productCategory/filter','class' => 'form-horizontal')) !!}
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label col-md-4" for="search">@lang('english.SEARCH')</label>
                            <div class="col-md-8">
                                {!! Form::text('search',  Request::get('search'), ['class' => 'form-control tooltips', 'title' => 'Name', 'placeholder' => 'Name', 'list'=>'search', 'autocomplete'=>'off']) !!} 
                                <datalist id="search">
                                    @if(!empty($nameArr))
                                    @foreach($nameArr as $name)
                                    <option value="{{$name->name}}"></option>
                                    @endforeach
                                    @endif
                                </datalist>
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
                </div>
                {!! Form::close() !!}
                <!-- End Filter -->
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="vcenter text-center">@lang('english.SL_NO')</th>
                            <th class="vcenter text-center">@lang('english.NAME')</th>
                            <th class="vcenter text-center">@lang('english.CODE')</th>
                            <th class="vcenter text-center">@lang('english.PARENT_CATEGORY')</th>
                            <th class="vcenter text-center">@lang('english.ORDER')</th>
                            <th class="vcenter text-center">@lang('english.STATUS')</th>
                            <th class="vcenter text-center">@lang('english.ACTION')</th>
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
                            <td class="vcenter text-center">{{ ++$sl }}</td>
                            <td class="vcenter">{{ $target->name }}</td>
                            <td class="vcenter">{{ $target->code }}</td>
                            <td class="vcenter">
                                <?php
                                if (isset($parentArr[$target->id])) {
                                    echo $parentArr[$target->id];
                                } else {
                                    echo '';
                                }
                                ?>
                            </td>
                            <td class="vcenter text-center">{{ $target->order }}</td>
                            <td class="vcenter text-center">
                                @if($target->status == '1')
                                <span class="label label-sm label-success">@lang('english.ACTIVE')</span>
                                @else
                                <span class="label label-sm label-warning">@lang('english.INACTIVE')</span>
                                @endif
                            </td>
                            <td class="td-actions text-center vcenter">
                                <div class="width-inherit">
               
                                    <a class="btn btn-icon-only btn-primary tooltips" title="Edit" href="{{ URL::to('content/' . $target->id . '/edit'.Helper::queryPageStr($qpArr)) }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    {{ Form::open(array('url' => 'productCategory/' . $target->id.'/'.Helper::queryPageStr($qpArr), 'class' => 'delete-form-inline' ,'id'=>'delete')) }}
                                    {{ Form::hidden('_method', 'DELETE') }}
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
                            <td colspan="8">@lang('english.NO_PRODUCT_CATEGORY_FOUND')</td>
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