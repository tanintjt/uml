@extends('admin.layouts.master')

@section('content')
    {!! Form::model($row,['method' => 'PUT','route'=>['spec-details-update',$row->id],'class' => 'form-horizontal', 'id' => 'admin-form','files'=>'true' ]) !!}
    <div class="panel panel-default">
        <div class="panel-heading">
            <span class="glyphicon glyphicon-plus"></span>&nbsp;{!! $title !!}
        </div>

        <div class="panel-body">

            <div class="col-xs-5">
                <div class="form-group{{ $errors->has('model_id') ? ' has-error' : '' }}">
                    {!! Form::label('model_id', 'Vehicle :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::select('model_id', $model, old('model_id',$row->vehicles->model->id), ['class' => 'form-control', 'id' => 'model_id']) !!}
                        @if ($errors->has('model_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('model_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('cat_id') ? ' has-error' : '' }}">
                    {!! Form::label('cat_id', 'Category:', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::select('cat_id', $spec_category, old('cat_id',$row->spec_category->id), ['class' => 'form-control', 'id' => 'cat_id']) !!}
                        @if ($errors->has('cat_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('cat_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-xs-7">

                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                    {!! Form::label('title', 'Title :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::text('title', old('title',$row->title), ['class' => 'form-control', 'id' => 'title', 'placeholder' => 'title']) !!}
                        @if ($errors->has('title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('spec_value') ? ' has-error' : '' }}">
                    {!! Form::label('spec_value', 'Spec Value :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::text('spec_value', old('spec_value',$row->spec_value), ['class' => 'form-control', 'id' => 'spec_value', 'placeholder' => 'specification value']) !!}
                        @if ($errors->has('spec_value'))
                            <span class="help-block">
                                <strong>{{ $errors->first('spec_value') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-offset-3 col-xs-9">
                        <button class="btn btn-sm btn-primary" type="submit"><span class="glyphicon glyphicon-ok-sign"></span> Save</button>
                        <a href="{!! url('admin/spec/details') !!}" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-repeat"></span> Cancel</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
