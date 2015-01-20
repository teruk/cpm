<?php

class SectionsController extends BaseController 
{
	
	/**
	 * 
	 */
	public function index()
	{
		$sections = Section::all();
		return View::make('sections.index', compact('sections'));
	}
	
	/**
	 * 
	 * @param Section $section
	 */
	public function edit(Section $section)
	{
		return View::make('sections.editInformation', compact('section'));
	}
	
	/**
	 * save a new section
	 */
	public function store()
	{
		$input = Input::all();
		$section = new Section($input);
		
		if ($section->save()) {
			Flash::success('Bereich erfolgreich angelegt.');
			return Redirect::back();
		}

		Flash::error($section->errors());
		return Redirect::back()->withInput();
	}
	
	/**
	 * delete a section
	 * @param Section $section
	 */
	public function destroy(Section $section)
	{
		$section->delete();
		Flash::success('Bereich erfolgreich gelöscht.');
		return Redirect::back();
	}
	
	/**
	 * update a section
	 * @param Section $section
	 */
	public function update(Section $section)
	{
		$input = Input::all();
		$section->fill($input);
		if ($section->updateUniques()) {
			Flash::success('Der Bereich wurde aktualisiert.');
			return Redirect::back();
		}
		
		Flash::error($section->errors());
		return Redirect::back()->withInput();
	}
}
