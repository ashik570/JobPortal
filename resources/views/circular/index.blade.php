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
                        <i class="fa fa-cubes"></i>{{trans('english.VIEW_CIRCULAR')}}
                    </div>
                    <div class="actions">
                        <a href="{{ URL::to('circular/create') }}" class="btn btn-default btn-sm">
                            <i class="fa fa-plus"></i> {{trans('english.CREATE_NEW_CIRCULAR')}} </a>
                    </div>
                </div>
                <div class="portlet-body">
                    {{ Form::open(array('role' => 'form', 'url' => 'circular/filter', 'class' => '', 'id' => 'circularFilter')) }}
                    {!! Form::hidden('filter', Helper::queryPageStr($qpArr)) !!}
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="col-md-4 control-label">{{trans('english.SEARCH_TEXT')}}</label>
                                <div class="col-md-8">
                                    {{ Form::text('search_text', Request::get('search_text'), array('id'=> 'circularSearchText', 'class' => 'form-control', 'placeholder' => 'Enter Search Text')) }}
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
                                    <th>{{trans('english.TITLE')}}</th>
                                    <th>{{trans('english.JOB_NATURE')}}</th>
                                    <th>{{trans('english.VACANCY')}}</th>
                                    <th>{{trans('english.EXPERIENCE')}}</th>
                                    <th>{{trans('english.SALARY')}}</th>
                                    <th>{{trans('english.SUBMISSION_DATE')}}</th>
                                    <th>{{trans('english.DEADLINE')}}</th>
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
                                <?php
                                $salaryTypeArr = Common::salaryTypes();
//                                dd($value->salary_type);
                                $salaryType = '';
                                if (!empty($value->salary_type)) {
                                    $salaryType = "(" . $salaryTypeArr[$value->salary_type] . ")";
                                }

                                $salaryRange = "";
                                if (!empty($value->nigotiable)) {
                                    $salaryRange = "nigotiable";
                                } else {
                                    if (!empty($value->salary_from) && !empty($value->salary_to) || !empty($value->salary_to)) {
                                        if (empty($value->salary_from)) {
                                            $salaryRange = "0 to " . $value->salary_to." Tk";
                                        } else {
                                            $salaryRange = $value->salary_from . " to " . $value->salary_to." Tk";
                                        }
                                    } else {
                                        $salaryRange = $value->salary_from." Tk";
                                    }
                                }
                                ?>
                                <tr class="contain-center">
                                    <td>{{ ++$sl}}</td>
                                    <td>{{ $value->title}}</td>
                                    <td>{{ $value->jobNature->name }}</td>
                                    @if(!empty($value->vacancy))
                                    <td class="text-center">{{ $value->vacancy }}</td>
                                    @else
                                    <td class="text-center">Not Specific</td>
                                    @endif
                                    <?php
                                    $message = '';
                                    $s = '';
                                    if (!empty($value['experience_not_required'])) {
                                        $message = "N/A";
                                    } else {
                                        if (!empty($value['experience_from']) && !empty($value['experience_to']) || !empty($value['experience_to'])) {
                                            if ($value['experience_to'] - $value['experience_from'] >= 1) {
                                                $s = 's';
                                            }
                                            $message = $value['experience_from'] . " to " . $value['experience_to'] . " year" . $s;
                                        } else {
                                            if ($value['experience_from'] > 1) {
                                                $s = 's';
                                            }
                                            $message = "At least " . $value['experience_from'] . " year" . $s;
                                        }
                                    }
                                    ?>
                                    <td class="text-center">{{ $message }}</td>
                                    <td class="text-center">{{ $salaryRange." ".$salaryType }}</td>
                                    <td class="text-center">{!! date('d F Y',strtotime($value->submission_date)) !!}</td>
                                    <td class="text-center">{!! date('d F Y',strtotime($value->deadline)) !!}</td>
                                    <td class="text-center">
                                        @if ($value->status == '1')
                                        <span class="label label-success">{{ trans('english.ACTIVE') }}</span>
                                        @else
                                        <span class="label label-warning">{{ trans('english.INACTIVE') }}</span>
                                        @endif
                                    </td>

                                    <td class="action-center">
                                        <div class='text-center'>
                                            {{ Form::open(array('url' => 'circular/delete/' . $value->id, 'id' => 'delete')) }}
                                            {{ Form::hidden('_method', 'DELETE') }}
                                            <a class="tooltips btn btn-primary btn-xs" href="{{ URL::to('circular/' . $value->id . '/edit'.Helper::queryPageStr($qpArr)) }}" title="{{trans('english.EDIT_CIRCULAR')}}" data-container="body" data-trigger="hover" data-placement="top">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <a class="tooltips get-circular-info" data-toggle="modal" data-target="#viewModal" data-id="{{$value->id}}" href="#viewModal" id="getCircularInfo_{{$value->id}}" title="{{trans('english.CIRCULAR_DETAILS')}}" data-container="body" data-trigger="hover" data-placement="top">
                                                <span class="btn btn-success btn-xs"> 
                                                    &nbsp;<i class='fa fa-info'></i>&nbsp;
                                                </span>
                                            </a>
                                            <!--<div class="mb-2"></div>-->
                                            <button class="tooltips btn btn-danger btn-xs" type="submit" data-placement="top" title="{{trans('english.CIRCULAR_DELETE')}}" data-rel="tooltip" data-original-title="{{trans('english.CIRCULAR_DELETE')}}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            {{ Form::close() }}
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="15">{{trans('english.EMPTY_DATA')}}</td>
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

<!--This module use for student other information edit-->
<div id="viewModal" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="col-md-12" id="dynamicContent">
            <!-- mysql data will load in table -->
            
        </div>
    </div>
</div>
<!-- END CONTENT BODY -->
<script type="text/javascript">
    $(document).on('click', '.get-circular-info', function (e) {
        e.preventDefault();
        var userId = $(this).data('id'); // get id of clicked row

        $('#dynamicContent').html(''); // leave this div blank
        $.ajax({
            url: "{{ URL::to('circular/circular-info') }}",
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                user_id: userId
            },
            cache: false,
            contentType: false,
            success: function (response) {
                $('#dynamicContent').html(''); // blank before load.
                $('#dynamicContent').html(response.html); // load here
                $('.date-picker').datepicker({autoclose: true});
            },
            error: function (jqXhr, ajaxOptions, thrownError) {
                $('#dynamicContent').html('<i class="fa fa-info-sign"></i> Something went wrong, Please try again...');
            }
        });
    });

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
