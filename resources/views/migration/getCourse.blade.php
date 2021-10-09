<div class="form-group">
    <label class="col-md-4 control-label" for="course_id">{{trans('english.SELECT_COURSE')}} :<span class="required"> *</span></label>
    <div class="col-md-8">
        {{ Form::select('course_id', $courseArr,  null, array('id'=> 'course_id', 'class' => 'form-control dopdownselect')) }}
    </div>
</div>

@if(Request::get('program_id') == '1')
<div class="form-group">
    <div class="col-md-4 text-right">{{trans('english.PART')}} : </div>
    <div class="col-md-8">
        
        @if($student->part_id == '1')
        {{ Form::select('part_id', $partArr,  null, array('id'=> 'part_id', 'class' => 'form-control dopdownselect')) }}
        @else
        <strong>{{ $student->part_name }}</strong>
        <input type="hidden" name="part_id" id="part_id" value="{{ $student->part_id }}" />
        @endif
    </div>
</div>
@endif

