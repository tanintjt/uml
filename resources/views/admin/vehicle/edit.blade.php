@extends('admin.layouts.master')

@section('content')
    {!! Form::model($row,['method' => 'PUT','url' => Request::segment(1).'/vehicle/'.$row->id,'class' => 'form-horizontal', 'id' => 'admin-form','files'=>'true' ]) !!}
    <div class="panel panel-default">
        <div class="panel-heading">
            <span class="glyphicon glyphicon-plus"></span>&nbsp;{!! $title !!}
        </div>

        <div class="panel-body">

            <div class="col-xs-6">
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


                <div class="form-group{{ $errors->has('engine_no') ? ' has-error' : '' }}">
                    {!! Form::label('engine_no', 'Engine No :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::text('engine_no', old('engine_no'), ['class' => 'form-control', 'id' => 'engine_no', 'placeholder' => 'engine no']) !!}
                        @if ($errors->has('engine_no'))
                            <span class="help-block">
                                <strong>{{ $errors->first('engine_no') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('chesis_no') ? ' has-error' : '' }}">
                    {!! Form::label('chesis_no', 'Chassis No :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::text('chesis_no', old('chesis_no'), ['class' => 'form-control', 'id' => 'chesis_no', 'placeholder' => 'Chassis no']) !!}
                        @if ($errors->has('chesis_no'))
                            <span class="help-block">
                                <strong>{{ $errors->first('chesis_no') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('reg_no') ? ' has-error' : '' }}">
                    {!! Form::label('reg_no', 'Registration No :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::text('reg_no', old('reg_no'), ['class' => 'form-control', 'id' => 'reg_no', 'placeholder' => 'registration no']) !!}
                        @if ($errors->has('reg_no'))
                            <span class="help-block">
                                <strong>{{ $errors->first('reg_no') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>


                <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                    {!! Form::label('description', 'Description :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::textarea('description', old('description'), ['class' => 'form-control', 'id' => 'description', 'placeholder' => 'description', 'rows' => 4]) !!}
                        @if ($errors->has('description'))
                            <span class="help-block">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

            </div>
            <div class="col-xs-6">

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
                    {!! Form::label('engine_details', 'Engine Details:', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::textarea('engine_details', old('engine_details'), ['class' => 'form-control', 'id' => 'engine_details', 'placeholder' => 'Engine Details', 'rows' => 4]) !!}
                        @if ($errors->has('engine_details'))
                            <span class="help-block">
                                <strong>{{ $errors->first('engine_details') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

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

                <div class="form-group">
                    {!! Form::label('fuel_system ', 'Fuel System :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::text('fuel_system',  old('fuel_system'),['class' => 'form-control', 'id' => 'fuel_system', 'placeholder' => 'fuel_system']) !!}
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
