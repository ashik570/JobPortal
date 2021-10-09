@extends('layouts.default')
@section('content')
<div class="page-content">

    @include('includes.flash')

    <div class="row">
        <div class="col-md-12">
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-exchange"></i>{{trans('english.STUDENT_MIGRATION')}} 
                    </div>
                    <div class="tools">

                    </div>
                </div>
                <div class="portlet-body form">

                    {{ Form::open(array('role' => 'form', 'url' => '#', 'class' => 'form-horizontal', 'id'=>'migration')) }}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-7 col-md-offset-1">

                                <div class="form-group">
                                    <label class="col-md-6 control-label" for="course_id">{{trans('english.REGISTRATION_NO')}}</label>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            {{Form::number('registration_no', null, array('class' => 'form-control', 'id' => 'registration_no'))}}
                                            <span class="input-group-btn">
                                                <input type="submit" class="btn blue" id="search" value="Search..." />
                                            </span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">

                                <div id="migration-loader">
                                </div>

                            </div>
                        </div>

                    </div>

                    {{ Form::close() }}

                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $("#migration").bind('submit', function (e) {

        e.preventDefault();

        var registration_no = $('#registration_no').val();

        $.ajax({
            url: "{{ URL::to('migration/history')}}",
            type: "POST",
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            data: {"registration_no": registration_no},
            dataType: 'html',
            cache: false,
            beforeSend: function () {

            },
        }).done(function (response) {

            $('#migration-loader').html(response);

        });

    });


    $('body').on('click', '#migrate', function () {

        var registration_no = $('#registration_no').val();
        var user_id = $('#user_id').val();

        $.ajax({
            url: "{{ URL::to('migration/migrate')}}",
            type: "POST",
             headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            data: {"registration_no": registration_no, "user_id": user_id},
            dataType: 'html',
            cache: false,
            beforeSend: function () {

            },
        }).done(function (response) {

            $('#migration2-loader').html(response);

        });
    });


    /*$('body').on('change', '#program_id', function () {

        var registration_no = $('#registration_no').val();
        var program_id = $('#program_id').val();

        $.ajax({
            url: "{{ URL::to('migration/getCourse')}}",
            type: "POST",
            data: {"program_id": program_id, "registration_no": registration_no},
            dataType: 'html',
            cache: false,
            beforeSend: function () {

            },
        }).done(function (response) {

            $('#course-loader').html(response);

        });
    });*/


    $('body').on('click', '#confirm-migrate', function () {

        var course_id = $('#course_id').val();
        var registration_no = $('#registration_no').val();

        if (course_id == '0') {
            swal('Please, select course!');
            return false;
        }

        var consent = confirm('Are you sure you want to migrate?\nYou can\'t undo this action?');

        if (consent) {

            toastr.clear();
            toastr.info("Loading...", "Please Wait.", {"closeButton": true});
            
            var data = new FormData($('#migration')[0]);
            
            $.ajax({
                url: "{{ URL::to('migration/saveMigration')}}",
                type: "POST",
                //data: {"program_id": program_id, "course_id": course_id, "part_id": part_id, "student_id": student_id, "registration_no": registration_no},
                data: data,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                async: true,
                success: function (response) {

                    toastr.clear();
                    toastr.success(response.data, "Success", {"closeButton": true});

                    var registration_no = $('#registration_no').val();

                    $.ajax({
                        url: "{{ URL::to('migration/history')}}",
                        type: "POST", headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                        
                        data: {"registration_no": registration_no},
                        dataType: 'html',
                        cache: false,
                        beforeSend: function () {

                        },
                    }).done(function (response) {

                        $('#migration-loader').html(response);

                    });

                    return false;

                },
                error: function (jqXhr, ajaxOptions, thrownError) {

                    //alert(thrownError);return false;
                    var errorsHtml = '';
                    if (jqXhr.status == 400) {

                        var errors = jqXhr.responseJSON.message;
                        errorsHtml += 'Following students marks have not been put:';
                        $.each(errors, function (key, value) {
                            errorsHtml += '<li>' + value[0] + '</li>';
                        });
                        toastr.error(errorsHtml, jqXhr.responseJSON.heading, {"closeButton": true, "timeOut": 0, "extendedTimeOut": 0, "onclick": null});

                    } else if (jqXhr.status == 500) {
                        toastr.error(jqXhr.responseJSON.error.message, jqXhr.statusText, {"closeButton": true});
                    } else if (jqXhr.status == 401) {
                        toastr.error(jqXhr.responseJSON.message, jqXhr.responseJSON.heading, {"closeButton": true});
                    } else {
                        toastr.error("Error", "Something went wrong", {"closeButton": true});
                    }
                }
            }).done(function (response) {

            });
        }


        $('#program-course-holder').modal('hide');


    });



    $('body').on('click', '#confirm-new-expiary-date', function () {

        var maximum_tenure = $('#maximum_tenure').val();
        var remarks = $('#remarks').val();
        var registration_no = $('#registration_no').val();

        var data = new FormData($('#migration')[0]);

        if (maximum_tenure == '') {
            alert('Please, Select New Expiary Date!');
            return false;
        }

        if (remarks == '') {
            alert('Please, Insert Remarks');
            return false;
        }

        var consent = confirm('Are you sure you want to extend expiary date?\nYou can\'t undo this action?');

        if (consent) {

            toastr.clear();
            toastr.info("Loading...", "Please Wait.", {"closeButton": true});

            $.ajax({
                url: "{{ URL::to('migration/extendExpiaryDate')}}",
                type: "POST",
                //data: {"maximum_tenure": maximum_tenure, "remarks": remarks, "registration_no": registration_no},
                data: data,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                async: true,
                success: function (response) {

                    toastr.clear();
                    toastr.success(response.data, "Success", {"closeButton": true});

                    var registration_no = $('#registration_no').val();

                    $.ajax({
                        url: "{{ URL::to('migration/history')}}",
                        type: "POST",
                        data: {"registration_no": registration_no},
                        dataType: 'html',
                        cache: false,
                        beforeSend: function () {

                        },
                    }).done(function (response) {

                        $('#migration-loader').html(response);

                    });

                    return false;

                },
                error: function (jqXhr, ajaxOptions, thrownError) {

                    //alert(thrownError);return false;
                    var errorsHtml = '';
                    if (jqXhr.status == 400) {

                        var errors = jqXhr.responseJSON.message;
                        errorsHtml += 'Following students marks have not been put:';
                        $.each(errors, function (key, value) {
                            errorsHtml += '<li>' + value[0] + '</li>';
                        });
                        toastr.error(errorsHtml, jqXhr.responseJSON.heading, {"closeButton": true, "timeOut": 0, "extendedTimeOut": 0, "onclick": null});

                    } else if (jqXhr.status == 500) {
                        toastr.error(jqXhr.responseJSON.error.message, jqXhr.statusText, {"closeButton": true});
                    } else if (jqXhr.status == 401) {
                        toastr.error(jqXhr.responseJSON.message, jqXhr.responseJSON.heading, {"closeButton": true});
                    } else {
                        toastr.error("Error", "Something went wrong", {"closeButton": true});
                    }
                }
            }).done(function (response) {

            });
        }


        $('#extend-expiary-date').modal('hide');


    });

</script>
@stop

