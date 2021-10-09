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
                        <i class="fa fa-cubes"></i>{{trans('english.VIEW_JOB_NATURE')}}
                    </div>
                    <div class="actions">
                        <a href="{{ URL::to('jobNature/create') }}" class="btn btn-default btn-sm">
                            <i class="fa fa-plus"></i> {{trans('english.CREATE_NEW_JOB_NATURE')}} </a>
                    </div>
                </div>
                <div class="portlet-body">
                    {{ Form::open(array('role' => 'form', 'url' => 'jobNature/filter', 'class' => '', 'id' => 'jobNatureFilter')) }}
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="col-md-4 control-label">{{trans('english.SEARCH_TEXT')}}</label>
                                <div class="col-md-8">
                                    {{ Form::text('search_text', Request::get('search_text'), array('id'=> 'jobNatureSearchText', 'class' => 'form-control', 'placeholder' => 'Enter Search Text')) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-md green btn-outline filter-submit margin-bottom-20">
                                <i class="fa fa-search"></i> {{trans('english.FILTER')}}
                            </button>
                        </div>
                    </div>
                    {{Form::close()}}
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>{{trans('english.SL_NO')}}</th>
                                    <th>{{trans('english.NAME')}}</th>
                                    <th>{{trans('english.ORDER')}}</th>
                                    <th>{{trans('english.STATUS')}}</th>
                                    <th class="text-center">{{trans('english.ACTION')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!$targetArr->isEmpty())
                                <?php
                                $page = Request::get('page');
                                $page = empty($page) ? 1 : $page;
                                $sl = ($page - 1) * trans('english.PAGINATION_COUNT');
                                ?>
                                @foreach($targetArr as $value)

                                <tr class="contain-center">
                                    <td>{{ ++$sl}}</td>
                                    <td>{{ $value->name}}</td>
                                    <td class="text-center">{{ $value->order }}</td>
                                    <td class="text-center">
                                        @if ($value->status == '1')
                                        <span class="label label-success">{{ trans('english.ACTIVE') }}</span>
                                        @else
                                        <span class="label label-warning">{{ trans('english.INACTIVE') }}</span>
                                        @endif
                                    </td>

                                    <td class="action-center">
                                        <div class='text-center'>
                                            {{ Form::open(array('url' => 'jobNature/delete/' . $value->id, 'id' => 'delete')) }}
                                            {{ Form::hidden('_method', 'DELETE') }}
                                            <a class="btn btn-primary btn-xs tooltips" title="{{trans('english.JOB_NATURE_EDIT')}}" data-original-title="{{trans('english.JOB_NATURE_EDIT')}}" href="{{ URL::to('jobNature/' . $value->id . '/edit') }}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <button class="btn btn-danger btn-xs tooltips" type="submit" data-placement="top" data-rel="tooltip" title="{{trans('english.JOB_NATURE_DELETE')}}" data-original-title="{{trans('english.JOB_NATURE_DELETE')}}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            {{ Form::close() }}
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="7">{{trans('english.EMPTY_DATA')}}</td>
                                </tr>
                                @endif 
                            </tbody>
                        </table>
                        
                    </div>
                    @include('layouts.paginator')
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
