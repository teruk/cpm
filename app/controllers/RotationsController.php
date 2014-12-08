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
			return Redirect::route('rotations.index')->with('message','Bereich erfolgreich angelegt.');
		else
			return Redirect::route('rotations.index')->withInput()->withErrors($rotation->errors());
	}
	
	/**
	 * delete a rotation
	 * @param Rotation $rotation
	 */
	public function destroy(Rotation $rotation)
	{
		$rotation->delete();
		return Redirect::route('rotations.index')->with('message','Bereich erfolgreich gelöscht.');
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
			return Redirect::route('rotations.show', $rotation->id)->with('message','Der Abschluss wurde aktualisiert.');
		else
			return Redirect::route('rotations.show', array_get($rotation->getOriginal(), 'id'))->withInput()->withErrors($rotation->errors());
	}
	
}