<?php

use Illuminate\Database\Migrations\Migration;

class RecurringInvoices extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('recurring_invoices', function($table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('invoice_id');
			$table->integer('recurring_frequency');
			$table->integer('recurring_period');
			$table->dateTime('generate_at');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('recurring_invoices');
	}

}