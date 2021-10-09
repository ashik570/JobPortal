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
                        <i class="fa fa-user"></i>{{trans('english.SCROLL_MESSAGE_LIST')}}
                    </div>
                    <div class="actions">
                        <a href="{{ URL::to('scrollmessage/create') }}" class="btn btn-default btn-sm">
                            <i class="fa fa-plus"></i> {{trans('english.CREATE_SCROLL_MESSAGE')}} </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>{{trans('english.SL_NO')}}</th>
                                    <th>{{trans('english.MESSAGE')}}</th>
                                    <th>{{trans('english.SCOPE')}}</th>
                                    <th>{{trans('english.PUBLISH')}}</th>
                                    <th>{{trans('english.STATUS')}}</th>
                                    <th>{{trans('english.ACTION')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!$targetArr->isEmpty())
								<?php $i = 0;?>
                                @foreach($targetArr as $item)
                                <tr class="contain-center">
                                    <td>{{ ++$i}}</td>
                                    <td>{{ $item->message}}</td>
                                    <td>
										@if(!empty($item->messagescope))
											 @foreach($item->messagescope as $scope)
												@if($scope->scope_id == 3)
													{{trans('english.HOME_PAGE')}} </br>
												@elseif($scope->scope_id == 1)
													{{trans('english.ISSP_DASHBOARD')}} </br>
												@elseif($scope->scope_id == 2)
													{{trans('english.JCSC_DASHBOARD')}} </br>
												@endif
											 @endforeach
										@endif
									</td>
									<td>
										{{$item->from_date. ' To '.$item->to_date}}
									</td>
									 <td>
										@if ($item->status == '1')
											<span class="label label-success">{{trans('english.ACTIVE')}}</span>
										@elseif($item->status == '2')
											<span class="label label-info">{{trans('english.COMMON')}}</span>
										@else
											<span class="label label-warning">{{trans('english.INACTIVE')}}</span>
										
										@endif
									</td>
                                    <td class="action-center">
                                        <div class='text-center'>
                                            {{ Form::open(array('url' => 'scrollmessage/' . $item->id, 'id' => 'delete')) }}
                                            {{ Form::hidden('_method', 'DELETE') }}
                                            <a class='btn btn-primary btn-xs' href="{{ URL::to('scrollmessage/' . $item->id . '/edit') }}">
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
                                    <td colspan="6">{{trans('english.EMPTY_DATA')}}</td>
                                </tr>
                                @endif 
                            </tbody>
                        </table>
                        
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
