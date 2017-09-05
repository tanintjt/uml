
<link href="{!! asset('public/themes/default/plugins/datepicker/bootstrap-datepicker.min.css') !!}" rel="stylesheet">
<link href="{!! asset('public/themes/default/css/bootstrap.min.css') !!}" rel="stylesheet">
<script src="{!! asset('public/themes/default/plugins/jQuery/jquery-2.2.3.min.js') !!}"></script>
<script src="{!! asset('public/themes/default/plugins/datepicker/bootstrap-datepicker.min.js') !!}"></script>


<link href="{!! asset('public/themes/default/select2/dist/css/select2.css') !!}" rel="stylesheet">
<script src="{!! asset('public/themes/default/select2/dist/js/select2.js') !!}"></script>

@extends('admin.layouts.master')

@section('content')

    {!! Form::open(array('url' => Request::segment(1).'/user-vehicle/store', 'class' => 'form-horizontal', 'name' => 'admin-form', 'id' => 'admin-form','files'=>'true')) !!}
    <div class="panel panel-default">
        <div class="panel-heading">
            <span class="glyphicon glyphicon-plus"></span>&nbsp;{!! $title !!}
        </div>

        <div class="panel-body">
            @if(Session::has('message'))
                <div class="alert {{ Session::get('error') == true ? 'alert-danger' : 'alert-success' }} alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{ Session::get('message') }}
                </div>
            @endif
            <div class="col-xs-5">

                {{--<div class="form-group{{ $errors->has('model_id') ? ' has-error' : '' }}">
                    {!! Form::label('model_id', 'Vehicle Model :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::select('model_id', $model, old('model_id'), ['class' => 'form-control', 'id' => 'model_id']) !!}
                        @if ($errors->has('model_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('model_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>--}}

                <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
                    {!! Form::label('user_id', 'Customer Name :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::select('user_id', $users, old('user_id'), ['class' => 'form-control','id'=>'searchText']) !!}
                        @if ($errors->has('user_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('user_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>


                <div class="form-group{{ $errors->has('engine_no') ? ' has-error' : '' }}">
                    {!! Form::label('engine_no', 'Engine No:', ['class' => 'col-xs-3 control-label']) !!}
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
                    {!! Form::label('chesis_no', 'Chassis No:', ['class' => 'col-xs-3 control-label']) !!}
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
                    {!! Form::label('reg_no', 'Registration No:', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::text('reg_no', old('reg_no'), ['class' => 'form-control', 'id' => 'reg_no', 'placeholder' => 'registration no']) !!}
                        @if ($errors->has('reg_no'))
                            <span class="help-block">
                                <strong>{{ $errors->first('reg_no') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-xs-7">

                <div class="form-group{{ $errors->has('color') ? ' has-error' : '' }}">
                    {!! Form::label('color', 'Color :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::text('color', old('color'), ['class' => 'form-control', 'id' => 'color', 'placeholder' => 'color']) !!}
                        @if ($errors->has('color'))
                            <span class="help-block">
                                <strong>{{ $errors->first('color') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>


                <div class="form-group{{ $errors->has('purchase_date') ? ' has-error' : '' }}">
                    {!! Form::label('purchase_date', 'Purchase Date:', ['class' => 'col-xs-3 control-label']) !!}
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
                        <a href="{!! url('admin/user-vehicle') !!}" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-repeat"></span> Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {!! Form::close() !!}

    <script>

        $('.datepicker').datepicker({
            autoclose: true,
            format:'yyyy-mm-dd',
        })

        $("#searchText").select2();

    </script>




@endsection


