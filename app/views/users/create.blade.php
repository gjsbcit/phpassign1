@extends('layouts.basic')

@section('maincontent')
    <h1>Register</h1>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {{Form::open(['route'=>'users.store'])}}
        <div>
            {{Form::label('email', 'Email Address: ')}}
            {{Form::text('email')}}
        </div><br>
        <div>
            {{Form::label('password', 'Password(2-30 chars): ')}}
            {{Form::password('password')}}
        </div><br>
        <div>
            {{Form::label('password_confirmation', 'Confirm Password: ')}}
            {{Form::password('password_confirmation')}}
        </div><br>
        <div>
            {{ $captchaHtml }}
            {{ Form::text('CaptchaCode', null, array('id' => 'CaptchaCode')) }}
        </div><br>
        <div>
            {{Form::submit('Register')}}
        </div><br>
    {{Form::close()}}
    {{ link_to_route('sessions.create', 'Back to login') }}

@stop