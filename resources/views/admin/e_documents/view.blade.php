@extends('admin.layouts.master')

@section('content')
    {!! Form::open(array('url' => 'admin/e-documents/'.$row->id, 'class' => 'form-inline', 'name' => 'admin-form', 'id' => 'admin-form', 'method' => 'get')) !!}
    <div class="panel panel-default">
        <div class="panel-heading">
            <span class="glyphicon glyphicon-eye-open"></span>&nbsp;{!! $title !!}
            <div class="input-group pull-right">
                <span class="input-group-btn">
                    <a href="{!! url('admin/e-documents/'.$row->id.'/edit')!!}" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-edit"></span> Edit</a>
                    <a href="{!! url('admin/e-documents')!!}" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-chevron-left"></span> Back</a>
                </span>
            </div>
        </div>

        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th width="20%" class="active">E-Doc Type</th>
                            <td>{!! isset($row->doc_type->name)?$row->doc_type->name:'' !!}</td>
                        </tr>
                        <tr>
                            <th class="active">Issue Date</th>
                            <td>
                                {!! isset($row->issue_date)?date('Y-m-d', strtotime($row->issue_date)):''!!}
                            </td>
                        </tr>
                        <tr>
                            <th class="active">Expiry Date</th>
                            <td>
                                {!!isset($row->expiry_date)?date('Y-m-d', strtotime($row->expiry_date)):'' !!}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
