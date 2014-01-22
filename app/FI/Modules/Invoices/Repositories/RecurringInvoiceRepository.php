<?php

/**
 * This file is part of FusionInvoice.
 *
 * (c) FusionInvoice, LLC <jessedterry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Invoices\Repositories;

use App;
use Config;

use FI\Classes\Date;
use FI\Modules\Invoices\Models\RecurringInvoice;

class RecurringInvoiceRepository {

	/**
	 * Get a list of records
	 * @param  int $page
	 * @param  int $numPerPage
	 * @return Invoice
	 */
	public function getPaged($page = 1, $numPerPage = null)
	{
		\DB::getPaginator()->setCurrentPage($page);

		$recurringInvoice = RecurringInvoice::with('invoice')->orderBy('generate_at', 'DESC');

		return $recurringInvoice->paginate($numPerPage ?: \Config::get('defaultNumPerPage'));
	}

	/**
	 * Create any new invoices from recurring
	 * @return int
	 */
	public function recurInvoices()
	{
		$invoiceCopy = App::make('InvoiceCopyRepository');

		$recurringInvoices = RecurringInvoice::recurNow()->get();

		foreach ($recurringInvoices as $recurringInvoice)
		{
			$invoiceCopy->copyInvoice(
				$recurringInvoice->invoice_id, 
				$recurringInvoice->invoice->client->name, 
				$recurringInvoice->generate_at, 
				Date::incrementDateByDays(substr($recurringInvoice->generate_at, 0, 10), Config::get('fi.invoicesDueAfter')),
				$recurringInvoice->invoice->invoice_group_id,
				$recurringInvoice->invoice->user_id);

			$generateAt = Date::incrementDate(substr($recurringInvoice->generate_at, 0, 10), $recurringInvoice->recurring_period, $recurringInvoice->recurring_frequency);

			$this->update(array('generate_at' => $generateAt), $recurringInvoice->id);
		}

		return count($recurringInvoices);
	}

	/**
	 * Get a single record
	 * @param  int $id
	 * @return Invoice
	 */
	public function find($id)
	{
		return RecurringInvoice::with(array('items.amount', 'custom'))->find($id);
	}
	
	/**
	 * Create a record
	 * @param  array $input
	 * @return int
	 */
	public function create($input)
	{
		$id = RecurringInvoice::create($input)->id;

		return $id;
	}
	
	/**
	 * Update a record
	 * @param  array $input
	 * @param  int $id
	 * @return void
	 */
	public function update($input, $id)
	{
		$recurringInvoice = RecurringInvoice::find($id);

		$recurringInvoice->fill($input);

		$recurringInvoice->save();
	}
	
	/**
	 * Delete a record
	 * @param  int $id
	 * @return void
	 */
	public function delete($id)
	{
		RecurringInvoice::destroy($id);
	}
	
}