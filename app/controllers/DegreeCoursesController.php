<?php

use Illuminate\Support\Facades\Redirect;
class DegreeCoursesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /degreecourses
	 *
	 * @return Response
	 */
	public function index()
	{
		$degreecourses = DegreeCourse::all();
		$listofdepartments = Department::lists('name','id');
		$listofdegrees = Degree::lists('name','id');
		$this->layout->content = View::make('degree_courses.index', compact('degreecourses','listofdepartments', 'listofdegrees'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /degreecourses/create
	 *
	 * @return Response
	 */
	public function create()
	{
		$this->layout->content = View::make('degree_courses.index');
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
		$degreecourse = new DegreeCourse($input);
		
		if ( $degreecourse->save() )
			return Redirect::route('degree_courses.index')->with('message', 'Studiengang erfolgreich erstellt!');
		else
			return Redirect::route('degree_courses.index')->withInput()->withErrors( $degreecourse->errors() );
	}

	/**
	 * Display the specified resource.
	 * GET /degreecourses/{id}
	 *
	 * @param  int  Degree_Course $degree_course
	 * @return Response
	 */
	public function show(DegreeCourse $degreecourse)
	{	
		$listofdepartments = Department::lists('name','id');
		$listofdegrees = Degree::lists('name','id');
		$listofrotations = Rotation::lists('name','id');
		$listofsections = Section::lists('name','id');
		$this->layout->content = View::make('degree_courses.show', compact('degreecourse', 'listofdepartments', 'listofdegrees', 'listofsections', 'listofrotations'));
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /degreecourses/{id}/edit
	 *
	 * @param  int  Degree_Course $degree_course
	 * @return Response
	 */
	public function edit(DegreeCourse $degreecourse)
	{
		$this->layout->content = View::make('degree_courses.index', compact('degreecourse'));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /degreecourses/{id}
	 *
	 * @param  int  Degree_Course $degree_course
	 * @return Response
	 */
	public function update(DegreeCourse $degreecourse)
	{
		$input = Input::all();
		$degreecourse->fill($input);
 
		if ( $degreecourse->updateUniques() )
			return Redirect::route('degree_courses.show', $degreecourse->id)->with('message', 'Der Studiengang wurde aktualisiert.');
		else
			return Redirect::route('degree_courses.show', array_get($degreecourse->getOriginal(), 'id'))->withInput()->withErrors( $degreecourse->errors() );
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /degreecourses/{id}
	 *
	 * @param  int  Degree_Course $degree_course
	 * @return Response
	 */
	public function destroy(DegreeCourse $degreecourse)
	{
		$degreecourse->delete();
		return Redirect::route('degree_courses.index')->with('message', 'Studiengang erfolgreich geloescht.');
	}

}