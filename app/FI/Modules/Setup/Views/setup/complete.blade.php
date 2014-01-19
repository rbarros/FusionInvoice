@extends('setup.master')

@section('content')

<h4>Installation Complete</h4>

<p>You may now <a href="{{ route('session.login') }}">log in</a>!</p>

@stop