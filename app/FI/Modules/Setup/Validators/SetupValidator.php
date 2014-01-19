<?php

/**
 * This file is part of FusionInvoice.
 *
 * (c) FusionInvoice, LLC <jessedterry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Setup\Validators;

class SetupValidator extends \FI\Validators\Validator {

	static $licenseRules = array(
		'accept' => 'accepted'
	);

	static $rules = array(
		'name'     => 'required',
		'email'    => 'required|email',
		'password' => 'required|confirmed'
	);

}