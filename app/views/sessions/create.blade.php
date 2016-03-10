@extends('layouts/basic')

@section('maincontent')
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<h1>Login</h1><br>

{{Form::open(['route'=>'sessions.store'])}}
<div>
    {{Form::label('email', 'Email:')}}
    {{Form::email('email', Input::old('email'))}}

</div><br>
<hr/>
<div>

    {{Form::label('password', 'Password:')}}
    {{Form::password('password')}}

</div><br>
<hr/>
<div>
    <input type="checkbox" name="remember"> Remember Me <br>
</div><br>
<hr/>
<div>
    {{Form::submit('Log in', ['class' => 'btn btn-large btn-primary' ])}}

</div><br>
<hr/>
{{Form::close()}}

{{ link_to_route('users.create', 'Register') }} |
{{ link_to_route('password.remind', 'Forgot Your Password?') }} <br><hr/>
{{HTML::link('http://twitter.com/phpjason', 'twitter')}}
@stop

