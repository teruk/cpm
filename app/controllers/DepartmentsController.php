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
		return View::make('departments.index', compact('departments'));
	}
	
	/**
	 * save a new department
	 * @return [type] [description]
	 */
	public function store()
	{
		$input = Input::all();
		$department = new Department($input);
		
		if ($department->save())
		{
			Flash::success('Fachbereich erfolgreich angelegt.');
			return Redirect::back();
		}

		Flash::error($department->errors());
		return Redirect::back()->withInput();
	}
	
	/**
	 * 
	 * @param Department $department
	 */
	public function edit(Department $department)
	{
		if (Entrust::hasRole('Admin') || Entrust::can('edit_department'))
		{
			$researchgroups = $department->researchgroups;
			$degreecourses = $department->degreecourses;

			return View::make('departments.editInformation', compact('department','researchgroups','degreecourses'));
		}

		Flash::error('Zugriff verweigert! Sie besitzen nicht die benötigten Berechtigungen.');
		return Redirect::back();
	}
	
	/**
	 * [update description]
	 * @param  Department $department [description]
	 * @return [type]                 [description]
	 */
	public function update(Department $department)
	{
		$input = Input::all();
		$department->fill($input);
		if ($department->updateUniques())
		{
			Flash::success('Der Fachbereich wurde aktualisiert.');
			return Redirect::back();
		}
		
		Flash::error($department->errors());
		return Redirect::back()->withInput();
	}
	
	/**
	 * [destroy description]
	 * @param  Department $department [description]
	 * @return [type]                 [description]
	 */
	public function destroy(Department $department)
	{
		/**
		 * Check if there a degree courses or research groups assigned to the department
		 * if yes, the department can't be deleted
		 */
		if (sizeof($department->researchgroups) > 0 || sizeof($department->degreecourses) > 0)
		{
			Flash::error('Der Fachbereich kann nicht gelöscht werden, da ihm bereits Arbeitsbereich und/oder Studiengänge zugeordnet sind.');
			return Redirect::back();
		}

		$department->delete();
		Flash::success('Fachbereich erfolgreich gelöscht.');
		return Redirect::back();
	}
}