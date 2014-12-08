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
		$this->layout->content = View::make('researchgroups.index', compact('researchgroups', 'listofdepartments'));
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
			$employee_shk->firstname = "SHK";
			$employee_shk->name = $researchgroup->short;
			$employee_shk->title = "";
			$employee_shk->researchgroup_id = $researchgroup->id;
			$employee_shk->teaching_load = 0;
			$employee_shk->employed_since = date("Y-m-d");
			$employee_shk->employed_till = date('Y-m-d',strtotime(date("Y-m-d", time()) . " + 10 year"));
			$employee_shk->inactive = 0;
			$employee_shk->save();

			// default nn for researchgroup
			$employee_nn = new Employee();
			$employee_nn->firstname = "N.N.";
			$employee_nn->name = $researchgroup->short;
			$employee_nn->title = "";
			$employee_nn->researchgroup_id = $researchgroup->id;
			$employee_nn->teaching_load = 0;
			$employee_nn->employed_since = date("Y-m-d");
			$employee_nn->employed_till = date('Y-m-d',strtotime(date("Y-m-d", time()) . " + 10 year"));
			$employee_nn->inactive = 0;
			$employee_nn->save();

			return Redirect::route('researchgroups.index')->with('message','Arbeitsbereich erfolgreich angelegt.');
		}
		else 
			return Redirect::route('researchgroups.index')->withInput()->withErrors( $researchgroup->errors());
	}
	
	/**
	 * Showing a specific research group
	 * GET /researchgroups/{researchgroup}/show
	 * 
	 * @param ResearchGroup $researchgroup
	 * @return Response
	 */
	public function show(Researchgroup $researchgroup)
	{
		$employees = Employee::where('researchgroup_id', '=', $researchgroup->id)->get();
		$departments = Department::all();
		$listofdepartments = array();
		foreach ($departments as $department)
		{
			$listofdepartments = array_add($listofdepartments, $department->id, $department->name);
		}
		$this->layout->content = View::make('researchgroups.show', compact('researchgroup', 'employees', 'listofdepartments'));
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
			return Redirect::route('researchgroups.show', $researchgroup->id)->with('message', 'Der Arbeitsbereich wurde erfolgreich aktualisiert.');
		}
		else
			return Redirect::route('researchgroups.show', array_get($researchgroup->getOriginal(), 'id'))->withInput()->withErrors($researchgroup->errors());
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
			return Redirect::route('researchgroups.index')->with('message', 'Arbeitsbereich wurde erfolgreich gelöscht.');
		}
		else
			return Redirect::route('researchgroups.index')->with('error', 'Der Arbeitsbereich kann nicht gelöscht werden, da ihm noch Mitarbeiter zugeordnet sind.');
	}
}