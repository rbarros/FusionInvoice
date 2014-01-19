@extends('setup.master')

@section('jscript')
<script type="text/javascript">
$(function() {
	
	$('#btn-run-migration').click(function() {

		$('#btn-run-migration').hide();
		$('#btn-running-migration').show();

		// $('#btn-run-migration')
		// .attr('disabled', 'disabled')
		// .html('{{ trans('fi.installing_please_wait') }}');

		$.post('{{ route('setup.postMigration') }}', function(response) {

			if (response.exception) {
				$('#div-exception').show().html(response.exception);

				$('#btn-running-migration').hide();
				$('#btn-run-migration').show();

			}
			else if (response.code == 0) {

				$('#div-exception').hide();

				$('#btn-running-migration').hide();
				$('#btn-migration-complete').show();

			}
			else {

				$('#btn-running-migration').hide();
				$('#btn-run-migration').show();

				$('#div-exception').show().html(response.code);

			}

		});
	});

});
</script>
@stop

@section('content')

<h4>{{ trans('fi.database_setup') }}</h4>

<p>{{ trans('fi.step_database_setup') }}</p>

<div class="alert alert-error" id="div-exception" style="display: none;"></div>

<a class="btn btn-primary" id="btn-run-migration">{{ trans('fi.continue') }}</a>

<a class="btn" id="btn-running-migration" style="display: none;" disabled="disabled">{{ trans('fi.installing_please_wait') }}</a>

<a href="{{ route('setup.account') }}" class="btn btn-success" id="btn-migration-complete" style="display: none;">{{ trans('fi.continue') }}</a>

@stop