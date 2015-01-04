<?php

class RotationsController extends BaseController {
	
	/**
	 * 
	 */
	public function index()
	{
		$rotations = Rotation::all();
		$this->layout->content = View::make('rotations.index', compact('rotations'));
	}
	
	/**
	 * 
	 * @param Rotation $rotation
	 */
	public function show(Rotation $rotation)
	{
		$this->layout->content = View::make('rotations.show', compact('rotation'));
	}
	
	/**
	 * save a new rotation
	 */
	public function store()
	{
		$input = Input::all();
		$rotation = new Rotation($input);
		
		if ($rotation->save())
		{
			Flash::success('Bereich erfolgreich angelegt.');
			return Redirect::back();
		}

		Flash::error($rotation->errors());
		return Redirect::back();
	}
	
	/**
	 * delete a rotation
	 * @param Rotation $rotation
	 */
	public function destroy(Rotation $rotation)
	{
		$rotation->delete();
		Flash::success('Bereich erfolgreich gelöscht.');
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
		if ($rotation->updateUniques())
		{
			Flash::success('Der Abschluss wurde aktualisiert.');
			return Redirect::route('rotations.show', $rotation->id);
		}
		
		Flash::error($rotation->errors());
		return Redirect::route('rotations.show', array_get($rotation->getOriginal(), 'id'))->withInput();
	}
	
}