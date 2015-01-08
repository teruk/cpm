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

		$this->layout->content = View::make('degreecourses.index', compact('degreecourses','listofdepartments', 'listofdegrees'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /degreecourses/create
	 *
	 * @return Response
	 */
	public function create()
	{
		$this->layout->content = View::make('degreecourses.index');
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
	public function show(Degreecourse $degreecourse)
	{	
		$listofdepartments = Department::lists('name','id');
		$listofdegrees = Degree::lists('name','id');
		$listofrotations = Rotation::lists('name','id');
		$listofsections = Section::lists('name','id');

		$this->layout->content = View::make('degreecourses.show', compact('degreecourse', 'listofdepartments', 'listofdegrees', 'listofsections', 'listofrotations'));
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /degreecourses/{id}/edit
	 *
	 * @param  int  Degree_Course $degree_course
	 * @return Response
	 */
	public function edit(Degreecourse $degreecourse)
	{
		$this->layout->content = View::make('degreecourses.index', compact('degreecourse'));
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
		$degreecourse->delete();
		Flash::success('Studiengang erfolgreich gelöscht.');
		return Redirect::back();
	}

}