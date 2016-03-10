@extends('layouts/basic')
@section('maincontent')

    <h1>Reset Your Password</h1><br>

    <h4>Type your email address in the text box below. A new password will be sent to your email address.</h4><br>

    {{ Form::open(array('route' => 'password.request')) }}

    <p>{{ Form::label('email', 'Email') }}
        {{ Form::email('email', Input::old('email')) }}</p>

    <p>{{ Form::submit('Submit') }}</p>

    {{ Form::close() }}

    {{link_to_route('login', 'Back to Login')}}

@stop