@extends('admin.layouts.master')

@section('content')
    {!! Form::open(array('url' => Request::segment(1).'/role/'.$row->id, 'class' => 'form-horizontal', 'name' => 'admin-form', 'id' => 'admin-form', 'method' => 'get')) !!}
    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="input-group">
                <span class="input-group-btn">
                    <a href="{!! url(Request::segment(1).'/role') !!}" class="btn btn-flat btn-danger pull-right"><i class="fa fa-remove"></i> Back</a>
                    <a href="{!! url(Request::segment(1).'/role/'.$row->id.'/edit') !!}" class="btn btn-flat btn-primary pull-right"><i class="fa fa-edit"></i> Edit</a>
                </span>
            </div>
        </div>

        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <th width="10%" class="active">Name</th>
                        <td>{!! $row->display_name !!}</td>
                    </tr>
                    <tr>
                        <th class="active">Permissions</th>
                        <td>
                            @foreach($permission as $value)
                                {!! in_array($value->id, $rolePermissions) ? '<span class="badge">'.$value->display_name.'</span>' : '' !!}
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th class="active">Status</th>
                        <td>{!! $row->status == 1 ? '<span class="label label-primary">Active</span>':'<span class="label label-danger">Inactive</span>' !!}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    {!! Form::close() !!}
@endsection
