<link href="{{asset('public/assets/pages/css/profile.min.css')}}" rel="stylesheet" type="text/css" />

@if(!empty($student))
<table class="table table-bordered table-striped">    
    <tbody>
        <tr>
            <td rowspan="4">
                <div class="profile-userpic">
                    @if(!empty($student->photo))
                    <img  src="{{URL::to('/')}}/public/uploads/user/{{$student->photo}}" class="img-responsive" style="height: 180px; width: 180px;" alt="{{ $student->first_name.' '.$student->last_name }}">
                    @else
                    <img  src="{{URL::to('/')}}/public/img/unknown.png" class="img-responsive" alt="{{ $student->first_name.' '.$student->last_name }}">
                    @endif
                </div>
            </td>
            <td colspan="2"><b>{{ $student->rank_name.' '.$student->first_name.' '.$student->last_name }}</b></td>

        </tr>
        <tr>
            <td>{{ trans('english.REGISTRATION_NO').' : '.$student->registration_no }}</td>
            <td>{{ trans('english.OFFICIAL_NAME').' : '.$student->official_name }}</td>
        </tr>
        <tr>
            <td>{{ trans('english.SERVICE_NO').' : '.$student->service_no }}</td>
            <td>{{ trans('english.BRANCH').' : '.$student->branch_name }}</td>
        </tr>
        <tr>
            <td>{{ trans('english.APPOINTMENT').' : '.$student->appointment_name }}</td>
            <td>
                @if($student->program_id == '1')
                @if(strtotime($student->maximum_tenure) <= strtotime(date('Y-m-d')))
                {!! trans('english.REGISTRATION_EXPIRY_DATE').' : <span class="color-view bg-red-thunderbird bg-font-red-thunderbird" style="padding:5px;"> '.$student->maximum_tenure.' </span>' !!}
                @else
                {!! trans('english.REGISTRATION_EXPIRY_DATE').' : <span class="color-view bg-green-jungle bg-font-green-jungle" style="padding:5px;"> '.$student->maximum_tenure.' </span>' !!}
                @endif
                @endif
            </td>
        </tr>        
        <tr>
            <td>{{ trans('english.PROGRAM').' : '.$student->program_name }}</td>
            <td>{{ trans('english.COURSE').' : '.(($student->program_id == '1') ? $student->course_name : $student->course2_name) }}</td>
            <td>{{ (($student->program_id == '1') ?  trans('english.PART').' : '.$student->part_name : '') }}</td>
        </tr>

    </tbody>
</table>

{{--
ISSP students will get this following table always
JSCSC students will get this table only if they have any data in migration table for ISSP 
--}}

@if ($student->program_id == '1' || !$migrationArr1->isEmpty())
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th colspan="5">{{ trans('english.ISSP') }}</th>
        </tr>
        <tr>
            <th>{{ trans('english.COURSE') }}</th>
            <th>{{ trans('english.PART') }}</th>
            <th>{{ trans('english.SUBJECT') }}</th>
            <th>{{ trans('english.TAE') }}</th>
            <th>{{ trans('english.EPE') }}</th>
        </tr>
    </thead>
    <tbody>

        <?php
        if (!empty($migrationCourseArr1)) {
            foreach ($migrationCourseArr1 as $courseId => $item) {

                $partIdArr = array_keys($item);
                $partId = $partIdArr[0];
                $courseSubjects = $item[$partId];

                if (!empty($courseSubjects)) {
                    $j = 0;
                    foreach ($courseSubjects as $subjectPhase => $result) {
                        
                        $subjectPhaseArr = explode('*', $subjectPhase);
                        $subjectId = $subjectPhaseArr[0];
                        $phaseId = $subjectPhaseArr[1];
                        
                        ?>
                        <tr>
                            @if($j == '0')
                            <td rowspan="{{ count($courseSubjects) }}">{{ $courseArr[$courseId] }}</td>
                            <td rowspan="{{ count($courseSubjects) }}">{{ $partArr[$partId] }}</td>
                            @endif

                            <td>{{  $phaseArr[$phaseId].' ('.$subjectArr[$subjectId].')' }}</td>
                            <td>
                                <?php
                                
                                
                                if (!empty($migrationCourseArr1[$courseId][$partId][$subjectId.'*'.$phaseId]['tae'])) {

                                    if ($migrationCourseArr1[$courseId][$partId][$subjectId.'*'.$phaseId]['tae']['result_status'] == '1') {
                                        $passFail = '<span class="label label-primary">' . trans('english.PASSED') . '</span>';
                                    } else {
                                        $passFail = '<span class="label label-danger">' . trans('english.FAILED') . '</span>';
                                    }

                                    echo trans('english.TOTAL_MARK') . ' : ' . $migrationCourseArr1[$courseId][$partId][$subjectId.'*'.$phaseId]['tae']['total_mark'] . '<br />';
                                    echo trans('english.ACHIEVED_MARK') . ' : ' . $migrationCourseArr1[$courseId][$partId][$subjectId.'*'.$phaseId]['tae']['achieved_mark'] . '<br />';
                                    echo trans('english.STATUS') . ' : ' . $passFail;
                                } else {
                                    echo '&nbsp;';
                                }
                                ?>
                            </td>            
                            <td>
                                <?php
                                if (!empty($migrationCourseArr1[$courseId][$partId][$subjectId.'*'.$phaseId]['epe'])) {

                                    if ($migrationCourseArr1[$courseId][$partId][$subjectId.'*'.$phaseId]['epe']['pass'] == '1') {
                                        $passFail = '<span class="label label-primary">' . trans('english.PASSED') . '</span>';
                                    } else if ($migrationCourseArr1[$courseId][$partId][$subjectId.'*'.$phaseId]['epe']['pass'] == '2') {
                                        $passFail = '<span class="label label-danger">' . trans('english.FAILED') . '</span>';
                                    } else {
                                        $passFail = '<span class="label label-warning">' . trans('english.RESULT_NOT_PUBLISHED') . '</span>';
                                    }

                                    echo trans('english.TOTAL_MARK') . ' : ' . $migrationCourseArr1[$courseId][$partId][$subjectId.'*'.$phaseId]['epe']['total_mark'] . '<br />';
                                    echo trans('english.ACHIEVED_MARK') . ' : ' . $migrationCourseArr1[$courseId][$partId][$subjectId.'*'.$phaseId]['epe']['converted_mark'] . '<br />';
                                    echo trans('english.STATUS') . ' : ' . $passFail;
                                } else {
                                    echo '&nbsp;';
                                }
                                ?>
                            </td>
                        </tr>

                        <?php
                        $j++;
                    }//foreach $subjectCourse
                }//if !empty($subjectCourse)
            }//foreach $migrationCourseArr1
        }else{//if !empty($migrationCourseArr
        
        echo '<tr>'
            . '<td colspan="5">'.trans('english.EMPTY_DATA').'</td>'
            . '</tr>'    ;
        
        }
        ?>

    </tbody>
</table>
@endif


@if($student->program_id == '2')
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th colspan="3">{{ trans('english.JCSC') }}</th>
        </tr>
        <tr>
            <th class="col-md-5">{{ trans('english.COURSE') }}</th>
            <th class="col-md-7">{{ trans('english.RESULT') }}</th>
        </tr>
    </thead>
    <tbody>
        <?php $jcscCount = 0; ?>
        @if($student->program_id == '2')
        <?php $jcscCount++; ?>
        <tr>
            <td rowspan="">{{ $student->course2_name }}</td>
            <td>
                @if(!empty($jcscResult))
                @foreach($jcscResult as $mk => $mark)
                {{ $moduleArr[$mk].' : '.$mark }}
                @endforeach
                @endif
            </td>
        </tr>
        @endif

        @if (!$migrationArr2->isEmpty())
        @foreach($migrationArr2 as $migration)
        <?php $jcscCount++; ?>
        <tr>
            <td rowspan="">{{ $migration->course_name }}</td>
            <td>
                <?php
                $resultArr = json_decode($migration->result, TRUE);
                if (!empty($resultArr)) {
                    foreach ($resultArr as $mk => $mark) {
                        echo $moduleArr[$mk] . ' : ' . $mark . '<br />';
                    }//foreach
                }//if
                ?>
            </td>
        </tr>
        @endforeach
        @endif

        @if($jcscCount == 0)
        <tr>
            <td colspan="2">{{ trans('english.NO_RECORD_FOUND') }}</td>
        </tr>
        @endif


    </tbody>
</table>
@endif



<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
            @if(($student->program_id == '1') && (strtotime($student->maximum_tenure) <= strtotime(date('Y-m-d'))))
            <a class="btn btn-circle yellow sbold" data-toggle="modal" href="#extend-expiary-date" id="migrate">{{ trans('english.EXTEND_EXPIARY_DATE') }}</a>
            @else
            <a class="btn btn-circle green sbold" data-toggle="modal" href="#program-course-holder" id="migrate">{{ trans('english.PROCEED_TO_MIGRATE') }}</a>
            @endif
            <button type="button" class="btn btn-circle grey-salsa btn-outline" id="cancel">{{ trans('english.CANCEL') }}</button> 
        </div>
    </div>
</div>


<div id="program-course-holder" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">{{ trans('english.MIGRATION_CONFIRMATION') }}</h4>
            </div>
            <div class="modal-body">
                <div class="scroller" data-always-visible="1" data-rail-visible1="1">

                    <div id="migration2-loader">
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn green" id="confirm-migrate">{{ trans('english.CONFIRM_MIGRATION') }}</button>

                <button type="button"  data-dismiss="modal" class="btn dark btn-outline">{{ trans('english.CANCEL') }}</button> 

            </div>
        </div>
    </div>
</div>


<div id="extend-expiary-date" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">{{ trans('english.EXTEND_EXPIARY_DATE') }}</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="col-md-4 control-label" for="maximum_tenure">{{trans('english.NEW_EXPIARY_DATE')}} :<span class="required"> *</span></label>
                    <div class="col-md-4">
                        <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy" data-date-start-date="+1d">
                            {{ Form::text('maximum_tenure', null, array('id'=> 'maximum_tenure', 'class' => 'form-control', 'readonly')) }}
                            <span class="input-group-btn">
                                <button class="btn default" type="button">
                                    <i class="fa fa-calendar"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="remarks">{{trans('english.REMARKS')}} :<span class="required"> *</span></label>
                    <div class="col-md-7">
                        {{ Form::textarea('remarks', null, array('id'=> 'remarks', 'class' => 'form-control', 'rows' => '4')) }}
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-4">{{trans('english.ATTACHMENT')}} : </label>
                    <div class="col-md-6">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="input-group">
                                <div class="form-control uneditable-input input-fixed input-small" data-trigger="fileinput">
                                    <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                    <span class="fileinput-filename"> </span>
                                </div>
                                <span class="input-group-addon btn default btn-file">
                                    <span class="fileinput-new"> {{trans('english.SELECT_FILE')}} </span>
                                    <span class="fileinput-exists"> {{trans('english.CHANGE')}} </span>
                                    <input name="attachment" type="file" id="attachment" />
                                </span>
                                <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> {{trans('english.REMOVE')}} </a>
                            </div>
                        </div>
                        <div class="clearfix margin-top-10 margin-bottom-10 text-default">
                            <span class="label label-danger">{{trans('english.NOTE')}}</span> {{trans('english.REGISTRATION_EXPIARTY_ATTACHMENT_INFO')}}
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn green" id="confirm-new-expiary-date">{{ trans('english.SAVE_NEW_EXPIARY_DATE') }}</button>
                <button type="button"  data-dismiss="modal" class="btn dark btn-outline">{{ trans('english.CANCEL') }}</button> 
            </div>
        </div>
    </div>
</div>


@endif

@if(empty($student))
<div class="form-actions">
    <div class="row">
        <div class="text-center font-red">
            <strong>{{ trans('english.UNKNOWN_REGISTRATION_NO') }}</strong>
        </div>
    </div>
</div>

@endif

<script type="text/javascript">

    $('.date-picker').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        isRTL: App.isRTL(),
        pickerPosition: (App.isRTL() ? "bottom-right" : "bottom-left")
    });

</script>