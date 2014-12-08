<?php

class SettingsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /settings
	 *
	 * @return Response
	 */
	public function index()
	{
		$listofturns = Turn::getList();
		$this->layout->content = View::make('settings.index', compact('listofturns'));
	}

	/**
	* update the current turn
	*/
	public function updateCurrentTurn()
	{
		if (Input::get('current_turn') != Setting::setting('current_turn')->first()->value)
		{
			DB::table('settings')->where('name','=','current_turn')->update(array('value' => Input::get('current_turn')));
			return Redirect::route('settings.index')->with('message','Die Einstellung aktuelles Semester erfolgreich aktualisiert.');
		}
		else
		{
			return Redirect::route('settings.index')->with('info','Keine Änderungen registriert!');
		}
	}
}