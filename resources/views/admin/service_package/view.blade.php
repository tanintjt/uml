@extends('admin.layouts.master')

@section('content')
    {!! Form::open(array('url' => Request::segment(1).'/service-package/'.$row->id, 'class' => 'form-horizontal', 'name' => 'admin-form', 'id' => 'admin-form', 'method' => 'get')) !!}
    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="input-group">
                <span class="input-group-btn">
                    <a href="{!! url(Request::segment(1).'/service-package') !!}" class="btn btn-flat btn-danger pull-right"><i class="fa fa-remove"></i> Back</a>
                    <a href="{!! url(Request::segment(1).'/service-package/'.$row->id.'/edit') !!}" class="btn btn-flat btn-primary pull-right"><i class="fa fa-edit"></i> Edit</a>
                </span>
            </div>
        </div>

        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <th width="20%" class="active">Category Name</th>
                        <td>{!!isset($row->service_package_type->name)?$row->service_package_type->name:'' !!}</td>
                    </tr>
                    <tr>
                        <th width="20%" class="active">Package Name</th>
                        <td>{!! $row->name !!}</td>
                    </tr>
                    <tr>
                        <th class="active">Details</th>
                        <td>{!! $row->details !!}</td>
                    </tr>
                    <tr>
                        <th class="active">Package Rate</th>
                        <td>{!! $row->package_rate !!}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
