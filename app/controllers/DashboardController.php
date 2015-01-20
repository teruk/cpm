<?php

use Illuminate\Support\Facades\Input;
class DashboardController extends BaseController {

	/**
	* get information (announcements, employees, etc)
	*/
	public function getDashboard()
	{
		$turn = Turn::find(Setting::setting('current_turn')->first()->value);
		$announcements = Announcement::orderBy('created_at','DESC')->take(3)->get();
		$appointeddays = Appointedday::where('date', '>=', date('Y-m-d'))->orderBy('date', 'ASC')->take(6)->get();
		// getting employees
		$employees = [];
		if (Entrust::hasRole('Admin') || Entrust::can('view_planning')) // todo replace role Lehrplanung with permission
			$employees = Employee::all();
		else {
			if (sizeof(Entrust::user()->getResearchgroupIds()) > 0) {
				$researchgroupsIds = Entrust::user()->getResearchgroupIds();
				$employees = Employee::whereIn('researchgroup_id',$researchgroupsIds)->orderBy('name','ASC')->get();
			}
		}

		// getting course plannings for current semester
		$plannedCourses = array();
		if (Entrust::hasRole('Admin') || Entrust::can('view_planning'))
			$plannedCourses = Planning::turnCourses($turn)->get();
		else {
			if (sizeof(Entrust::user()->researchgroups) > 0) {
				$researchgroupsIds = array();
				foreach (Entrust::user()->researchgroups as $researchgroup) {
					array_push($researchgroupsIds, $researchgroup->id);
				}
				$plannedCourses = DB::table('plannings')
					->join('employee_planning','employee_planning.planning_id', '=', 'plannings.id')
					->join('employees', 'employees.id','=','employee_planning.employee_id')
					->join('researchgroups', 'researchgroups.id', '=', 'employees.researchgroup_id')
					->select('plannings.id')
					->whereIn('researchgroups.id', $researchgroupsIds)
					->where('plannings.turn_id','=', $turn->id)
					->groupBy('plannings.id')
					->get();
				$planningIds = array();

				if (sizeof($plannedCourses) > 0) {
					foreach ($plannedCourses as $p) {
						array_push($planningIds, $p->id);
					}
				} else {
					$plannedCourses = array();
				}

				$plannedCoursesByUser = Planning::where('user_id','=',Entrust::user()->id)
											->where('turn_id','=',$turn->id)
											->groupBy('id')
											->get();

				if (sizeof($plannedCoursesByUser) > 0) {
					foreach ($plannedCoursesByUser as $p) {
						if (!array_key_exists($p->id, $planningIds)) {
							array_push($planningIds, $p->id);
						}
					}
				}
				// plannings by medium-term planning
				// the target is to find plannings, where two pr more research groups are involved
				// if one of the research groups creates the planning, the other ones have to see it
				$plannedCoursesByMediumtermplanning = DB::table('plannings')
														->join('courses','courses.id','=','plannings.course_id')
														->join('mediumtermplannings','mediumtermplannings.module_id','=','courses.module_id')
														->join('employee_mediumtermplanning','employee_mediumtermplanning.mediumtermplanning_id','=','mediumtermplannings.id')
														->join('employees','employee_mediumtermplanning.employee_id','=','employees.id')
														->select('plannings.id')
														->where('plannings.turn_id','=',$turn->id)
														->where('user_id','!=', Entrust::user()->id)
														->whereIn('employees.researchgroup_id',$researchgroupsIds)
														->groupBy('plannings.id')
														->get();
				if (sizeof($plannedCoursesByMediumtermplanning) > 0) {
					foreach ($plannedCoursesByMediumtermplanning as $p) {
						if (!in_array($p->id, $planningIds))
							array_push($planningIds, $p->id);
					}
				}

				if (sizeof($planningIds) > 0)
					$plannedCourses = Planning::related($planningIds)->get();
			}
		}
		$listofcoursetypes = CourseType::lists('short','id');
		$turns = $this->getTurns();

		// get medium-term planning
		if (Entrust::hasRole('Admin') || sizeof(Entrust::user()->researchgroups) > 0 || Entrust::can('view_planning'))
			$mtpgrid = $this->sortModules($employees);
		else
			$mtpgrid = array();

		// get planning logs
		$planninglog = Planninglog::where('id', '>', 0)->orderBy('created_at','DESC')->get();
		$deleted_planninglogs = array();
		foreach ($planninglog as $pl) {
			if ($pl->category == 0 && $pl->action_type == 2)
				array_push($deleted_planninglogs, $pl->planning_id);
		}

		// make view
		return View::make('pages.home', compact('turn', 'turns','announcements','appointeddays','employees','plannedCourses','listofcoursetypes', 'mtpgrid', 'planninglog','deleted_planninglogs'));
	}

	/**
	 * sorts mediumterm plannings by module
	 * @param  [type] $employees [description]
	 * @return [type]            [description]
	 */
	private function sortModules($employees)
	{
		/*
		 * selecting with the given start year and limited to entries
		 */
		// $turns = Turn::orderYearName()->get();
		$turns = $this->getTurns();
		
		/*
		 * selecting the medium-term plannings
		 */
		$turnIds = array();
		foreach ($turns as $t) {
			array_push($turnIds, $t->id);
		}

		$employeeIds = array();
		foreach ($employees as $e) {
			array_push($employeeIds, $e->id);
		}
		// $mediumtermplannings = Mediumtermplanning::whereIn('turn_id',$turn_ids)->get();
		$mediumtermplannings = DB::table('mediumtermplannings')
									->join('employee_mediumtermplanning','employee_mediumtermplanning.mediumtermplanning_id','=','mediumtermplannings.id')
									->select('mediumtermplannings.turn_id','mediumtermplannings.module_id','mediumtermplannings.id')
									->whereIn('mediumtermplannings.turn_id', $turnIds)
									->whereIn('employee_mediumtermplanning.employee_id', $employeeIds)
									->get();
		
		/*
		 * creating a list of medium-term planning with the module_id as key
		 * and value is an array with turn as key and as value the mediumtermplanning_id
		 */
		$listOfMediumtermplannings = array();
		foreach ($mediumtermplannings as $mediumtermplanning)
		{
			if (!array_key_exists($mediumtermplanning->module_id, $listOfMediumtermplannings))
				$listOfMediumtermplannings = array_add(
					$listOfMediumtermplannings, 
					$mediumtermplanning->module_id, 
					array($mediumtermplanning->turn_id => $mediumtermplanning->id)
					);
			else
				$listOfMediumtermplannings[$mediumtermplanning->module_id] = array_add(
					$listOfMediumtermplannings[$mediumtermplanning->module_id],
					$mediumtermplanning->turn_id,
					$mediumtermplanning->id
					);
		
		}
			
		/*
		 * Grouping the employees with the same mediumtermplanning_id
		*/
		$employeeMediumtermplannings = DB::table('employee_mediumtermplanning')
										->select('employee_id', 'mediumtermplanning_id', 'annulled', 'semester_periods_per_week')
										->whereIn('employee_id', $employeeIds)
										->get();
		$listOfEmployeeMediumtermplannings = array();
		foreach ($employeeMediumtermplannings as $employeeMediumtermplanning) {
			if (!array_key_exists($employeeMediumtermplanning->mediumtermplanning_id,$listOfEmployeeMediumtermplannings)) {
				$listOfEmployeeMediumtermplannings = array_add(
					$listOfEmployeeMediumtermplannings, 
					$employeeMediumtermplanning->mediumtermplanning_id, 
					array(
						$employeeMediumtermplanning->employee_id => array(
							'id' => $employeeMediumtermplanning->employee_id,
							'semester_periods_per_week' => $employeeMediumtermplanning->semester_periods_per_week,
							'annulled' => $employeeMediumtermplanning->annulled
							)
						)
					);
			} else {
				$listOfEmployeeMediumtermplannings[$employeeMediumtermplanning->mediumtermplanning_id] = array_add(
					$listOfEmployeeMediumtermplannings[$employeeMediumtermplanning->mediumtermplanning_id], 
					$employeeMediumtermplanning->employee_id, 
					array(
						'id' => $employeeMediumtermplanning->employee_id,
						'semester_periods_per_week' => $employeeMediumtermplanning->semester_periods_per_week,
						'annulled' => $employeeMediumtermplanning->annulled
						)
					);
			}
		}
		
		$modules = array();
		if (Entrust::hasRole('Admin') || Entrust::can('view_planning'))
			$modules = Module::all();
		else {

			$moduleIds = array();
			foreach ($mediumtermplannings as $mtp) {
				array_push($moduleIds, $mtp->module_id);
			}
			$modules = array();

			if (sizeof($moduleIds) > 0)
				$modules = Module::whereIn('id',$moduleIds)->get();
		}
		
		
		// employees
		$listOfEmployees = Employee::getList();
			
		/*
		 * building the array for the data grid
		* with x layers
		* 1st layer are the modules
		* 2nd layer are the turns
		* 3rd layer are the planned employees
		*/
		$mediumtermplanningGrid = array();
		if (sizeof($modules) > 0 && sizeof($listOfEmployees) > 0) {

			foreach ($modules as $module) {
				$moduleData = array();
				$lastMediumtermplanningId = -1;
				// search through the turns, if the module is planned
				foreach ($turns as $turn) {

					$employee = array();
					if (array_key_exists($module->id, $listOfMediumtermplannings)) {

						if (array_key_exists($turn->id, $listOfMediumtermplannings[$module->id])) {
							$mediumtermplanningId = $listOfMediumtermplannings[$module->id][$turn->id]; // get the mediumtermplanning_id
							// Check if this medium-term planning has employees assigned to it
							// 
							if (array_key_exists($mediumtermplanningId, $listOfEmployeeMediumtermplannings)) {
								foreach ( $listOfEmployeeMediumtermplannings[$mediumtermplanningId] as $employeeMediumtermplanning ) {
									$employee = array_add(
										$employee, 
										$employeeMediumtermplanning['id'], 
										array(
											'employee_id' => $employeeMediumtermplanning['id'],
											'name' => $listOfEmployees[$employeeMediumtermplanning['id']],
											'semester_periods_per_week' => $employeeMediumtermplanning['semester_periods_per_week'],
											'annulled' => $employeeMediumtermplanning['annulled'],
											)
										);
								}
								$lastMediumtermplanningId = $mediumtermplanningId;
							}							
						}
					}
					$moduleData = array_add($moduleData, $turn->id, $employee);
				}
				$mediumtermplanningGrid = array_add($mediumtermplanningGrid, $module->id, array(
						'id' => $module->id,
						'short' => $module->short,
						'last_mpid' => $lastMediumtermplanningId,
						'turns'=> $moduleData,
				));
			}
		}
		
		return $mediumtermplanningGrid;
	}

	/**
	* get current turn
	*/
	private function getTurns()
	{
		$turn = Turn::find(Setting::setting('current_turn')->first()->value);
		if ($turn->name == "SoSe")
			$turns = Turn::where('year','>=', $turn->year)
						// ->where('id','!=', $turn->id)
						->orderBy('year','ASC')
						->orderBy('name','ASC')
						->take(5)
						->get();
		else 
			$turns = Turn::where('year','>=', $turn->year)
						// ->where('id','!=', $turn->id)
						->orderBy('year','ASC')
						->orderBy('name','ASC')
						->take(5)
						->get();

		return $turns;
	}
}
