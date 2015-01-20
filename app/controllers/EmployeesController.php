<?php


class EmployeesController extends BaseController {
	
	/**
	 * Display a listing of employees
	 * GET /employees
	 * 
	 * @return Response
	 */
	public function index()
	{
		$researchgroupIds = array();
		if (Entrust::hasRole('Admin'))
			$researchgroupIds = Researchgroup::lists('id');
		elseif (Entrust::can('add_employee'))
			$researchgroupIds = Entrust::user()->getResearchgroupIds();

		$employees = Employee::whereIn('researchgroup_id', $researchgroupIds)
							->where('firstname','!=','SHK')
							->where('firstname','!=','N.N.')
							->get();
		$researchgroups = array();
		// Loading the research groups for less querys in the view
		if (Entrust::hasRole('Admin'))
			$researchgroups = Researchgroup::lists('name', 'id');
		elseif (Entrust::can('add_employee')) {
			foreach (Entrust::user()->researchgroups as $researchgroup) {
				$researchgroups = array_add($researchgroups, $researchgroup->id, $researchgroup->name);
			}
		}

		return View::make('employees.index', compact('employees', 'researchgroups'));
	}
	
	/**
	 * Store a newly created employee in database
	 * POST /employees
	 * 
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$employee = new Employee($input);
		$employee->inactive = 0;
		
		if ( $employee->save() ) {
			Flash::success('Mitarbeiter erfolgreich erstellt!');
			return Redirect::back();
		}
		
		Flash::error($employee->errors());
		return Redirect::back()->withInput();
	}
	
	/**
	 * Display the specific employee
	 * GET /employees/{employee}/show
	 * 
	 * @param Employee $employee
	 * @return Response
	 */
	public function edit(Employee $employee)
	{
		// check if the user is allowed to see this employee
		$allowed = false;
		if (Entrust::hasRole('Admin'))
			$allowed = true;
		else {
			if (Entrust::can('add_employee')) {
				foreach (Entrust::user()->researchgroups as $researchgroup) {
					if ($researchgroup->id == $employee->researchgroup_id)
						$allowed = true;
				}
			}
		}

		if ($allowed) {
			// Loading the research groups for less querys in the view
			$researchgroups = Researchgroup::lists('name', 'id');
			return View::make('employees.editInformation', compact('employee', 'researchgroups'));
		} else {
			Flash::error('Zugriff verweigert! Sie besitzen nicht die nötigen Berechtigungen.');
			return Redirect::back();
		}
	}
	
	/**
	 * Update the specified employee in database
	 * PATCH /employees/{employee}/update
	 * 
	 * @param Employee $employee
	 * @return Response
	 */
	public function update(Employee $employee)
	{
		$input = Input::all();
		$employee->fill($input);
		if (Input::get('inactive') == 1)
			$employee->inactive = 1;

		if ( $employee->updateUniques() ) {
			Flash::success('Das Modul wurde aktualisiert.');
			return Redirect::back();
		}
		
		Flash::error($employee->errors());
		return Redirect::back()->withInput();
	}
	
	/**
	 * Remove the specific employee from the database
	 * DELETE /employees/{employee}/delete
	 * 
	 * @param Employee $employee
	 * @return Response
	 */
	public function destroy(Employee $employee)
	{
		/*
		 * checking if the employee is already assigned to a midterm planning
		 * if yes, the employee can't be deleted
		 */
		if ($employee->mediumtermplannings->count() > 0 || $employee->plannings->count() > 0) {
			Flash::error('Mitarbeiter kann nicht gelöscht werden, da er bereits in Planungen miteinbezogen wurde.');
			return Redirect::back();
		}

		$employee->delete();
		Flash::success('Mitarbeiter erfolgreich gelöscht');
		return Redirect::back();
	}

	/**
	 * show employee course history
	 * @param  Employee $employee [description]
	 * @return [type]             [description]
	 */
	public function showHistory(Employee $employee)
	{
		$plannings = array();
		if (sizeof($employee->plannings) > 0)
		{
			$planningIds = array_fetch($employee->plannings->toArray(), 'id');
			$plannings = Planning::whereIn('id',$planningIds)->orderBy('turn_id','DESC')->get();
		}
		return View::make('employees.history', compact('employee', 'plannings'));
	}

	// public function export()
	// {
	// 	$employees = Employee::all();
	// 	$this->layout->content = View::make('employees.export', compact('employees'));
	// }
}
