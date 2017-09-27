@extends('admin.layouts.master')

@section('content')
    {!! Form::open(array('url' => '/vehicle/'.$row->id.'/colors', 'class' => 'form-inline', 'name' => 'admin-form', 'id' => 'admin-form', 'method' => 'get')) !!}
    <div class="panel panel-default">
        <div class="panel-heading">
            <span class="input-group-btn">
                <a href="{!! url(Request::segment(1).'/vehicle/'.$row->id.'/create/color') !!}" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-plus-sign"></span> New</a>
                <a href="{!! url('admin/vehicle')!!}" class="btn btn-sm btn-success pull-right"><span class="glyphicon glyphicon-chevron-left"></span> Back</a>
             </span>
        </div>

        <div class="panel-body">

            @if(Session::has('message'))
                <div class="alert {{ Session::get('error') == true ? 'alert-danger' : 'alert-success' }} alert-dismissible" user="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{ Session::get('message') }}
                </div>
            @endif

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
                                <img src="{!! isset($row->available_colors)? asset('public/uploads/vehicle/colors/'.$row->available_colors) :'' !!}" width="80px" height="50px" style="align-content: center">
                            <td class="text-center">{{ ucfirst($row->color_code) }}</td>
                            </td>
                            <td class="text-center">
                                <a href="{!! url(Request::segment(1).'/edit/vehicle/'.$row->id.'/color') !!}" class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-edit"></span></a>
                                <a href="{!! route('delete-vehicle',$row->id) !!}" class="btn btn-xs btn-danger" title="Delete" user="button" data-toggle="modal" data-target="#confirmDelete" data-title="Delete" data-message="Are you sure you want to delete ?"><span class="glyphicon glyphicon-trash"></span></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {!! Form::close() !!}


    <div class="modal modal-danger" id="confirmDelete" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove-circle"></span></button>
                    <h4 class="modal-title">Delete Parmanently</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure about this ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-flat btn-default" id="confirm"><span class="glyphicon glyphicon-trash"></span> Delete</button>
                    <button type="button" class="btn btn-sm btn-flat btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span> Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection
