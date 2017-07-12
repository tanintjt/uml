@extends('admin.layouts.master')

@section('content')
    {!! Form::open(array('url' => Request::segment(1).'/spare-parts', 'class' => 'form-horizontal', 'name' => 'admin-form', 'id' => 'admin-form','files'=>'true')) !!}
    <div class="panel panel-default">
        <div class="panel-heading">
            <span class="glyphicon glyphicon-plus"></span>&nbsp;{!! $title !!}
        </div>

        <div class="panel-body">

            <div class="col-xs-7">

                <div class="form-group{{ $errors->has('sp_cat_id') ? ' has-error' : '' }}">
                    {!! Form::label('sp_cat_id', 'Spare Parts Category :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::select('sp_cat_id', $sp_cat_list, old('sp_cat_id'), ['class' => 'form-control', 'id' => 'sp_cat_id']) !!}
                        @if ($errors->has('sp_cat_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('sp_cat_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('part_id') ? ' has-error' : '' }}">
                    {!! Form::label('part_id', 'Part ID :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::text('part_id', old('part_id'), ['class' => 'form-control', 'id' => 'part id']) !!}
                        @if ($errors->has('part_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('part_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

            </div>
            <div class="col-xs-5">

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    {!! Form::label('name', 'Name :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::text('name',  old('name'),['class' => 'form-control', 'id' => 'name', 'placeholder' => 'name']) !!}
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('rate') ? ' has-error' : '' }}">
                    {!! Form::label('rate', 'Rate :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::text('rate',  old('rate'),['class' => 'form-control', 'id' => 'rate', 'placeholder' => 'rate']) !!}
                        @if ($errors->has('rate'))
                            <span class="help-block">
                                <strong>{{ $errors->first('rate') }}</strong>
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
                        <a href="{!! url('admin/spare-parts') !!}" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-repeat"></span> Cancel</a>
                    </div>
                </div>

            </div>

        </div>
    </div>
    {!! Form::close() !!}
@endsection
