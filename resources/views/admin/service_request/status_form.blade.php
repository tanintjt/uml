@extends('admin.layouts.master')

@section('content')
    {!! Form::model($row,['method' => 'PUT','url' => Request::segment(1).'/service-request/'.$row->id,'class' => 'form-horizontal', 'id' => 'admin-form' ]) !!}
    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="input-group">
                <span class="input-group-btn">
                    <a href="{!! url(Request::segment(1).'/service-request') !!}" class="btn btn-flat btn-danger pull-right"><i class="fa fa-remove"></i> Back</a>
                    <button class="btn btn-flat btn-primary pull-right" type="submit"><i class="fa fa-check"></i> Update</button>
                </span>
            </div>
        </div>
        <div class="box-body">
            <div class="col-xs-12">
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    {!! Form::label('status', 'Status:', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-3">
                        {!! Form::Select('type',array(
                                       '1'=>'Pending',
                                       '2'=>'Accept',
                                       '3'=>'Reject',
                                       '4'=>'Rescheduled',
                                       '5'=>'Done',

                                       ),
        old('type'),['class'=>'form-control ','placeholder'=>'Select One','required'=>'required']) !!}
                        @if ($errors->has('status'))
                            <span class="help-block">
                                <strong>{{ $errors->first('status') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col-xs-3">
                        {!! Form::label('start_date', 'Start Date :', ['class' => 'col-xs-3 control-label']) !!}

                        {!! Form::text('start_date',  old('start_date'),['class' => 'form-control datepicker', 'id' => 'start_date', 'placeholder' => 'start date']) !!}
                        @if ($errors->has('start_date'))
                            <span class="help-block">
                                <strong>{{ $errors->first('start_date') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
