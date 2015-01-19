<?php

use Illuminate\Support\Facades\Redirect;
class OverviewController extends BaseController {

	/**
	 * [getDegreeCourses description]
	 * @return [type] [description]
	 */
	public function showDegreecourses()
	{
		$specialistregulations = Specialistregulation::orderBy('degreecourse_id','ASC')
													->orderBy('turn_id', 'ASC')
													->get();
		$this->layout->content = View::make('overviews.degreecourses', compact('specialistregulations'));
	}

	/**
	 * [getDegreeCourse description]
	 * @param  DegreeCourse $degreecourse [description]
	 * @return [type]                     [description]
	 */
	public function showSelectedDegreecourse(Specialistregulation $specialistregulation)
	{
		$listofsections = Section::lists('name','id');
		$this->layout->content = View::make('overviews.degreecourse', compact('specialistregulation','listofsections'));
	}

	/**
	 * [getCourses description]
	 * @return [type] [description]
	 */
	public function showCourses()
	{
		$courses = Course::with('coursetype')->orderBy('course_number','ASC')->get();
		$this->layout->content = View::make('overviews.courses', compact('courses'));
	}

	/**
	 * [getCourse description]
	 * @param  Course $course [description]
	 * @return [type]         [description]
	 */
	public function showSelectedCourse(Course $course)
	{
		$this->layout->content = View::make('overviews.course', compact('course'));
	}

	/**
	 * [getEmployees description]
	 * @return [type] [description]
	 */
	public function showEmployees()
	{
		$employees = Employee::with('researchgroup')->orderBy('researchgroup_id','ASC')->orderBy('name','ASC')->get();
		$this->layout->content = View::make('overviews.employees', compact('employees'));
	}

	/**
	 * [getEmployee description]
	 * @param  Employee $employee [description]
	 * @return [type]             [description]
	 */
	public function showSelectedEmployee(Employee $employee)
	{
		$listofcoursetypes = Coursetype::orderBy('name', 'ASC')->lists('name','id');
		$this->layout->content = View::make('overviews.employee', compact('employee','listofcoursetypes'));
	}

	/**
	 * [getModules description]
	 * @return [type] [description]
	 */
	public function showModules()
	{
		$modules = Module::orderBy('short','ASC')->get();
		$this->layout->content = View::make('overviews.modules', compact('modules'));
	}

	/**
	 * [getModule description]
	 * @param  Module $module [description]
	 * @return [type]         [description]
	 */
	public function showSelectedModule(Module $module)
	{
		$listofsections = Section::orderBy('name', 'ASC')->lists('name','id');
		$this->layout->content = View::make('overviews.module', compact('module','listofsections'));
	}

	/**
	 * [getTableResearchgroups description]
	 * @param  Turn   $turn [description]
	 * @return [type]       [description]
	 */
	public function getTableResearchgroups(Turn $turn)
	{
		// turn navigation
		$turnNav = $this->getTurnNav($turn);

		// researchgroups
		$researchgroups = Researchgroup::orderBy('short','ASC')->get();
		$output = array();
		foreach ($researchgroups as $rg) {
			$rg_plannings =  DB::table('plannings')
								->join('employee_planning','employee_planning.planning_id','=','plannings.id')
								->join('employees','employees.id','=','employee_planning.employee_id')
								->select('plannings.id')
								->where('plannings.turn_id','=',$turn->id)
								->where('employees.researchgroup_id','=',$rg->id)
								->groupBy('plannings.id')
								->get();
			$rg_pl_ids = array();
			if (sizeof($rg_plannings) > 0)
			{
				foreach ($rg_plannings as $rg_pl) {
					array_push($rg_pl_ids, $rg_pl->id);
				}
			}

			if (sizeof($rg_pl_ids) > 0)
				$plannings = Planning::with('course')->whereIn('id',$rg_pl_ids)->orderBy('course_number','ASC')->get();
			else
				$plannings = array();

			if (sizeof($plannings) > 0)
			{
				$rg = array(
					'name' => $rg->name,
					'short' => $rg->short,
					'plannings' => $plannings);
				array_push($output, $rg);
			}
		}
		$this->layout->content = View::make('overviews.table_researchgroups', compact('turnNav','output'));
	}

	/**
	 * [getTablePlannings description]
	 * @param  Turn   $turn [description]
	 * @return [type]       [description]
	 */
	public function getTablePlannings(Turn $turn)
	{
		// turn navigation
		$turnNav = $this->getTurnNav($turn);

		// plannings
		$plannings = Planning::with('course')->where('turn_id','=', $turn->id)->orderBy('course_number','ASC')->groupBy('course_id')->get();
		$plannings_data = array();
		$result = DB::table('plannings')
								->select(DB::raw('count(*) as groups, course_id'))
								->where('turn_id','=',$turn->id)
								->groupBy('course_id')
								->get();
		if (sizeof($result) > 0)
		{
			foreach ($result as $res) {
				$plannings_data[$res->course_id] = array();
				$plannings_data[$res->course_id]['groups'] = $res->groups;
				$plannings_data[$res->course_id]['employees'] = array();
			}
		}

		$result = DB::table('plannings')
						->join('employee_planning','employee_planning.planning_id','=','plannings.id')
						->select(DB::raw('sum(employee_planning.semester_periods_per_week) as sppw, plannings.course_id, employee_planning.employee_id'))
						->where('plannings.turn_id','=',$turn->id)
						->groupBy('plannings.course_id')
						->groupBy('employee_planning.employee_id')
						->get();
		if (sizeof($result) > 0)
		{
			foreach ($result as $res) {
				$employee = Employee::find($res->employee_id);
				$e = array('semester_periods_per_week' => $res->sppw, 'employee' => $employee);
				array_push($plannings_data[$res->course_id]['employees'], $e); 
			}
		}
		// print_r($employees);
		
		$this->layout->content = View::make('overviews.table_plannings', compact('turnNav', 'plannings','plannings_data'));
	}

	/**
	 * [showExams description]
	 * @param  Turn   $turn [description]
	 * @return [type]       [description]
	 */
	public function showExams(Turn $turn)
	{
		// turn navigation
		$turnNav = $this->getTurnNav($turn);

		$this->layout->content = View::make('overviews.exams', compact('turnNav'));
	}

	/**
	 * [showShk description]
	 * @param  Turn   $turn [description]
	 * @return [type]       [description]
	 */
	public function showStudentAssistants(Turn $turn)
	{
		// turn navigation
		$turnNav = $this->getTurnNav($turn);
		
		$shkplannings = DB::table('plannings')
							->join('employee_planning','employee_planning.planning_id','=','plannings.id')
							->join('employees','employees.id','=','employee_planning.employee_id')
							->select('plannings.id','employee_planning.semester_periods_per_week')
							->where('employees.firstname','=','SHK')
							->where('plannings.turn_id','=',$turn->id)
							->get();
		$planningIds = array();
		$semester_periods_per_week_total = 0;
		foreach ($shkplannings as $shk) 
		{
			array_push($planningIds, $shk->id);
			$semester_periods_per_week_total += $shk->semester_periods_per_week;
		}
		if (sizeof($planningIds) > 0)
		{
			$plannings = Planning::whereIn('id',$planningIds)->get();
		}
		else
		{
			$plannings = array();
		}
		$this->layout->content = View::make('overviews.studentAssistants', compact('plannings', 'turnNav', 'semester_periods_per_week_total'));
	}
}