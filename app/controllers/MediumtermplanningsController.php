<?php


use Illuminate\Session\Middleware;
use Illuminate\Support\Facades\Redirect;
class MediumtermplanningsController extends BaseController {
	
	/**
	 * 
	 * @return Response
	 */
	public function index()
	{
// 		$modulesall = Mediumtermplanning::groupTurn()->get();
		$turns = Turn::orderYearName()->get();
		$mtpgrid['modules_all'] = $this->sortModules("Alle");
		$mtpgrid['modules_bachelor'] = $this->sortModules("Bachelor");
		$mtpgrid['modules_master'] = $this->sortModules("Master");
		$mtpgrid['employees_all'] = $this->sortEmployees("Alle");
		$mtpgrid['employees_bachelor'] = $this->sortEmployees("Bachelor");
		$mtpgrid['employees_master'] = $this->sortEmployees("Master");
		
		$this->layout->content = View::make('mediumtermplannings.index', compact('mtpgrid','turns'));
	}
	
	/**
	 * generate the data grid for the overview from the 
	 * perspektive of the modules
	 * 
	 * @param number $degree
	 * @param number $startyear
	 * @param number $turnlimit			Number of entries, which should be fetched from the db
	 */
	public function sortModules($degree = "")
	{
		/*
		 * selecting with the given start year and limited to 10 entries
		 */
		$turns = Turn::orderYearName()->get();
		
		/*
		 * selecting the medium-term plannings
		 */
		$mediumtermplannings = Mediumtermplanning::all();
		
		/*
		 * creating a list of medium-term planning with the module_id as key
		 * and value is an array with turn as key and as value the mediumtermplanning_id
		 */
		$listofmtps = array();
		foreach ($mediumtermplannings as $mtp)
		{
			if (!array_key_exists($mtp->module_id, $listofmtps))
				$listofmtps = array_add($listofmtps, $mtp->module_id, array($mtp->turn_id => $mtp->id));
			else
				$listofmtps[$mtp->module_id] = array_add($listofmtps[$mtp->module_id], $mtp->turn_id, $mtp->id);
		
		}
			
		/*
		 * Grouping the employees with the same mediumtermplanning_id
		*/
		$emps = DB::table('employee_mediumtermplanning')->select('employee_id', 'mediumtermplanning_id', 'annulled', 'semester_periods_per_week')->get();
		$listofemps = array();
		foreach ($emps as $emp)
		{
			if (!array_key_exists($emp->mediumtermplanning_id,$listofemps))
			{
				$listofemps = array_add($listofemps, $emp->mediumtermplanning_id, array(
						$emp->employee_id => array(
								'id' => $emp->employee_id,
								'semester_periods_per_week' => $emp->semester_periods_per_week,
								'annulled' => $emp->annulled)));
			}
			else
			{
				$listofemps[$emp->mediumtermplanning_id] = array_add($listofemps[$emp->mediumtermplanning_id], $emp->employee_id, array(
						'id' => $emp->employee_id,
						'semester_periods_per_week' => $emp->semester_periods_per_week,
						'annulled' => $emp->annulled));
			}
		}
			
		/*
		 * selecting the modules from the specific deparment
		 * no unnessesary modules will be fetch from db
		 * @TODO add where-clause for department selection
		 */
		switch ($degree)
		{
			case "Bachelor":
				$modules = Module::bachelor()->get();
				break;
			case "Master":
				$modules = Module::master()->get();
				break;
			default:
				$modules = Module::all();
			break;
		}
		
		$listofmodules = array();
		foreach ($modules as $module)
		{
			$listofmodules = array_add($listofmodules, $module->id, $module->short);
		}	
			
		// employees
		$listofemployees = Employee::getList();
			
		/*
		 * building the array for the data grid
		* with x layers
		* 1st layer are the modules
		* 2nd layer are the turns
		* 3rd layer are the planned employees
		*/
		$mtpgrid = array();
		if (sizeof($modules) > 0 && sizeof($listofemployees) > 0)
		{
			foreach ($modules as $module)
			{
				$moduledata = array();
				$lastmpid = -1;
				// search through the turns, if the module is planned
				foreach ($turns as $turn)
				{
					$employee = array();
					if (array_key_exists($module->id, $listofmtps))
					{
						if (array_key_exists($turn->id, $listofmtps[$module->id]))
						{
							$mpid = $listofmtps[$module->id][$turn->id]; // get the mediumtermplanning_id
							// Check if this medium-term planning has employees assigned to it
							if (array_key_exists($mpid, $listofemps))
							{
								foreach ( $listofemps[$mpid] as $emp )
								{
									$employee = array_add($employee, $emp['id'], array(
											'employee_id' => $emp['id'],
											'name' => $listofemployees[$emp['id']],
											'semester_periods_per_week' => $emp['semester_periods_per_week'],
											'annulled' => $emp['annulled'],
									));
								}
								$lastmpid = $mpid;
							}							
						}
					}
					$moduledata = array_add($moduledata, $turn->id, $employee);
				}
				$mtpgrid = array_add($mtpgrid, $module->id, array(
						'id' => $module->id,
						'short' => $listofmodules[$module->id],
						'last_mpid' => $lastmpid,
						'turns'=> $moduledata,
				));
			}
		}
		
		return $mtpgrid;
	}
	
	
	/**
	 * generate the data grid for the overview from the 
	 * perspektive of the persons
	 * 
	 * @param string $degree
	 */
	public function sortEmployees($degree = "")
	{
		// selecting with the given start year and limited to 10 entries
		$turns = Turn::orderYearName()->get();

		/*
		 * selecting the medium-term plannings
		*/
		$mediumtermplannings = Mediumtermplanning::all();
		$listofmtps = array();
		foreach ($mediumtermplannings as $mtp)
		{
			if (!array_key_exists($mtp->id, $listofmtps))
			{
				$listofmtps = array_add($listofmtps, $mtp->id, array($mtp->turn_id => $mtp->module_id));
			}
			else
			{
				$listofmtps[$mtp->id] = array_add($listofmtps[$mtp->id], $mtp->turn_id, $mtp->module_id);
			}		
		}
			
		/*
		 * Grouping the employees with the same midterm_planning_id
		*/
		$emps = DB::table('employee_mediumtermplanning')
				->join('employees','employees.id','=','employee_mediumtermplanning.employee_id')
				->select('employee_mediumtermplanning.employee_id', 'employee_mediumtermplanning.mediumtermplanning_id', 'employee_mediumtermplanning.annulled', 'employee_mediumtermplanning.semester_periods_per_week')
				->where('employees.firstname','!=','SHK')
				->get();
		$listofemtps = array();
		foreach ($emps as $emp)
		{
			if (!array_key_exists($emp->employee_id, $listofemtps))
			{
				$listofemtps = array_add($listofemtps, $emp->employee_id, array(
						$emp->mediumtermplanning_id => array(
								'mediumtermplanning_id' => $emp->mediumtermplanning_id,
								'semester_periods_per_week' => $emp->semester_periods_per_week,
							'annulled' => $emp->annulled 
						)
				));
			}
			else 
			{
				$listofemtps[$emp->employee_id] = array_add($listofemtps[$emp->employee_id], $emp->mediumtermplanning_id, array(
						'mediumtermplanning_id' => $emp->mediumtermplanning_id,
						'semester_periods_per_week' => $emp->semester_periods_per_week,
						'annulled' => $emp->annulled
				));
			}
		}

		/*
		 * selecting the modules from the specific deparment
		* no unnessesary modules will be fetch from db
		* @TODO add where-clause for department selection
		*/
		switch ($degree)
		{
			case "Bachelor":
				$modules = Module::bachelor()->get();
				break;
			case "Master":
				$modules = Module::master()->get();
				break;
			default:
				$modules = Module::all();
			break;
		}
		
		$listofmodules = array();
		foreach ($modules as $module)
		{
			$listofmodules = array_add($listofmodules, $module->id, $module->short);
		}
			
			
		// employees
		$employees = Employee::where('firstname','!=','SHK')->get();
			
		/*
		 * building the array for the data grid
		* with x layers
		* 1st layer are the modules
		* 2nd layer are the turns
		* 3rd layer are the planned employees
		*/
		$mtpgrid = array();
		if (sizeof($modules) > 0 && sizeof($employees) > 0)
		{
			foreach ($employees as $employee)
			{
				$employeedata = array ();
				$teaching_load = 0;
				// search though the turns, if employee is assigned to something
				foreach ($turns as $turn)
				{
					$module = array();
					// checking if employee is in the list
					if (array_key_exists($employee->id, $listofemtps))
					{
						foreach ($listofemtps[$employee->id] as $emp)
						{
			
							if (array_key_exists($turn->id, $listofmtps[$emp['mediumtermplanning_id']]))
							{
								if (array_key_exists($listofmtps[$emp['mediumtermplanning_id']][$turn->id],$listofmodules))
								{
									$module = array_add($module, $listofmtps[$emp['mediumtermplanning_id']][$turn->id], array(
											'module_id' => $listofmtps[$emp['mediumtermplanning_id']][$turn->id],
											'short' => $listofmodules[$listofmtps[$emp['mediumtermplanning_id']][$turn->id]],
											'semester_periods_per_week' => $emp['semester_periods_per_week'],
											'annulled' => $emp['annulled'],
									));
									if (!$emp['annulled']){
										$teaching_load += $emp['semester_periods_per_week'];
									}
								}
							}
						}
					}
					$employeedata = array_add($employeedata, $turn->id, $module);
				}
				$mtpgrid = array_add($mtpgrid, $employee->id, array(
						'name' => $employee->name,
						'employee_id' => $employee->id,
						'turns'=> $employeedata,
						'teaching_load' => $teaching_load,
				));
			}
		}
		return $mtpgrid;
	}
	
	// public function export()
	// {
	// 	$mediumtermplannings = Mediumtermplanning::all();
	// 	$employee_mediumtermplanning = DB::table('employee_mediumtermplanning')->select('*')->get();
	// 	$this->layout->content = View::make('mediumtermplannings.export', compact('mediumtermplannings','employee_mediumtermplanning'));
	// }
}