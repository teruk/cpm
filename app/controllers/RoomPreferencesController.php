<?php

class RoomPreferencesController extends \BaseController 
{

	/**
	* show room preference
	*/
	public function roomPreference()
	{
		$current_turn = Turn::findOrFail(Setting::setting('current_turn')->first()->value);
		return Redirect::route('plannings.showRoomPreference',$current_turn->id);
	}

	/**
	* show room preference
	*/
	public function showRoomPreference(Turn $turn)
	{
		// turn navigation
		$turnNav = $this->getTurnNav($turn);
		
		$plannings = Planning::where('turn_id','=', $turn->id)->orderBy('course_number','ASC')->groupBy('course_number')->get();
		$this->layout->content = View::make('plannings.room_preferences', compact('plannings', 'turnNav'));
	}
}
