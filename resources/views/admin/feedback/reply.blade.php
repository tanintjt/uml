
@extends('admin.layouts.master')

@section('content')
    {!! Form::model($row,['method' => 'PUT','url' => Request::segment(1).'/feedback/'.$row->id,'class' => 'form-horizontal', 'id' => 'admin-form' ]) !!}
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
            <div class="col-xs-6">
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    {!! Form::label('status', 'Status:', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-6">
                        {!! Form::Select('status',array(
                                       '1'=>'Pending',
                                       '2'=>'Accept',
                                       '3'=>'Reject',
                                       '4'=>'Rescheduled',
                                       '5'=>'Done',

                                       ),
        old('status', $row->status),['class'=>'form-control ','placeholder'=>'Select One']) !!}
                        @if ($errors->has('status'))
                            <span class="help-block">
                                <strong>{{ $errors->first('status') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>



            </div>
            <div class="col-xs-6">
                <div class="form-group">
                    {!! Form::label('request_date', 'Requested Date :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-6">
                        {!! Form::text('request_date',  old('request_date'),['class' => 'form-control datepicker', 'id' => 'request_date','readonly']) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('request_time', 'Requested Time :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-6">
                        {!! Form::text('request_time',  old('request_time'),['class' => 'form-control datepicker', 'id' => 'request_time', 'readonly']) !!}
                    </div>
                </div>

            </div>
        </div>
    </div>
    {!! Form::close() !!}


@endsection
