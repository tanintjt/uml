@extends('admin.layouts.master')

@section('content')
    {!! Form::open(array('url' => 'admin/spec/category'.$row->id, 'class' => 'form-inline', 'name' => 'admin-form', 'id' => 'admin-form', 'method' => 'get')) !!}
    <div class="panel panel-default">
        <div class="panel-heading">
            <span class="glyphicon glyphicon-eye-open"></span>&nbsp;{!! $title !!}
            <div class="input-group pull-right">
                <span class="input-group-btn">
                    <a href="{!! url('admin/spec/category/'.$row->id.'/edit')!!}" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-edit"></span> Edit</a>
                    <a href="{!! url('admin/spec/category')!!}" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-chevron-left"></span> Back</a>
                </span>
            </div>
        </div>

        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th width="15%" class="active">Specification Name</th>
                            <td>{!!isset($row->title)?ucfirst($row->title):'' !!}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
