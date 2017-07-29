@extends('auth.layouts.master')

@section('content')


    <div class="login-box">
        <div class="login-logo">
            <a href="{{ url('/') }}"><b>{!! config('app.name') !!}</b></a>
        </div>

        <div class="login-box-body">
            <h3 class="login-box-msg">{!! $title !!}</h3>
            @if($data)
                <div class="alert alert-{!! $data['status'] !!}" role="alert">
                    {!! $data['message'] !!}
                </div>
            @endif

        </div>

        <div class="text-center">
            <img src="{!! asset('public/themes/default/img/UML-Color-03-04.svg') !!}"style="width:52%">
        </div>
    </div>
@endsection
