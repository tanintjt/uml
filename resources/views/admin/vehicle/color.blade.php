@extends('admin.layouts.master')

@section('content')
    {!! Form::open(array('url' => 'admin/vehicle/', 'class' => 'form-inline', 'name' => 'admin-form', 'id' => 'admin-form', 'method' => 'get')) !!}
    <div class="panel panel-default">
        <div class="panel-heading">
            <span class="input-group-btn">
                    <button type="button" class="btn btn-success btn-sm go"><span class="glyphicon glyphicon-search"></span> Go</button>
                    <button type="button" class="btn btn-info btn-sm clear"><span class="glyphicon glyphicon-refresh"></span> Clear</button>
                    <a href="{!! url(Request::segment(1).'/vehicle/'.$row->id.'/create/color') !!}" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-plus-sign"></span> New</a>

                <a href="{!! url('admin/vehicle')!!}" class="btn btn-sm btn-success pull-right"><span class="glyphicon glyphicon-chevron-left"></span> Back</a>
                </span>
            {{--<div class="input-group pull-right">
                <span class="input-group-btn">

                </span>
            </div>--}}
        </div>

        <div class="panel-body">
            <div class="table-responsive">


                <table class="table table-bordered">
                    <thead>
                    <tr class="active">
                        <th width="1%">#</th>
                        <th width="10%" class="text-center">Available Colors</th>
                        <th width="10%" class="text-center">Color Code</th>
                        <th width="10%" class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>
                    @foreach ($rows as $row)
                        <tr>
                            <td>{{ ((\Request::get('page', 1) - 1) * config('app.limit')) + $i++ }} </td>
                            <td style="align-content: center">
                                <img src="{!! asset(isset($row->available_colors)?$row->available_colors:'') !!}"style="align-content: center">
                            <td>{{ $row->color_code }}</td>
                            </td>
                            <td class="text-center">
                                {{--<a href="{!! url(Request::segment(1).'/user-vehicle/'.$row->id.'/view') !!}" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-eye-open"></span></a>--}}
                                <a href="{!! url(Request::segment(1).'/user-vehicle/'.$row->id.'/edit') !!}" class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-edit"></span></a>
                                <a href="{!! route('user-vehicle.delete',$row->id) !!}" class="btn btn-xs btn-danger" title="Delete " user="button" data-toggle="modal" data-target="#confirmDelete" data-title="Delete" data-message="Are you sure you want to delete ?"><span class="glyphicon glyphicon-trash"></span></a>
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
