@extends('admin.layouts.master')

@section('content')
    {!! Form::open(array('url' => 'admin/vehicle/', 'class' => 'form-inline', 'name' => 'admin-form', 'id' => 'admin-form', 'method' => 'get')) !!}
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>Vehicle : {!! isset($row->model->name)?$row->model->name:''!!}</strong>&nbsp;
            <div class="input-group pull-right">
                <span class="input-group-btn">
                    <a href="{!! url('admin/vehicle')!!}" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-chevron-left"></span> Back</a>
                </span>
            </div>
        </div>

        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                    <?php $i = 1; ?>
                    @foreach ($rows as $row)
                        <tr>
                            <td>{{ ((\Request::get('page', 1) - 1) * config('app.limit')) + $i++ }} </td>
                            <td style="align-content: center">
                                <img src="{!! asset(isset($row->available_colors)?$row->available_colors:'') !!}"style="align-content: center">
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
