<?php

/**
 * This file is part of FusionInvoice.
 *
 * (c) FusionInvoice, LLC <jessedterry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Invoices\Commands;

use App;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class Recurring extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'fi:recurring';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Checks to see if there are any recurring invoices to create.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->info('Checking for recurring invoices to create');

		App::make('SettingRepository')->setAll();

		$count = App::make('RecurringInvoiceRepository')->recurInvoices();

		$this->info('Recurring invoices generated: ' . $count);
	}

}
