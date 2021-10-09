<?php ?>
<div class="modal-content" id="modal-content">
    <div class="modal-header clone-modal-header">
        <div class="col-md-7 text-right">
            <h4 class="modal-title">@lang('english.APPLICATION_DETAILS')</h4>
        </div>
        <div class="col-md-5">
            <button type="button" data-dismiss="modal" data-placement="left" class="btn red pull-right tooltips" title="@lang('english.CLOSE_THIS_POPUP')">@lang('english.CLOSE')</button>
        </div>
    </div>
    <div class="modal-body">
        <div class="main-content hr-p-margin-0">
            <div class="container">
                <!--<div class="row">-->
                <div class="col-md-12">
                    <!--<div class="row">-->
                    <div class="col-md-8 modal-css ">
                        <div class="row mb-5 pb-15">
                            <div class="col-md-2">
                                <p class="vcenter font-weight-bold">@lang('english.JOB_TITLE')</p>
                            </div>
                            <div class="col-md-10">
                                <p class="text-success">{{ $data->circular }}</p>
                            </div>
                        </div>
                        <div class="row pb-15">
                            <div class="col-md-12">
                                <p class="vcenter font-weight-bold">@lang('english.APPLICANT_INFO')</p>
                            </div>
                        </div>
                        <div class="row pb-15">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="vcenter font-weight-bold">@lang('english.NAME')</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="text-success">{{ $data->name }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="vcenter font-weight-bold">@lang('english.EMAIL')</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="text-success">{{ $data->email }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="vcenter font-weight-bold">@lang('english.PHONE')</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="text-success">{{ $data->phone }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row pb-15">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="vcenter font-weight-bold">@lang('english.DATE_OF_SUBMISSION')</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="text-success">{!! date('d F Y',strtotime($data->submission_date)) !!}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="vcenter font-weight-bold">@lang('english.STATUS')</p>
                                    </div>
                                    <div class="col-md-6">
                                        @if($data->status==6 && $data->last_interaction_status==4)
                                        <span class="text-success">{{ __('english.NOT_INTERESTED') }}</span>
                                        @elseif($data->status==6)
                                        <span class="text-success">{{ __('english.DISCARD') }}</span>
                                        @elseif($data->status==0)
                                        <span class="text-success">{{ __('english.PENDING') }}</span>
                                        @elseif($data->status==1)
                                        <span class="text-success">{{ __('english.REVIEWED') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row pb-15">
                            <div class="col-md-12">
                                <p class="vcenter font-weight-bold">{{ __('english.REMARKS') }}</p>
                            </div>
                        </div>
                        <div class="row pb-15">
                            <div class="col-md-12">
                                <p class="text-success">{{ $data->remarks }}</p>
                            </div>
                        </div>



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