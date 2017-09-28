<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

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

        <div class="panel-body" id="customFields" style="margin-left: 14%">
            <div class="row">
                <div class="col-xs-5" id="colors">
                    {!! Form::hidden('vehicle_id',$id) !!}

                    <div class="form-group{{ $errors->has('files') ? ' has-error' : '' }}">
                        {!! Form::label('files', 'File :', ['class' => 'col-xs-3 control-label']) !!}
                        <div class="col-xs-3">
                            {!! Form::file('files[]', ['class'=>'code','id'=>'files','multiple' => true,'required']) !!}
                            @if ($errors->has('files'))
                                <span class="help-block">
                                <strong>{{ $errors->first('files') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-xs-5" id="code">
                    <div class="form-group{{ $errors->has('color_code') ? ' has-error' : '' }}">
                        {!! Form::label('color_code', 'Color:', ['class' => 'col-xs-2 control-label']) !!}
                        <div class="col-xs-9">
                            {!! Form::text('color_code[]',  old('color_code'),['required','multiple' => true,'class' => 'code form-control', 'id' => 'color_code', 'placeholder' => 'color code']) !!}
                            @if ($errors->has('color_code'))
                                <span class="help-block">
                                <strong>{{ $errors->first('color_code') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                <a href="javascript:void(0);" class="increment" title="Add more file/color" class="btn-info"><u style="font-weight: bold">Add More...</u></a>
            </div>


        </div>
    </div>

    {!! Form::close() !!}
    {{--<div class="DivClass" id="myDiv"></div> <button class="increment" style="background-color: #f05283;border-color: #f05283;color: white;margin-left: 84%">Add More...</button>--}}

    <script>

        $(document).ready(function(){
            $(".increment").click(function(){
            $('#customFields').append('<div class="row">'+'<div class="col-xs-5" id="colors">' +
                '<div class="form-group{{ $errors->has('files') ? ' has-error' : '' }}">' +
                '  {!! Form::label('files', 'File :', ['class' => 'col-xs-3 control-label']) !!}' +
                '     <div class="col-xs-3">' +
                '         {!! Form::file('files[]', ['class'=>'code','id'=>'files','multiple' => true,'required']) !!}' +
                '              @if ($errors->has('files'))' +
                '                   <span class="help-block">' +
                '                         <strong>{{ $errors->first('files') }}</strong>' +
                '                    </span>' +
                '               @endif' +
                '       </div>' +
                '</div>' +
                '</div>'+
                '<div class="col-xs-5" id="code">' +
                '     <div class="form-group{{ $errors->has('color_code') ?' has-error' : '' }}">' +
                '         {!! Form::label('color_code', 'Color:', ['class' => 'col-xs-2 control-label']) !!}' +
                '             <div class="col-xs-9">' +
                '                 {!! Form::text('color_code[]',  old('color_code'),['required','multiple' => true,'class' => 'code form-control','id' =>'color_code','placeholder' =>'color code']) !!}' +
                '                       @if ($errors->has('color_code'))' +
                '                          <span class="help-block">' +
                '                              <strong>{{ $errors->first('color_code') }}</strong>' +
                '                          </span>' +
                '                       @endif' +
                '             </div>' +
                '      </div>' +
                '</div>'+
                '<div class="col-xs-2">' +
                '     <div class="form-group">' +
                '             <div class="col-xs-9">' +
                '                 <button class="remCF btn-info" style="color: black;margin-top: 5%" title="delete this one"><span class="glyphicon glyphicon-remove"></span></button>' +
                '             </div>' +
                '      </div>' +
                '</div>'+'</div>'
            );
        });

            $("#customFields").on('click','.remCF',function(){
//                $(this).parent().parent().remove();
                $(this).closest("div.row").remove();
            });
     });

    </script>


@endsection


