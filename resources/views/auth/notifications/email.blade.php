
@extends('auth.layouts.master')

@section('content')

    <div class="login-box">
        <div class="login-logo">
            <a href="{{ url('/') }}"><b>{!! config('app.name') !!}</b></a>
        </div>

        <div class="login-box-body">
            <h3 class="login-box-msg">Verify Your Email Address</h3>
            <div class="col-xs-12">
                <p>You need to activate your email before you can start using all of our services.</p>
                <p class="text-center"><a href="{!! route('auth.activation', $activation->token) !!}" class="btn btn-success">Verify Email</a></p>
            </div>
        </div>
        <div class="text-center">
            <img src="{!! asset('public/themes/default/img/UML-Color-03-04.svg') !!}"style="width:52%">
        </div>
    </div>

@endsection
