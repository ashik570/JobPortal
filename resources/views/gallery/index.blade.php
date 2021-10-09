@extends('layouts.default')
@section('content')
<!-- BEGIN CONTENT BODY -->
<div class="page-content">

    <!-- BEGIN PORTLET-->
    @include('includes.flash')
    <!-- END PORTLET-->
    <div class="row">
        <div class="col-md-12">
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-file-image-o"></i>{{trans('english.VIEW_GALLERY')}}
                    </div>
                    <div class="actions">
                        <a href="{{ URL::to('gallery/create') }}" class="btn btn-default btn-sm">
                            <i class="fa fa-plus"></i> {{trans('english.UPLOAD_GALLERY_PHOTO')}} </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="table-responsive">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">{{trans('english.SL_NO')}}</th>
                                            <th class="text-center">{{trans('english.CAPTION')}}</th>
                                            <th class="text-center">{{trans('english.THUMB')}}</th>
                                            <th class='text-center'>{{trans('english.IMAGE')}}</th>
                                            <th class='text-center'>{{trans('english.ORDER')}}</th>
                                            <th class='text-center'>{{trans('english.STATUS')}}</th>
                                            <th class='text-center'>{{trans('english.ACTION')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!$targetArr->isEmpty())
                                        <?php
                                        $page = Request::get('page');
                                        $page = empty($page) ? 1 : $page;
                                        $sl = ($page - 1) * 10;
                                        ?>
                                        @foreach($targetArr as $gallery)

                                        <tr class="contain-center">
                                            <td>{{++$sl}}</td>
                                            <td>{{$gallery->caption}}</td>
                                            <td class="text-center">
                                                @if(!empty($gallery->thumb))
                                                <img width="50" height="auto" src="{{URL::to('/')}}/public/uploads/website/gallery/{{$gallery->thumb}}"}}">
                                                @endif
                                            </td>

                                            <td class="text-center">
                                                @if (!empty($gallery->photo))
                                                    <img width="100" height="auto" src="{{URL::to('/')}}/public/uploads/website/gallery/{{$gallery->photo}}"}}">
                                                @endif
                                            </td>
                                            <td>{{$gallery->order}}</td>
                                            <td class="text-center">
                                                @if ($gallery->status_id == '1')
                                                <span class="label label-sm label-success">@lang('english.ACTIVE')</span>
                                                @else
                                                <span class="label label-sm label-warning">@lang('english.INACTIVE')</span>
                                                @endif
                                            </td>
                                            <td class="action-center">
                                                <div class="text-center user-action">
                                                    {{ Form::open(array('url' => 'gallerymgt/' . $gallery->id, 'id' => 'delete')) }}
                                                    {{ Form::hidden('_method', 'DELETE') }}

                                                    <a class='btn btn-primary btn-xs tooltips' href="{{ URL::to('gallery/' . $gallery->id . '/edit') }}" title="Edit Gallery" data-container="body" data-trigger="hover" data-placement="top">
                                                        <i class='fa fa-edit'></i>
                                                    </a>
                                                    <button class="btn btn-danger btn-xs tooltips delete7" type="submit" title="Delete" data-placement="top" data-rel="tooltip" data-original-title="Delete">
                                                        <i class='fa fa-trash'></i>
                                                    </button>

                                                    {{ Form::close() }}
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="11">{{trans('english.EMPTY_DATA')}}</td>
                                        </tr>
                                        @endif 
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            @include('layouts.paginator')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END CONTENT BODY -->


<script type="text/javascript">
    $(document).on("submit", '#delete', function (e) {
        //This function use for sweetalert confirm message
        e.preventDefault();
        var form = this;
        swal({
            title: 'Are you sure you want to Delete?',
            text: '',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete",
            closeOnConfirm: false
        },
        function (isConfirm) {
            if (isConfirm) {
                toastr.info("Loading...", "Please Wait.", {"closeButton": true});
                form.submit();
            } else {
                //swal(sa_popupTitleCancel, sa_popupMessageCancel, "error");

            }
        });
    });
</script>
@stop
