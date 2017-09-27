
@extends('admin.layouts.master')

@section('content')

    {!! Form::model($row,['method' => 'PUT','route'=>['vehicle-feature-update',$row->id],'class' => 'form-horizontal', 'id' => 'admin-form','files'=>'true' ]) !!}

    <div class="panel panel-default">

        <div class="panel-heading">
            <a href="{!! route('vehicle.color',$id)!!}" class="btn btn-flat btn-danger pull-right"><i class="fa fa-remove"></i> Cancel</a>
            <button class="btn btn-flat btn-primary pull-right" id="upload"><i class="fa fa-check"></i> Save</button>
            <div class="DivClass" id="myDiv"></div> <p>&nbsp;&nbsp;</p>
        </div>

        <div class="panel-body" style="margin-left: 14%">

            <div class="col-xs-5" id="colors">

                <div class="form-group{{ $errors->has('files') ? ' has-error' : '' }}">
                    {!! Form::label('files', 'File :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-3">
                        {!! Form::file('files', ['id'=>'files']) !!}
                        @if ($errors->has('files'))
                            <span class="help-block">
                                <strong>{{ $errors->first('files') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

            </div>

            <div class="col-xs-7">

                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                    {!! Form::label('title', 'Title:', ['class' => 'col-xs-2 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::text('title',  old('title',$row->title),['class' => 'form-control', 'id' => 'title', 'placeholder' => 'title']) !!}
                        @if ($errors->has('title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

    {!! Form::close() !!}

@endsection


