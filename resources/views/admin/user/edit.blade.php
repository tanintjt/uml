@extends('admin.layouts.master')

@section('content')
    {!! Form::model($row,['method' => 'PUT','route'=>['user-update',$row->id],'class' => 'form-horizontal', 'id' => 'admin-form' ]) !!}
    <div class="panel panel-default">
        <div class="panel-heading">
            <span class="glyphicon glyphicon-plus"></span>&nbsp;{!! $title !!}
        </div>

        <div class="panel-body">

            <div class="col-xs-6">
                <div class="form-group{{ $errors->has('role_id') ? ' has-error' : '' }}">
                    {!! Form::label('role_id', 'Roles :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::select('role_id', $roles, old('role_id', $userRoles), ['class' => 'form-control', 'id' => 'role_id']) !!}
                        @if ($errors->has('role_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('role_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    {!! Form::label('name', 'Name :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::text('name', old('name', $row->name), ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Full name']) !!}
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('email', 'E-mail :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::text('email', old('email', $row->email), ['class' => 'form-control', 'id' => 'email', 'disabled']) !!}

                    </div>
                </div>

                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                    {!! Form::label('phone', 'Phone :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::text('phone', old('phone', $row->phone), ['class' => 'form-control', 'id' => 'phone', 'placeholder' => 'Phone']) !!}
                        @if ($errors->has('phone'))
                            <span class="help-block">
                                <strong>{{ $errors->first('phone') }}</strong>
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
            <div class="col-xs-6">


                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    {!! Form::label('password', 'Password :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::password('password', ['class' => 'form-control', 'id' => 'password', 'placeholder' => 'Password']) !!}
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('password_confirmation ', 'Confirm Password :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'password_confirmation', 'placeholder' => 'Confirm password']) !!}
                    </div>
                </div>

                <div class="form-group{{ $errors->has('parent_id') ? ' has-error' : '' }}">
                    {!! Form::label('parent_id', 'Refer To  :', ['class' => 'col-xs-3 control-label']) !!}
                    <div class="col-xs-9">
                        {!! Form::select('parent_id', $users, old('parent_id'), ['class' => 'form-control', 'id' => 'parent_id']) !!}
                        @if ($errors->has('parent_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('parent_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-xs-offset-3 col-xs-9">
                        <button class="btn btn-sm btn-primary" type="submit"><span class="glyphicon glyphicon-ok-sign"></span> Save</button>
                        <a href="{!! url('admin/user') !!}" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-repeat"></span> Cancel</a>
                    </div>
                </div>

            </div>

        </div>
    </div>
    {!! Form::close() !!}
@endsection
