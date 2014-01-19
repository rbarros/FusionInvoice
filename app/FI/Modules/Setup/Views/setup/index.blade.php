@extends('setup.master')

@section('content')

<h4>{{ trans('fi.license_agreement') }}</h4>

{{ Form::open() }}

{{ Form::textarea('license', $license, array('style' => 'width: 100%; height: 300px;', 'readonly' => 'readonly')) }}

<p>{{ Form::checkbox('accept', 1) }} {{ trans('fi.license_agreement_accept') }}</p>

{{ Form::submit(trans('fi.i_accept'), array('class' => 'btn btn-primary')) }}

{{ Form::close() }}

@stop