<div class="row">
    <div class="col-md-10">

        <div class="form-group">
            <div class="col-md-4 text-right">{{trans('english.PROGRAM')}} : </div>
            <div class="col-md-8">
                <strong>{{ $programArr[$toProgram] }}</strong>
                {{ Form::hidden('program_id', $toProgram, array('id'=> 'program_id')) }}
            </div>

        </div>
        
        <input type="hidden" name="student_id" id="student_id"  value="{{ $student->student_id }}" />

        <div id="course-loader">

            <div class="form-group">
                <label class="col-md-4 control-label" for="course_id">{{trans('english.SELECT_COURSE')}} :<span class="required"> *</span></label>
                <div class="col-md-8">
                    {{ Form::select('course_id', $courseArr,  null, array('id'=> 'course_id', 'class' => 'form-control dopdownselect')) }}
                </div>
            </div>
            
            @if($student->program_id == '1' && !$programMigration)
            <div class="form-group">
                <div class="col-md-4 text-right">{{trans('english.PART')}} : </div>
                <div class="col-md-8">
                    <strong>{!! $partArr[$toPart] !!}</strong>
                </div>
            </div>
            @endif
            
            <input type="hidden" name="part_id" id="part_id" value="{{ $toPart }}" />

        </div>

    </div>
</div>
