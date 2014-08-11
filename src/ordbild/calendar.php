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
	public $events;

	protected $default_settings;

	function __construct( $settings = null ) {
		date_default_timezone_set('Europe/Stockholm');
		setlocale(LC_TIME, 'sv_SE');
		
		$this->year = (isset($settings['year'])) ? $settings['year'] : date('Y');
		$this->month = (isset($settings['month'])) ? $settings['month'] : date('m');
		$this->day = (isset($settings['day'])) ? $settings['day'] : date('d');

		$this->events = (isset($settings['marked_dates'])) ? $settings['marked_dates'] : array();

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