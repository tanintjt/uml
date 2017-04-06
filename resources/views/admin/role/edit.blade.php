@extends('admin.layouts.master')

@section('content')
    {!! Form::model($row,['method' => 'PUT','url' => Request::segment(1).'/role/'.$row->id,'class' => 'form-horizontal', 'id' => 'admin-form' ]) !!}
    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="input-group">
                <span class="input-group-btn">
                    <a href="{!! url(Request::segment(1).'/role') !!}" class="btn btn-flat btn-danger pull-right"><i class="fa fa-remove"></i> Cancel</a>
                    <button class="btn btn-flat btn-primary pull-right" type="submit"><i class="fa fa-check"></i> Save</button>
                </span>
            </div>
        </div>
        <div class="box-body">

            <div class="col-xs-6">
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    {!! Form::label('name', 'Name :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::text('name', old('name', $row->display_name), ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Role name']) !!}
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('status', 'Status :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        <label class="radio-inline">
                            {!! Form::radio('status', '1', ($row->status == 1 ? true : false), ['id' => 'statuson']) !!} Yes
                        </label>
                        <label class="radio-inline">
                            {!! Form::radio('status', '2', ($row->status == 2 ? true : false), ['id' => 'statusoff']) !!} No
                        </label>
                    </div>
                </div>

            </div>

            <div class="col-xs-6">
                <div class="form-group{{ $errors->has('permission_id') ? ' has-error' : '' }}">
                    {!! Form::label('permission_id', 'Permissions :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-8">
                        {!! Form::select('permission_id[]', $permissions, old('permission_id', $rolePermissions), ['class' => 'form-control', 'id' => 'permission_id', 'multiple']) !!}
                        @if ($errors->has('permission_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('permission_id') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col-xs-1">
                        <div class="checkbox">
                            <label>
                                {{ Form::checkbox('', '', false, array('id' => 'checkbox')) }} All
                            </label>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    {!! Form::close() !!}
@endsection
