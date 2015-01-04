<?php

class DegreesController extends BaseController {
	
	/**
	 * [index description]
	 * @return [type] [description]
	 */
	public function index()
	{
		$degrees = Degree::all();
		$this->layout->content = View::make('degrees.index', compact('degrees'));
	}
	
	/**
	 * [show description]
	 * @param  Degree $degree [description]
	 * @return [type]         [description]
	 */
	public function show(Degree $degree)
	{
		$this->layout->content = View::make('degrees.show', compact('degree'));
	}
	
	/**
	 * [store description]
	 * @return [type] [description]
	 */
	public function store()
	{
		$input = Input::all();
		$degree = new Degree($input);
		
		if ($degree->save())
		{
			Flash::success('Bereich erfolgreich angelegt.');
			return Redirect::back();
		}

		Flash::error($degree->errors());
		return Redirect::back();
	}
	
	/**
	 * [destroy description]
	 * @param  Degree $degree [description]
	 * @return [type]         [description]
	 */
	public function destroy(Degree $degree)
	{
		$degree->delete();

		Flash::success('Bereich erfolgreich gelöscht.');
		return Redirect::back();
	}
	
	/**
	 * [update description]
	 * @param  Degree $degree [description]
	 * @return [type]         [description]
	 */
	public function update(Degree $degree)
	{
		$input = Input::all();
		$degree->fill($input);
		if ($degree->updateUniques())
		{
			Flash::success('Der Bereich wurde aktualisiert.');
			return Redirect::route('degrees.show', $degree->id);
		}

		Flash::error($degree->errors());
		return Redirect::route('degrees.show', array_get($degree->getOriginal(), 'id'))->withInput();
	}
	
}