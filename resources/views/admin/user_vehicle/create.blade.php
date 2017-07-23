<link href="{!! asset('public/themes/default/plugins/datepicker/bootstrap-datepicker.min.css') !!}" rel="stylesheet">
<link href="{!! asset('public/themes/default/css/bootstrap.min.css') !!}" rel="stylesheet">
<script src="{!! asset('public/themes/default/plugins/jQuery/jquery-2.2.3.min.js') !!}"></script>

<script src="{!! asset('public/themes/default/plugins/datepicker/bootstrap-datepicker.min.js') !!}"></script>


@extends('admin.layouts.master')

@section('content')

    {!! Form::open(array('url' => Request::segment(1).'/user-vehicle/store', 'class' => 'form-horizontal', 'name' => 'admin-form', 'id' => 'admin-form','files'=>'true')) !!}
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
                    {!! Form::label('brand_id', 'Vehicle :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::select('brand_id', $brand, old('brand_id'), ['class' => 'form-control', 'id' => 'brand_id']) !!}
                        @if ($errors->has('brand_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('brand_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>


            </div>
            <div class="col-xs-5">

                <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
                    {!! Form::label('user_id', 'User :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::select('user_id', $users, old('user_id'), ['class' => 'form-control', 'id' => 'user_id']) !!}
                        @if ($errors->has('user_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('user_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('purchase_date') ? ' has-error' : '' }}">
                    {!! Form::label('purchase_date', 'Purchase Date :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::text('purchase_date',  old('purchase_date'),['class' => 'form-control datepicker', 'id' => 'purchase_date', 'placeholder' => 'purchase date']) !!}
                        @if ($errors->has('purchase_date'))
                            <span class="help-block">
                                <strong>{{ $errors->first('purchase_date') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-xs-offset-3 col-xs-9">
                        <button class="btn btn-sm btn-primary" type="submit"><span class="glyphicon glyphicon-ok-sign"></span> Save</button>
                        <a href="{!! url('/user-vehicle') !!}" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-repeat"></span> Cancel</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
    {!! Form::close() !!}

    <script>
        $('.datepicker').datepicker({
            autoclose: true,
            format:'yyyy-mm-dd'
        })
    </script>
@endsection


