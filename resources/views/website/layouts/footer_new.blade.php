<footer class="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-lg-4 col-md-4">
                    <h3 class="title">
                        @lang('english.MAIL_AND_WEBSITE')
                    </h3>
                    <div class="footer-content">
                        <div class="contact-us">
                            <ul class="">
                                <i class="fa fa-envelope" aria-hidden="true"></i> &nbsp; {{$targetContactInfo->email??''}}
                                <br/>
                                <i class="fa fa-globe" aria-hidden="true"></i> &nbsp;
                                {{$targetContactInfo->website??''}}
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-6 col-lg-4 col-md-4">
                    <div class="footer-content">
                        <div class="contact-us">
                            <h3 class="title">@lang('english.CONTACT_INFO')</h3>
                            <?php
                            $phoneArr = explode(",", $targetContactInfo->phone)
                            ?>

                            <ul class="">
                                @foreach($phoneArr as $phone)
                                <i class="fa fa-phone" aria-hidden="true"></i> &nbsp;{{$phone}}<br/>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-6 col-lg-4 col-md-4">
                    <div class="footer-content">
                        <div class="contact-us">
                            <h3 class="title">@lang('english.ADDRESS')</h3>
                            <ul class="">
                                <i class="fa fa-map-marker" aria-hidden="true"></i> &nbsp; {!!$targetContactInfo->address??''!!}
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Boxes de Acoes -->
            </div>
        </div>
    </div>
    <div class="footer-last">
        <div class="container">
            <div class="row">
                <!--My Portfolio  dont Copy this -->
                <div class="copyright col-md-8">
                    @lang('english.COPYRIGHT')
                </div>
                <div class="social-sites col-md-4">
                    <div class="social-icons social-icons-color"> 
                        <i class="fa fa-question-circle" aria-hidden"true"=""></i>
                        <a href="http://dysin.krittika.org/faq-us" style="margin-right: 50px;">FAQ</a>
                        <a href="#" class="social-icon social-facebook" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
                        <a href="#" class="social-icon social-twitter" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
                        <a href="#" class="social-icon social-youtube" title="Youtube" target="_blank"><i class="icon-youtube"></i></a>
                        <!--<a href="#" class="social-icon social-instagram" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>					
                        <a href="#" class="social-icon social-pinterest" title="Pinterest" target="_blank"><i class="icon-pinterest"></i></a>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer><!-- End .footer -->
</div><!-- End .page-wrapper -->
<button id="scroll-top" title="@lang('english.BACK_TO_TOP')"><i class="icon-arrow-up"></i></button>


<!-- Plugins JS File -->
<script src="{{ asset('public/frontend/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('public/frontend/assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('public/frontend/assets/js/jquery.hoverIntent.min.js') }}"></script>
<script src="{{ asset('public/frontend/assets/js/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('public/frontend/assets/js/superfish.min.js') }}"></script>
<script src="{{ asset('public/frontend/assets/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('public/frontend/assets/js/bootstrap-input-spinner.js') }}"></script>
<script src="{{ asset('public/frontend/assets/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('public/frontend/assets/js/jquery.plugin.min.js') }}"></script>
<script src="{{ asset('public/frontend/assets/js/jquery.countdown.min.js') }}"></script>
<!-- Main JS File -->
<!--------Album----------->
<script src="{{asset('public/css/gallery/js/album.js.download.js')}}" type="text/javascript"></script>
<script src="{{asset('public/js/owl.carousel.min.js')}}"  type="text/javascript"></script>
<script src="{{asset('public/css/gallery/js/gallery/picturefill.min.js')}}"  type="text/javascript"></script>
<script src="{{asset('public/css/gallery/js/gallery/lightgallery.js')}}"  type="text/javascript"></script>
<script src="{{asset('public/css/gallery/js/gallery/lg-thumbnail.js')}}"  type="text/javascript"></script>
<script src="{{asset('public/css/gallery/js/gallery/lg-video.js')}}"  type="text/javascript"></script>
<script src="{{asset('public/css/gallery/js/gallery/lg-autoplay.js')}}"  type="text/javascript"></script>
<script src="{{asset('public/css/gallery/js/gallery/lg-zoom.js')}}"  type="text/javascript"></script>
<script src="{{asset('public/css/gallery/js/gallery/lg-hash.js')}}"  type="text/javascript"></script>
<script src="{{asset('public/css/gallery/js/gallery/lg-pager.js')}}" type="text/javascript"></script>
<script src="{{asset('public/css/gallery/js/gallery/jquery.mousewheel.min.js')}}" type="text/javascript"></script>
<script src="{{asset('public/css/gallery/js/nivo-lightbox.js')}}" type="text/javascript"></script>
<!--gallery-->
<script src="{{ asset('public/frontend/assets/js/main.js') }}"></script>
<script src="{{ asset('public/frontend/assets/js/dysin.js') }}"></script>
<script src="{{ asset('public/frontend/assets/js/jquery.marquee.js') }}"></script>
<script type="text/javascript">

$(document).on('click', '#submitBtn', function (e) {
    var email = $('#email').val();
    $.ajax({
        url: "{{URL::to('userSubcription')}}",
        type: 'POST',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            email: email
        },
        beforeSend: function () {
            $('#display').html('');
        },
        success: function (res) {
            $('#success').text('@lang("english.SUCCESSFULLY_SUBSCRIBED")');
            $('#error').text('');
        },
        error: function (jqXhr, ajaxOptions, thrownError) {
            if (jqXhr.status == 400) {
            } else if (jqXhr.status == 401) {
                $('#error').text(jqXhr.responseJSON.message);
                $('#success').text(' ');
            } else {
                $('#error').text('Error');
                $('#success').text(' ');
            }

        }
    });
});

$(document).ready(function () {
    $(".active-child").closest("li.parent-item").addClass('active');
    
    $('.lightgallery').lightGallery();
});
</script>
@yield('page-script')
</body>

</html>
