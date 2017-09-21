@extends('admin.layouts.master')

@section('content')
    {!! Form::open(array('url' => 'admin/vehicle/', 'class' => 'form-inline', 'name' => 'admin-form', 'id' => 'admin-form', 'method' => 'get')) !!}
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>Vehicle : {!! isset($row->model->name)?$row->model->name:''!!} </strong>&nbsp;
            <strong>(Colors :  {!! count($rows) !!} )</strong>&nbsp;
            <div class="input-group pull-right">
                <span class="input-group-btn">
                    <a href="{!! url('admin/vehicle')!!}" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-chevron-left"></span> Back</a>
                </span>
            </div>
        </div>

        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr class="active">
                        <th width="5%">#</th>
                        <th>Vehicle Image</th>
                        <th>Color Code</th>
                        <th width="10%">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>
                    @foreach ($rows as $row)
                        <tr>
                            <td>{{ ((\Request::get('page', 1) - 1) * config('app.limit')) + $i++ }} </td>
                            <td style="align-content: center">
                                <img src="{!! asset(isset($row->available_colors)?$row->available_colors:'') !!}"style="align-content: center">
                            <td>{!! $row->color_code !!}</td>
                            </td>
                            <td>
                                {{--<a href="{!! url(Request::segment(1).'/user/'.$row->id) !!}" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-eye-open"></span></a>--}}
                                <a href="{!! url(Request::segment(1).'/user/'.$row->id.'/edit') !!}" class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-edit"></span></a>

                                {{--<a href="{!! url(Request::segment(1).'/user/'.$row->id.'/delete') !!}" class="btn btn-xs btn-danger" title="Delete {!! $row->name !!}" user="button" data-toggle="modal" data-target="#confirmDelete" data-title="Delete {!!  $row->name !!}" data-message="Are you sure you want to delete {!!  $row->name !!} ?"><span class="glyphicon glyphicon-trash"></span></a>--}}
                                <a href="{!! route('user-delete',$row->id) !!}" class="btn btn-xs btn-danger" title="Delete {!! $row->name !!}" user="button" data-toggle="modal" data-target="#confirmDelete" data-title="Delete {!!  $row->name !!}" data-message="Are you sure you want to delete {!!  $row->name !!} ?"><span class="glyphicon glyphicon-trash"></span></a>
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
