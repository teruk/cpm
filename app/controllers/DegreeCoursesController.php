<?php

use Illuminate\Support\Facades\Redirect;
class DegreecoursesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /degreecourses
	 *
	 * @return Response
	 */
	public function index()
	{
		$degreecourses = Degreecourse::all();
		$listofdepartments = Department::lists('name','id');
		$listofdegrees = Degree::lists('name','id');

		return View::make('degreecourses.index', compact('degreecourses','listofdepartments', 'listofdegrees'));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /degreecourses
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$degreecourse = new Degreecourse($input);
		
		if ( $degreecourse->save() )
		{
			Flash::success('Studiengang erfolgreich erstellt!');
			return Redirect::back();
		}

		Flash::error($degreecourse->errors());
		return Redirect::back()->withInput();
	}

	/**
	 * Display the specified resource.
	 * GET /degreecourses/{id}
	 *
	 * @param  int  Degree_Course $degree_course
	 * @return Response
	 */
	public function edit(Degreecourse $degreecourse)
	{	
		$listofdepartments = Department::lists('name','id');
		$listofdegrees = Degree::lists('name','id');
		$listofrotations = Rotation::lists('name','id');
		$listofsections = Section::lists('name','id');

		return View::make('degreecourses.editInformation', compact('degreecourse', 'listofdepartments', 'listofdegrees', 'listofsections', 'listofrotations'));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /degreecourses/{id}
	 *
	 * @param  int  Degree_Course $degree_course
	 * @return Response
	 */
	public function update(Degreecourse $degreecourse)
	{
		$input = Input::all();
		$degreecourse->fill($input);
 
		if ( $degreecourse->updateUniques() )
		{
			Flash::success('Der Studiengang wurde aktualisiert.');
			return Redirect::back();
		}

		Flash::error($degreecourse->errors());
		return Redirect::back()->withInput();
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /degreecourses/{id}
	 *
	 * @param  int  Degree_Course $degree_course
	 * @return Response
	 */
	public function destroy(Degreecourse $degreecourse)
	{
		if ($degreecourse->modules() == 0)
		{
			$degreecourse->delete();
			Flash::success('Studiengang erfolgreich gelöscht.');
		}
		else
			Flash::error('Der Studiengang konnte nicht gelöscht werden, da ihm noch Module zugeordnet sind.');
		
		return Redirect::back();
	}

	/**
	 * return list of 
	 * @param  Degreecourse $degreecourse [description]
	 * @return [type]                     [description]
	 */
	public function showModules(Degreecourse $degreecourse)
	{
		$listofsections = Section::lists('name','id');
		$listofrotations = Rotation::lists('name','id');
		return View::make('degreecourses.modules', compact('degreecourse', 'listofsections', 'listofrotations'));
	}

}