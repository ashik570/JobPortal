@extends('layouts.default')
@section('content')
<!-- BEGIN CONTENT BODY -->
<div class="page-content"> 
    @include('layouts.flash')
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-book"></i>@lang('english.PUBLICATION_MANAGEMENT')
            </div>
            <div class="actions">
                <a class="btn btn-default btn-sm create-new" href="{{URL::to('publication/create'.Helper::queryPageStr($qpArr))}}"> @lang('english.CREATE_NEW')
                    <i class="fa fa-plus create-new"></i>
                </a>
            </div>
        </div>
        <div class="portlet-body">
            <div class="row">
                <!-- Begin Filter-->
                {!! Form::open(array('group' => 'form', 'url' => 'publication/filter','class' => 'form-horizontal')) !!}
                {!! Form::hidden('filter', Helper::queryPageStr($qpArr)) !!}
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-4" for="search">@lang('english.SEARCH')</label>
                        <div class="col-md-8">
                            {!! Form::text('fil_search',  Request::get('fil_search'), ['class' => 'form-control tooltips', 'title' => 'Title', 'placeholder' => 'Title', 'list' => 'Title', 'autocomplete' => 'off' ]) !!}

                            <datalist id="Title">
                                @if (!$nameArr->isEmpty())
                                @foreach($nameArr as $item)
                                <option value="{{$item->title}}" />
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
                {{ Form::close() }}
                <!-- End Filter -->
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="text-center vcenter">@lang('english.SL_NO')</th>
                            <th class="text-center vcenter">@lang('english.TITLE')</th>

                            <th class="text-center vcenter">@lang('english.ORDER')</th>
                            <th class="text-center vcenter">@lang('english.PHOTO')</th>
                            <th class="text-center vcenter">@lang('english.STATUS')</th>
                            <th class="td-actions text-center vcenter">@lang('english.ACTION')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!$targetArr->isEmpty())
                        <?php
                        $page = Request::get('page');
                        $page = empty($page) ? 1 : $page;
                        $sl = ($page - 1) * (Session::get('paginatorCount'));
                        ?>
                        @foreach($targetArr as $item)
                        <tr>
                            <td>{{++$sl}}</td>                    
                            <td>{{ $item->title }}</td>              
                            <td class='text-center vcenter'>{{ $item->order }}</td>
                            <td class="text-center vcenter">
                                <?php if (!empty($item->image)) { ?>
                                    <img width="50" height="60" src="{{URL::to('/')}}/public/uploads/website/publication/{{$item->image}}" alt="{{ $item->title}}"/>
                                <?php } else { ?>
                                    <img width="50" height="60" src="{{URL::to('/')}}/public/img/no-img.png" alt="{{ $item->title}}"/>
                                <?php } ?>
                            </td>  
                            <td class='text-center vcenter'>
                                @if($item->status_id=='1')  
                                <span class="label label-success">
                                    @lang('english.ACTIVE')

                                </span>
                                @else
                                <span class="label label-warning">
                                    @lang('english.INACTIVE')
                                </span>
                                @endif
                            </td>  
                            <td class="action-center text-center vcenter">
                                {{ Form::open(array('url' => 'publication/' .$item->id.'/'.Helper::queryPageStr($qpArr), 'class' => 'delete-publication'))}}
                                {{ Form::hidden('_method', 'DELETE') }}
                                
                                <a title="EDIT" class="btn btn-warning btn-md has-tooltip" href="{{ URL::to('publication/'.$item->id.'/edit/'.Helper::queryPageStr($qpArr) ) }}"><span class="fa fa-edit"></span></a>&nbsp;&nbsp;
                                
                                @if(!empty($item->upload_file))
                                <a href ="{{URL::to('publication/download',$item->id)}}"  title="@lang('english.DOWNLOAD_ATTACHEMENT')" class="btn btn-success tooltips"> 
                                    <i class = "fa fa-download"></i>
                                </a>
                                @endif
                                
                                <button title="Delete" class="btn btn-danger btn-md has-tooltip" type="submit" data-placement="top"  data-original-title="Delete">
                                    <span class="fa fa-trash"></span>
                                </button>
                                {{ Form::close() }}
                            </td>


                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="9" class="vcenter">@lang('english.NO_DATA_FOUND')</td>
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
    $(document).on("submit", '.delete-publication', function (e) {
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