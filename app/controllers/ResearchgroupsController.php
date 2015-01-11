<?php

use Illuminate\Support\Facades\Redirect;
/**
 * Contains the logic for the research groups
 * 
 * @author Sebb
 *
 */

class ResearchgroupsController extends BaseController{
	
	/**
	 * Display a listing of the research groups
	 * GET /research_groups
	 * 
	 * @return Response
	 */
	public function index()
	{
		$researchgroups = Researchgroup::all();
		$departments = Department::all();
		$listofdepartments = array();
		foreach ($departments as $department)
		{
			$listofdepartments = array_add($listofdepartments, $department->id, $department->name);
		}
		return View::make('researchgroups.index', compact('researchgroups', 'listofdepartments'));
	}
	
	/**
	 * Store a newly created research group in storage.
	 * POST /researchgroups
	 * 
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$researchgroup = new Researchgroup($input);
		$researchgroup->department_id = 1;
		
		if ($researchgroup->save())
		{
			// default shk for researchgroup
			$employee_shk = new Employee();
			$employee_shk->saveDummyEmployee("SHK", $researchgroup, "");
			$employee_shk->save();

			// default nn for researchgroup
			$employee_nn = new Employee();
			$employee_nn->saveDummyEmployee('N.N.', $researchgroup, "");
			$employee_nn->save();

			Flash::success('Arbeitsbereich erfolgreich angelegt.');
			return Redirect::back();
		}

		Flash::error($researchgroup->errors());
		return Redirect::back()->withInput();
	}
	
	/**
	 * Showing a specific research group
	 * GET /researchgroups/{researchgroup}/show
	 * 
	 * @param ResearchGroup $researchgroup
	 * @return Response
	 */
	public function edit(Researchgroup $researchgroup)
	{
		$employees = Employee::where('researchgroup_id', '=', $researchgroup->id)->get();
		$departments = Department::all();
		$listofdepartments = array();
		foreach ($departments as $department)
		{
			$listofdepartments = array_add($listofdepartments, $department->id, $department->name);
		}
		return View::make('researchgroups.editInformation', compact('researchgroup', 'employees', 'listofdepartments'));
	}
	
	/**
	 * Update the specific research group.
	 * PATCH /researchgroups/{researchgroup}/update
	 * 
	 * @param ResearchGroup $researchgroup
	 * @return Response
	 */
	public function update(Researchgroup $researchgroup)
	{
		$input = Input::all();
		// if the abbrevation of the research group changed, the shk and nn need to be updated
		$researchgroup_short = $researchgroup->short;
		if (Input::get('short') != $researchgroup_short)
		{
			$employee_shk = Employee::where('name','=',$researchgroup->short)->where('firstname','=','SHK')->first();
			$employee_shk->name = Input::get('short');
			$employee_nn = Employee::where('name','=',$researchgroup->short)->where('firstname','=','N.N.')->first();
			$employee_nn->name = Input::get('short');
		}
		$researchgroup->fill($input);
		if ($researchgroup->updateUniques())
		{
			// the changes to the shk and nn can only be saved, if the researchgroup update is successful
			if ($researchgroup->short != $researchgroup_short)
			{
				$employee_shk->updateUniques();
				$employee_nn->updateUniques();
			}

			Flash::success('Der Arbeitsbereich wurde erfolgreich aktualisiert.');
			return Redirect::back();
		}

		Flash::error($researchgroup->errors());
		return Redirect::back()->withInput();
	}
	
	/**
	 * Deletes the research group from the database
	 * @param ResearchGroup $researchgroup
	 */
	public function destroy(Researchgroup $researchgroup)
	{
		if (sizeof($researchgroup->employees) == 0)
		{
			$researchgroup->delete();
			Flash::success('Arbeitsbereich wurde erfolgreich gelöscht.');
			return Redirect::back();
		}
		
		Flash::error('Der Arbeitsbereich kann nicht gelöscht werden, da ihm noch Mitarbeiter zugeordnet sind.');
		return Redirect::back();
	}

	/**
	 * show research group courses
	 * @param  ResearchGroup $researchgroup [description]
	 * @return [type]                       [description]
	 */
	public function showCourses(ResearchGroup $researchgroup)
	{
		return View::make('researchgroups.courses', compact('researchgroup'));
	}

	/**
	 * show research group employees
	 * @param  ResearchGroup $researchgroup [description]
	 * @return [type]                       [description]
	 */
	public function showEmployees(ResearchGroup $researchgroup)
	{
		return View::make('researchgroups.employees', compact('researchgroup'));
	}
}