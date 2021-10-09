@include('website.layouts.header')
<div class="page-title-container">
    <div class="container">
        <h2 class="page-title first-word"> @lang('english.JOB_LIST') </h2>
    </div>
</div>
{{ Form::open(array('role' => 'form', 'url' => '', 'class' => '', 'id' => 'jobList')) }}
{!! Form::hidden('filter', Helper::queryPageStr($qpArr)) !!}

{{Form::close()}}
<div class="main-content joblist-a joblist">
    <div class="container">
        <div class="row" style="padding-bottom: 30px;">
            <div class="col-md-12">
                @if(!empty($targetArr))
                <?php
                $page = Request::get('page');
                $page = empty($page) ? 1 : $page;
                $sl = ($page - 1) * trans('english.PAGINATION_COUNT');
                ?>
                @foreach($targetArr as $value)
                <a href="{{ URL::to('jobs/details',$value['id']) }}">
                    <div class="card w-100">
                        <div class="row card-body">
                            <div class="col-md-7 col-md-offset-4">
                                <?php
                                if (!empty($value['vacancy'])) {
                                    $vacancy = "(" . $value['vacancy'] . ")";
                                } else {
                                    $vacancy = '';
                                }
                                ?>
                                <h5 class="card-title text-success">{{ $value['title']." ".$vacancy }}</h5>
                                <span class="card-text"><i class="fa fa-graduation-cap"></i>&nbsp;Educational Requirements</span><br>
                                <div class="description-block">{!! $value['educational_requirements'] !!}</div>

                            </div>

                            <div class="col-md-9">
                                <span>
                                    <?php
                                    $message = '';
                                    $s = '';
                                    if (!empty($value['experience_not_required'])) {
                                        $message = "N/A";
                                    } else {
                                        if (!empty($value['experience_from']) && !empty($value['experience_to']) || !empty($value['experience_to'])) {
                                            if ($value['experience_to'] - $value['experience_from'] >= 1) {
                                                $s = 's';
                                            }
                                            $message = $value['experience_from'] . " to " . $value['experience_to'] . " year" . $s;
                                        } else {
                                            if ($value['experience_from'] > 1) {
                                                $s = 's';
                                            }
                                            $message = "At least " . $value['experience_from'] . " year" . $s;
                                        }
                                    }
                                    ?>
                                    <span><i class="fa fa-briefcase"></i></span> Experience : {{ $message }}
                                </span>
                            </div>
                            <div class="col-md-3">
                                <span class="text-danger"><i class="fa fa-calendar-times-o"></i></span> Deadline :<span class='bold'> {{ date('d F Y',strtotime($value['deadline'])) }}</span>
                            </div>

                        </div>

                    </div>
                </a>
                <br/>
                @endforeach
                @endif
            </div>
            
        </div>
        @include('layouts.paginator')
    </div>
</div>
@include('website.layouts.footer') 
