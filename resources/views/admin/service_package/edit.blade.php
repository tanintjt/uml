@extends('admin.layouts.master')

@section('content')
    {!! Form::model($row,['method' => 'PUT','url' => Request::segment(1).'/service-package/'.$row->id,'class' => 'form-horizontal', 'id' => 'admin-form','files'=>'true' ]) !!}
    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="input-group">
            </div>
        </div>
        <div class="panel-body">
            @if(Session::has('message'))
                <div class="alert {{ Session::get('error') == true ? 'alert-danger' : 'alert-success' }} alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{ Session::get('message') }}
                </div>
            @endif
            <div class="col-xs-5">

                <div class="form-group{{ $errors->has('package_type_id') ? ' has-error' : '' }}">
                    {!! Form::label('package_type_id', 'Category :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::select('package_type_id', $package_type_id, old('package_type_id'), ['class' => 'form-control', 'id' => 'package_type_id']) !!}
                        @if ($errors->has('package_type_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('package_type_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('details', 'Details :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::textarea('details', old('details'), ['class' => 'form-control', 'id' => 'details', 'placeholder' => 'Details', 'rows' => 3]) !!}
                    </div>
                </div>

            </div>

            <div class="col-xs-7">
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    {!! Form::label('name', 'Name :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::text('name', old('name'), ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Name']) !!}
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>



                <div class="form-group{{ $errors->has('package_rate') ? ' has-error' : '' }}">
                    {!! Form::label('package_rate', 'Rate :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::text('package_rate', old('package_rate'), ['class' => 'form-control', 'id' => 'package_rate', 'placeholder' => 'package rate']) !!}
                        @if ($errors->has('package_rate'))
                            <span class="help-block">
                                <strong>{{ $errors->first('package_rate') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-offset-3 col-xs-9">
                        <button class="btn btn-sm btn-primary" type="submit"><span class="glyphicon glyphicon-ok-sign"></span> Save</button>
                        <a href="{!! url('admin/service-package') !!}" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-repeat"></span> Cancel</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
