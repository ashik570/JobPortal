@extends('layouts.default')
@section('content')
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-road"></i>@lang('english.ADD_FACULTY')
            </div>
        </div>
        <div class="portlet-body form">
            {!! Form::open(array('group' => 'form', 'url' => 'faculty', 'files'=> true, 'class' => 'form-horizontal')) !!}
            {!! Form::hidden('filter', Helper::queryPageStr($qpArr)) !!}
            {{csrf_field()}}
            <div class="form-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label col-md-3" for="name">@lang('english.NAME') :<span class="text-danger"> *</span></label>
                            <div class="col-md-5">
                                {!! Form::text('name', null, ['id'=> 'name', 'class' => 'form-control','autocomplete'=>'off']) !!} 
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3" for="rankId">@lang('english.RANK') :<span class="text-danger"> *</span></label>
                            <div class="col-md-5">
                                {!! Form::select('rank_id', $rankList, null, ['id'=> 'rankId', 'class' => 'form-control  js-source-states','autocomplete'=>'off']) !!} 
                                <span class="text-danger">{{ $errors->first('rank_id') }}</span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-3" for="apptId">@lang('english.APPT') :<span class="text-danger"> *</span></label>
                            <div class="col-md-5">
                                {!! Form::select('appt_id', $apptList, null, ['id'=> 'apptId', 'class' => 'form-control  js-source-states','autocomplete'=>'off']) !!} 
                                <span class="text-danger">{{ $errors->first('appt_id') }}</span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-3 control-label">{{trans('english.DOC')}} : </label>
                            <div class="col-md-5">
                                <div class="input-group input-large date-picker input-daterange" data-date="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd">
                                    {{ Form::text('doc', Request::get('doc'), array('id'=> 'doc', 'class' => 'form-control datepicker2', 'placeholder' => 'Enter Date of Commissioning')) }}
                                </div>
                                <span class="help-block text-danger"> {{ $errors->first('doc') }} </span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-3 control-label">{{trans('english.DOP')}} : </label>
                            <div class="col-md-5">
                                <div class="input-group input-large date-picker input-daterange" data-date="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd">
                                    {{ Form::text('dop', Request::get('dop'), array('id'=> 'dop', 'class' => 'form-control datepicker2', 'placeholder' => 'Enter Date of Posting')) }}
                                </div>
                                <span class="help-block text-danger"> {{ $errors->first('dop') }} </span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-3 control-label">{{trans('english.DOB')}} :</label>
                            <div class="col-md-5">
                                <div class="input-group input-large date-picker input-daterange" data-date="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd">
                                    {{ Form::text('dob', Request::get('dob'), array('id'=> 'dob', 'class' => 'form-control datepicker2', 'placeholder' => 'Enter Date of Birth')) }}
                                </div>
                                <span class="help-block text-danger"> {{ $errors->first('dob') }} </span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-3 control-label">{{trans('english.DOM')}} :</label>
                            <div class="col-md-5">
                                <div class="input-group input-large date-picker input-daterange" data-date="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd">
                                    {{ Form::text('dom', Request::get('dom'), array('id'=> 'dom', 'class' => 'form-control datepicker2', 'placeholder' => 'Enter Date of Merrage')) }}
                                </div>
                                <span class="help-block text-danger"> {{ $errors->first('dom') }} </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" for="spouse">@lang('english.SPOUSE') :</label>
                            <div class="col-md-5">
                                {!! Form::text('spouse', null, ['id'=> 'spouse', 'class' => 'form-control','autocomplete'=>'off']) !!} 
                                <span class="text-danger">{{ $errors->first('spouse') }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" for="contactNumber">@lang('english.CONTACT_NO') :</label>
                            <div class="col-md-5">
                                {!! Form::text('contact_no', null, ['id'=> 'contactNumber', 'class' => 'form-control','autocomplete'=>'off']) !!} 
                                <span class="text-danger">{{ $errors->first('contact_no') }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" for="spouse">@lang('english.CHILDREN') :</label>
                            <div class="col-md-5">
                            <div class="table-responsive">  
                                <table class="table " id="dynamic_field">  
                                    <tr>  
                                        <td><input type="text" name="child[0][name]" placeholder="Name" class="form-control" /></td>  
                                        <td><input type="number" name="child[0][age]" placeholder="Age" class="form-control" /></td>  
                                        <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>  
                                    </tr>  
                                </table>  
                            </div>
                         </div> 
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-3" for="">@lang('english.CONDUTING_THE_CLASSES') :</label>
                            <div class="col-md-5">
                            <div class="table-responsive">  
                                <table class="table " id="dynamic_field2">  
                                    <tr>  
                                        <td><input type="text" name="conducting_the_classes[]" placeholder="Type Place" class="form-control" /></td> 
                                        <td><button type="button" name="add" id="add2" class="btn btn-success">Add More</button></td>  
                                    </tr>  
                                </table>  
                            </div>
                         </div> 
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-3" for="image">@lang('english.PHOTO') :</label>
                            <div class="col-md-7">
                                <div class="cv">
                                    <img width="250" src="{{URL::to('/')}}/public/uploads/website/no-image.png" alt=""/>
                                </div>
                                <!-- input file -->
                                <div class="box mt-10">
                                    <input type="file" name="image" id="ocImage">
                                    <span class="text-danger">{{ $errors->first('image') }}</span>
                                    <span class="text-danger">{{ $errors->first('cropError') }}</span>
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
                                <div class="result-sign"></div>
                                <!-- crop btn -->
                                <button class="c-btn crop2 btn red mt-ladda-btn ladda-button btn-circle hide" type="button">@lang('english.CROP')</button>
                            </div>

                            <div class="col-md-4">
                                <div class="col-md-offset-1">
                                    <!-- input file -->
                                    <img class="cropped2 view-image" src="" alt="">
                                    <input type="hidden" name="croped_image" id="cropImg2" value="">
                                </div>
                                <div class="box">
                                    <div class="options2 hide">
                                        <input type="hidden" class="sign-w" value="300" min="80" max="1200" />
                                    </div>
                                </div>
                            </div>			
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3" for="userName">@lang('english.ORDER') :<span class="text-danger"> *</span></label>
                            <div class="col-md-5">
                                {!! Form::select('order', $orderList, $lastOrderNumber, ['id'=> 'order_id', 'class' => 'form-control js-source-states','autocomplete'=>'off']) !!}
                                <span class="text-danger">{{ $errors->first('order') }}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3" for="statusId">@lang('english.STATUS') :</label>
                            <div class="col-md-5">
                                {!! Form::select('status', ['1' => __('english.ACTIVE'), '0' => __('english.INACTIVE')], '1', ['class' => 'form-control', 'id' => 'statusId']) !!}
                                <span class="text-danger">{{ $errors->first('status') }}</span>
                            </div>
                        </div>
                        
                        

                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-4 col-md-8">
                        <button class="btn btn-circle green" type="submit" name="submit">
                            <i class="fa fa-check"></i> @lang('english.SUBMIT')
                        </button>
                        <a href="{{ URL::to('/faculty'.Helper::queryPageStr($qpArr)) }}" class="btn btn-circle btn-outline grey-salsa">@lang('english.CANCEL')</a>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>	
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $('.datepicker2').datepicker({
            format: 'dd MM yyyy',
            autoclose: true,
            todayHighlight: true,
            showClose: true,
        });
    });
    
    $(document).on("click", '#ocImage', function (e) {
    $(".cv").hide();
    });
            //Added for Cropper use for CoverPhoto
            let result2 = document.querySelector('.result-sign'),
            sign_w = document.querySelector('.sign-w'),
            options2 = document.querySelector('.options2'),
            crop2 = document.querySelector('.crop2'),
            cropped2 = document.querySelector('.cropped2'),
            upload2 = document.querySelector('#ocImage'),
            cropper2 = '';
            var fileTypes2 = ['jpg', 'jpeg', 'png', 'gif'];
            // on change show image with crop options
            upload2.addEventListener('change', function (f) {

            if (f.target.files.length) {
            // start file reader
            const reader2 = new FileReader();
                    var file2 = f.target.files[0]; // Get your file here
                    var fileExt2 = file2.type.split('/')[1]; // Get the file extension
                    if (fileTypes2.indexOf(fileExt2) !== - 1) {
            reader2.onload = function (f) {
//          console.log(f.target.result);
            if (f.target.result) {
            // create new image
            let img = document.createElement('img');
                    img.id = 'sign';
                    img.src = f.target.result
                    // clean result before
                    result2.innerHTML = '';
                    // append new image
                    result2.appendChild(img);
                    // show crop btn and options
                    crop2.classList.remove('hide');
                    options2.classList.remove('hide');
                    // init cropper2
                    cropper2 = new Cropper(img, {
                    aspectRatio: 40 / 45,
                            quality: 1,
                            imageSmoothingQuality : 'high',
                    });
            }
            };
                    reader2.readAsDataURL(file2);
            } else {
            alert('File not supported');
                    return false;
            }
            }
            });
            // crop on click
            crop2.addEventListener('click', function (f) {
            f.preventDefault();
                    // get result to data uri
                    let imgSrc = cropper2.getCroppedCanvas({
                    width: sign_w.value // input value
                    }).toDataURL();
                    // remove hide class of img
                    cropped2.classList.remove('hide');
                    // show image cropped
                    cropped2.src = imgSrc;
                    $('#cropImg2').val(imgSrc);
            });
//crop sign end 



    $(document).ready(function(){ 
      var i=1;  
      $('#add').click(function(){  
            
           $('#dynamic_field').append('<tr id="row'+i+'" class="dynamic-added"><td><input type="text" name="child['+i+'][name]" placeholder="Name" class="form-control name_list" /></td>\n\
                <td><input type="number" name="child['+i+'][age]" placeholder="Age" class="form-control name_list" /></td>\n\
                <td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
         i++;            
      });  


      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      }); 
    });
    
    
    
    $(document).ready(function(){ 
      var j=1;  
      $('#add2').click(function(){  
           j++;  
           $('#dynamic_field2').append('<tr id="row'+j+'" class="dynamic-added"><td><input type="text" name="conducting_the_classes[]" placeholder="Type Place" class="form-control name_list" /></td>\n\
                <td><button type="button" name="remove" id="'+j+'" class="btn btn-danger btn_remove2">X</button></td></tr>');  
      });  


      $(document).on('click', '.btn_remove2', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      }); 
    });
</script>
@stop