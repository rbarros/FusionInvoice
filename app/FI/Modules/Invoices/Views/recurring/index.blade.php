@extends('layouts.master')

@section('content')

<div class="headerbar">
	<h1>{{ trans('fi.recurring_invoices') }}</h1>

	<div class="pull-right">
		{{ Pager::create($recurringInvoices) }}
	</div>

</div>

<div class="table-content">

	@include('layouts/_alerts')

	<table class="table table-striped">

		<thead>
			<tr>
				<th>{{ trans('fi.base_invoice') }}</th>
				<th>{{ trans('fi.client') }}</th>
				<th>{{ trans('fi.start_date') }}</th>
				<th>{{ trans('fi.end_date') }}</th>
				<th>{{ trans('fi.every') }}</th>
				<th>{{ trans('fi.next_date') }}</th>
				<th>{{ trans('fi.options') }}</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($recurringInvoices as $recurringInvoice)
			<tr>
				<td><a href="{{ route('invoices.show', array($recurringInvoice->invoice_id)) }}">{{ $recurringInvoice->invoice->number }}</a></td>
				<td><a href="{{ route('clients.show', array($recurringInvoice->invoice->client_id)) }}">{{ $recurringInvoice->invoice->client->name }}</a></td>
				<td>{{ $recurringInvoice->invoice->formattedCreatedAt }}</td>
				<td></td>
				<td>{{ $recurringInvoice->recurring_frequency . ' ' . $frequencies[$recurringInvoice->recurring_period] }}</td>
				<td>{{ $recurringInvoice->formattedGenerateAt }}</td>
				<td>
					<div class="options btn-group">
						<a class="btn btn-small dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-cog"></i> {{ trans('fi.options') }}</a>
						<ul class="dropdown-menu">
							<li>
								<a href="{{ route('recurring.delete', array($recurringInvoice->id)) }}" onclick="return confirm('{{ trans('fi.delete_record_warning') }}');">
									<i class="icon-trash"></i> {{ trans('fi.delete') }}
								</a>
							</li>
						</ul>
					</div>
				</td>
			</tr>
			@endforeach
		</tbody>

	</table>

</div>

@stop