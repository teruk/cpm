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
		$todaySunday = false;
	
		// check if today is sunday
		if (date('w', time()) == 0)
			$todaySunday = true;

		switch ($weekday)
		{
			case 0:
				$day = date("Y-m-d", (($todaySunday == true)? strtotime('last monday'):strtotime('monday this week')));
				break;
			case 1:
				$day = date("Y-m-d", (($todaySunday == true)? strtotime('last tuesday'):strtotime('tuesday this week')));
				break;
			case 2:
				$day = date("Y-m-d", (($todaySunday == true)? strtotime('last wednesday'):strtotime('wednesday this week')));
				break;
			case 3:
				$day = date("Y-m-d", (($todaySunday == true)? strtotime('last thursday'):strtotime('thursday this week')));
				break;
			case 4:
				$day = date("Y-m-d", (($todaySunday == true)? strtotime('last friday'):strtotime('friday this week')));
				break;
			case 5:
				$day = date("Y-m-d", (($todaySunday == true)? strtotime('last saturday'):strtotime('saturday this week')));
				break;
			case 6:
				$day = date("Y-m-d", (($todaySunday == true)? strtotime('sunday this week'):strtotime('next sunday')));
				break;
		}
		return $day;
	}

	/**
	 * Extract the ids from an array of objects
	 * 
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function getIds($data)
	{
		$ids = array();
		foreach ($data as $key) {
			array_push($ids, $key->id);
		}
		return $ids;
	}

	/**
	 * fetch array of turns for turn navigation
	 * @param  Turn   $displayTurn [description]
	 * @return [type]              [description]
	 */
	public function getTurnNav(Turn $displayTurn)
	{
		// turn settings
		$currentTurn = Turn::find(Setting::setting('current_turn')->first()->value);
		$nextTurn = Turn::nextTurn($currentTurn)->first();
		$turns = [
			'currentTurn' => $currentTurn,
			'nextTurn' => $nextTurn,
			'afterNextTurn' => Turn::nextTurn($nextTurn)->first(),
			'displayTurn' => $displayTurn,
			'beforeTurns' => Turn::beforeTurns($currentTurn)->get()
		];

		return $turns;
	}
}
