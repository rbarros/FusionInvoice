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

use FI\Modules\Invoices\Models\RecurringInvoice;

class RecurringInvoiceRepository {

	/**
	 * Get all records
	 * @return Invoice
	 */
	public function all()
	{
		return RecurringInvoice::all();
	}

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