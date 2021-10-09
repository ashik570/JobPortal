@extends('layouts.default')
@section('content')
<!-- BEGIN CONTENT BODY -->
<div class="page-content">

    <!-- BEGIN PORTLET-->
    @include('includes.flash')
    <!-- END PORTLET-->
    <div class="row">
        <div class="col-md-12">
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-badge"></i>{{trans('english.VIEW_DESIGNATION_LIST')}}
                    </div>
                    <div class="actions">
                        <a href="{{ URL::to('designation/create') }}" class="btn btn-default btn-sm">
                            <i class="fa fa-plus"></i> {{trans('english.CREATE_A_DESIGNATION')}} </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>{{trans('english.SL_NO')}}</th>
                                    <th>{{trans('english.TITLE')}}</th>
                                    <th>{{trans('english.SHORT_NAME')}}</th>
                                    <th class="text-center">{{trans('english.ORDER')}}</th>
                                    <th class='text-center'>{{trans('english.STATUS')}}</th>
                                    <th class='text-center'>{{trans('english.ACTION')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!$designationArr->isEmpty())
                                <?php
                                $page = Request::get('page');
                                $page = empty($page) ? 1 : $page;
                                $sl = ($page - 1) * trans('english.PAGINATION_COUNT');
                                ?>
                                @foreach($designationArr as $value)

                                <tr class="contain-center">
                                    <td>{{++$sl}}</td>
                                    <td>{{ $value->title}}</td>
                                    <td>{{ $value->short_name}}</td>
                                    <td class="text-center">{{ $value->order }}</td>
                                    <td class="text-center">
                                        @if ($value->status == 'active')
                                        <span class="label label-success">{{ $value->status }}</span>
                                        @else
                                        <span class="label label-warning">{{ $value->status }}</span>
                                        @endif
                                    </td>

                                    <td class="action-center">
                                        <div class='text-center'>
                                            {{ Form::open(array('url' => 'designation/' . $value->id, 'id' => 'delete')) }}
                                            {{ Form::hidden('_method', 'DELETE') }}
                                            <a class='btn btn-primary btn-xs' href="{{ URL::to('designation/' . $value->id . '/edit') }}">
                                                <i class='fa fa-edit'></i>
                                            </a>
                                            <button class="btn btn-danger btn-xs" type="submit" data-placement="top" data-rel="tooltip" data-original-title="Delete">
                                                <i class='fa fa-trash'></i>
                                            </button>
                                            {{ Form::close() }}
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="4">{{trans('english.EMPTY_DATA')}}</td>
                                </tr>
                                @endif 
                            </tbody>
                        </table>

                    </div>
                    <div class="row">
                        <div class="col-md-5 col-sm-5">
                            <div class="dataTables_info" role="status" aria-live="polite">
                                <?php
                                $start = empty($designationArr->total()) ? 0 : (($designationArr->currentPage() - 1) * $designationArr->perPage() + 1);
                                $end = ($designationArr->currentPage() * $designationArr->perPage() > $designationArr->total()) ? $designationArr->total() : ($designationArr->currentPage() * $designationArr->perPage());
                                ?> <br />
                                @lang('english.SHOWING') {{ $start }} @lang('english.TO') {{$end}} @lang('english.OF')  {{$designationArr->total()}} @lang('english.RECORDS')
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-7">
                            {{ $designationArr->appends(Request::all())->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END CONTENT BODY -->

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
