@extends('admin.layouts.master')

@section('content')
    {!! Form::open(array('url' => Request::segment(1).'/service-center/'.$row->id, 'class' => 'form-horizontal', 'name' => 'admin-form', 'id' => 'admin-form', 'method' => 'get')) !!}
    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="input-group">
                <span class="input-group-btn">
                    <a href="{!! url(Request::segment(1).'/service-center') !!}" class="btn btn-flat btn-danger pull-right"><i class="fa fa-remove"></i> Back</a>
                    <a href="{!! url(Request::segment(1).'/service-center/'.$row->id.'/edit') !!}" class="btn btn-flat btn-primary pull-right"><i class="fa fa-edit"></i> Edit</a>
                </span>
            </div>
        </div>

        <div class="box-body">
            {{--<div class="table-responsive">--}}
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        {{--<div class="box box-solid">--}}
                            <div class="box-body">
                                <table class="table table-bordered">
                                    <tbody>
                                    <tr>
                                        <th width="10%" class="active">Address</th>
                                        <td>{!! $row->address !!}</td>
                                    </tr>
                                    <tr>
                                        <th class="active">Phone</th>
                                        <td>{!! $row->phone !!}</td>
                                    </tr>
                                    <tr>
                                        <th class="active">Latitude</th>
                                        <td>{!! $row->latitude !!}</td>
                                    </tr>
                                    <tr>
                                        <th class="active">Longitude</th>
                                        <td>{!! $row->longitude !!}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        {{--</div>--}}
                    </div>
                    <div>
                        <div class="col-sm-12 col-md-6">
                            {{--<div class="box box-solid">--}}
                            <div class="box-body">
                                <table class="table table-bordered">
                                    <tbody>
                                    <tr>
                                        @if(isset($row->store_image))
                                             <td><img src="{!! asset(isset($row->store_image)?$row->store_image:'') !!}" width="90%" height="60%" style="margin-left:5%"></td>
                                        @else
                                        @endif
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            {{--</div>--}}
                        </div>
                    </div>
                </div>
            {{--</div>--}}
        </div>
    </div>
    {!! Form::close() !!}
@endsection
