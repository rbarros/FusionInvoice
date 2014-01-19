<?php

/**
 * This file is part of FusionInvoice.
 *
 * (c) FusionInvoice, LLC <jessedterry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Setup\Controllers;

use App;
use Artisan;
use Config;
use Hash;
use Input;
use Redirect;
use Response;
use View;

use FI\Modules\Setup\Setup;

class SetupController extends \BaseController {

	/**
	 * Setting repository
	 * @var SettingRepository
	 */
	protected $setting;

	/**
	 * User repository
	 * @var UserRepository
	 */
	protected $user;

	/**
	 * Setup validator
	 * @var SetupValidator
	 */
	protected $validator;

	/**
	 * Controller injection
	 * @param SettingRepository $setting
	 * @param UserRepository $user
	 * @param SetupValidator $validator
	 */
	public function __construct($setting, $user, $validator)
	{
		$this->setting   = $setting;
		$this->user      = $user;
		$this->validator = $validator;
	}

	public function index()
	{
		return View::make('setup.index')
		->with('license', file_get_contents(base_path() . '/LICENSE'));
	}

	public function postIndex()
	{
		if ($this->validator->validate(Input::all(), 'licenseRules'))
		{
			return Redirect::route('setup.prerequisites');
		}

		return Redirect::route('setup.index');
	}

	public function prerequisites()
	{
		$errors          = array();
		$versionRequired = '5.3.7';
		$dbDriver        = Config::get('database.default');
		$dbConfig        = Config::get('database.connections.' . $dbDriver);

		if (version_compare(phpversion(), $versionRequired, '<')) {
			$errors[] = sprintf(trans('fi.php_version_error'), $versionRequired);
		}

		if ($dbDriver == 'sqlite')
		{
			if (!file_exists($dbConfig['database']))
			{
				$errors[] = trans('fi.sqlite_database_not_exist');
			}
		}
		else
		{
			if (!$dbConfig['host'] or !$dbConfig['database'] or !$dbConfig['username'] or !$dbConfig['password'])
			{
				$errors[] = trans('fi.database_not_configured');
			}
		}

		if (!$errors)
		{
			return Redirect::route('setup.migration');
		}

		return View::make('setup.prerequisites')
		->with('errors', $errors);
	}

	public function migration()
	{
		return View::make('setup.migration');
	}

	public function postMigration()
	{
        App::error(function(\Exception $e)
        {
            return Response::json(array('exception' => $e->getMessage()));
        });

		return Response::json(array('code' => Artisan::call('migrate', array('--seed' => 1))));
	}

	public function account()
	{
		if (!$this->user->count())
		{
			return View::make('setup.account');
		}

		return Redirect::route('setup.complete');
	}

	public function postAccount()
	{
		$input = Input::all();

		if (!$this->validator->validate($input))
		{
			return Redirect::route('setup.account')
			->withErrors($this->validator->errors())
			->withInput();
		}

		unset($input['password_confirmation']);

		$input['password'] = Hash::make($input['password']);

		$this->user->create($input);

		return Redirect::route('setup.complete');
	}

	public function complete()
	{
		return View::make('setup.complete');
	}
}