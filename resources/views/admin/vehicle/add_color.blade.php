
@extends('admin.layouts.master')

@section('content')

    {!! Form::open(array('url' => Request::segment(1).'/vehicle/store', 'class' => 'form-horizontal', 'name' => 'admin-form', 'id' => 'admin-form','files'=>'true')) !!}
    <div class="panel panel-default">
        <div class="panel-heading">
            <span class="glyphicon glyphicon-plus"></span>&nbsp;{!! $title !!}
        </div>

        <div class="panel-body">

            <div class="col-xs-6">

                <div class="form-group{{ $errors->has('available_colors') ? ' has-error' : '' }}">
                    {!! Form::label('available_colors', 'Colors :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-3">
                        {!! Form::file('available_colors') !!}
                        @if ($errors->has('available_colors'))
                            <span class="help-block">
                                <strong>{{ $errors->first('available_colors') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

            </div>
            <div class="col-xs-5">

                <div class="form-group{{ $errors->has('color_code') ? ' has-error' : '' }}">
                    {!! Form::label('color_code', 'Color Code:', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::text('color_code',  old('color_code'),['class' => 'form-control', 'id' => 'color_code', 'placeholder' => 'color code']) !!}
                        @if ($errors->has('color_code'))
                            <span class="help-block">
                                <strong>{{ $errors->first('color_code') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-offset-3 col-xs-9">
                        <button class="btn btn-sm btn-primary" type="submit"><span class="glyphicon glyphicon-ok-sign"></span> Save</button>
                        <a href="{!! url('admin/vehicle') !!}" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-repeat"></span> Cancel</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection


