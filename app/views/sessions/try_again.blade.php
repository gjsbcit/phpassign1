@extends('layouts/basic')

@section('maincontent')
    <p>File can only be .jpg and .gif. Please {{ link_to_route('home.index', 'Try again') }}.</p>
@stop

