<div class="form-group">
    <label class="control-label col-md-3" for="image">@lang('english.FEATURED_IMAGE') :<span class="text-danger"> *</span></label>
    <div class="col-md-7">
        <div class="cv">
            <img src="{{URL::to('/')}}/public/img/no-image.png" alt=""/>
        </div>
        <!-- input file -->
        <div class="box mt-10">
            <input type="file" name="featured_icon" id="featuredIcon">
            <span class="text-danger">{{ $errors->first('featured_icon') }}</span>
            <div class="clearfix margin-top-10">
                <span class="label label-danger">@lang('english.NOTE')</span> @lang('english.ACCEPTED_IMAGE_FORMATE_jpg_png_jpeg_gif')
            </div>
        </div>				
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label"></label>
    <div class="col-md-4">
        <!-- leftbox -->
        <div class="result-icon"></div>
        <!-- crop btn -->
        <button class="c-btn crop3 btn red mt-ladda-btn ladda-button btn-circle hide" type="button">@lang('english.CROP')</button>
    </div>

    <div class="col-md-4">
        <div class="col-md-offset-1">
            <!-- input file -->
            <img class="cropped3 view-image" src="" alt="">
            <input type="hidden" name="croped_image_icon" id="cropImg3" value="">
        </div>
        <div class="box">
            <div class="options3 hide">
                <input type="hidden" class="icon-w" value="300" min="80" max="1300" />
            </div>
        </div>
    </div>
    
</div>


<script type="text/javascript">

        $(document).on("click", '#featuredIcon', function (e) {
            $(".cv").hide();
        });
        //Added for Cropper use for CoverPhoto
        let result3 = document.querySelector('.result-icon'),
        icon_w = document.querySelector('.icon-w'),
        options3 = document.querySelector('.options3'),
        crop3 = document.querySelector('.crop3'),
        cropped3 = document.querySelector('.cropped3'),
        upload3 = document.querySelector('#featuredIcon'),
        cropper3 = '';
        var fileTypes3 = ['jpg', 'jpeg', 'png', 'gif'];
        // on change show image with crop options
        uploadfileTypes3.addEventListener('change', function (f) {

        if (f.target.files.length) {
        // start file reader
        const reader3 = new FileReader();
                var file3 = f.target.files[0]; // Get your file here
                var fileExt3 = file3.type.split('/')[1]; // Get the file extension
                if (fileTypes3.indexOf(fileExt3) !== - 1) {
        reader3.onload = function (f) {
//          console.log(f.target.result);
        if (f.target.result) {
        // create new image
        let img = document.createElement('img');
                img.id = 'sign';
                img.src = f.target.result
                // clean result before
                result3.innerHTML = '';
                // append new image
                result3.appendChild(img);
                // show crop btn and options
                crop3.classList.remove('hide');
                options3.classList.remove('hide');
                // init cropper3
                cropper3 = new Cropper(img, {
                aspectRatio: 40 / 30,
                        quality: 1,
                        imageSmoothingQuality : 'high',
                });
        }
        };
                reader3.readAsDataURL(file3);
        } else {
        alert('File not supported');
                return false;
        }
        }
        });
        // crop on click
        crop3.addEventListener('click', function (f) {
        f.preventDefault();
            // get result to data uri
            let imgSrc = cropper3.getCroppedCanvas({
            width: icon_w.value // input value
            }).toDataURL();
            // remove hide class of img
            cropped3.classList.remove('hide');
            // show image cropped
            cropped3.src = imgSrc;
            $('#cropImg3').val(imgSrc);
        });
//crop sign end 



</script>