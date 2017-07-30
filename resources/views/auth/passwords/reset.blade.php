{{--
@extends('auth.layouts.master')

@section('content')



    <div class="login-box">
        <div class="login-logo">
            <a href="{{ url('/') }}"><b>{!! config('app.name') !!}</b></a>
        </div>

        <div class="login-box-body">
            <p class="login-box-msg">Reset Password</p>

            {!! Form::open(array('route' => 'password.request', 'name' => 'login-form', 'id' => 'login-form')) !!}

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
                <input type="hidden" name="token" value="{{ $token }}">


                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="col-md-4 control-label">Password</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control" name="password" required>

                        @if ($errors->has('password'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            Reset Password
                        </button>
                    </div>
                </div>

            {!! Form::close() !!}
        </div>



        <div class="text-center">
            <img src="{!! asset('public/themes/default/img/UML-Color-03-04.svg') !!}"style="width:52%">
        </div>
    </div>
@endsection
--}}

@extends('auth.layouts.master')

@section('content')

    <div class="login-box">
        <div class="login-logo">
            <a href="{{ url('/') }}"><b>{!! config('app.name') !!}</b></a>
        </div>

        <div class="login-box-body">
            <p class="login-box-msg">Reset Password</p>

            {!! Form::open(array('route' => 'password.request', 'name' => 'login-form', 'id' => 'login-form')) !!}

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class=" control-label">E-Mail Address</label>

                <div class="">
                    <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>

                    @if ($errors->has('email'))
                        <span class="help-block">
                              <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class=" control-label">Password</label>

                <div class="">
                    <input id="password" type="password" class="form-control" name="password" required>

                    @if ($errors->has('password'))
                        <span class="help-block">
                             <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <label for="password-confirm" class=" control-label">Confirm Password</label>
                <div class="">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>

            {{--<div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                        Reset Password
                    </button>
                </div>
            </div>--}}

            <div class="row">
                <div class="col-xs-4 pull-right">
                    <button type="submit" class="btn btn-primary btn-block btn-flat" style="background-color:#f05283;border-color:#f05283 ">Submit</button>
                </div>
            </div>

            {!! Form::close() !!}
        </div>

        <div class="text-center">
            <img src="{!! asset('public/themes/default/img/UML-Color-03-04.svg') !!}"style="width:52%">
        </div>
    </div>

@endsection

