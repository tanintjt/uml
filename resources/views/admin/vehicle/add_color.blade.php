
@extends('admin.layouts.master')

@section('content')



    {!! Form::open(array('url' => Request::segment(1).'/vehicle/store/color', 'class' => 'form-horizontal','id'=>'upload',
      'name' => 'admin-form', 'id' => 'admin-form','files' => true)) !!}

    <div class="panel panel-default">

        <div class="panel-heading">
            <a href="{!! route('vehicle.color',$id)!!}" class="btn btn-flat btn-danger pull-right"><i class="fa fa-remove"></i> Cancel</a>
            <button class="btn btn-flat btn-primary pull-right" id="upload"><i class="fa fa-check"></i> Save</button>
            <div class="DivClass" id="myDiv"></div> <p>&nbsp;&nbsp;</p>
        </div>

        <div class="panel-body" style="margin-left: 14%">

            <div class="col-xs-5" id="colors">
                {!! Form::hidden('vehicle_id',$id) !!}

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

            <div class="col-xs-7" id="code">

                <div class="form-group{{ $errors->has('color_code') ? ' has-error' : '' }}">
                    {!! Form::label('color_code', 'Color:', ['class' => 'col-xs-2 control-label']) !!}
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

            {{--<div class="col-xs-2" id="remove">
                <div class="form-group">
                    <div class="col-xs-9">
                        <span style="color: black;margin-top: 5%"><span class="glyphicon glyphicon-remove"></span></span>
                   </div>
                </div>
            </div>--}}

        </div>
    </div>

    {!! Form::close() !!}
    <div class="DivClass" id="myDiv"></div> <button id="incriment" onclick="incrementDivClass()" style="background-color: #f05283;border-color: #f05283;color: white;margin-left: 84%">Add More...</button>

    <script>

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
                '<div class="col-xs-7" id="code">' +
                '     <div class="form-group{{ $errors->has('color_code') ?' has-error' : '' }}">' +
                '         {!! Form::label('color_code', 'Color:', ['class' => 'col-xs-2 control-label']) !!}' +
                '             <div class="col-xs-9">' +
                '                 {!! Form::text('color_code',  old('color_code'),['class' => 'form-control','id' =>'color_code','placeholder' =>'color code']) !!}' +
                '                       @if ($errors->has('color_code'))' +
                '                          <span class="help-block">' +
                '                              <strong>{{ $errors->first('color_code') }}</strong>' +
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
    </script>


@endsection


