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

use Auth;
use Config;
use Event;

use FI\Classes\Date;

class InvoiceCopyRepository {

	/**
	 * Client repository
	 * @var ClientRepository
	 */
	protected $client;

	/**
	 * Invoice repository
	 * @var InvoiceRepository
	 */
	protected $invoice;

	/**
	 * Invoice group repository
	 * @var InvoiceGroupRepository
	 */
	protected $invoiceGroup;

	/**
	 * Invoice item repository
	 * @var InvoiceItemRepository
	 */
	protected $invoiceItem;

	/**
	 * Invoice tax rate repository
	 * @var InvoiceTaxRateRepository
	 */
	protected $invoiceTaxRate;

	/**
	 * Dependency injection
	 * @param ClientRepository $client
	 * @param InvoiceRepository $invoice
	 * @param InvoiceGroupRepository $invoiceGroup
	 * @param InvoiceItemRepository $invoiceItem
	 */
	public function __construct($client, $invoice, $invoiceGroup, $invoiceItem, $invoiceTaxRate)
	{
		$this->client         = $client;
		$this->invoice        = $invoice;
		$this->invoiceGroup   = $invoiceGroup;
		$this->invoiceItem    = $invoiceItem;
		$this->invoiceTaxRate = $invoiceTaxRate;
	}

	/**
	 * Copies an invoice
	 * @param  int $fromInvoiceId
	 * @param  string $clientName
	 * @param  date $createdAt
	 * @param  date $dueAt
	 * @param  int $invoiceGroupId
	 * @param  int $userId
	 * @return int
	 */
	public function copyInvoice($fromInvoiceId, $clientName, $createdAt, $dueAt, $invoiceGroupId, $userId)
	{
		$clientId = $this->client->findIdByName($clientName);

		if (!$clientId)
		{
			$clientId = $this->client->create(array('name' => $clientName));
		}

		$toInvoiceId = $this->invoice->create(
			array(
				'client_id'         => $clientId,
				'created_at'        => $createdAt,
				'due_at'            => $dueAt,
				'invoice_group_id'  => $invoiceGroupId,
				'number'            => $this->invoiceGroup->generateNumber($invoiceGroupId),
				'user_id'           => $userId,
				'invoice_status_id' => 1,
				'url_key'           => str_random(32)
			)
		);		

		$items = $this->invoiceItem->findByInvoiceId($fromInvoiceId);

		foreach ($items as $item)
		{
			$this->invoiceItem->create(
				array(
					'invoice_id'    => $toInvoiceId,
					'name'          => $item->name,
					'description'   => $item->description,
					'quantity'      => $item->quantity,
					'price'         => $item->price,
					'tax_rate_id'   => $item->tax_rate_id,
					'display_order' => $item->display_order
				)
			);
		}

		$invoiceTaxRates = $this->invoiceTaxRate->findByInvoiceId($fromInvoiceId);

		foreach ($invoiceTaxRates as $invoiceTaxRate)
		{
			$this->invoiceTaxRate->create(
				array(
					'invoice_id'       => $toInvoiceId,
					'tax_rate_id'      => $invoiceTaxRate->tax_rate_id,
					'include_item_tax' => $invoiceTaxRate->include_item_tax,
					'tax_total'        => $invoiceTaxRate->tax_total
				)
			);
		}

		Event::fire('invoice.modified', $toInvoiceId);

		return $toInvoiceId;
	}
	
}