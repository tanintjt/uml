@extends('admin.layouts.master')

@section('content')
    {!! Form::model($row,['method' => 'PUT','url' => Request::segment(1).'/faq/'.$row->id,'class' => 'form-horizontal', 'id' => 'admin-form','files'=>'true' ]) !!}
    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="input-group">
                <span class="input-group-btn">
                    <a href="{!! url(Request::segment(1).'/faq') !!}" class="btn btn-flat btn-danger pull-right"><i class="fa fa-remove"></i> Cancel</a>
                    <button class="btn btn-flat btn-primary pull-right" type="submit"><i class="fa fa-check"></i> Save</button>
                </span>
            </div>
        </div>
        <div class="box-body">
            <div class="col-xs-12">

                <div class="form-group{{ $errors->has('question') ? ' has-error' : '' }}">
                    {!! Form::label('question', 'Question :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-6">
                        {!! Form::textarea('question', old('question',$row->question), ['class' => 'form-control', 'id' => 'question', 'placeholder' => 'Question', 'rows' => 2]) !!}
                        @if ($errors->has('question'))
                            <span class="help-block">
                                <strong>{{ $errors->first('question') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('answer') ? ' has-error' : '' }}">
                    {!! Form::label('answer', 'Answer:', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-6">
                        {!! Form::textarea('answer', old('answer',$row->answer), ['class' => 'form-control', 'id' => 'answer', 'placeholder' => 'Answer', 'rows' =>4]) !!}
                        @if ($errors->has('answer'))
                            <span class="help-block">
                                <strong>{{ $errors->first('answer') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('status', 'Status :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        <label class="radio-inline">
                            {!! Form::radio('status', '1', true, ['id' => 'statuson']) !!} Yes
                        </label>
                        <label class="radio-inline">
                            {!! Form::radio('status', '2', false, ['id' => 'statusoff']) !!} No
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
