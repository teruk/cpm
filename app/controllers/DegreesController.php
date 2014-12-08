<?php

class DegreesController extends BaseController {
	
	/**
	 * 
	 */
	public function index()
	{
		$degrees = Degree::all();
		$this->layout->content = View::make('degrees.index', compact('degrees'));
	}
	
	/**
	 * 
	 * @param Degree $degree
	 */
	public function show(Degree $degree)
	{
		$this->layout->content = View::make('degrees.show', compact('degree'));
	}
	
	/**
	 * 
	 */
	public function store()
	{
		$input = Input::all();
		$degree = new Degree($input);
		
		if ($degree->save())
			return Redirect::route('degrees.index')->with('message','Bereich erfolgreich angelegt.');
		else
			return Redirect::route('degrees.index')->withInput()->withErrors($degree->errors());
	}
	
	/**
	 * 
	 * @param Degree $degree
	 */
	public function destroy(Degree $degree)
	{
		$degree->delete();
		return Redirect::route('degrees.index')->with('message','Bereich erfolgreich gelöscht.');
	}
	
	/**
	 * 
	 * @param Degree $degree
	 */
	public function update(Degree $degree)
	{
		$input = Input::all();
		$degree->fill($input);
		if ($degree->updateUniques())
			return Redirect::route('degrees.show', $degree->id)->with('message','Der Bereich wurde aktualisiert.');
		else
			return Redirect::route('degrees.show', array_get($degree->getOriginal(), 'id'))->withInput()->withErrors($degree->errors());
	}
	
}