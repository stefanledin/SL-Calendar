<?php namespace ordbild;

class Markup
{
	public $markup;
	protected $calendar;

	function __construct(Calendar $calendar) {
		$this->calendar = $calendar;
		$this->markup = $this->create_markup();
	}

	public function create_markup()
	{
		$markup = '<table class="small calendar">';
			$markup .= $this->header();
			$markup .= $this->week_header();
			$markup .= '<tbody>';
				$markup .= $this->weeks();
			$markup .= '</tbody>';
		$markup .= '</table>';
		return $markup;
	}

	public function header()
	{
		$markup = '<caption>';
			$markup .= '<a href="#" title="" class="prev"></a>';
			$markup .= $this->calendar->month_name.' '.$this->calendar->year;
			$markup .= '<a href="#" title="" class="next"></a>';
		$markup .= '</caption>';		
		return $markup;
	}

	public function week_header()
	{
		$markup = '<thead><tr>';
			$markup .= '<th scope="col" title="Monday">M</th>';
			$markup .= '<th scope="col" title="Tuesday">T</th>';
			$markup .= '<th scope="col" title="Wednesday">O</th>';
			$markup .= '<th scope="col" title="Thursday">T</th>';
			$markup .= '<th scope="col" title="Friday">F</th>';
			$markup .= '<th scope="col" title="Saturday">L</th>';
			$markup .= '<th scope="col" title="Sunday">S</th>';
  		$markup .= '</tr></thead>';
		return $markup;
	}

	public function weeks()
	{
		// 2014-09-{day}
		$base_date = $this->calendar->year.'-'.$this->calendar->month.'-';
		
		$first_day = strtotime($base_date.'01');
		$previous_day = $first_day;
		$markup = '';
		for ($i=1; $i <= $this->calendar->days_in_month; $i++) { 
			// Timestamp for "today"
			$today = ($i == 1) ? $first_day : strtotime('+1 day', $previous_day);

			$markup .= $this->day($today, $i);

			$previous_day = $today;
		}

		return $markup;
	}

	public function day($timestamp, $day_in_month)
	{
		$weekday = getdate($timestamp);
		$weekday = $weekday['wday'];
		$month_day = getdate($timestamp);
		$month_day = $month_day['mday'];
		$markup = '';

		// Om det är första dagen i månaden eller den första i veckan
		if ( ($weekday == 1) || ($day_in_month == 1) ) {
			$markup .= '<tr>';
			
			// Om första dagen i månaden inte en måndag så ska det vara lite extra
			// utrymme framför. Detta representerar dagarna i veckan som hör till
			// föregående månad.
			if ($weekday != 1) {
				$markup .= '<td colspan="'.($weekday-1).'"></td>';
			}
		}
		
		// Dagens datum
		$markup .= '<td>'.$day_in_month.'</td>';
		
		// Om det är sista dagen i veckan eller sista dagen i månaden.
		if ( ($weekday == 0) || $day_in_month == $this->calendar->days_in_month ) {

			// Om det är sista dagen i månaden, men inte sista dagen i veckan.
			// Precis som i början av månaden ska det vara lite utrymme som 
			// representerar nästa månad. 
			if ( ($month_day == $this->calendar->days_in_month) && ($weekday != 0) ) {
				$markup .= '<td colspan="'.(7-$weekday).'"></td>';
			}
			$markup .= '</tr>';
		}
		return $markup;
	}
}