<?php namespace SL;

class Calendar
{
	public $year;
	public $month;

	function __construct($year = null, $month = null, $timezone = 'Europe/Stockholm') {
		date_default_timezone_set($timezone);
		$this->year = ($year) ? $year : date('Y');
		$this->month = ($month) ? $month : date('m');
	}
}