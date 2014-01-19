@extends('setup.master')

@section('content')

<h4>{{ trans('fi.account_setup') }}</h4>

{{ Form::open(array('route' => 'setup.postAccount', 'class' => 'form-install')) }}

@foreach ($errors->all('<div class="alert alert-error">:message</div>') as $error)
{{ $error }}
@endforeach

<p>{{ trans('fi.step_about_yourself') }}</p>

<div class="controls controls-row">
  {{ Form::text('name', null, array('class' => 'span4', 'placeholder' => trans('fi.name'))) }}
  {{ Form::text('company', null, array('class' => 'span5', 'placeholder' => trans('fi.company'))) }}
</div>

<div class="controls controls-row">
  {{ Form::text('address_1', null, array('class' => 'span9', 'placeholder' => trans('fi.address'))) }}
</div>

<div class="controls controls-row">
  {{ Form::text('city', null, array('class' => 'span3', 'placeholder' => trans('fi.city'))) }}
  {{ Form::text('state', null, array('class' => 'span2', 'placeholder' => trans('fi.state'))) }}
  {{ Form::text('zip', null, array('class' => 'span2', 'placeholder' => trans('fi.zip_code'))) }}
  {{ Form::text('country', null, array('class' => 'span2', 'placeholder' => trans('fi.country'))) }}
</div>

<div class="controls controls-row">
  {{ Form::text('fax', null, array('class' => 'span3', 'placeholder' => trans('fi.fax'))) }}
  {{ Form::text('mobile', null, array('class' => 'span3', 'placeholder' => trans('fi.mobile'))) }}
  {{ Form::text('web', null, array('class' => 'span3', 'placeholder' => trans('fi.web'))) }}
</div>

<p>{{ trans('fi.step_create_account') }}</p>

<div class="controls controls-row">
  {{ Form::text('email', null, array('class' => 'span3', 'placeholder' => trans('fi.email'))) }}
  {{ Form::password('password', array('class' => 'span3', 'placeholder' => trans('fi.password'))) }}
  {{ Form::password('password_confirmation', array('class' => 'span3', 'placeholder' => trans('fi.password_confirmation'))) }}
</div>

<button class="btn btn-primary" type="submit">{{ trans('fi.install') }}</button>
{{ Form::close() }}

@stop