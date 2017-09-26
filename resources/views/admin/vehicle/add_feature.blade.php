
@extends('admin.layouts.master')

@section('content')


    {!! Form::open(array('url' => Request::segment(1).'/store/features', 'class' => 'form-horizontal','id'=>'upload',
      'name' => 'admin-form', 'id' => 'admin-form','files' => true)) !!}

    <div class="panel panel-default">

        <div class="panel-heading">

            {{--<span style="color:red;">* </span>You have to upload five features.--}}

            <a href="{!! route('vehicle.features',$id)!!}" class="btn btn-flat btn-danger pull-right"><i class="fa fa-remove"></i> Cancel</a>
            <button class="btn btn-flat btn-primary pull-right" id="upload"><i class="fa fa-check"></i> Save</button>
            <div class="DivClass" id="myDiv"></div> <p>&nbsp;&nbsp;</p>
            {{--<p></p>--}}
        </div>

        <div class="panel-body">
            {!! Form::hidden('vehicle_id',$id) !!}

            <div class="col-xs-7" id="feature">

                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                    {!! Form::label('title', 'Name:', ['class' => 'col-xs-2 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::text('title',  old('title'),['class' => 'form-control', 'id' => 'title', 'placeholder' => 'feature name (required)']) !!}
                        @if ($errors->has('title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

            </div>

            <div class="col-xs-5" id="title">

                <div class="form-group{{ $errors->has('files') ? ' has-error' : '' }}">
                    {!! Form::label('files', 'File :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-3">
                        {!! Form::file('files[]', ['id'=>'files','multiple' => true]) !!}
                        @if ($errors->has('files'))
                            <span class="help-block">
                                <strong>{{ $errors->first('files') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

            </div>
        </div>

        <div class="panel-body">
            {!! Form::hidden('vehicle_id',$id) !!}

            <div class="col-xs-7" id="feature">

                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                    {!! Form::label('title', 'Name:', ['class' => 'col-xs-2 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::text('title',  old('title'),['class' => 'form-control', 'id' => 'title', 'placeholder' => 'feature name (required)']) !!}
                        @if ($errors->has('title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

            </div>

            <div class="col-xs-5" id="title">

                <div class="form-group{{ $errors->has('files') ? ' has-error' : '' }}">
                    {!! Form::label('files', 'File :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-3">
                        {!! Form::file('files[]', ['id'=>'files','multiple' => true]) !!}
                        @if ($errors->has('files'))
                            <span class="help-block">
                                <strong>{{ $errors->first('files') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

            </div>
        </div>
        <div class="panel-body">
            {!! Form::hidden('vehicle_id',$id) !!}

            <div class="col-xs-7" id="feature">

                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                    {!! Form::label('title', 'Name:', ['class' => 'col-xs-2 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::text('title',  old('title'),['class' => 'form-control', 'id' => 'title', 'placeholder' => 'feature name (required)']) !!}
                        @if ($errors->has('title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

            </div>

            <div class="col-xs-5" id="title">

                <div class="form-group{{ $errors->has('files') ? ' has-error' : '' }}">
                    {!! Form::label('files', 'File :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-3">
                        {!! Form::file('files[]', ['id'=>'files','multiple' => true]) !!}
                        @if ($errors->has('files'))
                            <span class="help-block">
                                <strong>{{ $errors->first('files') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

            </div>
        </div>
        <div class="panel-body">
            {!! Form::hidden('vehicle_id',$id) !!}

            <div class="col-xs-7" id="feature">

                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                    {!! Form::label('title', 'Name:', ['class' => 'col-xs-2 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::text('title',  old('title'),['class' => 'form-control', 'id' => 'title', 'placeholder' => 'feature name (required)']) !!}
                        @if ($errors->has('title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

            </div>

            <div class="col-xs-5" id="title">

                <div class="form-group{{ $errors->has('files') ? ' has-error' : '' }}">
                    {!! Form::label('files', 'File :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-3">
                        {!! Form::file('files[]', ['id'=>'files','multiple' => true]) !!}
                        @if ($errors->has('files'))
                            <span class="help-block">
                                <strong>{{ $errors->first('files') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

            </div>
        </div>
        <div class="panel-body">
            {!! Form::hidden('vehicle_id',$id) !!}

            <div class="col-xs-7" id="feature">

                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                    {!! Form::label('title', 'Name:', ['class' => 'col-xs-2 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::text('title',  old('title'),['class' => 'form-control', 'id' => 'title', 'placeholder' => 'feature name (required)']) !!}
                        @if ($errors->has('title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

            </div>

            <div class="col-xs-5" id="title">

                <div class="form-group{{ $errors->has('files') ? ' has-error' : '' }}">
                    {!! Form::label('files', 'File :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-3">
                        {!! Form::file('files[]', ['id'=>'files','multiple' => true]) !!}
                        @if ($errors->has('files'))
                            <span class="help-block">
                                <strong>{{ $errors->first('files') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

            </div>
        </div>

    </div>

    {!! Form::close() !!}

    {{--<div class="DivClass" id="myDiv"></div> <button id="incriment" onclick="incrementDivClass()" style="background-color: #f05283;border-color: #f05283;color: white;margin-left: 84%">Add More...</button>--}}

   {{-- <script>

        function incrementDivClass()
        {
            var divIncrement = ($('.DivClass').length);
            $('.panel-body').append('<div class="col-xs-5" id="colors">' +
                '' +
                '<div class="form-group{{ $errors->has('files') ? ' has-error' : '' }}">' +
                '  {!! Form::label('files', 'File :', ['class' => 'col-xs-3 control-label']) !!}' +
                '     <div class="col-xs-3">' +
                '         {!! Form::file('files[]', ['id'=>'files','multiple' => true]) !!}' +
                '              @if ($errors->has('files'))' +
                '                   <span class="help-block">' +
                '                         <strong>{{ $errors->first('files') }}</strong>' +
                '                    </span>' +
                '               @endif' +
                '       </div>' +
                '</div>' +

                '</div>'+
                '<div class="col-xs-7" id="title">' +
                '     <div class="form-group{{ $errors->has('title') ?' has-error' : '' }}">' +
                '         {!! Form::label('title', 'Title:', ['class' => 'col-xs-2 control-label']) !!}' +
                '             <div class="col-xs-9">' +
                '                 {!! Form::text('title',  old('title'),['class' => 'form-control','id' =>'color_code','placeholder' =>'feature name']) !!}' +
                '                       @if ($errors->has('title'))' +
                '                          <span class="help-block">' +
                '                              <strong>{{ $errors->first('title') }}</strong>' +
                '                          </span>' +
                '                       @endif' +
                '             </div>' +
                '      </div>' +
                '</div>' /*+
            '<div class="col-xs-2" id="remove">' +'&nbsp;'+
            '     <div class="form-group">' +
            '             <div class="col-xs-9">' +
            '                 <span style="color: black;margin-top: 5%"><span class="glyphicon glyphicon-remove"></span></span>' +
            '             </div>' +
            '      </div>' +
            '</div>'*/
            );

        }

        $("#remove").click(function(){
            $(this).parent(".panel-body").remove();
        });
    </script>--}}


    <style>

        .fileUpload {
            position: relative;
            overflow: hidden;
            margin: 10px;
        }
        .fileUpload input.upload {
            position: absolute;
            top: 0;
            right: 0;
            margin: 0;
            padding: 0;
            font-size: 20px;
            cursor: pointer;
            opacity: 0;
            filter: alpha(opacity=0);
        }
    </style>

@endsection


