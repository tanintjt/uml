@extends('admin.layouts.master')

@section('content')
    {!! Form::open(array('url' => Request::segment(1).'/service-package', 'method' => 'POST', 'class' => 'form-inline', 'name' => 'admin-form', 'id' => 'admin-form')) !!}
    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="input-group">
                {!! Form::text('search', old('search', Session::get('search')), ['class' => 'form-control input-sm', 'placeholder' => 'Search for...', 'id' => 'search']) !!}
                <span class="input-group-btn">
                    <button type="button" class="btn btn-success btn-sm go"><span class="glyphicon glyphicon-search"></span> Go</button>
                    <button type="button" class="btn btn-info btn-sm clear"><span class="glyphicon glyphicon-refresh"></span> Clear</button>
                    <a href="{!! url(Request::segment(1).'/service-package/create')!!}" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-plus-sign"></span> New</a>
                </span>
            </div>
            <div class="pull-right">
                {!! Form::select('package_type_id', $package_type_id, old('package_type_id', Session::get('package_type_id') ), ['class' => 'form-control input-sm', 'id' => 'package_type_id']) !!}
                {{--{!! Form::select('model_id', $model, old('model_id', Session::get('model_id') ), ['class' => 'form-control input-sm', 'id' => 'model_id']) !!}--}}
                {{--{!! Form::select('brand_id', $brand, old('brand_id', Session::get('brand_id') ), ['class' => 'form-control input-sm', 'id' => 'brand_id']) !!}--}}
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
                        <th width="20%">Category Name</th>
                        <th width="20%">Package Name</th>
                        <th width="8%">Package Rate</th>
                        <th width="10%">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>
                    @foreach ($rows as $row)
                        <tr>
                            <td>{{ ((\Request::get('page', 1) - 1) * config('app.limit')) + $i++ }} </td>
                            <td>{{isset($row->service_package_type->name)?$row->service_package_type->name:''}}</td>
                            <td>{{ $row->name}}</td>
                            <td>{{ $row->package_rate}}</td>
                            {{--<td class="text-center">
                                <span class="glyphicon glyphicon-{{ $row->status == 1 ? 'ok text-primary':'remove text-danger' }}" aria-hidden="true"></span>
                            </td>--}}
                            <td>
                                <a href="{!! url(Request::segment(1).'/service-package/'.$row->id) !!}" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-eye-open"></span></a>
                                <a href="{!! url(Request::segment(1).'/service-package/'.$row->id.'/edit') !!}" class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-edit"></span></a>

                                {{--<a href="{!! url(Request::segment(1).'/permission/'.$row->id.'/delete') !!}" class="btn btn-xs btn-danger" title="Delete {!! $row->display_name !!}" role="button" data-toggle="modal" data-target="#confirmDelete" data-title="Delete {!!  $row->display_name !!}" data-message="Are you sure you want to delete {!!  $row->display_name !!} ?"><span class="glyphicon glyphicon-trash"></span></a>--}}
                                <a href="{!! route('service-package-delete',$row->id) !!}" class="btn btn-xs btn-danger" title="Delete {!! $row->display_name !!}" user="button" data-toggle="modal" data-target="#confirmDelete" data-title="Delete {!!  $row->display_name !!}" data-message="Are you sure you want to delete {!!  $row->display_name !!} ?"><span class="glyphicon glyphicon-trash"></span></a>
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

