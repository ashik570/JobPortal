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
                        <i class="fa fa-user"></i>View User
                    </div>
                    <div class="actions">
                        <a href="{{ URL::to('users/create') }}" class="btn btn-default btn-sm">
                            <i class="fa fa-plus"></i> {{trans('english.CREATE_A_USER')}} </a>
                    </div>
                </div>
                <div class="portlet-body">

                    {{ Form::open(array('role' => 'form', 'url' => 'users/filter', 'class' => '', 'id' => 'userFilter')) }}
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">{{trans('english.SELECT_GROUP')}}</label>
                                {{Form::select('group_id', $groupList, Request::get('group_id'), array('class' => 'form-control dopdownselect', 'id' => 'userGroupId'))}}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">{{trans('english.SELECT_RANK')}}</label>
                                {{Form::select('rank_id', $designationList, Request::get('designation_id'), array('class' => 'form-control dopdownselect', 'id' => 'userDesignationId'))}}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">{{trans('english.SELECT_APPROINTMENT')}}</label>
                                {{Form::select('appointment_id', $appointmentList, Request::get('appointment_id'), array('class' => 'form-control dopdownselect', 'id' => 'userApprointmentId'))}}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group tooltips" title="Search by Username/First Name/Last Name/Official Name/Service No">
                                <label class="control-label">{{trans('english.SEARCH_TEXT')}}</label>
                                {{ Form::text('search_text', Request::get('search_text'), array('id'=> 'userSearchText', 'class' => 'form-control', 'placeholder' => 'Enter Search Text')) }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-offset-4 col-md-4">
                            <button type="submit" class="btn btn-md green btn-outline filter-submit margin-bottom-20">
                                <i class="fa fa-search"></i> Filter
                            </button>
                        </div>
                    </div>
                    {{Form::close()}}
                    <div class="row">
                        <div class="table-responsive">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>{{trans('english.SL_NO')}}</th>
                                            <th>{{trans('english.USER_GROUP')}}</th>
                                            <th>{{trans('english.DESIGNATION')}}</th>
                                            <th>{{trans('english.APPOINTMENT')}}</th>
                                            <th>{{trans('english.BRANCH')}}</th>
                                            <th>{{trans('english.NAME')}}</th>
                                            <th>{{trans('english.USERNAME')}}</th>
                                            <th class='text-center'>{{trans('english.PHOTO')}}</th>
                                            <th class="text-center">{{trans('english.ACCOUNT_CONFIRMED')}}</th>
                                            <th>{{trans('english.STATUS')}}</th>
                                            <th class='text-center'>{{trans('english.ACTION')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!$usersArr->isEmpty())
                                        <?php
                                        $page = Request::get('page');
                                        $page = empty($page) ? 1 : $page;
                                        $sl = ($page - 1) * trans('english.PAGINATION_COUNT');
                                        ?>
                                        @foreach($usersArr as $value)

                                        <tr class="contain-center">
                                            <td>{{++$sl}}</td>
                                            <td>{{$value->UserGroup->name}}</td>
                                            <td>{{$value->designation->title}}</td>
                                            <td>{{$value->appointment->title}}</td>
                                            <td>{{ !empty($value->branch->name) ? $value->branch->name: '' }}</td>
                                            <td>{{ $value->first_name }} {{ $value->last_name }}</td>
                                            <td>{{ $value->username }}</td>
                                            <td class="text-center">
                                                @if(isset($value->photo))
                                                <img width="100" height="100" src="{{URL::to('/')}}/public/uploads/thumbnail/{{$value->photo}}" alt="{{ $value->first_name.' '.$value->last_name }}">
                                                @else
                                                <img width="100" height="100" src="{{URL::to('/')}}/public/img/unknown.png" alt="{{ $value->first_name.' '.$value->last_name }}">
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($value->password_changed == '1')
                                                <span class="label label-success">{{trans('english.YES')}}</span>
                                                @else
                                                <span class="label label-warning">{{trans('english.NO')}}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($value->status == 'active')
                                                <span class="label label-success">{{ $value->status }}</span>
                                                @else
                                                <span class="label label-warning">{{ $value->status }}</span>
                                                @endif
                                            </td>

                                            <td class="action-center">
                                                <div class="text-center user-action">
                                                    {{ Form::open(array('url' => 'users/' . $value->id, 'id' => 'delete')) }}
                                                    {{ Form::hidden('_method', 'DELETE') }}

                                                    <?php
                                                    $dd = Request::query();
                                                    if (!empty($dd)) {
                                                        $param = '';
                                                        $sn = 1;

                                                        foreach ($dd as $key => $item) {
                                                            if ($sn === 1) {
                                                                $param .= $key . '=' . $item;
                                                            } else {
                                                                $param .= '&' . $key . '=' . $item;
                                                            }
                                                            $sn++;
                                                        }//foreach
                                                    }
                                                    ?>
                                                    @if((Auth::user()->group_id == 1) || (Auth::user()->group_id != $value->group_id))
                                                    <a class='btn btn-info btn-xs tooltips' href="{{ URL::to('users/activate/' . $value->id ) }}@if(isset($param)){{'/'.$param }} @endif" data-rel="tooltip" title="@if($value->status == 'active') Inactivate @else Activate @endif" data-container="body" data-trigger="hover" data-placement="top">
                                                        @if($value->status == 'active')
                                                        <i class='fa fa-remove'></i>
                                                        @else
                                                        <i class='fa fa-check-circle'></i>
                                                        @endif
                                                    </a>
                                                    @endif
                                                    <a class='btn btn-primary btn-xs tooltips' href="{{ URL::to('users/' . $value->id . '/edit') }}" title="Edit User" data-container="body" data-trigger="hover" data-placement="top">
                                                        <i class='fa fa-edit'></i>
                                                    </a>
                                                    <a class="tooltips" href="{{ URL::to('users/cp/' . $value->id) }}@if(isset($param)){{'/'.$param }} @endif" data-original-title="Change Password">
                                                        <span class="btn btn-success btn-xs"> 
                                                            <i class="fa fa-key"></i>
                                                        </span>
                                                    </a>
                                                    <a class="tooltips" data-toggle="modal" data-target="#view-modal" data-id="{{$value->id}}" href="#view-modal" id="getStudentInfo" title="Details User Information" data-container="body" data-trigger="hover" data-placement="top">
                                                        <span class="btn btn-success btn-xs"> 
                                                            &nbsp;<i class='fa fa-info'></i>&nbsp;
                                                        </span>
                                                    </a>
                                                    @if((Auth::user()->group_id == 1) || (Auth::user()->group_id != $value->group_id))
                                                    <button class="btn btn-danger btn-xs tooltips" type="submit" title="Delete" data-placement="top" data-rel="tooltip" data-original-title="Delete">
                                                        <i class='fa fa-trash'></i>
                                                    </button>
                                                    @endif
                                                    {{ Form::close() }}
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="11">{{trans('english.EMPTY_DATA')}}</td>
                                        </tr>
                                        @endif 
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5 col-sm-5">
                            <div class="dataTables_info" role="status" aria-live="polite">

                                <?php
                                $start = empty($usersArr->total()) ? 0 : (($usersArr->currentPage() - 1) * $usersArr->perPage() + 1);
                                $end = ($usersArr->currentPage() * $usersArr->perPage() > $usersArr->total()) ? $usersArr->total() : ($usersArr->currentPage() * $usersArr->perPage());
                                ?> <br />
                                @lang('english.SHOWING') {{ $start }} @lang('english.TO') {{$end}} @lang('english.OF')  {{$usersArr->total()}} @lang('english.RECORDS')
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-7">
                            {{ $usersArr->appends(Request::all())->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END CONTENT BODY -->
<!--This module use for student other information edit-->
<div id="view-modal" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="dynamic-content"><!-- mysql data will load in table -->
        </div>
    </div>
</div>

<script type="text/javascript">
    // ****************** Ajax Code for children edit *****************
    $(document).on('click', '#getStudentInfo', function (e) {
        e.preventDefault();
        var userId = $(this).data('id'); // get id of clicked row

        $('#dynamic-content').html(''); // leave this div blank
        $.ajax({
            url: "{{ URL::to('ajaxresponse/user-info') }}",
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
                $('#dynamic-content').html(''); // blank before load.
                $('#dynamic-content').html(response.html); // load here
                $('.date-picker').datepicker({autoclose: true});
            },
            error: function (jqXhr, ajaxOptions, thrownError) {
                $('#dynamic-content').html('<i class="fa fa-info-sign"></i> Something went wrong, Please try again...');
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
