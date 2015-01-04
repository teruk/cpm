<?php

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
class TurnsController extends BaseController {
	
	public function index()
	{
		$turns = Turn::all();
		/*
		 * generating a list of available turns
		 */
		$availableturns = Turn::getListofAvailableTurns();
		$this->layout->content = View::make('turns.index', compact('turns','availableturns'));
	}
	
	/**
	 * delete a turn
	 * @param Turn $turn
	 */
	public function destroy(Turn $turn)
	{
		/*
		 * Check if there are midterm plannings for this turn
		 * if yes, then the turn can't be deleted
		 */
		if (sizeof($turn->midtermplannings) > 0)
		{
			Flash::error('Dieses Semester kann nicht gelöscht werden, da es bereits in die mittelfristige Lehrplanung miteinbezogen wurde.');
			return Redirect::back();
		}
		
		$turn->delete();
		Flash::success('Semester erfolgreich gelöscht.');
		return Redirect::back();
	}
	
	/**
	* show detail auf a turn
	*/
	public function show(Turn $turn)
	{
		$this->layout->content = View::make('turns.show', compact('turn'));
	}
	
	/**
	* save a new turn
	*/
	public function store()
	{
		$input = Input::all();
		$turn = new Turn($input);
		$availableturns = Turn::getListofAvailableTurns();
		$year = substr($availableturns[$turn->name], -4);
		$turn->year = $year;
		$turn->name = trim(str_replace($year, "", $availableturns[$turn->name]));
		
		/*
		 * checking if the combination of name and year already exists
		 * TODO should be unnessary
		 */
		$duplicate = DB::table('turns')
					->select('id')
					->where('name', '=', $turn->name)
					->where('year', '=', $turn->year)
					->get();
		if (sizeof($duplicate))
			$message = "Dieses Semester existiert schon.";
		$passed = $turn->checkLogic();

		// if the logical check is passed and there are no duplicates, then try to save the turn
		if ($passed['successful'] && sizeof($duplicate) == 0)
		{
			if ( $turn->save() )
			{
				Flash::success('Semester erfolgreich erstellt!');
				return Redirect::back();
			}
			
			Flash::error($turn->errors());
			return Redirect::back();
		}
		
		Flash::error($passed['message']);
		return Redirect::back();
	}
	
	/**
	* update the turn
	*/
	public function update(Turn $turn)
	{
		$turn->semester_start = Input::get('semester_start');
		$turn->semester_end = Input::get('semester_end');
		$passed = $turn->checkLogic();
		if ($passed['successful'])
		{
			if ($turn->updateUniques())
			{
				Flash::success('Das Semester wurde aktualisiert.');
				return Redirect::route('turns.show', $turn->id);
			}
			
			Flash::error($turn->errors());
			return Redirect::route('turns.show', array_get($turn->getOriginal(), 'id'))->withInput();
		}

		Flash::error($passed['message']);
		return Redirect::route('turns.show', $turn->id);
	}
}