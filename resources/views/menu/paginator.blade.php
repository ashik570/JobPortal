@if(!empty($targetArr))
<div class="row">
    <div class="col-md-10">
        {{ $targetArr->appends(Request::all())->links() }}
        <?php
        $start = empty($targetArr->total()) ? 0 : (($targetArr->currentPage() - 1) * $targetArr->perPage() + 1);
        $end = ($targetArr->currentPage() * $targetArr->perPage() > $targetArr->total()) ? $targetArr->total() : ($targetArr->currentPage() * $targetArr->perPage());
        ?> <br />
        @lang('english.SHOWING') {{ $start }} @lang('english.TO') {{$end}} @lang('english.OF')  {{$targetArr->total()}} @lang('english.RECORDS')
    </div>
    <div class="col-md-2" id="recordPerPageHolder">					
        {!! Form::open(array('group' => 'form', 'url' => 'setRecordPerPage', 'class' => '')) !!}
        <div class="input-group">
            <div class="input-icon">
                <i class="fa fa-asterisk fa-fw"></i>
                {!! Form::text('record_per_page', Session::get('paginatorCount'), ['class' => 'form-control integer-only tooltips'
                , 'title' => __('english.RECORDS_PER_PAGE'), 'placeholder' => __('english.RECORDS_PER_PAGE'), 'id' => 'recordPerPage',
                'maxlength' => 3]) !!}
            </div>
            <span class="input-group-btn">
                <button id="" class="btn btn-success" type="submit">
                    <i class="fa fa-arrow-right fa-fw"></i></button>
            </span>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@elseif(!empty($menuObj))
<div class="row">
    <div class="col-md-10">
        {{ $menuObj->appends(Request::all())->links()}}
        <?php
        $start = empty($menuObj->total()) ? 0 : (($menuObj->currentPage() - 1) * $menuObj->perPage() + 1);
        $end = ($menuObj->currentPage() * $menuObj->perPage() > $menuObj->total()) ? $menuObj->total() : ($menuObj->currentPage() * $menuObj->perPage());
        ?> <br />
        @lang('english.SHOWING') {{ $start }} @lang('english.TO') {{$end}} @lang('english.OF')  {{$menuObj->total()}} @lang('english.RECORDS')
    </div>
    <div class="col-md-2" id="recordPerPageHolder">					
        {!! Form::open(array('group' => 'form', 'url' => 'setRecordPerPage', 'class' => '')) !!}
        <div class="input-group">
            <div class="input-icon">
                <i class="fa fa-asterisk fa-fw"></i>
                {!! Form::text('record_per_page', Session::get('paginatorCount'), ['class' => 'form-control integer-only tooltips'
                , 'title' => __('english.RECORDS_PER_PAGE'), 'placeholder' => __('english.RECORDS_PER_PAGE'), 'id' => 'recordPerPage',
                'maxlength' => 3]) !!}
            </div>
            <span class="input-group-btn">
                <button id="" class="btn btn-success" type="submit">
                    <i class="fa fa-arrow-right fa-fw"></i></button>
            </span>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endif