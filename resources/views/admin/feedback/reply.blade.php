
@extends('admin.layouts.master')

@section('content')
    {!! Form::model($row,['method' => 'PUT','route'=>['store-reply',$row->id],'class' => 'form-horizontal', 'id' => 'admin-form' ]) !!}
    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="input-group">
                <span class="input-group-btn">
                    <a href="{!! url(Request::segment(1).'/feedback') !!}" class="btn btn-flat btn-danger pull-right"><i class="fa fa-remove"></i> Back</a>
                    <button class="btn btn-flat btn-primary pull-right" type="submit"><i class="fa fa-check"></i> Update</button>
                </span>
            </div>
        </div>
        <div class="box-body">
            <div class="col-xs-12">
                <div class="form-group">
                    {!! Form::label('subject', 'Subject :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-6">
                        {!! Form::text('subject',  old('subject'),['class' => 'form-control', 'id' => 'subject','readonly']) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('feedback_details', 'Feedback Details :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-6">
                        {!! Form::textarea('feedback_details',  old('feedback_details'),['class' => 'form-control ','rows'=>'6', 'id' => 'feedback_details', 'readonly']) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('reply_message', 'Message :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-6">
                        {!! Form::textarea('reply_message',  old('reply_message'),['class' => 'form-control ','rows'=>'6',  'id' => 'reply_message','placeholder'=>'Write your reply.....']) !!}
                    </div>
                </div>
            </div>
            {{--<div class="col-xs-6">

                <div class="form-group">
                    {!! Form::label('reply_message', 'Reply :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-6">
                        {!! Form::textarea('reply_message',  old('reply_message'),['class' => 'form-control ', 'id' => 'reply_message']) !!}
                    </div>
                </div>
            </div>--}}
        </div>
    </div>
    {!! Form::close() !!}


@endsection
