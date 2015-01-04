<?php

use Illuminate\Support\Facades\Redirect;
class OverviewController extends BaseController {

	/**
	 * [getDegreeCourses description]
	 * @return [type] [description]
	 */
	public function getDegreeCourses()
	{
		$degreecourses = DegreeCourse::orderBy('degree_id','ASC')->orderBy('name','ASC')->get();
		$this->layout->content = View::make('overviews.degreecourses', compact('degreecourses'));
	}

	/**
	 * [getDegreeCourse description]
	 * @param  DegreeCourse $degreecourse [description]
	 * @return [type]                     [description]
	 */
	public function getDegreeCourse(DegreeCourse $degreecourse)
	{
		$listofsections = Section::lists('name','id');
		$this->layout->content = View::make('overviews.degreecourse', compact('degreecourse','listofsections'));
	}

	/**
	 * [getCourses description]
	 * @return [type] [description]
	 */
	public function getCourses()
	{
		$courses = Course::orderBy('course_number','ASC')->get();
		$listofcoursetypes = Coursetype::orderBy('name', 'ASC')->lists('name','id');
		$this->layout->content = View::make('overviews.courses', compact('courses','listofcoursetypes'));
	}

	/**
	 * [getCourse description]
	 * @param  Course $course [description]
	 * @return [type]         [description]
	 */
	public function getCourse(Course $course)
	{
		$listofcoursetypes = Coursetype::orderBy('name', 'ASC')->lists('name','id');
		$this->layout->content = View::make('overviews.course', compact('course','listofcoursetypes'));
	}

	/**
	 * [getEmployees description]
	 * @return [type] [description]
	 */
	public function getEmployees()
	{
		$employees = Employee::orderBy('researchgroup_id','ASC')->orderBy('name','ASC')->get();
		$this->layout->content = View::make('overviews.employees', compact('employees'));
	}

	/**
	 * [getEmployee description]
	 * @param  Employee $employee [description]
	 * @return [type]             [description]
	 */
	public function getEmployee(Employee $employee)
	{
		$listofcoursetypes = Coursetype::orderBy('name', 'ASC')->lists('name','id');
		$this->layout->content = View::make('overviews.employee', compact('employee','listofcoursetypes'));
	}

	/**
	 * [getModules description]
	 * @return [type] [description]
	 */
	public function getModules()
	{
		$modules = Module::orderBy('short','ASC')->get();
		$this->layout->content = View::make('overviews.modules', compact('modules'));
	}

	/**
	 * [getModule description]
	 * @param  Module $module [description]
	 * @return [type]         [description]
	 */
	public function getModule(Module $module)
	{
		$listofsections = Section::orderBy('name', 'ASC')->lists('name','id');
		$listofcoursetypes = Coursetype::orderBy('name', 'ASC')->lists('name','id');
		$this->layout->content = View::make('overviews.module', compact('module','listofsections','listofcoursetypes'));
	}

	/**
	 * [tableReseachgroups description]
	 * @return [type] [description]
	 */
	public function tableReseachgroups()
	{
		$turn = Turn::find(Setting::setting('current_turn')->first()->value);
		return Redirect::route('overview.tableResearchgroups', $turn->id);
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
	 * [tablePlannings description]
	 * @return [type] [description]
	 */
	public function tablePlannings()
	{
		$turn = Turn::find(Setting::setting('current_turn')->first()->value);
		return Redirect::route('overview.tablePlannings', $turn->id);
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
	 * [exams description]
	 * @return [type] [description]
	 */
	public function exams()
	{
		$turn = Turn::find(Setting::setting('current_turn')->first()->value);
		return Redirect::route('overview.showExams', $turn->id);
	}

	/**
	 * [shk description]
	 * @return [type] [description]
	 */
	public function shk()
	{
		$current_turn = Turn::find(Setting::setting('current_turn')->first()->value);
		return Redirect::route('overview.showShk',$current_turn->id);
	}

	/**
	 * [showShk description]
	 * @param  Turn   $turn [description]
	 * @return [type]       [description]
	 */
	public function showShk(Turn $turn)
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
		$planning_ids = array();
		$semester_periods_per_week_total = 0;
		foreach ($shkplannings as $shk) 
		{
			array_push($planning_ids, $shk->id);
			$semester_periods_per_week_total += $shk->semester_periods_per_week;
		}
		if (sizeof($planning_ids) > 0)
		{
			$plannings = Planning::whereIn('id',$planning_ids)->get();
		}
		else
		{
			$plannings = array();
		}
		$this->layout->content = View::make('overviews.shk', compact('plannings', 'turnNav', 'semester_periods_per_week_total'));
	}

	/**
	 * [showRoomSearch description]
	 * @return [type] [description]
	 */
	public function showRoomSearch()
	{
		if(Session::get('result') == "")
			$searchresults = array();
		else
			$searchresults = Session::get('result');

		if(Session::get('turn') == "")
			$turn = Turn::find(Setting::setting('current_turn')->first()->value);
		else
			$turn = Turn::find(Session::get('turn'));

		$turns = Turn::getList();
		$roomtypes = RoomType::lists('name','id');
		$this->layout->content = View::make('overviews.room_search', compact('searchresults','turns','roomtypes','turn'));
	}

	/**
	 * [roomSearch description]
	 * @return [type] [description]
	 */
	public function roomSearch()
	{
		$starttime = date('H:i:s', strtotime(Input::get('start_time')));
		$endtime = date('H:i:s', strtotime(Input::get('end_time')));
		$maxseats = 10000;
		if (Input::get('max_seats') >= Input::get('min_seats') || Input::get('max_seats') == "")
		{
			if (Input::get('max_seats') != "")
			{
				$maxseats = Input::get('max_seats');
			}
			$results = DB::table('planning_room')
						->join('plannings', 'planning_room.planning_id','=','plannings.id')
						->join('rooms','rooms.id','=','planning_room.room_id')
						->select('rooms.id')
						->where('plannings.turn_id', '=', Input::get('turn_id')) // Import to select ohne results from the same turn
						->where('planning_room.weekday','=' ,Input::get('weekday'))
						->where('rooms.roomtype_id','=', Input::get('room_type_id'))
						->where(function($query) use ($starttime, $endtime)
						{
							$query->where(function($q1) use ($starttime){
								$q1->where('planning_room.start_time', '<', $starttime)
								->where('planning_room.end_time', '>', $starttime);
							})
							->orWhere(function ($q2) use ($endtime){
								$q2->where('planning_room.start_time', '<', $endtime)
								->where('planning_room.end_time', '>', $endtime);
							})
							->orWhere(function ($q3) use ($starttime, $endtime){
								$q3->where('planning_room.start_time', '=', $starttime)
								->where('planning_room.end_time', '=', $endtime);
							})
							->orWhere(function ($q4) use ($starttime, $endtime){
								$q4->where('planning_room.start_time', '=', $starttime)
								->where('planning_room.end_time', '<', $endtime);
							})
							->orWhere(function ($q5) use ($starttime, $endtime){
								$q5->where('planning_room.start_time', '>', $starttime)
								->where('planning_room.end_time', '=', $endtime);
							})
							->orWhere(function ($q6) use ($starttime, $endtime){
								$q6->where('planning_room.start_time', '>', $starttime)
								->where('planning_room.end_time', '<', $endtime);
							});
						})
						->orderBy('seats','ASC')
						->get();
			$room_ids = array();
			foreach ($results as $res) {
				array_push($room_ids, $res->id);
			}
			$result = array();
			if (sizeof($room_ids) > 0)
			{
				$result = Room::where('roomtype_id','=', Input::get('room_type_id'))
								->where('seats','>=', Input::get('min_seats'))
								->where('seats', '<=', $maxseats)
								->whereNotIn('id',$room_ids)
								->get();
			}
			else
			{
				$result = Room::where('roomtype_id','=', Input::get('room_type_id'))
								->where('seats','>=', Input::get('min_seats'))
								->where('seats', '<=', $maxseats)
								->get();
			}
			if (sizeof($result) > 0)
				return Redirect::route('overview.showRoomSearch')->withInput()->with('result', $result)->with('turn', Input::get('turn_id'));
			else
			{
				Flash::error('Keine freien Räume gefunden!');
				return Redirect::route('overview.showRoomSearch')->withInput();
			}
		}

		Flash::error('Fehlerhafte Eingabe! Die maximale Platzanzahl ist kleiner als die minimale Platzanzahl!');
		return Redirect::route('overview.showRoomSearch')->withInput();
	}

}