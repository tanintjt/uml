<link href="{!! asset('public/themes/default/plugins/datepicker/bootstrap-datepicker.min.css') !!}" rel="stylesheet">
<link href="{!! asset('public/themes/default/css/bootstrap.min.css') !!}" rel="stylesheet">
<script src="{!! asset('public/themes/default/plugins/jQuery/jquery-2.2.3.min.js') !!}"></script>

<script src="{!! asset('public/themes/default/plugins/datepicker/bootstrap-datepicker.min.js') !!}"></script>


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

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


                {{-- @if(isset($row->status))
                    @if($row->status=='4')--}}
                <div class="form-group">
                    {!! Form::label('updated_at', 'Date :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-6">
                        {!! Form::text('updated_at',  old('updated_at',date('Y-m-d', strtotime($row->updated_at))),['class' => 'form-control datepicker', 'id' => 'start_date', 'placeholder' => 'start date']) !!}
                    </div>
                </div>
                {{--@endif
            @endif--}}

                <div class="form-group">
                    {!! Form::label('updated_time', 'Time :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-6">
                        {!! Form::text('updated_time',  old('updated_at',date('HH:mm:ss', strtotime($row->updated_at))),['class' => 'form-control', 'id' => 'time', 'placeholder' => 'start date']) !!}
                    </div>
                </div>

                {{--<input class="form-control" type="text" id="time"/>--}}

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



    <script>
        $('.datepicker').datepicker({
            autoclose: true,
            format:'yyyy-mm-dd'
        })
    </script>


    <script>
        $('#time').datetimepicker({
            format: 'HH:mm:ss'
            //format: 'LT'
        });
    </script>
@endsection
