@extends('layouts.default')
@section('content')
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    @include('layouts.flash')
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-road"></i>@lang('english.FACULTY_LIST')
            </div>
            <div class="actions">
                <a class="btn btn-default btn-sm create-new" href="{{ URL::to('faculty/create'.Helper::queryPageStr($qpArr)) }}"> {{trans('english.CREATE_NEW')}}
                    <i class="fa fa-plus create-new"></i>
                </a>
            </div>
        </div>
        <div class="portlet-body">


            <div class="col-md-12 table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="vcenter" width="80">@lang('english.SL_NO')</th>
                            <th class="text-center vcenter" width="120">@lang('english.IMAGE')</th>
                            <th class="text-center vcenter">@lang('english.NAME')</th>
                            <th class="text-center vcenter" width="120">@lang('english.APPT')</th>
                            <th class="text-center vcenter">@lang('english.RANK')</th>
                            <th class="text-center vcenter">@lang('english.DOC')</th>
                            <th class="text-center vcenter">@lang('english.DOP')</th>
                            <th class="text-center vcenter">@lang('english.DOB')</th>
                            <th class="text-center vcenter">@lang('english.DOM')</th>
                            <th class="text-center vcenter">@lang('english.SPOUSE')</th>
                            <th class="text-center vcenter">@lang('english.CHILDREN_WITH_AGE')</th>
                            <th class="text-center vcenter">@lang('english.CONDUCTING_THE_CLASSES')</th>
                            <th class="text-center vcenter">@lang('english.CONTACT_NO')</th>
                            <th class="text-center vcenter">@lang('english.ORDER')</th>
                            <th class=" text-center vcenter">@lang('english.STATUS')</th>
                            <th class="td-actions text-center vcenter">@lang('english.ACTION')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!$targetArr->isEmpty())
                        <?php
                        $page = Request::get('page');
                        $page = empty($page) ? 1 : $page;
                        $sl = ($page - 1) * (Session::get('paginatorCount'));
                        ?>
                        @foreach($targetArr as $target)
                        <tr>
                            <td class="vcenter">{{ ++$sl }}</td>
                            <td class="text-center vcenter">
                                <?php if (!empty($target->photo)) { ?>
                                    <img width="70"  src="{{URL::to('/')}}/public/uploads/website/{{$target->photo}}" alt="{{$target->name}}"/>
                                <?php } else { ?>
                                    <img width="70"  src="{{URL::to('/')}}/public/img/no-image.png" alt="{{ $target->name}}"/>
                                <?php } ?>
                            </td>

                            <td class="text-center vcenter"><div style="width:250px">{{ $target->name }}</div></td>
                            <td class="text-center vcenter"><div style="width:150px">{{ $apptArr[$target->appt_id] ?? '' }}</div></td>
                            <td class="text-center vcenter"><div style="width:100px">{{ $rankArr[$target->rank_id] ?? '' }}</div></td>
                            <td class="text-center vcenter"><div style="width:100px">{{ $target->doc ?? '' }}</div></td>
                            <td class="text-center vcenter"><div style="width:100px">{{ $target->dop ?? '' }}</div></td>
                            <td class="text-center vcenter"><div style="width:100px">{{ $target->dob ?? '' }}</div></td>
                            <td class="text-center vcenter"><div style="width:100px">{{ $target->dom ?? '' }}</div></td>
                            <td class="text-center vcenter"><div style="width:200px">{{ $target->spouse ?? '' }}</div></td>
                            <td class="">
                                
                                @php $childIndex = 1; $childrenWithAge = json_decode($target->children_with_age,true); @endphp 
                                @if(!empty($childrenWithAge))
                                <div style="width: 250px">
                                @foreach($childrenWithAge as $childData)
                                <p class="child-name-age"><strong>{{ $childIndex++ }} . </strong> {{$childData['name']}} - {{ $childData['age'] }}</p>
                                @endforeach
                                </div>
                                @endif
                            </td>

                            <td class="">
                                @php $placeIndex = 1; $conductingPlaceArr = json_decode($target->conducting_the_classes,true); @endphp 
                                @if(!empty($conductingPlaceArr))
                                <div style="width:250px">
                                @foreach($conductingPlaceArr as $plaeData)
                                <p class="conducting-place"><strong>{{$placeIndex++}}. </strong> {{$plaeData}}</p>
                                @endforeach
                                </div>
                                @endif
                            </td>
                            <td class="text-center vcenter">{{ $target->contact_no ?? '' }}</td>
                            <td class="text-center vcenter">{{ $target->order ?? '' }}</td>
                            <td class="text-center vcenter">
                                @if($target->status == 1)
                                <span class="label label-sm label-success">@lang('english.ACTIVE')</span>
                                @else
                                <span class="label label-sm label-warning">@lang('english.INACTIVE')</span>
                                @endif
                            </td>
                            <td  class="text-center vcenter">
                                <div>
                                    {{ Form::open(array('url' => 'faculty/' . $target->id, 'id'=>'delete')) }}
                                    {{ Form::hidden('_method', 'DELETE') }}
                                    <a class="btn btn-icon-only btn-primary tooltips" title="Edit" href="{{ URL::to('faculty/' . $target->id . '/edit'.Helper::queryPageStr($qpArr)) }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <button class="btn btn-icon-only btn-danger tooltips" title="Delete" type="submit" data-placement="top" data-rel="tooltip" data-original-title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    {{ Form::close() }}
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="10" class="vcenter">@lang('english.NO_DATA_FOUND')</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            @include('layouts.paginator')
        </div>	
    </div>
</div>


<script type="text/javascript">
    $(document).on("submit", '#delete', function (e) {
        alert
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