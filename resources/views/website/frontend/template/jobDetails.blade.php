<?php
$salaryTypeArr = Common::salaryTypes();
//dd($target->salary_type);
//$salaryType = $salaryTypeArr[$target->salary_type];
$message = '';
$s = '';
if (!empty($target->experience_not_required)) {
    $message = "N/A";
} else {
    if (!empty($target->experience_from) && !empty($target->experience_to) || !empty($target->experience_to)) {
        if ($target->experience_to - $target->experience_from >= 1) {
            $s = 's';
        }
        $message = $target->experience_from . " to " . $target->experience_to . " year" . $s;
    } else {
        if ($target->experience_from > 1) {
            $s = 's';
        }
        $message = "At least " . $target->experience_from . " year" . $s;
    }
}

$salaryRange = "";
if(!empty($target->nigotiable)){
    $salaryRange="nigotiable";
}else{
    if(!empty($target->salary_from) && !empty($target->salary_to) || !empty($target->salary_to)){
        if(empty($target->salary_from)){
            $salaryRange = "0 to ".$target->salary_to." Tk";
        }else{
            $salaryRange = $target->salary_from." to ".$target->salary_to." Tk";
        }
        
    }else{
        $salaryRange = $target->salary_from." Tk";
    }
}

?>
@include('website.layouts.header')
<div class="page-title-container">
    <div class="container">
        <h2 class="page-title first-word ml-3"> @lang('english.JOB_DETAILS') </h2>
    </div>
</div>
<div class="main-content hr-p-margin-0 job-details">
    <div class="container">
        <div class="row">
            <div class="col-md-12 pb-15">
                <div class="row">
                    <div class="col-md-8 paper-shadow ">
                        <h3 class="text-success">{{ $target->title }}</h3>
                        <p class="font-weight-bold">@lang('english.VACANCY')</p>
                        @if(!empty($target->vacancy))
                        <span class="ml-5 ml-26">{{ $target->vacancy }}</span>
                        @else
                        <span class="ml-5 ml-26">@lang('english.NOT_SPECIFIC')</span>
                        @endif
                        <p class="font-weight-bold">@lang('english.JOB_RESPONSIBILITIES')</p>
                        <div class="ml-5">{!! $target->job_requirements !!}</div>
                        <p class="font-weight-bold">@lang('english.EMPLOYMENT_STATUS')</p>
                        <span class="ml-5">{{ $target->jobNature->name }}</span>
                        <p class="font-weight-bold">@lang('english.EDUCATIONAL_REQUIREMENTS')</p>
                        <div class="ml-5">{!! $target->educational_requirements !!}</div>
                        <p class="font-weight-bold">@lang('english.EXPERIENCE_REQUIREMENTS')</p>
                        <div class="ml-5">{!! $message !!}</div>
                        <p class="font-weight-bold">@lang('english.SALARY')</p>
                        <div class="ml-5">{!! $salaryRange !!}</div>
                        @if(!empty($data->additional_requirements))
                        <p class="font-weight-bold">@lang('english.ADDITIONAL_REQUIREMENTS')</p>
                        @endif
                        <div class="ml-5">{!! $target->additional_requirements !!}</div>
                        @if(!empty($data->other_benifits))
                        <p class="font-weight-bold">@lang('english.OTHER_BENIFITS')</p>
                        @endif
                        <div class="ml-5">{!! $target->other_benifits !!}</div>
                        
                        <div class="text-center">
                            <a class="btn btn-success" href="{{ URL::to('jobs/apply',$target->id) }}" onclick="">@lang('english.APPLY_ONLINE')</a>
                        </div>
                        
                    </div>
                    <div class="col-md-4">
                        <div class="right job-summary">
                            <div class="card card-default">
                                <div class="card-header bg-dark text-light font-weight-bold" role="heading">@lang('english.JOB_SUMMARY')</div>
                                <div class="card-body bg-gray">
                                    <h6>
                                        <strong>@lang('english.PUBLISHED_ON')</strong>&nbsp;{{ date('F d, Y',strtotime($target->submission_date)) }}
                                    </h6>
                                    <h6>
                                        <strong>@lang('english.VACANCY_C')</strong>&nbsp;
                                        {{ $target->vacancy }}
                                    </h6>
                                    <h6>
                                        <strong>@lang('english.EMPLOYMENT_STATUS:')</strong>&nbsp;{{ $target->jobNature->name }}
                                    </h6>
                                    <h6>
                                        <strong>@lang('english.EXPERIENCE')</strong>&nbsp;{{ $message }}
                                    </h6>
                                    <h6>
                                        <strong>@lang('english.GENDER_C')</strong>&nbsp;@lang('english.ALL_ALLOWED')
                                    </h6>
                                    <h6>
                                        <strong>@lang('english.SALARY')</strong>&nbsp;{{ $salaryRange }}
                                    </h6>
                                    <h6>
                                        <strong>@lang('english.APPLICATION_DEADLINE')</strong>&nbsp;{{ date('F d, Y',strtotime($target->deadline)) }}
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
<!--                    <div class="col-md-12 text-center">
                        <div class="text-center">
                            <a class="btn btn-success" href="" onclick="">Apply Online</a>
                        </div>
                    </div>-->
                </div>
            </div>
        </div>
    </div>
</div>
@include('website.layouts.footer') 
