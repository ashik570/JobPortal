<?php
$id = request()->route('id');
$title = $target['title'];
?>
@include('website.layouts.header')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row justify-content-center">
                <!--<div class="col-md-4"></div>-->
                <div class="col-md-5 mt-5 mb-5 main-div">

                    {{ Form::open(array('role' => 'form', 'url' => '', 'class' => 'form-horizontal apply', 'id' => 'apply')) }}
                    {{ Form::hidden('circular_id', $id) }}
                    {{ Form::hidden('title', $title) }}
<!--                    <h5 class="text-center">Applying for position of<span class="text-success">{{ $title }}</span> Post</h5>-->
                    @lang('english.APPLYING_POSITION', ['title' => $title])
                    <!-- Progress bar -->
                    <div class="progressbar">
                        <div class="progress" id="progress"></div>

                        <div class="progress-step progress-step-active" data-title="Basic Intro"></div>
                        <div class="progress-step" data-title="Verification"></div>
                        <div class="progress-step" data-title="Upload CV"></div>
                    </div>

                    <!-- Steps -->
                    <div class="form-step form-step-active">
                        <div class="input-group ml-21">
                            <label for="name">{{trans('english.NAME')}}:<span class="required"> *</span></label>
                            {{ Form::text('name', Request::get('name'), array('id'=> 'name', 'class' => '')) }}
                            <span class="help-block text-danger"> {{ $errors->first('name') }}</span>
                        </div>
                        <div class="input-group ml-21">
                            <label for="email">{{trans('english.EMAIL')}}:<span class="required"> *</span></label>
                            {{ Form::email('email', Request::get('email'), array('id'=> 'email', 'class' => '')) }}
                            <span class="help-block text-danger"> {{ $errors->first('email') }}</span>
                        </div>
                        <div class="input-group ml-21">
                            <label for="phone">{{trans('english.PHONE')}}:<span class="required"> *</span></label>
                            {{ Form::text('phone', Request::get('phone'), array('id'=> 'phone', 'class' => '')) }}
                            <span class="help-block text-danger"> {{ $errors->first('phone') }}</span>
                        </div>
                        <div class="justify-content-center d-flex mb-5">
                            <button type="button" class="btn mr-2 btn-primary btn-next proceed" id="btn-next">
                                {{trans('english.PROCEED')}}
                            </button>
                            <a href="{{URL::to('jobs/details',$id)}}">
                                <button type="button" class="btn btn-outline">{{ trans('english.CANCEL') }}</button> 
                            </a>
                        </div>
                    </div>

                    {{ Form::close() }}
                </div>
                <!--<div class="col-md-4"></div>-->
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        var countDown;
        var formStepsNum = 0;
        var options = {
            closeButton: true,
            debug: false,
            positionClass: "toast-bottom-right",
            onclick: null
        };

        $(document).on("click", ".proceed", function (e) {
            var formData = new FormData($('#apply')[0]);

            $.ajax({
                url: "{{ URL::to('jobs/intro') }}",
                type: 'POST',
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    $('.proceed').prop('disabled', true);
                    App.blockUI({boxed: true});
                },
                success: function (res) {
                    const applicant = {
                        name: res.data.name,
                        email: res.data.email,
                        phone: res.data.phone,
                        code: res.data.code
                    }

                    localStorage.setItem("applicant", JSON.stringify(applicant));

                    $('.proceed').prop('disabled', false);
                    $('.main-div').html(res.html);
                    verificationCountDown();
                    progressBar();
                    App.unblockUI();

                },
                error: function (jqXhr, ajaxOptions, thrownError) {
                    if (jqXhr.status == 400) {
                        var errorsHtml = '';
                        var errors = jqXhr.responseJSON.message;
                        $.each(errors, function (key, value) {
                            errorsHtml += '<li>' + value + '</li>';
                        });
                        toastr.error(errorsHtml, jqXhr.responseJSON.heading, options);
                    } else if (jqXhr.status == 401) {
                        toastr.error(jqXhr.responseJSON.message, '', options);
                    } else {
                        toastr.error('Error', 'Something went wrong', options);
                    }
                    $('.proceed').prop('disabled', false);
                    App.unblockUI();
                }
            });
        });

        $(document).on("click", ".verify", function (e) {

            var person = JSON.parse(localStorage.getItem('applicant'));
            var storageCode = person.code;
            var formCode = $("#code").val();
            var title = $("#title").val();
            var circularId = $("#circularId").val();

//                    console.log(storageCode);
            $.ajax({
                url: "{{ URL::to('jobs/verify') }}",
                type: 'POST',
//                        cache: false,
//                        contentType: false,
//                        processData: false,
                dataType: 'json',
                data: {storage_code: storageCode, form_code: formCode, title: title, circular_id: circularId},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    $('.verify').prop('disabled', true);
                    App.blockUI({boxed: true});
                },
                success: function (res) {
                    clearInterval(countDown);
                    $('.verify').prop('disabled', false);
                    $('.main-div').html(res.html);
                    progressBar();
                    App.unblockUI();

                },
                error: function (jqXhr, ajaxOptions, thrownError) {
                    if (jqXhr.status == 400) {
                        var errorsHtml = '';
                        var errors = jqXhr.responseJSON.message;
                        $.each(errors, function (key, value) {
                            errorsHtml += '<li>' + value + '</li>';
                        });
                        toastr.error(errorsHtml, jqXhr.responseJSON.heading, options);
                    } else if (jqXhr.status == 401) {
                        toastr.error(jqXhr.responseJSON.message, '', options);
                    } else {
                        toastr.error('Error', 'Something went wrong', options);
                    }
                    $('.verify').prop('disabled', false);
                    App.unblockUI();
                }
            });
        });

        $(document).on("click", ".submit", function (e) {
            var person = JSON.parse(localStorage.getItem('applicant'));
//                    console.log(person.name);
            var name = person.name;
            var email = person.email;
            var phone = person.phone;

//            var circularId = $("#circularId").val();
//            var cv = $("#cv").val();
//                    console.log(cv);
            var formData = new FormData($('#submit')[0]);
            formData.append('name',name);
            formData.append('email',email);
            formData.append('phone',phone);
            $.ajax({
                url: "{{ URL::to('jobs/store') }}",
                type: 'POST',
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    $('.submit').prop('disabled', true);
                    App.blockUI({boxed: true});
                },
                success: function (res) {
                    clearInterval(countDown);
                    $('.submit').prop('disabled', false);
                    $('.main-div').html(res.html);
                    progressBar();
                    App.unblockUI();

                },
                error: function (jqXhr, ajaxOptions, thrownError) {
                    if (jqXhr.status == 400) {
                        var errorsHtml = '';
                        var errors = jqXhr.responseJSON.message;
                        $.each(errors, function (key, value) {
                            errorsHtml += '<li>' + value + '</li>';
                        });
                        toastr.error(errorsHtml, jqXhr.responseJSON.heading, options);
                    } else if (jqXhr.status == 401) {
                        toastr.error(jqXhr.responseJSON.message, '', options);
                    } else {
                        toastr.error('Error', 'Something went wrong', options);
                    }
                    $('.submit').prop('disabled', false);
                    App.unblockUI();
                }
            });
        });


        function progressBar() {
            formStepsNum++;
            updateProgressbar();
//                    $('.timer')
//                    $("#timer").css("display", "block");
        }

        function updateProgressbar() {
            var progressSteps = $(".progress-step");
            var idx = 0;
            progressSteps.each(function () {
                if (idx < formStepsNum + 1) {
                    $(this).addClass("progress-step-active");
                } else {
                    $(this).removeClass("progress-step-active");
                }
                idx++;
            });
            var progressActive = $(".progress-step-active");

            var progressStyleWidth = ((progressActive.length - 1) / (progressSteps.length - 1)) * 100 + "%";
            $("#progress").css('width', progressStyleWidth);

        }

        function verificationCountDown() {
            // Set the date we're counting down to
            var countDownDate = new Date().getTime() + (2 * 60 * 1000);

            // Update the count down every 1 second
            countDown = setInterval(function () {

                // Get today's date and time
                var now = new Date().getTime();

                // Find the distance between now and the count down date
                var distance = countDownDate - now;

                // Time calculations for days, hours, minutes and seconds

                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Output the result in an element with id="demo"
                $(".time").html(minutes + ":" + seconds);

                // If the count down is over, write some text 
                if (distance <= 0) {
                    var circularId = $("#circularId").val();
                    localStorage.clear();
                    location = "{{ URL::to('/jobs/details/') }}/" + circularId;
                }
            }, 1000);
        }
    });



</script>
@include('website.layouts.footer') 