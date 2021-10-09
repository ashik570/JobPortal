@extends('layouts.default')
@section('content')
<div class="page-content">
    @include('layouts.flash')
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-clone"></i>@lang('english.PUBLICATION_CATEGORY_MANAGEMENT')
            </div>
            <div class="actions">
                <a class="btn btn-default btn-sm create-new" href="{{URL::to('catpublication/create'.Helper::queryPageStr($qpArr))}}"> @lang('english.CREATE_NEW')
                    <i class="fa fa-plus create-new"></i>
                </a>
            </div>
        </div>
        <div class="portlet-body">
            <div class="row">
                <!-- Begin Filter-->
                {!! Form::open(array('group' => 'form', 'url' => 'catpublication/filter','class' => 'form-horizontal')) !!}
                {!! Form::hidden('filter', Helper::queryPageStr($qpArr)) !!}
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label col-md-4" for="search">@lang('english.SEARCH')</label>
                        <div class="col-md-8">
                            {!! Form::text('fil_search',  Request::get('fil_search'), ['class' => 'form-control tooltips', 'title' => 'Name', 'placeholder' => 'Name', 'list' => 'userName', 'autocomplete' => 'off' ]) !!}
                            
                            <datalist id="userName">
                                @if (!$nameArr->isEmpty())
                                @foreach($nameArr as $item)
                                <option value="{{$item->name}}" />
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
                                <th class='vcenter'>@lang('english.SL_NO')</th>
                                <th class="text-center vcenter">@lang('english.NAME')</th>
                                
                                <th class="text-center vcenter">@lang('english.ORDER')</th>
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
                                <td>{{ $item->name }}</td>              
                                  
                                <td class='text-center vcenter'>{{ $item->order }}</td>  
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
                                <td class="action-center text-center">
                                        {{ Form::open(array('url' => 'catpublication/' . $item->id, 'class' => 'delete-publication-category')) }}
                                        {{ Form::hidden('_method', 'DELETE') }}
                                        <a title="Update" class="btn btn-success btn-md has-tooltip" href="{{ URL::to('catpublication/'.$item->id.'/edit/'.Helper::queryPageStr($qpArr) ) }}"><span class="fa fa-edit"></span></a>&nbsp;&nbsp;

                                        <button title="Delete" class="btn btn-danger btn-md has-tooltip" type="submit" data-placement="top"  data-original-title="Delete">
                                            <span class="fa fa-trash"></span>
                                        </button>
                                        {{ Form::close() }}
                                    </td>
                                    
                                
                            </tr>
                            @endforeach
                            
                            @else
                            <tr>
                            <td colspan="5" class="vcenter">@lang('english.NO_DATA_FOUND')</td>
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
    $(document).on("submit", '.delete-publication-category', function (e) {
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