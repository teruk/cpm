<?php

class RotationsController extends BaseController 
{
	
	/**
	 * 
	 */
	public function index()
	{
		$rotations = Rotation::all();
		return View::make('rotations.index', compact('rotations'));
	}
	
	/**
	 * 
	 * @param Rotation $rotation
	 */
	public function edit(Rotation $rotation)
	{
		return View::make('rotations.editInformation', compact('rotation'));
	}
	
	/**
	 * save a new rotation
	 */
	public function store()
	{
		$input = Input::all();
		$rotation = new Rotation($input);
		
		if ($rotation->save()) {
			Flash::success('Der Turnus wurde erfolgreich angelegt.');
			return Redirect::back();
		}

		Flash::error($rotation->errors());
		return Redirect::back()->withInput();
	}
	
	/**
	 * delete a rotation
	 * @param Rotation $rotation
	 */
	public function destroy(Rotation $rotation)
	{
		if ($rotation->modules->count() == 0) {
			$rotation->delete();
			Flash::success('Der Turnus wurde erfolgreich gelöscht.');
		}
		else
			Flash::error('Turnus konnte nicht gelöscht werden. Es existieren noch Module die diesen Turnus verwenden.');

		return Redirect::back();
	}
	
	/**
	 * update a rotation
	 * @param Rotation $rotation
	 */
	public function update(Rotation $rotation)
	{
		$input = Input::all();
		$rotation->fill($input);
		if ($rotation->updateUniques()) {
			Flash::success('Der Turnus wurde aktualisiert.');
			return Redirect::back();
		}
		
		Flash::error($rotation->errors());
		return Redirect::back()->withInput();
	}
}
