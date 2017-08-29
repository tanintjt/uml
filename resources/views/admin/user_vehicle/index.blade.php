@extends('admin.layouts.master')


@section('content')
    {!! Form::open(array('url' => Request::segment(1).'/user-vehicle', 'method' => 'POST', 'class' => 'form-inline', 'name' => 'admin-form', 'id' => 'admin-form')) !!}
    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="input-group">
                {!! Form::text('search', old('search', Session::get('search')), ['class' => 'form-control input-sm', 'placeholder' => 'Search for...', 'id' => 'search']) !!}
                <span class="input-group-btn">
                    <button type="button" class="btn btn-success btn-sm go"><span class="glyphicon glyphicon-search"></span> Go</button>
                    <button type="button" class="btn btn-info btn-sm clear"><span class="glyphicon glyphicon-refresh"></span> Clear</button>
                    <a href="{!! url(Request::segment(1).'/user-vehicle/create')!!}" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-plus-sign"></span> New</a>
                </span>
            </div>
            <div class="pull-right">
                {!! Form::select('user_id', $users, old('user_id', Session::get('user_id') ), ['class' => 'form-control input-sm', 'id' => 'user_id']) !!}
                {{--{!! Form::select('model_id', $model, old('model_id', Session::get('model_id') ), ['class' => 'form-control input-sm', 'id' => 'model_id']) !!}--}}
            </div>

        </div>
        <div class="box-body">

            @if(Session::has('message'))
                <div class="alert {{ Session::get('error') == true ? 'alert-danger' : 'alert-success' }} alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{ Session::get('message') }}
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr class="active">
                        <th width="5%">#</th>
                        <th width="5%">User Name</th>
                        <th width="5%">Vehicle</th>
                        <th width="5%">Engine No</th>
                        <th width="5%">Chassis No</th>
                        <th width="5%">Purchase Date</th>
                        <th width="10%">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>
                    @foreach ($rows as $row)
                        <tr>
                            <td>{{ ((\Request::get('page', 1) - 1) * config('app.limit')) + $i++ }} </td>
                            <td>{{ isset($row->users->name)?$row->users->name:''}}</td>
                            <td>{{ $row->vehicles->model->name }}</td>
                            <td>{{ $row->vehicles->engine_no }}</td>
                            <td>{{ $row->vehicles->chesis_no }}</td>
                            <td>{{ isset($row->purchase_date)?date('Y-m-d', strtotime($row->purchase_date)):''}}</td>
                            <td>
                                <a href="{!! url(Request::segment(1).'/user-vehicle/'.$row->id.'/view') !!}" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-eye-open"></span></a>
                                <a href="{!! url(Request::segment(1).'/user-vehicle/'.$row->id.'/edit') !!}" class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-edit"></span></a>
                                <a href="{!! route('user-vehicle.delete',$row->id) !!}" class="btn btn-xs btn-danger" title="Delete " user="button" data-toggle="modal" data-target="#confirmDelete" data-title="Delete" data-message="Are you sure you want to delete ?"><span class="glyphicon glyphicon-trash"></span></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="box-footer">
            {{ $rows->links() }}
        </div>

    </div>
    {!! Form::close() !!}

    <div class="modal modan-danger" id="confirmDelete" user="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
        <div class="modal-dialog" >
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove-circle"></span></button>
                    <h4 class="modal-title">Delete Parmanently</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure about this ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-xs btn-danger" id="confirm"><span class="glyphicon glyphicon-trash"></span> Delete</button>
                    <button type="button" class="btn btn-xs btn-primary" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span> Close</button>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="image" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    {{--<h4 class="modal-title">{{$title}}</h4>--}}
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    {{--@include('admin.vehicle.vehicle_image')--}}
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

@endsection