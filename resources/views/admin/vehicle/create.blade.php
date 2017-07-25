
@extends('admin.layouts.master')

@section('content')

    {!! Form::open(array('url' => Request::segment(1).'/vehicle/store', 'class' => 'form-horizontal', 'name' => 'admin-form', 'id' => 'admin-form','files'=>'true')) !!}
    <div class="panel panel-default">
        <div class="panel-heading">
            <span class="glyphicon glyphicon-plus"></span>&nbsp;{!! $title !!}
        </div>

        <div class="panel-body">

            <div class="col-xs-7">
                <div class="form-group{{ $errors->has('type_id') ? ' has-error' : '' }}">
                    {!! Form::label('type_id', 'Type :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::select('type_id', $type, old('type_id'), ['class' => 'form-control', 'id' => 'type_id']) !!}
                        @if ($errors->has('type_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('type_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('model_id') ? ' has-error' : '' }}">
                    {!! Form::label('model_id', 'Model :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::select('model_id', $model, old('model_id'), ['class' => 'form-control', 'id' => 'model_id']) !!}
                        @if ($errors->has('model_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('model_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('brand_id') ? ' has-error' : '' }}">
                    {!! Form::label('brand_id', 'Brand :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::select('brand_id', $brand, old('brand_id'), ['class' => 'form-control', 'id' => 'brand_id']) !!}
                        @if ($errors->has('brand_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('brand_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('engine_displacement') ? ' has-error' : '' }}">
                    {!! Form::label('engine_displacement', 'Engine Displacement :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::text('engine_displacement',  old('engine_displacement'),['class' => 'form-control', 'id' => 'engine_displacement', 'placeholder' => 'engine_displacement']) !!}
                        @if ($errors->has('engine_displacement'))
                            <span class="help-block">
                                <strong>{{ $errors->first('engine_displacement') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('engine_details') ? ' has-error' : '' }}">
                    {!! Form::label('engine_details', 'Engine Details :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::textarea('engine_details', old('engine_details'), ['class' => 'form-control', 'id' => 'engine_details', 'placeholder' => 'Engine Details', 'rows' => 3]) !!}
                        @if ($errors->has('engine_details'))
                            <span class="help-block">
                                <strong>{{ $errors->first('engine_details') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-xs-5">

                <div class="form-group{{ $errors->has('production_year') ? ' has-error' : '' }}">
                    {!! Form::label('production_year', 'Production Year :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::text('production_year',  old('production_year'),['class' => 'form-control', 'id' => 'production_year', 'placeholder' => 'production_year']) !!}
                        @if ($errors->has('production_year'))
                            <span class="help-block">
                                <strong>{{ $errors->first('production_year') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('fuel_system') ? ' has-error' : '' }}">
                    {!! Form::label('fuel_system ', 'Fuel System :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::text('fuel_system',  old('fuel_system'),['class' => 'form-control', 'id' => 'fuel_system', 'placeholder' => 'fuel_system']) !!}
                        @if ($errors->has('fuel_system'))
                            <span class="help-block">
                                <strong>{{ $errors->first('fuel_system') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('vehicle_image') ? ' has-error' : '' }}">
                    {!! Form::label('vehicle_image', 'Vehicle Image:', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-3">
                        {!! Form::file('vehicle_image',old('vehicle_image'), [ 'class' => 'form-control','required']) !!}
                        @if ($errors->has('vehicle_image'))
                            <span class="help-block">
                                <strong>{{ $errors->first('vehicle_image') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('available_colors') ? ' has-error' : '' }}">
                    {!! Form::label('available_colors', 'Available Colors:', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-3">
                        {!! Form::file('available_colors[]', ['multiple'=>true]) !!}
                        @if ($errors->has('available_colors'))
                            <span class="help-block">
                                <strong>{{ $errors->first('available_colors') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                {{--<div class="form-group">
                    {!! Form::label('color', 'Color :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::text('color', old('color', '#2fccad'), ['class' => 'form-control color', 'id' => 'color']) !!}
                    </div>
                </div>--}}

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


