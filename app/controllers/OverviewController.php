<?php

use Illuminate\Support\Facades\Redirect;
class OverviewController extends BaseController {

	public function getDegreeCourses()
	{
		$degreecourses = DegreeCourse::orderBy('degree_id','ASC')->orderBy('name','ASC')->get();
		$this->layout->content = View::make('overviews.degreecourses', compact('degreecourses'));
	}

	public function getDegreeCourse(DegreeCourse $degreecourse)
	{
		$listofsections = Section::lists('name','id');
		$this->layout->content = View::make('overviews.degreecourse', compact('degreecourse','listofsections'));
	}

	public function getCourses()
	{
		$courses = Course::orderBy('course_number','ASC')->get();
		$listofcoursetypes = CourseType::orderBy('name', 'ASC')->lists('name','id');
		$this->layout->content = View::make('overviews.courses', compact('courses','listofcoursetypes'));
	}

	public function getCourse(Course $course)
	{
		$listofcoursetypes = CourseType::orderBy('name', 'ASC')->lists('name','id');
		$this->layout->content = View::make('overviews.course', compact('course','listofcoursetypes'));
	}

	public function getEmployees()
	{
		$employees = Employee::orderBy('researchgroup_id','ASC')->orderBy('name','ASC')->get();
		$this->layout->content = View::make('overviews.employees', compact('employees'));
	}

	public function getEmployee(Employee $employee)
	{
		$listofcoursetypes = CourseType::orderBy('name', 'ASC')->lists('name','id');
		$this->layout->content = View::make('overviews.employee', compact('employee','listofcoursetypes'));
	}

	public function getModules()
	{
		$modules = Module::orderBy('short','ASC')->get();
		$this->layout->content = View::make('overviews.modules', compact('modules'));
	}

	public function getModule(Module $module)
	{
		$listofsections = Section::orderBy('name', 'ASC')->lists('name','id');
		$listofcoursetypes = CourseType::orderBy('name', 'ASC')->lists('name','id');
		$this->layout->content = View::make('overviews.module', compact('module','listofsections','listofcoursetypes'));
	}

	public function tableReseachgroups()
	{
		$turn = Turn::find(Setting::setting('current_turn')->first()->value);
		return Redirect::route('overview.tableResearchgroups', $turn->id);
	}

	public function getTableResearchgroups(Turn $turn)
	{
		// turn settings
		$current_turn = Turn::find(Setting::setting('current_turn')->first()->value);
		$next_turn = Turn::nextTurn($current_turn)->first();
		$afternext_turn = Turn::turnAfterNext($current_turn)->first();
		// set the turn which will be displayed
		$display_turn = $turn;
		$before_turns = Turn::beforeTurns($display_turn)->get();

		$listofcoursetypes = CourseType::orderBy('short', 'ASC')->lists('short','id');

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
			{
				$plannings = Planning::whereIn('id',$rg_pl_ids)->orderBy('course_number','ASC')->get();
			}
			else
			{
				$plannings = array();
			}

			if (sizeof($plannings) > 0)
			{
				$rg = array(
					'name' => $rg->name,
					'short' => $rg->short,
					'plannings' => $plannings);
				array_push($output, $rg);
			}
		}
		$this->layout->content = View::make('overviews.table_researchgroups', compact('current_turn','next_turn', 'afternext_turn','before_turns', 'display_turn', 'listofcoursetypes','output'));
	}

	public function tablePlannings()
	{
		$turn = Turn::find(Setting::setting('current_turn')->first()->value);
		return Redirect::route('overview.tablePlannings', $turn->id);
	}

	public function getTablePlannings(Turn $turn)
	{
		// turn settings
		$current_turn = Turn::find(Setting::setting('current_turn')->first()->value);
		$next_turn = Turn::nextTurn($current_turn)->first();
		$afternext_turn = Turn::turnAfterNext($current_turn)->first();
		// set the turn which will be displayed
		$display_turn = $turn;
		$before_turns = Turn::beforeTurns($display_turn)->get();

		$listofcoursetypes = CourseType::orderBy('name', 'ASC')->lists('short','id');
		// plannings
		$plannings = Planning::where('turn_id','=', $turn->id)->orderBy('course_number','ASC')->groupBy('course_id')->get();
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
		
		$this->layout->content = View::make('overviews.table_plannings', compact('current_turn','next_turn', 'afternext_turn','before_turns', 'display_turn', 'listofcoursetypes','plannings','plannings_data'));
	}

	public function showExams(Turn $turn)
	{
		// turn settings
		$current_turn = Turn::find(Setting::setting('current_turn')->first()->value);
		$next_turn = Turn::nextTurn($current_turn)->first();
		$afternext_turn = Turn::turnAfterNext($current_turn)->first();
		// set the turn which will be displayed
		$display_turn = $turn;
		$before_turns = Turn::beforeTurns($display_turn)->get();

		$this->layout->content = View::make('overviews.exams', compact('current_turn','next_turn', 'afternext_turn','before_turns', 'display_turn'));
	}

	public function exams()
	{
		$turn = Turn::find(Setting::setting('current_turn')->first()->value);
		return Redirect::route('overview.showExams', $turn->id);
	}

	public function shk()
	{
		$current_turn = Turn::find(Setting::setting('current_turn')->first()->value);
		return Redirect::route('overview.showShk',$current_turn->id);
	}

	public function showShk(Turn $turn)
	{
		$current_turn = Turn::find(Setting::setting('current_turn')->first()->value);
		$next_turn = Turn::nextTurn($current_turn)->first();
		$afternext_turn = Turn::turnAfterNext($current_turn)->first();
		// set the turn which will be displayed
		$display_turn = $turn;
		$before_turns = Turn::beforeTurns($display_turn)->get();
		
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
		$this->layout->content = View::make('overviews.shk', compact('plannings', 'current_turn', 'next_turn', 'afternext_turn', 'display_turn','before_turns',
			'semester_periods_per_week_total'));
	}

	public function showRoomSearch()
	{
		if(Session::get('result') == "")
		{
			$searchresults = array();
		}
		else
		{
			$searchresults = Session::get('result');
		}
		if(Session::get('turn') == "")
		{
			$turn = Turn::find(Setting::setting('current_turn')->first()->value);
		}
		else
		{
			$turn = Turn::find(Session::get('turn'));
		}
		$turns = Turn::getList();
		$roomtypes = RoomType::lists('name','id');
		$this->layout->content = View::make('overviews.room_search', compact('searchresults','turns','roomtypes','turn'));
	}

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
						->where('rooms.room_type_id','=', Input::get('room_type_id'))
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
				$result = Room::where('room_type_id','=', Input::get('room_type_id'))
								->where('seats','>=', Input::get('min_seats'))
								->where('seats', '<=', $maxseats)
								->whereNotIn('id',$room_ids)
								->get();
			}
			else
			{
				$result = Room::where('room_type_id','=', Input::get('room_type_id'))
								->where('seats','>=', Input::get('min_seats'))
								->where('seats', '<=', $maxseats)
								->get();
			}
			if (sizeof($result) > 0)
				return Redirect::route('overview.showRoomSearch')->withInput()->with('result', $result)->with('turn', Input::get('turn_id'));
			else
				return Redirect::route('overview.showRoomSearch')->withInput()->with('error', 'Keine freien Räume gefunden!');
		}
		else
		{
			return Redirect::route('overview.showRoomSearch')->withInput()->with('error', 'Fehlerhafte Eingabe! Die maximale Platzanzahl ist kleiner als die minimale Platzanzahl!');
		}
		
	}

}