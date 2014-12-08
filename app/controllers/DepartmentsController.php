<?php

use Illuminate\Support\Facades\Redirect;
class DepartmentsController extends BaseController {
	
	/**
	 * Display a listing of departments
	 * GET /departments
	 */
	public function index()
	{
		$departments = Department::all();
		$this->layout->content = View::make('departments.index', compact('departments'));
	}
	
	/**
	 * 
	 */
	public function store()
	{
		$input = Input::all();
		$department = new Department($input);
		
		if ($department->save())
			return Redirect::route('departments.index')->with('message','Fachbereich erfolgreich angelegt.');
		else 
			return Redirect::route('departments.index')->withInput()->withErrors($department->errors());
	}
	
	/**
	 * 
	 * @param Department $department
	 */
	public function show(Department $department)
	{
		$researchgroups = $department->researchgroups;
		$degreecourses = $department->degreecourses;
		$listofdegrees = $this->getListofdegrees();
		$this->layout->content = View::make('departments.show', compact('department','researchgroups','degreecourses','listofdegrees'));
	}
	
	/**
	 * 
	 * @param Department $department
	 */
	public function update(Department $department)
	{
		$input = Input::all();
		$department->fill($input);
		if ($department->updateUniques())
			return Redirect::route('departments.show', $department->id)->with('message','Der Fachbereich wurde aktualisiert.');
		else 
			return Redirect::route('departments.show', array_get($department->getOriginal(), 'id'))->withInput()->withErrors($department->errors());
	}
	
	/**
	 * 
	 * @param Department $department
	 */
	public function destroy(Department $department)
	{
		/**
		 * Check if there a degree courses or research groups assigned to the department
		 * if yes, the department can't be deleted
		 */
		if (sizeof($department->researchgroups) > 0 || sizeof($department->degreecourses) > 0)
			return Redirect::route('departments.index')->with('error', ' Der Fachbereich kann nicht gelöscht werden, da ihm bereits Arbeitsbereich und/oder Studiengänge zugeordnet sind.');
		else 
		{
			$department->delete();
			return Redirect::route('departments.index')->with('message', 'Fachbereich erfolgreich gelöscht.');
		}
	}
}