<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="copyright col-md-8">
                <?php echo app('translator')->get('english.COPYRIGHT'); ?>
            </div>
            <div class="social-sites col-md-4">
                <div class="social-icons social-icons-color pull-right">          
                    <a href="#" class="social-icon social-facebook" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
                    <a href="#" class="social-icon social-twitter" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
                    <a href="#" class="social-icon social-youtube" title="Youtube" target="_blank"><i class="icon-youtube"></i></a>
                    <!--<a href="#" class="social-icon social-instagram" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>					
                    <a href="#" class="social-icon social-pinterest" title="Pinterest" target="_blank"><i class="icon-pinterest"></i></a>-->
                </div>
            </div>
        </div>
    </div>

</footer><!-- End .footer -->
</div><!-- End .page-wrapper -->
<button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>



<!-- Plugins JS File -->

<!--<script src="<?php echo e(asset('public/frontend/assets/js/jquery.min.js')); ?>"></script>-->
<script src="<?php echo e(asset('public/frontend/assets/js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/frontend/assets/js/jquery.hoverIntent.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/frontend/assets/js/jquery.waypoints.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/frontend/assets/js/superfish.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/frontend/assets/js/owl.carousel.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/frontend/assets/js/bootstrap-input-spinner.js')); ?>"></script>
<script src="<?php echo e(asset('public/frontend/assets/js/jquery.magnific-popup.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/frontend/assets/js/jquery.plugin.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/frontend/assets/js/jquery.countdown.min.js')); ?>"></script>
<!-- Main JS File -->
<!--------Album----------->
<script src="<?php echo e(asset('public/css/gallery/js/album.js.download.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/js/owl.carousel.min.js')); ?>"  type="text/javascript"></script>
<script src="<?php echo e(asset('public/css/gallery/js/gallery/picturefill.min.js')); ?>"  type="text/javascript"></script>
<script src="<?php echo e(asset('public/css/gallery/js/gallery/lightgallery.js')); ?>"  type="text/javascript"></script>
<script src="<?php echo e(asset('public/css/gallery/js/gallery/lg-thumbnail.js')); ?>"  type="text/javascript"></script>
<script src="<?php echo e(asset('public/css/gallery/js/gallery/lg-video.js')); ?>"  type="text/javascript"></script>
<script src="<?php echo e(asset('public/css/gallery/js/gallery/lg-autoplay.js')); ?>"  type="text/javascript"></script>
<script src="<?php echo e(asset('public/css/gallery/js/gallery/lg-zoom.js')); ?>"  type="text/javascript"></script>
<script src="<?php echo e(asset('public/css/gallery/js/gallery/lg-hash.js')); ?>"  type="text/javascript"></script>
<script src="<?php echo e(asset('public/css/gallery/js/gallery/lg-pager.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/css/gallery/js/gallery/jquery.mousewheel.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('public/css/gallery/js/nivo-lightbox.js')); ?>" type="text/javascript"></script>
<!--gallery-->
<script src="<?php echo e(asset('public/frontend/assets/js/main.js')); ?>"></script>
<script src="<?php echo e(asset('public/frontend/assets/js/dysin.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')); ?>" type="text/javascript"></script>
<script type="text/javascript">

$(document).on('click', '#submitBtn', function (e) {
    var email = $('#email').val();
    $.ajax({
        url: "<?php echo e(URL::to('userSubcription')); ?>",
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
            $('#success').text('<?php echo app('translator')->get("english.SUCCESSFULLY_SUBSCRIBED"); ?>');
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
});
$(document).ready(function () {
    $('.lightgallery').lightGallery();
});
</script>
<?php echo $__env->yieldContent('page-script'); ?>
</body>

</html>
<?php /**PATH E:\xampp-7.4.9\htdocs\swapnoloke\resources\views/website/layouts/footer.blade.php ENDPATH**/ ?>