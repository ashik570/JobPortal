<?php
//dd($targetArr[0]['id']);
?>
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
                        <i class="fa fa-cubes"></i>{{trans('english.VIEW_PENDING_APPLICANTION')}}
                    </div>
                    <!--                    <div class="actions">
                                            <a href="{{ URL::to('jobNature/create') }}" class="btn btn-default btn-sm">
                                                <i class="fa fa-plus"></i> {{trans('english.CREATE_NEW_JOB_NATURE')}} </a>
                                        </div>-->
                </div>
                <div class="portlet-body">
                    {{ Form::open(array('role' => 'form', 'url' => 'applicant/filter', 'class' => '', 'id' => 'jobTitleFilter')) }}
                    {!! Form::hidden('filter', Helper::queryPageStr($qpArr)) !!}
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="col-md-4 control-label">{{trans('english.JOB_TITLE')}}</label>
                                <div class="col-md-8">
                                    {!! Form::select('circular_id', $circularList, Request::get('circular_id'), array('id'=> 'jobTitle', 'class' => 'form-control dopdownselect')) !!}
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
                                    <th class="text-center vcenter" rowspan="2">{{trans('english.SL_NO')}}</th>
                                    <th class="text-center vcenter" rowspan="2">{{trans('english.JOB_TITLE')}}</th>
                                    <th class="text-center vcenter" colspan="4">{{trans('english.APPLICANT_INFO')}}</th>
                                    <!--<th>{{trans('english.STATUS')}}</th>-->
                                    <th class="text-center vcenter" rowspan="2" class="text-center">{{trans('english.ACTION')}}</th>
                                </tr>
                                <tr>
                                    <th class="text-center vcenter">{{trans('english.NAME')}}</th>
                                    <th class="text-center vcenter">{{trans('english.EMAIL')}}</th>
                                    <th class="text-center vcenter">{{trans('english.PHONE')}}</th>
                                    <th class="text-center vcenter">{{trans('english.CV')}}</th>
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
                                    <td>{{ $value->circular }}</td>
                                    <td>{{ $value->name}}</td>
                                    <td class="text-center">{{ $value->email }}</td>
                                    <td class="text-center">{{ $value->phone }}</td>
                                    <td class="text-center"><a href="{{ URL::to('public/uploads/website/cv/' . $value->cv) }}" download="{{ $value->name }}"><i class="fa fa-download"></i></a></td>
<!--                                    <td class="text-center">
                                        @if ($value->status == '1')
                                        <span class="label label-success">{{ trans('english.ACTIVE') }}</span>
                                        @else
                                        <span class="label label-warning">{{ trans('english.INACTIVE') }}</span>
                                        @endif
                                    </td>-->

                                    <td class="action-center">
                                        <div class='text-center'>
                                            <a class="btn btn-danger btn-xs discard  tooltips" data-rel="tooltip" data-toggle="modal" data-target="#viewModal" data-id="{{$value->id}}" href="#viewModal" id="discard_{{$value->id}}" title="{{trans('english.DISCARD')}}" data-container="body" data-trigger="hover" data-placement="top">

                                                <i class='fa fa-ban'></i>
                                            </a>
                                            <a class="btn btn-primary btn-xs review tooltips" data-placement="top" data-rel="tooltip" data-original-title="{{trans('english.REVIEWED')}}" data-toggle="modal" data-id ="{{$value->id}}" href="#viewModal" title="{{trans('english.REVIEWED')}}" id="reviewed_{{$value->id}}" data-container="body" data-trigger="hover" data-placement="top">
                                                <i class="fa fa-arrow-right"></i>
                                            </a>
                                            <a class="btn btn-warning btn-xs tooltips application-details" data-toggle="modal" data-target="#view-modal2" href="#view-modal2" data-placement="top" data-rel="tooltip" data-original-title="{{trans('english.VIEW_APPLICATION_DETAILS')}}" data-id ="{{$value->id}}" title="{{trans('english.VIEW_APPLICATION_DETAILS')}}" id="applicationDetails_{{$value->id}}" data-container="body" data-trigger="hover" data-placement="top">
                                                <i class="fa fa-bars"></i>
                                            </a>
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
                    <!--Paginator-->
                    @include('layouts.paginator')
                </div>
            </div>
        </div>
    </div>
</div>

<!--This module use for student other information edit-->
<div id="viewModal" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="col-md-12" id="applicantModal">
            <!-- mysql data will load in table -->

        </div>
    </div>
</div>

<div id="view-modal2" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="col-md-12" id="applicationContent">
            <!-- mysql data will load in table -->

        </div>
    </div>
</div>
<!-- END CONTENT BODY -->
<!-- END CONTENT BODY -->
<script type="text/javascript">
    $(document).on('click', '.application-details', function (e) {
        e.preventDefault();
        var applicationId = $(this).data('id'); // get id of clicked row

        $('#applicationContent').html(''); // leave this div blank
        $.ajax({
            url: "{{ URL::to('applicant/applicantion-info') }}",
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                application_id: applicationId
            },
            cache: false,
            contentType: false,
            success: function (response) {
                $('#applicationContent').html(''); // blank before load.
                $('#applicationContent').html(response.html); // load here
                $('.date-picker').datepicker({autoclose: true});
            },
            error: function (jqXhr, ajaxOptions, thrownError) {
                $('#applicationContent').html('<i class="fa fa-info-sign"></i> Something went wrong, Please try again...');
            }
        });
    });


    $(document).on('click', '.discard', function (e) {
        e.preventDefault();
        var jobId = $(this).data('id'); // get id of clicked row
        $('#applicantModal').html(''); // leave this div blank

        var options = {
            closeButton: true,
            debug: false,
            positionClass: "toast-bottom-right",
            onclick: null,
        };
        $.ajax({
            url: "{{ URL::to('applicant/applicant-discard-modal') }}",
            type: "POST",
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                job_applicant_id: jobId
            },

            success: function (response) {
                $('#applicantModal').html(''); // blank before load.
                $('#applicantModal').html(response.html); // load here
                $('.date-picker').datepicker({autoclose: true});
            },
            error: function (jqXhr, ajaxOptions, thrownError) {
                if (jqXhr.status == 400) {
                    var errorsHtml = '';
                    var errors = jqXhr.responseJSON.message;
                    $.each(errors, function (key, value) {
                        errorsHtml += '<li>' + value[0] + '</li>';
                    });
                    toastr.error(errorsHtml, jqXhr.responseJSON.heading, options);
                } else if (jqXhr.status == 401) {
                    toastr.error(jqXhr.responseJSON.message, '', options);
                } else {
                    toastr.error('Error', 'Something went wrong', options);
                }
            }
        });
    });

    $(document).on('click', "#discardApplication", function (e) {
        e.preventDefault();
        swal({
            title: "Are you sure?",
            text: "This application will be discard!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, discard it",
            cancelButtonText: "No, Don't void it",
            closeOnConfirm: true,
            closeOnCancel: true
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var options = {
                    closeButton: true,
                    debug: false,
                    positionClass: "toast-bottom-right",
                    onclick: null,
                };

                var formData = new FormData($("#discardApplicationForm")[0]);

                $.ajax({
                    url: "{{ URL::to('applicant/applicant-discard')}}",
                    type: "POST",
                    dataType: 'json', // what to expect back from the PHP script, if anything
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    beforeSend: function () {
                        $("#discardApplication").prop('disabled', true);
                        App.blockUI({boxed: true});
                    },
                    success: function (res) {
                        toastr.success(res.message, res.heading, options);
                        location = "{{ URL::to('/applicant') }}";
                    },
                    error: function (jqXhr, ajaxOptions, thrownError) {
                        if (jqXhr.status == 400) {
                            var errorsHtml = '';
                            var errors = jqXhr.responseJSON.message;
                            $.each(errors, function (key, value) {
                                errorsHtml += '<li>' + value[0] + '</li>';
                            });
                            toastr.error(errorsHtml, jqXhr.responseJSON.heading, options);
                        } else if (jqXhr.status == 401) {
                            toastr.error(jqXhr.responseJSON.message, '', options);
                        } else {
                            toastr.error('Error', 'Something went wrong', options);
                        }
                        $("#discardApplication").prop('disabled', false);
                        App.unblockUI();
                    }
                }); //ajax
            }
        });
    });

    $(document).on('click', '.review', function (e) {
//        alert("ok");
        e.preventDefault();
        var jobId = $(this).data('id'); // get id of clicked row

        $('#applicantModal').html(''); // leave this div blank
        $.ajax({
            url: "{{ URL::to('applicant/applicant-reviewed-modal') }}",
            type: "POST",
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                job_applicant_id: jobId
            },
            success: function (response) {
                $('#applicantModal').html(''); // blank before load.
                $('#applicantModal').html(response.html); // load here
                $('.date-picker').datepicker({autoclose: true});
            },
            error: function (jqXhr, ajaxOptions, thrownError) {
                $('#applicantModal').html('<i class="fa fa-info-sign"></i> Something went wrong, Please try again...');
            }
        });
    });

    $(document).on('click', "#reviewedApplication", function (e) {
        e.preventDefault();
        swal({
            title: "Are you sure?",
            text: "This application will be review!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, review it",
            cancelButtonText: "No, Don't void it",
            closeOnConfirm: true,
            closeOnCancel: true
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var options = {
                    closeButton: true,
                    debug: false,
                    positionClass: "toast-bottom-right",
                    onclick: null,
                };

                var formData = new FormData($("#reviewedApplicationForm")[0]);

                $.ajax({
                    url: "{{ URL::to('applicant/applicant-reviewed')}}",
                    type: "POST",
                    dataType: 'json', // what to expect back from the PHP script, if anything
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    beforeSend: function () {
                        $("#reviewedApplication").prop('disabled', true);
                        App.blockUI({boxed: true});
                    },
                    success: function (res) {
                        toastr.success(res.message, res.heading, options);
                        location = "{{ URL::to('/applicant') }}";
                    },
                    error: function (jqXhr, ajaxOptions, thrownError) {
                        if (jqXhr.status == 400) {
                            var errorsHtml = '';
                            var errors = jqXhr.responseJSON.message;
                            $.each(errors, function (key, value) {
                                errorsHtml += '<li>' + value[0] + '</li>';
                            });
                            toastr.error(errorsHtml, jqXhr.responseJSON.heading, options);
                        } else if (jqXhr.status == 401) {
                            toastr.error(jqXhr.responseJSON.message, '', options);
                        } else {
                            toastr.error('Error', 'Something went wrong', options);
                        }
                        $("#reviewedApplication").prop('disabled', false);
                        App.unblockUI();
                    }
                }); //ajax
            }
        });
    });
</script>
@stop
