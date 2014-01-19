@extends('setup.master')

@section('content')

<h4>{{ trans('fi.prerequisites') }}</h4>

<p>{{ trans('fi.step_prerequisites') }}</p>

<ul>
	@foreach ($errors as $error)
	<li>{{ $error }}</li>
	@endforeach
</ul>

<a href="{{ route('setup.prerequisites') }}" class="btn btn-primary">{{ trans('fi.try_again') }}</a>

@stop