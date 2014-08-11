<?php namespace ordbild;

class Calendar
{
	public $year;
	public $month;
	public $day;
	public $month_name;
	public $days_in_month;
	public $week;

	public $markup;

	function __construct($year = null, $month = null, $day = null, $timezone = 'Europe/Stockholm') {
		date_default_timezone_set($timezone);
		setlocale(LC_TIME, 'sv_SE');
		
		$this->year = ($year) ? $year : date('Y');
		$this->month = ($month) ? $month : date('m');
		$this->day = ($day) ? $day : date('d');

		$base_date = strtotime($this->year.'-'.$this->month.'-'.$this->day);

		$this->month_name = strftime('%B', $base_date);
		$this->days_in_month = cal_days_in_month(CAL_GREGORIAN, $this->month, $this->year);

		$this->week = date('W', $base_date);
	}

	public function paint()
	{
		$markup = new Markup($this);
		echo $markup->markup;
	}


}