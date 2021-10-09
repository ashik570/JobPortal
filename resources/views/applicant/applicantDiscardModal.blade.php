<div class="modal-content" id="modal-content">
    <div class="modal-header clone-modal-header">
        <div class="col-md-7 text-right">
            <h4 class="modal-title">@lang('english.DISCARD')</h4>
        </div>
        <div class="col-md-5">
            <button type="button" data-dismiss="modal" data-placement="left" class="btn red pull-right tooltips" title="@lang('english.CLOSE_THIS_POPUP')">@lang('english.CLOSE')</button>
        </div>
    </div>
    <div class="modal-body">
        {!! Form::open(array('group' => 'form', 'url' => '', 'class' => 'form-horizontal', 'id' => 'discardApplicationForm')) !!}
        {{csrf_field()}}
        {!! Form::hidden('applicant_id', $jobApplicantId) !!}
        <div class="form-body">
            <div class="row">
                <div class="col-md-offset-2 col-md-7">
                    <div class="form-group">
                        <label class="control-label col-md-4" for="discardRemarks">@lang('english.REMARKS') :<span class="text-danger"> *</span></label>
                        <div class="col-md-8">
                            {!! Form::textarea('discard_remarks', null, ['id'=> 'discardRemarks', 'class' => 'form-control','autocomplete' => 'off','rows' => 4, 'cols' => 40,]) !!} 
                            <span class="text-danger">{{ $errors->first('discard_remarks') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <div class="modal-footer">
        <button type="button" class="btn grey-cascade"  id="discardApplication">
            <i class="fa fa-ban"></i> @lang('english.SUBMIT')
        </button>
        <button type="button" data-dismiss="modal" data-placement="top" class="btn dark btn-outline tooltips" title="@lang('english.CLOSE_THIS_POPUP')">@lang('english.CLOSE')</button>
    </div>
</div>

<script src="{{asset('public/js/custom.js')}}" type="text/javascript"></script>
<script type="text/javascript">
$(function () {
    $(".tooltips").tooltip();
});
</script>