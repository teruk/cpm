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
		$employees = array();
		if (Entrust::hasRole('Admin') || Entrust::can('view_planning')) // todo replace role Lehrplanung with permission
			$employees = Employee::all();
		else 
		{
			if (sizeof(Entrust::user()->researchgroups) > 0)
			{
				$rg_ids = array();
				foreach (Entrust::user()->researchgroups as $rg) {
					array_push($rg_ids, $rg->id);
				}
				$employees = Employee::whereIn('researchgroup_id',$rg_ids)->orderBy('name','ASC')->get();
			}
		}

		// getting course plannings for current semester
		$planned_courses = array();
		if (Entrust::hasRole('Admin') || Entrust::can('view_planning'))
			$planned_courses = Planning::turnCourses($turn)->get();
		else
		{
			if (sizeof(Entrust::user()->researchgroups) > 0)
			{
				$rg_ids = array();
				foreach (Entrust::user()->researchgroups as $rg) {
					array_push($rg_ids, $rg->id);
				}
				$planned_courses = DB::table('plannings')
					->join('employee_planning','employee_planning.planning_id', '=', 'plannings.id')
					->join('employees', 'employees.id','=','employee_planning.employee_id')
					->join('researchgroups', 'researchgroups.id', '=', 'employees.researchgroup_id')
					->select('plannings.id')
					->whereIn('researchgroups.id',$rg_ids)
					->where('plannings.turn_id','=', $turn->id)
					->groupBy('plannings.id')
					->get();
				$planning_ids = array();
				if (sizeof($planned_courses) > 0)
				{
					foreach ($planned_courses as $p) {
						array_push($planning_ids, $p->id);
					}
				}
				else {
					$planned_courses = array();
				}
				$planned_courses_user = Planning::where('user_id','=',Entrust::user()->id)->where('turn_id','=',$turn->id)->groupBy('id')->get();
				if (sizeof($planned_courses_user) > 0)
				{
					foreach ($planned_courses_user as $p) {
						if (!array_key_exists($p->id, $planning_ids))
						{
							array_push($planning_ids, $p->id);
						}
					}
				}
				// plannings by medium-term planning
				// the target is to find plannings, where two pr more research groups are involved
				// if one of the research groups creates the planning, the other ones have to see it
				$planned_courses_mediumtermplanning = DB::table('plannings')
														->join('courses','courses.id','=','plannings.course_id')
														->join('mediumtermplannings','mediumtermplannings.module_id','=','courses.module_id')
														->join('employee_mediumtermplanning','employee_mediumtermplanning.mediumtermplanning_id','=','mediumtermplannings.id')
														->join('employees','employee_mediumtermplanning.employee_id','=','employees.id')
														->select('plannings.id')
														->where('plannings.turn_id','=',$turn->id)
														->where('user_id','!=', Entrust::user()->id)
														->whereIn('employees.researchgroup_id',$rg_ids)
														->groupBy('plannings.id')
														->get();
				if (sizeof($planned_courses_mediumtermplanning) > 0)
				{
					foreach ($planned_courses_mediumtermplanning as $p) {
						if (!in_array($p->id, $planning_ids))
							array_push($planning_ids, $p->id);
					}
				}

				if (sizeof($planning_ids) > 0)
					$planned_courses = Planning::related($planning_ids)->get();
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
		$this->layout->content = View::make('home', compact('turn', 'turns','announcements','appointeddays','employees','planned_courses','listofcoursetypes', 'mtpgrid', 'planninglog','deleted_planninglogs'));
	}

	/**
	* 
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
		$turn_ids = array();
		foreach ($turns as $t) {
			array_push($turn_ids, $t->id);
		}
		$employee_ids = array();
		foreach ($employees as $e) {
			array_push($employee_ids, $e->id);
		}
		// $mediumtermplannings = Mediumtermplanning::whereIn('turn_id',$turn_ids)->get();
		$mediumtermplannings = DB::table('mediumtermplannings')
									->join('employee_mediumtermplanning','employee_mediumtermplanning.mediumtermplanning_id','=','mediumtermplannings.id')
									->select('mediumtermplannings.turn_id','mediumtermplannings.module_id','mediumtermplannings.id')
									->whereIn('mediumtermplannings.turn_id', $turn_ids)
									->whereIn('employee_mediumtermplanning.employee_id', $employee_ids)
									->get();
		
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
		$emps = DB::table('employee_mediumtermplanning')
				->select('employee_id', 'mediumtermplanning_id', 'annulled', 'semester_periods_per_week')
				->whereIn('employee_id', $employee_ids)
				->get();
		$listofemps = array();
		foreach ($emps as $emp)
		{
			if (!array_key_exists($emp->mediumtermplanning_id,$listofemps))
				$listofemps = array_add($listofemps, $emp->mediumtermplanning_id, array(
						$emp->employee_id => array(
								'id' => $emp->employee_id,
								'semester_periods_per_week' => $emp->semester_periods_per_week,
								'annulled' => $emp->annulled)));
			else
				$listofemps[$emp->mediumtermplanning_id] = array_add($listofemps[$emp->mediumtermplanning_id], $emp->employee_id, array(
						'id' => $emp->employee_id,
						'semester_periods_per_week' => $emp->semester_periods_per_week,
						'annulled' => $emp->annulled));
		}
		
		$modules = array();
		if (Entrust::hasRole('Admin') || Entrust::can('view_planning'))
			$modules = Module::all();
		else
		{

			$module_ids = array();
			foreach ($mediumtermplannings as $mtp) {
				array_push($module_ids, $mtp->module_id);
			}
			$modules = array();
			if (sizeof($module_ids) > 0)
				$modules = Module::whereIn('id',$module_ids)->get();
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
						'short' => $module->short,
						'last_mpid' => $lastmpid,
						'turns'=> $moduledata,
				));
			}
		}
		
		return $mtpgrid;
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