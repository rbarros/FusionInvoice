<?php

/**
 * This file is part of FusionInvoice.
 *
 * (c) FusionInvoice, LLC <jessedterry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Classes;

use Config;
use DateInterval;
use DateTime;

class Date {
	
	/**
	 * Returns an array of date format options
	 * @return array
	 */
	static function formats()
	{
		return array(
			'm/d/Y' => array(
				'setting'    => 'm/d/Y',
				'datepicker' => 'mm/dd/yyyy'
				),
			'm-d-Y' => array(
				'setting'    => 'm-d-Y',
				'datepicker' => 'mm-dd-yyyy'
				),
			'm.d.Y' => array(
				'setting'    => 'm.d.Y',
				'datepicker' => 'mm.dd.yyyy'
				),
			'Y/m/d' => array(
				'setting'    => 'Y/m/d',
				'datepicker' => 'yyyy/mm/dd'
				),
			'Y-m-d' => array(
				'setting'    => 'Y-m-d',
				'datepicker' => 'yyyy-mm-dd'
				),
			'Y.m.d' => array(
				'setting'    => 'Y.m.d',
				'datepicker' => 'yyyy.mm.dd'
				),
			'd/m/Y' => array(
				'setting'    => 'd/m/Y',
				'datepicker' => 'dd/mm/yyyy'
				),
			'd-m-Y' => array(
				'setting'    => 'd-m-Y',
				'datepicker' => 'dd-mm-yyyy'
				),
			'd-M-Y' => array(
				'setting'    => 'd-M-Y',
				'datepicker' => 'dd-M-yyyy'
				),
			'd.m.Y' => array(
				'setting'    => 'd.m.Y',
				'datepicker' => 'dd.mm.yyyy'
				)
			);
	}

	/**
	 * Returns a flattened version of the format() method array to display 
	 * as dropdown options
	 * @return array
	 */
	public static function dropdownArray()
	{
		$formats = self::formats();

		$return = array();

		foreach ($formats as $format)
		{
			$return[$format['setting']] = $format['setting'];
		}

		return $return;
	}

	/**
	 * Converts a stored date to the user formatted date
	 * @param  date $date 	The yyyy-mm-dd standardized date
	 * @return date 		The user formatted date
	 */
	public static function format($date = null)
	{
		$date = new DateTime($date);

		return $date->format(Config::get('fi.dateFormat'));
	}

	/**
	 * Converts a user submitted date back to standard yyyy-mm-dd format
	 * @param  date $userDate	The user submitted date
	 * @return date 			The yyyy-mm-dd standardized date
	 */
	public static function unformat($userDate = null)
	{
		if ($userDate)
		{
			$date = DateTime::createFromFormat(Config::get('fi.dateFormat'), $userDate);

			return $date->format('Y-m-d');
		}

		return null;
	}

	/**
	 * Adds a specified number of days to a user submitted date and returns
	 * the new date standardized as yyyy-mm-dd
	 * @param  date $userDate 	The user submitted date
	 * @param  int $numDays  	The number of days to increment
	 * @return date 			The yyyy-mm-dd standardized incremented date
	 */
	public static function incrementDateByDays($userDate, $numDays)
	{
		$date = DateTime::createFromFormat(Config::get('fi.dateFormat'), $userDate);

		$date->add(new DateInterval('P' . $numDays . 'D'));

		return $date->format('Y-m-d');
	}

	/**
	 * Adds a specified number of periods to a user submitted date and returns
	 * the new date standardized as yyyy-mm-dd
	 * @param  date $userDate     The user submitted date
	 * @param  int $period     1 = Days, 2 = Weeks, 3 = Months, 4 = Years
	 * @param  int $numPeriods The number of periods to increment
	 * @return date             The yyyy-mm-dd standardized incremented date
	 */
	public static function incrementDate($userDate, $period, $numPeriods)
	{
		$date = DateTime::createFromFormat(Config::get('fi.dateFormat'), $userDate);

		switch ($period)
		{
			case 1:
				$date->add(new DateInterval('P' . $numPeriods . 'D'));
				break;
			case 2:
				$date->add(new DateInterval('P' . $numPeriods . 'W'));
				break;
			case 3:
				$date->add(new DateInterval('P' . $numPeriods . 'M'));
				break;
			case 4:
				$date->add(new DateInterval('P' . $numPeriods . 'Y'));
				break;
		}

		return $date->format('Y-m-d');
	}

	/**
	 * Returns the short name of the month from a numeric representation
	 * @param  int $n
	 * @return string
	 */
	public static function getMonthShortName($n)
	{
		return date('M', mktime(0, 0, 0, $n, 1, date('Y')));
	}
}