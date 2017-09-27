@extends('admin.layouts.master')

@section('content')
    {!! Form::open(array('url' => 'admin/vehicle/'.$row->id, 'class' => 'form-inline', 'name' => 'admin-form', 'id' => 'admin-form', 'method' => 'get')) !!}
    <div class="panel panel-default">
        <div class="panel-heading">
            <span class="glyphicon glyphicon-eye-open"></span>&nbsp;{!! $title !!}
            <div class="input-group pull-right">
                <span class="input-group-btn">
                    <a href="{!! url('admin/vehicle/'.$row->id.'/edit')!!}" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-edit"></span> Edit</a>
                    <a href="{!! url('admin/vehicle')!!}" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-chevron-left"></span> Back</a>
                </span>
            </div>
        </div>

        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th width="10%" class="active">Brand</th>
                            <td>{!!isset($row->brand->name)?$row->brand->name:'' !!}</td>
                        </tr>
                        <tr>
                            <th class="active">Type</th>
                            <td>{!! isset($row->types->name)?$row->types->name:'' !!}</td>
                        </tr>
                        <tr>
                            <th class="active">Model</th>
                            <td>
                                {!! isset($row->model->name)?$row->model->name:'' !!}
                            </td>
                        </tr>
                        <tr>
                            <th class="active">Production Year</th>
                            <td>{!! $row->production_year !!}</td>
                        </tr>
                        <tr>
                            <th class="active">Description</th>
                            <td>{!! $row->description !!}</td>
                        </tr>
                        <tr>
                            <th class="active">Engine Displacement</th>
                            <td>{!! $row->engine_displacement !!}</td>
                        </tr>
                        <tr>
                            <th class="active">Engine Details</th>
                            <td>{!! $row->engine_details !!}</td>
                        </tr>
                        <tr>
                            <th class="active">fuel System</th>
                            <td>{!! $row->fuel_system !!}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
