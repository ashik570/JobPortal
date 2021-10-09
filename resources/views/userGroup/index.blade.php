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
                        <i class="fa fa-group"></i>View User Group
                    </div>
                </div>
                <div class="portlet-body flip-scroll">
                    <table class="table table-bordered table-striped table-condensed flip-content">
                        <thead class="flip-content">
                            <tr>
                                <th>{{trans('english.SL_NO')}}</th>
                                <th>{{trans('english.NAME')}}</th>
                                <th>{{trans('english.INFO')}}</th>
                                <th class="td-actions">{{trans('english.ACTION')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($group as $key => $value)
                            <tr>
                                <td>{{ $value->id }}</td>
                                <td>{{ $value->name }}</td>
                                <td>{{ $value->info }}</td>
                                <td>
                                    <div class='text-center'>
                                        <a href="{{ URL::to('userGroup/' . $value->id . '/edit') }}" class="btn btn-icon-only green">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END CONTENT BODY -->
@stop