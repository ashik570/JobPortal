@if($typeId == 2)
<div class="form-group">
    <label class="control-label col-md-3" for="url">@lang('english.URL') :</label>
    <div class="col-md-5">
        {!! Form::text('url', null, ['id'=> 'title', 'class' => 'form-control']) !!} 
        <span class="text-danger">{{ $errors->first('url') }}</span>
    </div>
</div>
@elseif($typeId == 5)
<div class="form-group">
    <label class="control-label col-md-3" for="content">@lang('english.CONTENT') :<span class="text-danger"> *</span></label>
    <div class="col-md-5">
        {!! Form::select('content_id', $contentList, null, ['class' => 'form-control js-source-states', 'id' => 'content']) !!} 
    </div>
</div>
@elseif($typeId == 16)
<div class="form-group">
    <label class="control-label col-md-3" for="pcategoryId">@lang('english.SELECT_PUBLICATION_CATEGORY') :<span class="text-danger"> *</span></label>
    <div class="col-md-5">
        {!! Form::select('pcategory_id', $publicationCatList, null, ['class' => 'form-control js-source-states', 'id' => 'pcategoryId']) !!} 
    </div>
</div>
@elseif($typeId == 35)
<div class="form-group">
    <label class="control-label col-md-3" for="programId">@lang('english.PROGRAM') :<span class="text-danger"> *</span></label>
    <div class="col-md-5">
        {!! Form::select('program_id', $programList, null, ['class' => 'form-control js-source-states', 'id' => 'programId']) !!} 
    </div>
</div>
@else
<div></div>
@endif