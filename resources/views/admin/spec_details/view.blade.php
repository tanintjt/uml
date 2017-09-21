@extends('admin.layouts.master')

@section('content')
    {!! Form::open(array('url' => 'admin/spec/details'.$row->id, 'class' => 'form-inline', 'name' => 'admin-form', 'id' => 'admin-form', 'method' => 'get')) !!}
    <div class="panel panel-default">
        <div class="panel-heading">
            <span class="glyphicon glyphicon-eye-open"></span>&nbsp;{!! $title !!}
            <div class="input-group pull-right">
                <span class="input-group-btn">
                    <a href="{!! url('admin/spec/details/'.$row->id.'/edit')!!}" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-edit"></span> Edit</a>
                    <a href="{!! url('admin/spec/details')!!}" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-chevron-left"></span> Back</a>
                </span>
            </div>
        </div>

        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th width="10%" class="active">Vehicle</th>
                            <td>{!!isset($row->vehicles->model->name)?$row->vehicles->model->name:'' !!}</td>
                        </tr>
                        <tr>
                            <th class="active">Specification Category</th>
                            <td>{!! isset($row->spec_category->title)?ucfirst($row->spec_category->title):'' !!}</td>
                        </tr>
                        <tr>
                            <th class="active">Title</th>
                            <td>
                                {!! isset($row->title)?ucfirst($row->title):'' !!}
                            </td>
                        </tr>
                        <tr>
                            <th class="active">Value</th>
                            <td>{!! isset($row->spec_value)?ucfirst($row->spec_value):'' !!}</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
