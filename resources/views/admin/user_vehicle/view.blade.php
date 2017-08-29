@extends('admin.layouts.master')

@section('content')
    {!! Form::open(array('url' => Request::segment(1).'/user-vehicle/'.$row->id, 'class' => 'form-horizontal', 'name' => 'admin-form', 'id' => 'admin-form', 'method' => 'get')) !!}
    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="input-group">
                <span class="input-group-btn">
                    <a href="{!! url(Request::segment(1).'/user-vehicle') !!}" class="btn btn-flat btn-danger pull-right"><i class="fa fa-remove"></i> Back</a>
                    <a href="{!! url(Request::segment(1).'/user-vehicle/'.$row->id.'/edit') !!}" class="btn btn-flat btn-primary pull-right"><i class="fa fa-edit"></i> Edit</a>
                </span>
            </div>
        </div>

        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <th width="20%" class="active">User Name</th>
                        <td>{!! $row->users->name !!}</td>
                    </tr>
                    <tr>
                        <th width="20%" class="active">Vehicle Name</th>
                        <td>{!! $row->vehicles->model->name !!}</td>
                    </tr>
                    <tr>
                        <th width="20%" class="active">Engine No</th>
                        <td>{!! $row->vehicles->engine_no !!}</td>
                    </tr>
                    <tr>
                        <th width="20%" class="active">Chassis No</th>
                        <td>{!! $row->vehicles->chesis_no !!}</td>
                    </tr>
                    <tr>
                        <th width="20%" class="active">Color</th>
                        <td>{!! $row->color !!}</td>
                    </tr>
                    <tr>
                        <th class="active">Purchase Date</th>
                        <td>{!! isset($row->purchase_date)?date('Y-m-d', strtotime($row->purchase_date)):'' !!}</td>
                    </tr>
                    <tr>
                        <th class="active">Vehicle Image</th>
                        <td>
                            <img src="{!! asset(isset($row->vehicles->vehicle_image)?$row->vehicles->vehicle_image:'') !!}"style="width:30%">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
