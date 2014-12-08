<?php

class BaseController extends Controller {

	protected $layout = 'layouts.main';
	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
			$this->layout = View::make($this->layout);

		// variables, that are available in all views
		View::share('currentUser', Auth::user());
		View::share('signedIn', Auth::user());
		View::share('currentTurn', Setting::setting('current_turn')->first()->value);
	}
	
	/** 
	* Returns the current date for the given weekday
	* TODO fix sunday, so that that the entries are shown on sunday
	* @param integer $weekday
	* @return Date $day
	*/
	public function getWeekdayDate($weekday)
	{
		$mon = date("Y-m-d",strtotime('monday this week'));
		$tue = date("Y-m-d",strtotime('tuesday this week'));
		$wed = date("Y-m-d",strtotime('wednesday this week'));
		$thu = date("Y-m-d",strtotime('thursday this week'));
		$fri = date("Y-m-d",strtotime('friday this week'));
		$sat = date("Y-m-d",strtotime('saturday this week'));
		$sun = date("Y-m-d",strtotime('last sunday'));
		switch ($weekday)
		{
			case 0:
				$day = $mon;
				break;
			case 1:
				$day = $tue;
				break;
			case 2:
				$day = $wed;
				break;
			case 3:
				$day = $thu;
				break;
			case 4:
				$day = $fri;
				break;
			case 5:
				$day = $sat;
				break;
			case 6:
				$day = $sun;
				break;
		}
		return $day;
	}
}
