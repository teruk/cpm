<?php

class SectionsController extends BaseController {
	
	/**
	 * 
	 */
	public function index()
	{
		$sections = Section::all();
		$this->layout->content = View::make('sections.index', compact('sections'));
	}
	
	/**
	 * 
	 * @param Section $section
	 */
	public function show(Section $section)
	{
		$this->layout->content = View::make('sections.show', compact('section'));
	}
	
	/**
	 * save a new section
	 */
	public function store()
	{
		$input = Input::all();
		$section = new Section($input);
		
		if ($section->save())
			return Redirect::route('sections.index')->with('message','Bereich erfolgreich angelegt.');
		else
			return Redirect::route('sections.index')->withInput()->withErrors($section->errors());
	}
	
	/**
	 * delete a section
	 * @param Section $section
	 */
	public function destroy(Section $section)
	{
		$section->delete();
		return Redirect::route('sections.index')->with('message','Bereich erfolgreich gelöscht.');
	}
	
	/**
	 * update a section
	 * @param Section $section
	 */
	public function update(Section $section)
	{
		$input = Input::all();
		$section->fill($input);
		if ($section->updateUniques())
			return Redirect::route('sections.show', $section->id)->with('message','Der Bereich wurde aktualisiert.');
		else
			return Redirect::route('sections.show', array_get($section->getOriginal(), 'id'))->withInput()->withErrors($section->errors());
	}
	
}