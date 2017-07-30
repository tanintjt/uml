@extends('admin.layouts.master')

@section('content')
    {!! Form::model($row,['method' => 'PUT','route'=>['employee-assign',$row->id],'class' => 'form-horizontal', 'id' => 'admin-form' ]) !!}
    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="input-group">
                <span class="input-group-btn">
                    <a href="{!! url(Request::segment(1).'/service-request') !!}" class="btn btn-flat btn-danger pull-right"><i class="fa fa-remove"></i> Cancel</a>
                    <button class="btn btn-flat btn-primary pull-right" type="submit"><i class="fa fa-check"></i> Save</button>
                </span>
            </div>
        </div>
        <div class="box-body">
            <div class="col-xs-12">
                <div class="form-group{{ $errors->has('employee_id') ? ' has-error' : '' }}">
                    {!! Form::label('employee_id', 'Employee :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-4">
                        {!! Form::select('employee_id', $employee, old('employee_id'), ['class' => 'form-control', 'id' => 'employee_id']) !!}
                        @if ($errors->has('employee_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('employee_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
