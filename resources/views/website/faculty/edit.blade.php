@extends('layouts.default')
@section('content')
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-road"></i>@lang('english.UPDATE_FACULTY')
            </div>
        </div>
        <div class="portlet-body form">
            {!! Form::model($target, ['route' => array('faculty.update', $target->id), 'method' => 'PATCH', 'files'=> true, 'class' => 'form-horizontal'] ) !!}
            {!! Form::hidden('filter', Helper::queryPageStr($qpArr)) !!}
            {{csrf_field()}}
            <div class="form-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label col-md-3" for="name">@lang('english.NAME') :<span class="text-danger"> *</span></label>
                            <div class="col-md-5">
                                {!! Form::text('name', $target->name, ['id'=> 'name', 'class' => 'form-control','autocomplete'=>'off']) !!} 
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3" for="rankId">@lang('english.RANK') :<span class="text-danger"> *</span></label>
                            <div class="col-md-5">
                                {!! Form::select('rank_id', $rankList, $target->rank_id, ['id'=> 'rankId', 'class' => 'form-control  js-source-states','autocomplete'=>'off']) !!} 
                                <span class="text-danger">{{ $errors->first('rank_id') }}</span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-3" for="apptId">@lang('english.APPT') :<span class="text-danger"> *</span></label>
                            <div class="col-md-5">
                                {!! Form::select('appt_id', $apptList, $target->appt_id, ['id'=> 'apptId', 'class' => 'form-control  js-source-states','autocomplete'=>'off']) !!} 
                                <span class="text-danger">{{ $errors->first('appt_id') }}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">{{trans('english.DOC')}} : <span class="required"> *</span></label>
                            <div class="col-md-5">
                                <div class="input-group input-large date-picker input-daterange" data-date="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd">
                                    {{ Form::text('doc', !empty($target->doc) ? Helper::formatDate($target->doc):null, array('id'=> 'doc', 'class' => 'form-control datepicker2', 'placeholder' => 'Enter Date of Commissioning')) }}
                                </div>
                                <span class="help-block text-danger"> {{ $errors->first('doc') }} </span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-3 control-label">{{trans('english.DOP')}} : <span class="required"> *</span></label>
                            <div class="col-md-5">
                                <div class="input-group input-large date-picker input-daterange" data-date="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd">
                                    {{ Form::text('dop', !empty($target->dop) ? Helper::formatDate($target->dop):null, array('id'=> 'dop', 'class' => 'form-control datepicker2', 'placeholder' => 'Enter Date of Commissioning')) }}
                                </div>
                                <span class="help-block text-danger"> {{ $errors->first('dop') }} </span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-3 control-label">{{trans('english.DOB')}} : <span class="required"> *</span></label>
                            <div class="col-md-5">
                                <div class="input-group input-large date-picker input-daterange" data-date="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd">
                                    {{ Form::text('dob', !empty($target->dob) ? Helper::formatDate($target->dob):null, array('id'=> 'dob', 'class' => 'form-control datepicker2', 'placeholder' => 'Enter Date of Commissioning')) }}
                                </div>
                                <span class="help-block text-danger"> {{ $errors->first('dob') }} </span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-3 control-label">{{trans('english.DOM')}} : <span class="required"> *</span></label>
                            <div class="col-md-5">
                                <div class="input-group input-large date-picker input-daterange" data-date="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd">
                                    {{ Form::text('dom', !empty($target->dom) ? Helper::formatDate($target->dom):null, array('id'=> 'dom', 'class' => 'form-control datepicker2', 'placeholder' => 'Enter Date of Commissioning')) }}
                                </div>
                                <span class="help-block text-danger"> {{ $errors->first('dom') }} </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" for="spouse">@lang('english.SPOUSE') :<span class="text-danger"> *</span></label>
                            <div class="col-md-5">
                                {!! Form::text('spouse', $target->spouse, ['id'=> 'spouse', 'class' => 'form-control','autocomplete'=>'off']) !!} 
                                <span class="text-danger">{{ $errors->first('spouse') }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" for="contactNumber">@lang('english.CONTACT_NO') :</label>
                            <div class="col-md-5">
                                {!! Form::text('contact_no', $target->contact_no, ['id'=> 'contactNumber', 'class' => 'form-control','autocomplete'=>'off']) !!} 
                                <span class="text-danger">{{ $errors->first('contact_no') }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" for="spouse">@lang('english.CHILDREN') :<span class="text-danger"> *</span></label>
                            <div class="col-md-5">
                            <div class="table-responsive">  
                                <table class="table " id="dynamic_field"> 
                                    @if(!empty(json_decode($target->children_with_age,true)))
                                        @php $cn=0; $ca=0; $sl=1; @endphp
                                        @foreach(json_decode($target->children_with_age,true) as $childData)
                                        <tr class="{{$loop->first ? '':'dynamic-added'}}" id="row{{$sl}}">
                                        <td><input type="text" value="{{ $childData['name']??'' }}" name="child[{{$cn++}}][name]" placeholder="Name" class="form-control" /></td>  
                                        <td><input type="number" value="{{ $childData['age']??'' }}" name="child[{{$ca++}}][age]" placeholder="Age" class="form-control" /></td> 
                                        @if(!$loop->first)<td><button type="button" name="remove" id="{{$sl}}" class="btn btn-danger btn_remove">X</button></td>@endif
                                        @if($loop->first)
                                        <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td> 
                                        @endif
                                        @php $sl++; @endphp
                                        </tr>
                                        @endforeach
                                    @else
                                    <tr>  
                                        <td><input type="text" name="child[0][name]" placeholder="Name" class="form-control" /></td>  
                                        <td><input type="number" name="child[0][age]" placeholder="Age" class="form-control" /></td>
                                        <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>  
                                    </tr> 
                                    @endif
                                </table>  
                            </div>
                         </div> 
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-3" for="">@lang('english.CONDUTING_THE_CLASSES') :<span class="text-danger"> *</span></label>
                            <div class="col-md-5">
                            <div class="table-responsive">  
                                <table class="table " id="dynamic_field2">  
                                    @if(!empty(json_decode($target->conducting_the_classes,true)))
                                    @php $sl=1; $r=2; @endphp
                                    @foreach(json_decode($target->conducting_the_classes,true) as $childData)
                                    <tr id="rowS{{$sl++}}" class="dynamic-added">
                                    <td><input type="text" value="{{ $childData ?? '' }}" name="conducting_the_classes[]" placeholder="Type Place" class="form-control name_list" /></td>
                                    @if(!$loop->first)
                                    <td><button type="button" name="remove" id="{{ $r++ }}" class="btn btn-danger btn_remove2">X</button></td></tr>
                                    @endif
                                    @if($loop->first)
                                        <td><button type="button" name="add" id="add2" class="btn btn-success">Add More</button></td> 
                                    @endif 
                                    
                                    @endforeach
                                    @else 
                                    <tr>  
                                        <td><input type="text" name="conducting_the_classes[]" placeholder="Type Place" class="form-control" /></td> 
                                        <td><button type="button" name="add" id="add2" class="btn btn-success">Add More</button></td>  
                                    </tr> 
                                    @endif 
                                </table>  
                            </div>
                         </div> 
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-3" for="image">@lang('english.PHOTO') :</label>
                            <div class="col-md-7">
                                <div class="cv">
                                    @if(!empty($target->photo))
                                    <img src="{{asset('/public/uploads/website/'.$target->photo)}}" alt="" style="max-width: 200px"/>
                                    @else
                                    <img src="{{URL::to('/')}}/public/uploads/website/no-image.png" alt="" style="max-width: 200px"/>
                                    @endif
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
                            <label class="control-label col-md-3" for="orderId">@lang('english.ORDER') :<span class="text-danger"> *</span></label>
                            <div class="col-md-5">
                                {!! Form::select('order', $orderList, $target->order, ['id'=> 'orderId', 'class' => 'form-control js-source-states','autocomplete'=>'off']) !!}
                                <span class="text-danger">{{ $errors->first('order') }}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3" for="statusId">@lang('english.STATUS') :</label>
                            <div class="col-md-5">
                                {!! Form::select('status', ['1' => __('english.ACTIVE'), '0' => __('english.INACTIVE')], $target->status, ['class' => 'form-control', 'id' => 'statusId']) !!}
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
           $('#dynamic_field2').append('<tr id="rowS'+j+'" class="dynamic-added"><td><input type="text" name="conducting_the_classes[]" placeholder="Type Place" class="form-control name_list" /></td>\n\
                <td><button type="button" name="remove" id="'+j+'" class="btn btn-danger btn_remove2">X</button></td></tr>');  
      });  


      $(document).on('click', '.btn_remove2', function(){  
           var button_id = $(this).attr("id");   
           $('#rowS'+button_id+'').remove();  
      }); 
    });
</script>
@stop