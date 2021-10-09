<?php
$salaryTypeArr = Common::salaryTypes();
//dd($target->salary_type);
//$salaryType = $salaryTypeArr[$target->salary_type];
$message = '';
$s = '';
if (!empty($data->experience_not_required)) {
    $message = "N/A";
} else {
    if (!empty($data->experience_from) && !empty($data->experience_to) || !empty($data->experience_to)) {
        if ($data->experience_to - $data->experience_from >= 1) {
            $s = 's';
        }
        $message = $data->experience_from . " to " . $data->experience_to . " year" . $s;
    } else {
        if ($data->experience_from > 1) {
            $s = 's';
        }
        $message = "At least " . $data->experience_from . " year" . $s;
    }
}

$salaryRange = "";
if (!empty($data->nigotiable)) {
    $salaryRange = "nigotiable";
} else {
    if (!empty($data->salary_from) && !empty($data->salary_to) || !empty($data->salary_to)) {
        if (empty($data->salary_from)) {
            $salaryRange = "0 to " . $data->salary_to." Tk";
        } else {
            $salaryRange = $data->salary_from . " to " . $data->salary_to." Tk";
        }
    } else {
        $salaryRange = $data->salary_from." Tk";
    }
}
?>
<div class="modal-content" id="modal-content">
    <div class="modal-header clone-modal-header">
        <div class="col-md-7 text-right">
            <h4 class="modal-title">@lang('english.CIRCULAR_DETAILS')</h4>
        </div>
        <div class="col-md-5">
            <button type="button" data-dismiss="modal" data-placement="left" class="btn red pull-right tooltips" title="@lang('english.CLOSE_THIS_POPUP')">@lang('english.CLOSE')</button>
        </div>
    </div>
    <div class="modal-body">
        <div class="main-content hr-p-margin-0">
            <div class="container">
                <!--<div class="row">-->
                <div class="col-md-8 pb-15">
                    <!--<div class="row">-->
                    <div class="col-md-12 modal-css ">
                        <h3 class="text-success">{{ $data->title }}</h3>
                        <p class="font-weight-bold">@lang('english.VACANCY')</p>
                        @if(!empty($data->vacancy))
                        <span class="ml-5 ml-26">{{ $data->vacancy }}</span>
                        @else
                        <span class="ml-5 ml-26">@lang('english.NOT_SPECIFIC')</span>
                        @endif
                        <p class="font-weight-bold">@lang('english.JOB_RESPONSIBILITIES')</p>
                        <div class="ml-5 ml-26">{!! $data->job_requirements !!}</div>
                        <p class="font-weight-bold">@lang('english.EMPLOYMENT_STATUS')</p>
                        <span class="ml-5 ml-26">{{ $data->jobNature->name }}</span>
                        <p class="font-weight-bold">@lang('english.EDUCATIONAL_REQUIREMENTS')</p>
                        <div class="ml-5 description-block2 ml-26">{!! $data->educational_requirements !!}</div>
                        <p class="font-weight-bold">@lang('english.EXPERIENCE_REQUIREMENTS')</p>
                        <div class="ml-5 ml-26">{!! $message !!}</div>
                        <p class="font-weight-bold">@lang('english.SALARY')</p>
                        <div class="ml-5 ml-26">{!! $salaryRange !!}</div>
                        @if(!empty($data->additional_requirements))
                        <p class="font-weight-bold">@lang('english.ADDITIONAL_REQUIREMENTS')</p>
                        @endif
                        <div class="ml-5 ml-26">{!! $data->additional_requirements !!}</div>
                        @if(!empty($data->other_benifits))
                        <p class="font-weight-bold">@lang('english.OTHER_BENIFITS')</p>
                        @endif
                        <div class="ml-5 ml-26">{!! $data->other_benifits !!}</div>
                    </div>
                    <!--</div>-->
                </div>
                <!--</div>-->
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" data-dismiss="modal" data-placement="top" class="btn dark btn-outline tooltips" title="@lang('english.CLOSE_THIS_POPUP')">@lang('english.CLOSE')</button>
    </div>
</div>

<script src="{{asset('public/js/custom.js')}}" type="text/javascript"></script>
<script type="text/javascript">
$(function () {
    $(".tooltips").tooltip();
});
</script>