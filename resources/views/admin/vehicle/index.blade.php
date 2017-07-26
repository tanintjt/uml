@extends('admin.layouts.master')


@section('content')
    {!! Form::open(array('url' => Request::segment(1).'/vehicle', 'method' => 'POST', 'class' => 'form-inline', 'name' => 'admin-form', 'id' => 'admin-form')) !!}
    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="input-group">
                {!! Form::text('search', old('search', Session::get('search')), ['class' => 'form-control input-sm', 'placeholder' => 'Search for...', 'id' => 'search']) !!}
                <span class="input-group-btn">
                    <button type="button" class="btn btn-success btn-sm go"><span class="glyphicon glyphicon-search"></span> Go</button>
                    <button type="button" class="btn btn-info btn-sm clear"><span class="glyphicon glyphicon-refresh"></span> Clear</button>
                    <a href="{!! url(Request::segment(1).'/vehicle/create')!!}" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-plus-sign"></span> New</a>
                </span>
            </div>
            <div class="pull-right">
                {!! Form::select('type_id', $type, old('type_id', Session::get('type_id') ), ['class' => 'form-control input-sm', 'id' => 'type_id']) !!}
                {!! Form::select('model_id', $model, old('model_id', Session::get('model_id') ), ['class' => 'form-control input-sm', 'id' => 'model_id']) !!}
                {!! Form::select('brand_id', $brand, old('brand_id', Session::get('brand_id') ), ['class' => 'form-control input-sm', 'id' => 'brand_id']) !!}
            </div>

        </div>
        <div class="box-body">

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
                        <th width="5%">#</th>
                        <th width="5%">Brand</th>
                        <th width="5%">Type</th>
                        <th width="5%">Model</th>
                        <th width="5%">Fuel System</th>
                        <th width="10%" class="text-center">Image</th>
                        <th width="10%">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>
                    @foreach ($rows as $row)
                        <tr>
                            <td>{{ ((\Request::get('page', 1) - 1) * config('app.limit')) + $i++ }} </td>
                            <td>{{ isset($row->brand->name)?$row->brand->name:''}}</td>
                            <td>{{ isset($row->types->name)?$row->types->name:''}}</td>
                            <td>{{ isset($row->model->name)?$row->model->name:''}}</td>
                            <td>{{ $row->fuel_system }}</td>
                            <td>
                                @if( isset($row->vehicle_image))
                                <a href="{!!route('vehicle-image',$row->id)  !!}" data-toggle="modal" data-target="#image">
                                    <img src="{!! asset(isset($row->vehicle_image)?$row->vehicle_image:'') !!}" width="60px" height="50px" style="margin-left: 26%">
                                </a>

                                @else
                                    <img src="{{ URL::to('/img/default.jpg') }}" width="80px" height="80px">
                                @endif
                            </td>
                            <td>

                                <a href="{!! url(Request::segment(1).'/vehicle/'.$row->id) !!}" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-eye-open"></span></a>
                                <a href="{!! url(Request::segment(1).'/vehicle/'.$row->id.'/edit') !!}" class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-edit"></span></a>
                                <a href="{!! route('vehicle-delete',$row->id) !!}" class="btn btn-xs btn-danger" title="Delete " user="button" data-toggle="modal" data-target="#confirmDelete" data-title="Delete" data-message="Are you sure you want to delete ?"><span class="glyphicon glyphicon-trash"></span></a>
                                <a href="{!! route('vehicle-colors',$row->id) !!}" class="btn btn-xs btn-info" title="available colors">Colors</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="box-footer">

        </div>

    </div>
    {!! Form::close() !!}

    <div class="modal modan-danger" id="confirmDelete" user="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
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
                    <button type="button" class="btn btn-xs btn-danger" id="confirm"><span class="glyphicon glyphicon-trash"></span> Delete</button>
                    <button type="button" class="btn btn-xs btn-primary" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span> Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="image" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog"  style="width:60%;">
            <div class="modal-content">

            </div>
        </div>
    </div>



@endsection