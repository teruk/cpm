<?php

use Illuminate\Support\Facades\Redirect;
class CoursetypesController extends BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /coursetypes
	 *
	 * @return Response
	 */
	public function index()
	{
		$coursetypes = Coursetype::all();

		return View::make('coursetypes.index', compact('coursetypes'));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /coursetypes
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$coursetype = new Coursetype($input);
		
		if ( $coursetype->save() )
		{
			Flash::success('Kurstyp erfolgreich erstellt!');
			return Redirect::back();
		}

		Flash::error($coursetype->errors());
		return Redirect::back()->withInput();
	}

	/**
	 * Display the specified resource.
	 * GET /coursetypes/{id}
	 *
	 * @param  int  CourseType $coursetype
	 * @return Response
	 */
	public function edit(Coursetype $coursetype)
	{	
		return View::make('coursetypes.editInformation', compact('coursetype'));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /coursetypes/{id}
	 *
	 * @param  int  CourseType $coursetype
	 * @return Response
	 */
	public function update(Coursetype $coursetype)
	{
		$input = Input::all();
		$coursetype->fill($input);
 
		if ( $coursetype->updateUniques() )
		{
			Flash::success('Der Kurstyp wurde aktualisiert.');
			return Redirect::back();
		}
		
		Flash::error($coursetype->errors());
		return Redirect::back()->withInput();
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /coursetypes/{id}
	 *
	 * @param  int  CourseType $coursetype
	 * @return Response
	 */
	public function destroy(Coursetype $coursetype)
	{
		$coursetype->delete();
		Flash::success('Kurstyp erfolgreich gelöscht.');
		return Redirect::back();
	}

}