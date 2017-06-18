@extends('admin.layouts.master')

@section('content')
    {!! Form::open(array('url' => Request::segment(1).'/service-center', 'class' => 'form-horizontal', 'name' => 'admin-form', 'id' => 'admin-form','files'=>'true')) !!}
    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="input-group">
                <span class="input-group-btn">
                    <a href="{!! url(Request::segment(1).'/service-center') !!}" class="btn btn-flat btn-danger pull-right"><i class="fa fa-remove"></i> Cancel</a>
                    <button class="btn btn-flat btn-primary pull-right" type="submit"><i class="fa fa-check"></i> Save</button>
                </span>
            </div>
        </div>
        <div class="box-body">
            <div class="col-xs-12">
                <div class="form-group">
                    {!! Form::label('address', 'Address :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-3">
                        {!! Form::textarea('address', old('address'), ['class' => 'form-control', 'id' => 'address', 'placeholder' => 'Address', 'rows' => 3]) !!}
                    </div>
                </div>
                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                    {!! Form::label('phone', 'Phone :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-3">
                        {!! Form::text('phone', old('phone'), ['class' => 'form-control', 'id' => 'phone', 'placeholder' => 'Phone']) !!}
                        @if ($errors->has('phone'))
                            <span class="help-block">
                                <strong>{{ $errors->first('phone') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('latitude') ? ' has-error' : '' }}">
                    {!! Form::label('latitude', 'Latitude :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-3">
                        {!! Form::text('latitude', old('latitude'), ['class' => 'form-control', 'id' => 'latitude', 'placeholder' => 'latitude']) !!}
                        @if ($errors->has('latitude'))
                            <span class="help-block">
                                <strong>{{ $errors->first('latitude') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('longitude') ? ' has-error' : '' }}">
                    {!! Form::label('longitude', 'Longitude :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-3">
                        {!! Form::text('longitude', old('longitude'), ['class' => 'form-control', 'id' => 'longitude', 'placeholder' => 'longitude']) !!}
                        @if ($errors->has('longitude'))
                            <span class="help-block">
                                <strong>{{ $errors->first('longitude') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('store_image') ? ' has-error' : '' }}">
                    {!! Form::label('store_image', 'Store Image:', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-3">
                        {!! Form::file('store_image',old('store_image'), [ 'class' => 'form-control','required']) !!}
                        @if ($errors->has('store_image'))
                            <span class="help-block">
                                <strong>{{ $errors->first('store_image') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
