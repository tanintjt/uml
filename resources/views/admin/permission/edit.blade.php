@extends('admin.layouts.master')

@section('content')
    {!! Form::model($row,['method' => 'PUT','route'=>['permission-update',$row->id],'class' => 'form-horizontal', 'id' => 'admin-form' ]) !!}
    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="input-group">
                <span class="input-group-btn">
                    <a href="{!! url(Request::segment(1).'/permission') !!}" class="btn btn-flat btn-danger pull-right"><i class="fa fa-remove"></i> Back</a>
                    <button class="btn btn-flat btn-primary pull-right" type="submit"><i class="fa fa-check"></i> Update</button>
                </span>
            </div>
        </div>
        <div class="box-body">
            <div class="col-xs-12">
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    {!! Form::label('name', 'Name :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-3">
                        {!! Form::text('name', old('name', $row->display_name), ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Permission name']) !!}
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('description', 'Description :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-3">
                        {!! Form::textarea('description', old('description', $row->description), ['class' => 'form-control', 'id' => 'description', 'placeholder' => 'Description', 'rows' => 3]) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('status', 'Status :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-3">
                        <label class="radio-inline">
                            {!! Form::radio('status', '1', ($row->status == 1 ? true : false), ['id' => 'statuson']) !!} Yes
                        </label>
                        <label class="radio-inline">
                            {!! Form::radio('status', '2', ($row->status == 2 ? true : false), ['id' => 'statusoff']) !!} No
                        </label>
                    </div>
                </div>

            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
