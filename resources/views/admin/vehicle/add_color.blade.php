
@extends('admin.layouts.master')

@section('content')

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">


    <div class="panel panel-default">
        <div class="panel-heading">
            {{--<span class="glyphicon glyphicon-plus"></span>&nbsp;--}}
            {{--<button class="btn btn-primary btn-xs pull-right yourDivClass" id="incriment" onclick="incrementDivClass()" style="background-color: #f05283;border-color: #f05283">+</button>{!! $title !!}--}}
            <div class="yourDivClass" id="myDiv"></div> <button id="incriment" onclick="incrementDivClass()" style="background-color: #f05283;border-color: #f05283;color: white">+</button>

                    <a href="{!! url(Request::segment(1).'/role') !!}" class="btn btn-flat btn-danger pull-right"><i class="fa fa-remove"></i> Cancel</a>
                    <button class="btn btn-flat btn-primary pull-right" type="submit"><i class="fa fa-check"></i> Save</button>

        </div>

        {!! Form::open(array('url' => Request::segment(1).'/vehicle/store', 'class' => 'form-horizontal', 'name' => 'admin-form', 'id' => 'admin-form','files'=>'true')) !!}
        <div class="panel-body">

            <div class="col-xs-7" id="colors">

                <div class="form-group{{ $errors->has('available_colors') ? ' has-error' : '' }}">
                    {!! Form::label('available_colors', 'File :', ['class' => 'col-xs-3 control-label']) !!}
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
            <div class="col-xs-5" id="code">

                <div class="form-group{{ $errors->has('color_code') ? ' has-error' : '' }}">
                    {!! Form::label('color_code', 'Color:', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::text('color_code',  old('color_code'),['class' => 'form-control', 'id' => 'color_code', 'placeholder' => 'color code']) !!}
                        @if ($errors->has('color_code'))
                            <span class="help-block">
                                <strong>{{ $errors->first('color_code') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            {{--<div class="form-group pull-right">
                <div class="col-xs-offset-3 col-xs-9">
                    <button class="btn btn-sm btn-primary" type="submit"><span class="glyphicon glyphicon-ok-sign"></span> Save</button>
                    <a href="{!! url('admin/vehicle') !!}" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-repeat"></span> Cancel</a>
                </div>
            </div>--}}
        </div>
    </div>


    <script>

        function incrementDivClass()
        {
            var divIncriment = ($('.yourDivClass').length);
            $('.panel-body').append('<div class="col-xs-7" id="colors">' +
                '' +
                '                <div class="form-group{{ $errors->has('available_colors') ? ' has-error' : '' }}">' +
                '                    {!! Form::label('available_colors', 'File :', ['class' => 'col-xs-3 control-label']) !!}' +
                '                    <div class="col-xs-3">' +
                '                        {!! Form::file('available_colors') !!}' +
                '                        @if ($errors->has('available_colors'))' +
                '                            <span class="help-block">' +
                '                                <strong>{{ $errors->first('available_colors') }}</strong>' +
                '                            </span>' +
                '                        @endif' +
                '                    </div>' +
                '                </div>' +
                '' +
                '            </div>'+
                '<div class="col-xs-5" id="code">' +'&nbsp;'+
                '<div class="form-group{{ $errors->has('color_code') ?' has-error' : '' }}">' +
                '{!! Form::label('color_code', 'Color:', ['class' => 'col-xs-3 control-label']) !!}' +
                '<div class="col-xs-9">' +
                '{!! Form::text('color_code',  old('color_code'),['class' => 'form-control','id' =>'color_code','placeholder' =>'color code']) !!}' +
                '@if ($errors->has('color_code'))' +
                '<span class="help-block">' +
                '<strong>{{ $errors->first('color_code') }}</strong>' +
                '</span>' +
                '@endif' +
                '</div>' +
                '</div>' +
                '</div>'
            );
        }
    </script>

    {!! Form::close() !!}
@endsection


