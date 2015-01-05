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
		$rg_ids = array();
		if (Entrust::hasRole('Admin'))
			$rg_ids = Researchgroup::lists('id');
		elseif (Entrust::can('add_employee'))
		{
			foreach (Entrust::user()->researchgroups as $rg) {
				array_push($rg_ids, $rg->id);
			}
		}

		$employees = Employee::whereIn('researchgroup_id',$rg_ids)
							->where('firstname','!=','SHK')
							->where('firstname','!=','N.N.')
							->get();
		$listofresearchgroups = array();
		// Loading the research groups for less querys in the view
		if (Entrust::hasRole('Admin'))
			$listofresearchgroups = Researchgroup::lists('name', 'id');
		elseif (Entrust::can('add_employee'))
		{
			foreach (Entrust::user()->researchgroups as $rg) {
				$listofresearchgroups = array_add($listofresearchgroups, $rg->id, $rg->name);
			}
		}

		$this->layout->content = View::make('employees.index', compact('employees', 'listofresearchgroups'));
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
		
		if ( $employee->save() )
		{
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
	public function show(Employee $employee)
	{
		// check if the user is allowed to see this employee
		$allowed = false;
		if (Entrust::hasRole('Admin'))
			$allowed = true;
		else
		{
			if (Entrust::can('add_employee'))
			{
				foreach (Entrust::user()->researchgroups as $rg) 
				{
					if ($rg->id == $employee->researchgroup_id)
						$allowed = true;
				}
			}
		}

		if ($allowed)
		{
			// Loading the research groups for less querys in the view
			$listofresearchgroups = Researchgroup::lists('name', 'id');
			$plannings = array();
			if (sizeof($employee->plannings) > 0)
			{
				$planning_ids = array();
				foreach ($employee->plannings as $p) {
					array_push($planning_ids, $p->id);
				}
				$plannings = Planning::whereIn('id',$planning_ids)->orderBy('turn_id','DESC')->get();
			}
			$this->layout->content = View::make('employees.show', compact('employee', 'listofresearchgroups', 'plannings'));
		}
		else
		{
			Flash::error('Sie besitzen nicht die nötigen Rechte, um diesen Mitarbeiter anzusehen!');
			return Redirect::route('home');
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

		if ( $employee->updateUniques() )
		{
			Flash::success('Das Modul wurde aktualisiert.');
			return Redirect::route('employees.show', $employee->id);
		}
		
		Flash::error($employee->errors());
		return Redirect::route('employees.show', array_get($employee->getOriginal(), 'id'))->withInput();
	}
	
	/**
	 * Remove the specific employee from the database
	 * DELETE /employees/{employee}/delete
	 * 
	 * @param Employee $employee
	 * @return Response
	 */
	public function delete(Employee $employee)
	{
		/*
		 * checking if the employee is already assigned to a midterm planning
		 * if yes, the employee can't be deleted
		 */
		if (sizeof($employee->mediumtermplannings) > 0 || sizeof($employee->plannings) > 0)
		{
			Flash::error('Mitarbeiter kann nicht gelöscht werden, da er bereits in Planungen miteinbezogen wurde.');
			return Redirect::back();
		}

		$employee->delete();
		Flash::success('Mitarbeiter erfolgreich gelöscht');
		return Redirect::back();
	}

	// public function export()
	// {
	// 	$employees = Employee::all();
	// 	$this->layout->content = View::make('employees.export', compact('employees'));
	// }
}