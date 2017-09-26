@extends('admin.layouts.master')

@section('content')
    {!! Form::open(array('url' => '/vehicle/'.$row->id.'/features', 'class' => 'form-inline', 'name' => 'admin-form', 'id' => 'admin-form', 'method' => 'get')) !!}
    <div class="panel panel-default">
        <div class="panel-heading">
            <span class="input-group-btn">
                    {{--<button type="button" class="btn btn-success btn-sm go"><span class="glyphicon glyphicon-search"></span> Go</button>--}}
                    {{--<button type="button" class="btn btn-info btn-sm clear"><span class="glyphicon glyphicon-refresh"></span> Clear</button>--}}
                    <a href="{!! url(Request::segment(1).'/vehicle/'.$row->id.'/create/features') !!}" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-plus-sign"></span> New</a>

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
                        <th width="10%" class="text-center">Name</th>
                        <th width="10%" class="text-center">Features</th>
                        <th width="10%" class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>
                    @foreach ($rows as $row)
                        <tr>
                            <td>{{ ((\Request::get('page', 1) - 1) * config('app.limit')) + $i++ }} </td>
                            <td class="text-center">{{ $row->title }}</td>
                            <td style="align-content: center">
                                {{--<img src="{!! asset(isset($row->features)?$row->features:'') !!}" width="80px" height="50px" style="align-content: center">--}}
                                <img src="{!! isset($row->features)? asset('public/uploads/vehicle/features/'.$row->features) :'' !!}" width="80px" height="50px" style="align-content: center">
                            </td>
                            <td class="text-center">
                                <a href="{!! route('features-delete',$row->id) !!}" class="btn btn-xs btn-danger" title="Delete" user="button" data-toggle="modal" data-target="#confirmDelete" data-title="Delete" data-message="Are you sure you want to delete ?"><span class="glyphicon glyphicon-trash"></span></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
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
        <div class="modal-dialog">
            <div class="modal-content">

            </div>
        </div>
    </div>

@endsection
