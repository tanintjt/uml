@extends('admin.layouts.master')

@section('content')
    {!! Form::open(array('url' => 'admin/spare-parts/'.$row->id, 'class' => 'form-inline', 'name' => 'admin-form', 'id' => 'admin-form', 'method' => 'get')) !!}
    <div class="panel panel-default">
        <div class="panel-heading">
            <span class="glyphicon glyphicon-eye-open"></span>&nbsp;{!! $title !!}
            <div class="input-group pull-right">
                <span class="input-group-btn">
                    <a href="{!! url('admin/spare-parts/'.$row->id.'/edit')!!}" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-edit"></span> Edit</a>
                    <a href="{!! url('admin/spare-parts')!!}" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-chevron-left"></span> Back</a>
                </span>
            </div>
        </div>

        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th width="15%" class="active">Name</th>
                            <td>{!!isset($row->name)?ucfirst($row->name):'' !!}</td>
                        </tr>
                        <tr>
                            <th class="active">Spare Parts Category</th>
                            <td>{!! isset($row->sp_cat->name)?ucfirst($row->sp_cat->name):'' !!}</td>
                        </tr>
                        <tr>
                            <th class="active">Part ID</th>
                            <td>
                                {!! isset($row->part_id)?$row->part_id:'' !!}
                            </td>
                        </tr>
                        <tr>
                            <th class="active">Rate</th>
                            <td>{!! $row->rate !!}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
