
@extends('admin.layouts.master')

@section('content')

    {!! Form::model($row,['method' => 'PUT','route'=>['vehicle-color-update',$row->id],'class' => 'form-horizontal', 'id' => 'admin-form','files'=>'true' ]) !!}

    <div class="panel panel-default">

        <div class="panel-heading">
            <a href="{!! url(Request::segment(1).'/vehicle/'.$row->vehicle_id.'/colors') !!}" class="btn btn-flat btn-danger pull-right"><i class="fa fa-remove"></i> Cancel</a>
            <button class="btn btn-flat btn-primary pull-right" id="upload"><i class="fa fa-check"></i> Save</button>
            <div class="DivClass" id="myDiv"></div> <p>&nbsp;&nbsp;</p>
        </div>

        <div class="panel-body" style="margin-left: 14%">

            <div class="col-xs-5" id="colors">

                <div class="form-group{{ $errors->has('files') ? ' has-error' : '' }}">
                    {!! Form::label('files', 'File :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-3">
                        {!! Form::file('files', ['id'=>'files']) !!}
                        @if ($errors->has('files'))
                            <span class="help-block">
                                <strong>{{ $errors->first('files') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

            </div>

            <div class="col-xs-7" id="code">

                <div class="form-group{{ $errors->has('color_code') ? ' has-error' : '' }}">
                    {!! Form::label('color_code', 'Color:', ['class' => 'col-xs-2 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::text('color_code',  old('color_code',$row->color_code),['class' => 'form-control', 'id' => 'color_code', 'placeholder' => 'color code']) !!}
                        @if ($errors->has('color_code'))
                            <span class="help-block">
                                <strong>{{ $errors->first('color_code') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

    {!! Form::close() !!}

@endsection


