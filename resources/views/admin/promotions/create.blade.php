


<link href="{!! asset('public/themes/default/plugins/datepicker/bootstrap-datepicker.min.css') !!}" rel="stylesheet">
<link href="{!! asset('public/themes/default/css/bootstrap.min.css') !!}" rel="stylesheet">
<script src="{!! asset('public/themes/default/plugins/jQuery/jquery-2.2.3.min.js') !!}"></script>

<script src="{!! asset('public/themes/default/plugins/datepicker/bootstrap-datepicker.min.js') !!}"></script>


@extends('admin.layouts.master')

@section('content')

    {!! Form::open(array('url' => Request::segment(1).'/promotions/store', 'class' => 'form-horizontal', 'name' => 'admin-form', 'id' => 'admin-form','files'=>'true')) !!}
    <div class="panel panel-default">
        <div class="panel-heading">
            <span class="glyphicon glyphicon-plus"></span>&nbsp;{!! $title !!}
        </div>

        <div class="panel-body">

            <div class="col-xs-7">

                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                    {!! Form::label('title', 'Title :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::text('title',  old('title'),['class' => 'form-control', 'id' => 'title', 'placeholder' => 'title']) !!}
                        @if ($errors->has('title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('start_date') ? ' has-error' : '' }}">
                    {!! Form::label('start_date', 'Start Date :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::text('start_date',  old('start_date'),['class' => 'form-control datepicker', 'id' => 'start_date', 'placeholder' => 'start date']) !!}
                        @if ($errors->has('start_date'))
                            <span class="help-block">
                                <strong>{{ $errors->first('start_date') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

            </div>

            <div class="col-xs-5">

                <div class="form-group{{ $errors->has('end_date') ? ' has-error' : '' }}">
                    {!! Form::label('end_date', 'End Date :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::text('end_date',  old('end_date'),['class' => 'form-control datepicker', 'id' => 'end_date', 'placeholder' => 'end date']) !!}
                        @if ($errors->has('end_date'))
                            <span class="help-block">
                                <strong>{{ $errors->first('end_date') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
                    {!! Form::label('file', 'File:', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-3">
                        {!! Form::file('file',old('file'), [ 'class' => 'form-control','required']) !!}
                        @if ($errors->has('file'))
                            <span class="help-block">
                                <strong>{{ $errors->first('file') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-offset-3 col-xs-9">
                        <button class="btn btn-sm btn-primary" type="submit"><span class="glyphicon glyphicon-ok-sign"></span> Save</button>
                        <a href="{!! url('admin/promotions') !!}" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-repeat"></span> Cancel</a>
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






