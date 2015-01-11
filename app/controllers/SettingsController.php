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
		return View::make('settings.index', compact('listofturns'));
	}

	/**
	 * show setting current turn
	 * @return [type] [description]
	 */
	public function editCurrentTurn()
	{
		$turns = Turn::getList();
		return View::make('settings.editCurrentTurn', compact('turns'));
	}

	/**
	 * update setting current turn
	 * 
	 * @return [type] [description]
	 */
	public function updateCurrentTurn()
	{
		if (Input::get('current_turn') != Setting::setting('current_turn')->first()->value)
		{
			DB::table('settings')->where('name','=','current_turn')->update(array('value' => Input::get('current_turn')));
			Flash::success('Die Einstellung aktuelles Semester erfolgreich aktualisiert.');
			return Redirect::back();
		}

		Flash::message('Keine Änderungen registriert!');
		return Redirect::back();
	}
}