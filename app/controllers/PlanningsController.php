<?php
/*
* TODO: optimize
*/

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
class PlanningsController extends BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /plannings
	 *
	 * @return Response
	 */
	public function index()
	{
		$current_turn = Turn::find(Setting::setting('current_turn')->first()->value);
		return Redirect::route('plannings.indexTurn', $current_turn->id);
	}

	/**
	*
	*/
	public function indexTurn(Turn $turn)
	{
		if (Entrust::hasRole('Admin') || Entrust::can('view_planning') || sizeof(Entrust::user()->researchgroups) > 0)
		{
			$current_turn = Turn::find(Setting::setting('current_turn')->first()->value);
			$next_turn = Turn::nextTurn($current_turn)->first();
			$afternext_turn = Turn::turnAfterNext($current_turn)->first();
			// set the turn which will be displayed
			$display_turn = $turn;
			$before_turns = Turn::beforeTurns($display_turn)->get();
			$planned_courses = $this->getPlannedCourses($display_turn);

			$listofcoursetypes = CourseType::orderBy('short', 'ASC')->lists('short','id');
			// checking if the predecessor turn contains planned courses
			$predecessorturn = $turn->getPredecessor();
			$pastcourses = 0;
			if (!is_numeric($predecessorturn))
				$pastcourses = sizeof(DB::table('plannings')->where('turn_id','=',$predecessorturn->id)->get());
			$lists = $this->getCourseTypes($turn);
			$this->layout->content = View::make('plannings.index', compact('current_turn','next_turn', 'afternext_turn','before_turns','planned_courses', 'display_turn', 'lists', 'pastcourses', 'listofcoursetypes'));
		}
		else
			return Redirect::route('home')->with('error','Sie besitzen nicht die nötigen Rechte, um diesen Bereich zu betreten.');
	}

	/**
	* 
	* @param Turn $turn
	*/
	private function getPlannedCourses(Turn $turn)
	{
		// get the planned courses for the current turn
		if (Entrust::hasRole('Admin') || Entrust::can('view_planning'))
			$planned_courses = Planning::turnCourses($turn)->get();
		else
		{
			$rg_ids = Entrust::user()->researchgroupIds();
			// plannings with employees of the specific research groups
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
			else 
				$planned_courses = array();

			// plannings which were created the current user
			$planned_courses_user = Planning::where('user_id','=',Entrust::user()->id)
								->where('turn_id','=',$turn->id)
								->groupBy('id')
								->get();
			if (sizeof($planned_courses_user) > 0)
			{
				foreach ($planned_courses_user as $p) {
					if (!in_array($p->id, $planning_ids))
						array_push($planning_ids, $p->id);
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
		return $planned_courses;
	}
	
	/**
	*
	*/
	public function showall(Turn $turn)
	{
		$listofcoursetypes = CourseType::orderBy('short', 'ASC')->lists('short','id');
		$listofturns = Turn::getList();
		$plannings = array();
		if (Entrust::hasRole('Admin') || Entrust::can('copy_planning_all'))
			$plannings = Planning::all();
		else
		{
			$planning_ids = array();
			// three kinds of plannings needed to be fetched from the db
			// 1. course plannings, which were thought by members of the research group
			$rg_ids = Entrust::user()->researchgroupIds();
			// foreach (Entrust::user()->researchgroups as $rg) {
			// 	array_push($rg_ids, $rg->id);
			// }
			if (sizeof($rg_ids) > 0)
			{
				$planned_courses_rg = DB::table('plannings')
					->join('employee_planning','employee_planning.planning_id', '=', 'plannings.id')
					->join('employees', 'employees.id','=','employee_planning.employee_id')
					->select('plannings.id')
					->whereIn('employees.researchgroup_id',$rg_ids)
					->get();
				if (sizeof($planned_courses_rg) > 0)
				{
					foreach ($planned_courses_rg as $p) {
						array_push($planning_ids, $p->id);
					}
				}

				// 2. old courses plannings, which the research group is assigned to through the medium-term planning
				$planned_courses_mtp = DB::table('plannings')
					->join('courses', 'courses.id', '=', 'plannings.course_id')
					->join('mediumtermplannings','mediumtermplannings.module_id','=','courses.module_id')
					->join('employee_mediumtermplanning','mediumtermplannings.id','=','employee_mediumtermplanning.mediumtermplanning_id')
					->join('employees', 'employees.id','=','employee_mediumtermplanning.employee_id')
					->select('plannings.id')
					->whereIn('employees.researchgroup_id',$rg_ids)
					->where('mediumtermplannings.turn_id','=',$turn->id)
					->get();
				
				if (sizeof($planned_courses_mtp) > 0)
				{
					foreach ($planned_courses_mtp as $p) {
						array_push($planning_ids, $p->id);
					}
				}
				
			}
			// 3. course, which where created by the user
			$planned_courses_user = Planning::where('user_id', '=', Entrust::user()->id)->get();
			if (sizeof($planned_courses_user) > 0)
			{
				foreach ($planned_courses_user as $p) {
					array_push($planning_ids, $p->id);
				}
			}
			// get all plannings
			if (sizeof($planning_ids) > 0)
				$plannings = Planning::related($planning_ids)->get();
		}
		
		$this->layout->content = View::make('plannings.select', compact('plannings', 'listofturns','listofcoursetypes', 'turn'));
	}

	/**
	* default show week schedule
	*/
	public function schedule()
	{
		$current_turn = Turn::find(Setting::setting('current_turn')->first()->value);
		return Redirect::route('plannings.showSchedule',$current_turn->id);
	}

	/**
	* show week schedule
	* @param Turn $turn
	*/
	public function showSchedule(Turn $turn)
	{
		$current_turn = Turn::find(Setting::setting('current_turn')->first()->value);
		$next_turn = Turn::nextTurn($current_turn)->first();
		$afternext_turn = Turn::turnAfterNext($current_turn)->first();
		// set the turn which will be displayed
		$display_turn = $turn;
		$before_turns = Turn::beforeTurns($display_turn)->get();
		$planned_courses = $this->getPlannedCourses($display_turn);

		$output = $this->getSchedule($planned_courses);

		$this->layout->content = View::make('plannings.schedule', compact('output', 'current_turn', 'next_turn', 'afternext_turn', 'display_turn','before_turns'));
	}

	/**
	* show room preference
	*/
	public function roomPreference()
	{
		$current_turn = Turn::find(Setting::setting('current_turn')->first()->value);
		return Redirect::route('plannings.showRoomPreference',$current_turn->id);
	}

	/**
	* show room preference
	*/
	public function showRoomPreference(Turn $turn)
	{
		$current_turn = Turn::find(Setting::setting('current_turn')->first()->value);
		$next_turn = Turn::nextTurn($current_turn)->first();
		$afternext_turn = Turn::turnAfterNext($current_turn)->first();
		// set the turn which will be displayed
		$display_turn = $turn;
		$before_turns = Turn::beforeTurns($display_turn)->get();
		
		$plannings = Planning::where('turn_id','=', $turn->id)->orderBy('course_number','ASC')->groupBy('course_number')->get();
		$this->layout->content = View::make('plannings.room_preferences', compact('plannings', 'current_turn', 'next_turn', 'afternext_turn', 'display_turn','before_turns'));
	}

	/**
	* show status overview
	*/
	public function getStatusOverview(Turn $turn)
	{
		$listofcoursetypes = CourseType::orderBy('short', 'ASC')->lists('short','id');
		$plannings = Planning::where('turn_id','=',$turn->id)->orderBy('course_number')->get();
		$this->layout->content = View::make('plannings.update_status', compact('plannings', 'turn','listofcoursetypes'));
	}
	
	/**
	* store 
	*/
	public function store(Turn $turn)
	{
		$input = Input::all();
		$course = Course::find($input['course_id']);
		if (!Planning::checkDuplicate($turn, $course, $input['group_number']))
		{
			$planning = new Planning();
			$planning->store($turn, $input, $course);
			if ($planning->save())
			{
				$turn->saveExam($course->module);
				$action = "Planung erstellt (".$turn->name." ".$turn->year."): ".$planning->course_number." ".
				$planning->course_title."; Gruppen-Nr. ".$planning->group_number."; Bemerkung: ".$planning->comment."; Raumwunsch: ".
				$planning->room_preference;
				$planninglog = new Planninglog();
				$planninglog->add($planning, 0, $action, 0);
				return Redirect::route('plannings.indexTurn', $turn->id)->with('message', 'Veranstaltung '.$planning->course_title.' erfolgreich erstellt.');
			}
			else
				return Redirect::route('plannings.indexTurn', $turn->id)->withInput()->withErrors( $planning->errors() );

		}
		else
			return Redirect::route('plannings.indexTurn', $turn->id)->with('error', 'Fehler: Diese Veranstaltung existiert schon.<br>
																		Veranstaltung: '.$course->course_number.' '.$course->name.' Gruppen-Nr. '.$input['group_number'].' '.$turn->name.' '.$turn->year);
	}

	/**
	* store a module
	* @param Turn $turn
	*/
	public function storeModule(Turn $turn)
	{
		$module = Module::find(Input::get('module_id'));
		$listofcoursetypes = CourseType::orderBy('name', 'ASC')->lists('name','id');
		// get the lecture
		$result = Course::where('module_id','=',$module->id)->whereIn('course_type_id',array(1))->first();
		foreach ($module->courses as $course) 
		{
			if ($listofcoursetypes[$course->course_type_id] == "Vorlesung" || $listofcoursetypes[$course->course_type_id] == "Vorlesung + Übung")
			{
				$planning = new Planning;
				$planning->turn_id = $turn->id;
				$planning->course_id = $course->id;
				$planning->researchgroup_status = 0;
				$planning->board_status = 0;
				$planning->comment = Input::get('comment');
				$planning->room_preference = Input::get('room_preference');
				$planning->group_number = 1;
				$planning->language = Input::get('language');
				$planning->course_number = $course->course_number;
				$planning->course_title = $course->name;
				$planning->course_title_eng = $course->name_eng;
				$planning->semester_periods_per_week = $course->semester_periods_per_week;
				$planning->user_id = Entrust::user()->id;
				$planning->teaching_assignment = 0;
				if (Input::get('board_status') != "")
					$planning->board_status = 1;

				if (Input::get('researchgroup_status') != "")
					$planning->researchgroup_status = 1;
				
				if ( $planning->save() )
				{
					$turn = Turn::find($turn->id);
					$turn->saveExam($course->module);
					// log
					$action = "Planung erstellt (".$turn->name." ".$turn->year."): ".$planning->course_number." ".
					$planning->course_title."; Gruppen-Nr. ".$planning->group_number."; Bemerkung: ".$planning->comment."; Raumwunsch: ".
					$planning->room_preference;
					$planninglog = new Planninglog();
					$planninglog->add($planning, 0, $action, 0);
				}
			}
			else
			{
				$number_of_groups = ceil($result->participants/$course->participants);
				for($x = 1; $x <= $number_of_groups; $x++)
				{
					$planning = new Planning;
					$planning->turn_id = $turn->id;
					$planning->course_id = $course->id;
					$planning->researchgroup_status = 0;
					$planning->board_status = 0;
					$planning->comment = Input::get('comment');
					$planning->room_preference = Input::get('room_preference');
					$planning->group_number = $x;
					$planning->language = Input::get('language');
					$planning->course_number = $course->course_number;
					$planning->course_title = $course->name;
					$planning->course_title_eng = $course->name_eng;
					$planning->semester_periods_per_week = $course->semester_periods_per_week;
					$planning->user_id = Entrust::user()->id;
					$planning->teaching_assignment = 0;
					if (Input::get('board_status') != "")
						$planning->board_status = 1;

					if (Input::get('researchgroup_status') != "")
						$planning->researchgroup_status = 1;
					
					if ( $planning->save() )
					{
						$turn = Turn::find($turn->id);
						$turn->saveExam($course->module);
						// log
						$action = "Planung erstellt (".$turn->name." ".$turn->year."): ".$planning->course_number." ".
						$planning->course_title."; Gruppen-Nr. ".$planning->group_number."; Bemerkung: ".$planning->comment."; Raumwunsch: ".
						$planning->room_preference;
						$planninglog = new Planninglog();
						$planninglog->add($planning, 0, $action, 0);
					}
				}
			}
		}
		return Redirect::route('plannings.indexTurn', $turn->id)->with('message', 'Modul '.$module->name.' ('.$module->short.') erfolgreich erstellt.');
	}

	/**
	* store a individual
	* @param Turn $turn
	*/
	public function storeIndividual(Turn $turn)
	{
		// check for duplicates
		$course = Course::find(Input::get('course_id'));
		$result =  Planning::where('course_id','=', $course->id)
					->where('turn_id','=',$turn->id)
					->get();
		$duplicate = Planning::where('course_id', '=',$course->id)
							->where('turn_id', '=', $turn->id)
							->where('course_title', '=', Input::get('course_title'))
							->get();
		$listofcoursetypes = CourseType::orderBy('short', 'ASC')->lists('short','id');
		if (sizeof($duplicate) == 0)
		{
			$planning = new Planning;
			$planning->turn_id = $turn->id;
			$planning->course_id = $course->id;
			$planning->researchgroup_status = 0;
			$planning->board_status = 0;
			$planning->comment = Input::get('comment');
			$planning->room_preference = Input::get('room_preference');
			$planning->group_number = sizeof($result)+1;
			$planning->language = Input::get('language');
			$planning->course_number = $listofcoursetypes[$course->course_type_id].'-'.(sizeof($result)+1);
			$planning->course_title = Input::get('course_title');
			$planning->course_title_eng = Input::get('course_title_eng');
			$planning->semester_periods_per_week = $course->semester_periods_per_week;
			$planning->user_id = Entrust::user()->id;
			if (Input::get('teaching_assignment') == 1)
				$planning->teaching_assignment = 1;
			else
				$planning->teaching_assignment = 0;

			if ( $planning->save() )
			{
				$turn->saveExam($course->module);
				// log
				$action = "Planung erstellt (".$turn->name." ".$turn->year."): ".$planning->course_number." ".
				$planning->course_title."; Gruppen-Nr. ".$planning->group_number."; Bemerkung: ".$planning->comment."; Raumwunsch: ".
				$planning->room_preference;
				$planninglog = new Planninglog();
				$planninglog->add($planning, 0, $action, 0);
				return Redirect::route('plannings.indexTurn', $turn->id)->with('message', 'Veranstaltung '.$planning->course_title.' erfolgreich erstellt.');
			}
			else
				return Redirect::route('plannings.indexTurn', $turn->id)->withInput()->withErrors( $planning->errors() );
		}
		else
			return Redirect::route('plannings.indexTurn', $turn->id)->with('error', 'Fehler: Diese Veranstaltung existiert schon.<br>
																		Veranstaltung: '.$listofcoursetypes[$course->course_type_id].' '.Input::get('course_title').' '.$turn->name.' '.$turn->year);	
	}

	/**
	* store a project
	* @param Turn $turn
	*/
	public function storeProject(Turn $turn)
	{
		// check for duplicates
		$course = Course::find(Input::get('course_id'));
		$result =  Planning::where('course_id','=',$course->id)
					->where('turn_id','=',$turn->id)
					->get();
		$duplicate = Planning::where('course_id', '=',$course->id)
							->where('turn_id', '=', $turn->id)
							->where('course_title', '=', Input::get('course_title'))
							->get();
		$listofcoursetypes = CourseType::orderBy('short', 'ASC')->lists('short','id');
		if (sizeof($duplicate) == 0)
		{
			$planning = new Planning;
			$planning->turn_id = $turn->id;
			$planning->course_id = $course->id;
			$planning->researchgroup_status = 0;
			$planning->board_status = 0;
			$planning->comment = Input::get('comment');
			$planning->room_preference = Input::get('room_preference');
			$planning->group_number = sizeof($result)+1;
			$planning->language = Input::get('language');
			$planning->course_number = $listofcoursetypes[$course->course_type_id].'-'.(sizeof($result)+1);
			$planning->course_title = Input::get('course_title');
			$planning->course_title_eng = Input::get('course_title_eng');
			$planning->semester_periods_per_week = Input::get('semester_periods_per_week');
			$planning->user_id = Entrust::user()->id;
			if (Input::get('teaching_assignment') == 1)
				$planning->teaching_assignment = 1;
			else
				$planning->teaching_assignment = 0;

			if ( $planning->save() )
			{
				// exam
				$turn->saveExam($course->module);
				// log
				$action = "Planung erstellt (".$turn->name." ".$turn->year."): ".$planning->course_number." ".
				$planning->course_title."; Gruppen-Nr. ".$planning->group_number."; Bemerkung: ".$planning->comment."; Raumwunsch: ".
				$planning->room_preference;
				$planninglog = new Planninglog();
				$planninglog->add($planning, 0, $action, 0);
				return Redirect::route('plannings.indexTurn', $turn->id)->with('message', 'Veranstaltung '.$planning->course_title.' erfolgreich erstellt.');
			}
			else
				return Redirect::route('plannings.indexTurn', $turn->id)->withInput()->withErrors( $planning->errors() );
		}
		else
			return Redirect::route('plannings.indexTurn', $turn->id)->with('error', 'Fehler: Diese Veranstaltung existiert schon.<br>
																	Veranstaltung: '.$listofcoursetypes[$course->course_type_id].' '.Input::get('course_title').' '.$turn->name.' '.$turn->year);
	}
	
	/**
	* edit planning
	* @param Turn $turn
	* @param Planning $planning
	*/
	public function edit(Turn $turn, Planning $planning)
	{
		// check if user is responsible for this course or has the role room planer, admin or course planer
		$responsible = false;
		if (!Entrust::hasRole('Admin') && !Entrust::can('view_planning') && $planning->user_id != Entrust::user()->id)
		{
			foreach (Entrust::user()->researchgroups as $rg) {
				foreach ($planning->employees as $e) {
					if ($e->researchgroup_id == $rg->id)
						$responsible = true;
				}
			}
			// medium-term planning check
			$mediumtermplanning = Mediumtermplanning::where('turn_id','=',$turn->id)->where('module_id','=',$planning->course->module_id)->first();
			if (sizeof($mediumtermplanning) > 0)
			{
				foreach ($mediumtermplanning->employees as $e) {
					foreach (Entrust::user()->researchgroups as $rg) {
						if ($e->researchgroup_id == $rg->id)
							$responsible = true;
					}
				}
			}
		}
		if (Entrust::hasRole('Admin') || Entrust::can('view_planning') || $planning->user_id == Entrust::user()->id || $responsible)
		{
			$employees = Employee::all();
			$course = Course::find($planning->course_id); // TODO checking if it's a problem, when a course doesn't belong to a module
			if (sizeof(Session::get('tabindex')) == "")
				$tabindex = 0;
			else 
				$tabindex = Session::get('tabindex');

			$lists = array();
			$lists['coursetypes'] = CourseType::orderBy('name', 'ASC')->lists('name','id');
			$lists['coursetypesshort'] = CourseType::orderBy('short', 'ASC')->lists('short','id');
			$lists['departments'] = Department::orderBy('name','ASC')->lists('name','id');
			$lists['researchgroups'] = Researchgroup::orderBy('short','ASC')->lists('short','id');
	// 		$lists['rooms'] = $this->getListofrooms($course->participants);
			$lists['rooms'] = Room::getList(); // TODO find another way to suggest suitable rooms
			$lists['turns'] = Turn::getList();
			$lists['employees'] = array();
			// get only employee which belong to the assigned research groups
			if (Entrust::hasRole('Admin') || Entrust::can('view_planning'))
				$lists['employees'] = Employee::getList();
			else 
			{
				$rg_ids = Entrust::user()->researchgroupIds();
				$employees = Employee::whereIn('researchgroup_id',$rg_ids)
									->orderBy('researchgroup_id', 'ASC')
									->orderBy('name', 'ASC')
									->get();
				foreach ($employees as $e) {
					$lists['employees'] = array_add($lists['employees'],$e->id, $e->title.' '.$e->firstname.' '.$e->name);
				}
			}			


			$oldplannings = DB::table('plannings')
								->join('turns','turns.id','=','plannings.turn_id')
								->select('plannings.id')
								->where('plannings.course_id','=',$planning->course_id)
								->where('plannings.group_number','=',$planning->group_number)
								->where('turns.year','<=',$turn->year)
								->where('plannings.id','!=',$planning->id)
								->orderBy('turns.year','DESC')
								->orderBy('turns.name','DESC')
								->get();
			if (sizeof($oldplannings) > 0)
			{
				$planningids = array();
				foreach ($oldplannings as $rp)
				{
					array_push($planningids, $rp->id);
				}
				$oldplannings = Planning::related($planningids)->get();
			}
			else
				$oldplannings = array();
			
			$relatedplannings = DB::table('plannings')
									->join('courses','courses.id','=','plannings.course_id')
									->select('plannings.id')
									->where('courses.module_id','=',$course->module->id)
									->where('plannings.turn_id','=',$planning->turn_id)
									->whereNotIn('plannings.id', array($planning->id))
									->orderBy('plannings.group_number', 'ASC')
									->get();
			if (sizeof($relatedplannings) > 0)
			{
				$planningids = array();
				foreach ($relatedplannings as $rp)
				{
					array_push($planningids, $rp->id);
				}
				$relatedplannings = Planning::related($planningids)->get();
			}
			else 
				$relatedplannings = array();
			
			$oldrooms = DB::table('planning_room')
							->join('plannings','plannings.id', '=', 'planning_room.planning_id')
							->join('turns', 'plannings.turn_id', '=', 'turns.id')
							->select('planning_room.room_id','planning_room.id', 'planning_room.weekday','planning_room.start_time','planning_room.end_time', 'plannings.turn_id')
							->where('plannings.course_id', '=', $planning->course_id)
							->where('plannings.id', '!=', $planning->id)
							->where('plannings.group_number','=', $planning->group_number)
							->where('turns.year', '<=', $turn->year)
							->orderBy('turns.year', 'DESC')
							->orderBy('turns.name', 'DESC')
							->take(6)
							->get();
			
			//
			// TODO moving possibleemployees to basecontroller
			//
			
			// possible list of employees to add, employees who are already assigned to the courseturn shouldn't be included in that list
			$planningemployees = $planning->employees;
			$lists['possibleemployees'] = $lists['employees'];
			if (sizeof($planningemployees) > 0)
			{
				foreach ($planningemployees as $ccte)
				{
					if (array_key_exists($ccte->id, $lists['possibleemployees']))
						unset($lists['possibleemployees'][$ccte->id]);
				}
			}
			//
			// TODO END
			//
			
			// get exam type for this semester
			$exam = DB::table('module_turn')
						->select('exam')
						->where('turn_id', '=', $turn->id)
						->where('module_id', '=', $course->module->id)
						->first();

			// get the planning logs for this planning
			$planninglog = Planninglog::where('planning_id','=', $planning->id)->orderBy('created_at', 'DESC')->get();
			// get courses with possible schedule conflicts
			$conflictcourses = $planning->getConflictCourses();
			$output = $this->getConflictCourseSchedule($conflictcourses);
			$this->layout->content = View::make('plannings.edit', compact('course', 'turn','planning', 'lists','tabindex', 'oldrooms','relatedplannings', 'oldplannings', 'conflictcourses', 'exam','output','planninglog'));
		}
		else
			return Redirect::route('home')->with('error', 'Sie besitzen keine Rechte für diesen Bereich!');
	}
	
	/**
	* update a specific planning
	* @param Turn $turn
	* @param Planning $planning
	*/
	public function update(Turn $turn, Planning $planning)
	{
		$board_statusarray = array('Vorlauf','1.Lesung','2.Lesung');
		$rgstatusarray = array('unbestätigt', 'bestätigt', 'gestrichen', 'ausgelaufen');
		$duplicate = false;
		// check if the group number has changed
		if (Input::get('group_number') != $planning->group_number)
		{
			// number has changed, check for a duplicate
			$existingplanning = DB::table('plannings')
							->where('course_id','=',$planning->course_id)
							->where('turn_id','=',$turn->id)
							->where('group_number','=',Input::get('group_number'))
							->first();
			if (sizeof($existingplanning) == 1)
				$duplicate = true;
		}
		// check for duplicates
		if (!$duplicate)
		{
			$planning->group_number = Input::get('group_number');
			$planning->comment = Input::get('comment');
			$planning->room_preference = Input::get('room_preference');
			$planning->language = Input::get('language');
			if (Input::get('course_number'))
				$planning->course_number = Input::get('course_number');

			if (Input::get('course_title_eng'))
				$planning->course_title_eng = Input::get('course_title_eng');

			if (Input::get('course_title') != "")
				$planning->course_title = Input::get('course_title');

			if (Input::get('researchgroup_status') != "")
				$planning->researchgroup_status = Input::get('researchgroup_status');

			if (Input::get('board_status') != "")
				$planning->board_status = Input::get('board_status');

			if ( $planning->updateUniques() )
			{
				// updating comment and room preferences
				DB::table('plannings')->where('turn_id','=',$turn->id)->where('course_number','=',$planning->course_number)->update(array(
					'comment' => $planning->comment, 'room_preference' => $planning->room_preference));
				// log
				$action = "Planung aktualisiert (".$turn->name." ".$turn->year."): ".
							$planning->course_number." ".$planning->course_title." (".$planning->course_title."); Gruppen-Nr. ".
							$planning->group_number."; Sprache ".Config::get('constants.language')[$planning->language]."; AB: ".Config::get('constants.pl_rgstatus')[$planning->researchgroup_status]."; VS: ".
							Config::get('constants.pl_board_status')[$planning->board_status]."; Bemerkung: ".$planning->comment."; Raumwunsch: ".$planning->room_preference;
							$planninglog = new Planninglog();
				$planninglog->add($planning, 0, $action, 0);
				return Redirect::route('plannings.edit', array($turn->id, $planning->id))->with('message', 'Veranstaltung erfolgreich aktualisiert.');
			}
			else 
				return Redirect::route('plannings.edit', array($turn->id, $planning->id))->withInput()->withErrors( $planning->errors() );
		}
		else 
			return Redirect::route('plannings.edit', array($turn->id, $planning->id))->with('error', 'Duplikat aufgetreten! Die Gruppe für diese Veranstaltung existiert bereit.');
	}
	
	/**
	* copy the whole last turn
	* @param Turn $turn
	*/
	public function copyLastTurn(Turn $turn)
	{
		$copyall = true;
		$warnmessage = "Es konnten nicht alle Veranstaltungen aus dem letzten Semester kopiert werden,
					da diese bereits im aktuellen Semester existieren.<br> Folgende Veranstaltungen konnten nicht kopiert werden: ";
		// try to find a predecessor turn
		$predecessorturn = $turn->getPredecessor();
		$planned_courses = array();
		if (!is_numeric($predecessorturn))
		{
			// get all courses of the specific turn
			if (Entrust::hasRole('Admin') || Entrust::hasRole('Lehrplanung') ) // role Lehrplanung has to be changed to a permission
				$planned_courses = Planning::where('turn_id','=',$predecessorturn->id)->get();
			else
			{
				$rg_ids = Entrust::user()->researchgroupIds();
				$planned_courses = DB::table('plannings')
					->join('employee_planning','employee_planning.planning_id', '=', 'plannings.id')
					->join('employees', 'employees.id','=','employee_planning.employee_id')
					->join('researchgroups', 'researchgroups.id', '=', 'employees.researchgroup_id')
					->select('plannings.id')
					->whereIn('researchgroups.id',$rg_ids)
					->where('plannings.turn_id','=', $predecessorturn->id)
					->get();
				$planning_ids = array();
				if (sizeof($planned_courses) > 0)
				{
					foreach ($planned_courses as $p) {
						array_push($planning_ids, $p->id);
					}
				}
				else
					$planned_courses = array();

				$planned_courses_user = Planning::where('user_id','=',Entrust::user()->id)->where('turn_id','=',$predecessorturn->id)->get();
				foreach ($planned_courses_user as $p) {
					if (!array_key_exists($p->id, $planning_ids))
						array_push($planning_ids, $p->id);
				}
				if (sizeof($planning_ids) > 0)
					$planned_courses = Planning::related($planning_ids)->get();
			}
			$employees = 0;
			$comments = 0;
			$room_preferences = 0;
			if (Input::get('employees') == 1)
				$employees = 1;

			if (Input::get('comments') == 1)
				$comments = 1;

			if (Input::get('room_preferences') == 1)
				$room_preferences = 1;

			$result = $this->copyPlannings($turn, $planned_courses, $employees, $comments, $room_preferences);
		
			if ($result['copyall'])
				return Redirect::route('plannings.indexTurn', $turn->id)->with('message', 'Alle Veranstaltungen wurden erfolgreich kopiert.')
																		->with('info', 'Hinweis: Die Raumzuordnungen wurden nicht übernommen und der Modulabschluss wurde auf den Standardabschluss zurückgesetzt.');
			else
				return Redirect::route('plannings.indexTurn', $turn->id)->with('error', $result['warnmessage'])
																		->with('info', 'Hinweis: Die Raumzuordnungen wurden nicht übernommen und der Modulabschluss wurde auf den Standardabschluss zurückgesetzt.');
		}
		else
			return Redirect::route('plannings.indexTurn', $turn->id)->with('error', "Es existiert kein vorheriges Semester zum Kopieren!");
	}
	
	/**
	* copy selected plannings
	* @param Turn $turn
	*/
	public function copySelectedPlanning(Turn $turn)
	{
		if (sizeof(Input::get('selected'))  > 0)
		{
			$plannings = Planning::whereIn('id',Input::get('selected'))->get();
			$result = $this->copyPlannings($turn, $plannings, 1, 1, 1);
			if ($result['copyall'])
				return Redirect::route('plannings.indexTurn', $turn->id)->with('message', 'Alle Veranstaltungen wurden erfolgreich kopiert.')
																		->with('info', 'Hinweis: Die Raumzuordnungen wurden nicht übernommen und der Modulabschluss wurde auf den Standardabschluss zurückgesetzt.');
			else
				return Redirect::route('plannings.indexTurn', $turn->id)->with('error', $result['warnmessage'])
																		->with('info', 'Hinweis: Die Raumzuordnungen wurden nicht übernommen und der Modulabschluss wurde auf den Standardabschluss zurückgesetzt.');
		}
		else 
			return Redirect::route('plannings.indexTurn', $turn->id)->with('error', 'Es wurden keine Veranstaltungen ausgewählt.');
	}

	/**
	* update planning status
	* @param Turn $turn
	*/
	public function updateStatus(Turn $turn)
	{
		if (sizeof(Input::get('selected')) > 0)
		{
			$plannings = Planning::whereIn('id',Input::get('selected'))->get();
			foreach ($plannings as $p) {
				$action = "Planung aktualisiert (".$turn->name." ".$turn->year."): ".$p->course_number." ".$p->course_title." Gruppen-Nr. ".
				$p->group_number."; AB: ".Config::get('constants.pl_rgstatus')[$p->researchgroup_status]."->".Config::get('constants.pl_rgstatus')[Input::get('researchgroup_status')]."; VS: ".
				Config::get('constants.pl_board_status')[$p->board_status]."->".Config::get('constants.pl_board_status')[Input::get('board_status')];
				$p->board_status = Input::get('board_status');
				$p->researchgroup_status = Input::get('researchgroup_status');
				$p->save();				
				$planninglog = new Planninglog();
				$planninglog->add($p, 0, $action, 1);
			}
			return Redirect::route('plannings.statusOverview', $turn->id)->with('message','Die Status wurden erfolgreich aktualisiert.');
		}
		else
		{
			return Redirect::route('plannings.statusOverview', $turn->id)->with('error','Es wurden keine Veranstaltungen ausgewählt.');
		}
	}
	
	/**
	* delete planning
	* @param Turn $turn
	* @param Planning $planning
	*/
	public function destroy(Turn $turn, Planning $planning)
	{
		// delete employees from planning_employee
		$planning->employees()->detach();
		// delete room relationships from planning_room
		$planning->rooms()->detach();
		// delete exam type
		// check if the planning is for the last course of this module
		$remaining_courses = DB::table('plannings')
								->join('courses', 'courses.id', '=', 'plannings.course_id')
								->select('plannings.id')
								->where('courses.module_id', '=', $planning->course->module_id)
								->where('plannings.turn_id', '=', $turn->id)
								->get();
		if (sizeof($remaining_courses) <= 1)
			$turn->modules()->detach($planning->course->module_id);

		// delete planning
		$action = "Planung gelöscht (".$turn->name." ".$turn->year."): ".$planning->course_number." ".$planning->course_title." Gruppen-Nr. ".$planning->group_number;
		$planninglog = new Planninglog();
		$planninglog->add($planning, 0, $action, 2);
		$planning->delete();
		return Redirect::route('plannings.indexTurn', $turn->id)->with('message', 'Veranstaltung erfolgreich gelöscht.');
	}
	
	/**
	* add employee planning relationship
	* @param Turn $turn
	* @param Planning $planning
	*/
	public function addEmployee(Turn $turn, Planning $planning)
	{
		$employee = Employee::find(Input::get('employee_id'));
		$action = "Mitarbeiter zugeordnet (".$turn->name." ".$turn->year."): ".$planning->course_number." ".$planning->course_title." Gruppen-Nr. ".$planning->group_number." ".$employee->firstname.' '.$employee->name.' ('.Input::get('semester_periods_per_week').' SWS)';
		$planninglog = new Planninglog();
		$planninglog->add($planning, 1, $action, 0);
		$planning->employees()->attach(Input::get('employee_id'), array(
				'semester_periods_per_week'=>(Input::get('semester_periods_per_week')))
		);
		return Redirect::route('plannings.edit', array($turn->id, $planning->id))->with('message', 'Mitarbeiter erfolgreich hinzugefügt.')
																				->with('tabindex', Input::get('tabindex'));
	}
	
	/**
	* update employee planning relationship
	* @param Turn $turn
	* @param Planning $planning
	*/
	public function updateEmployee(Turn $turn, Planning $planning)
	{
		// TODO check if the sum of semester periods per weeks exceeds the semester periods per week of the course
		$employee = Employee::find(Input::get('employee_id'));
		// log
		foreach ($planning->employees as $e) {
			if ($e->id == $employee->id)
				$action = "Mitarbeiter aktualisiert (".$turn->name." ".$turn->year."): ".$planning->course_number." ".$planning->course_title." Gruppen-Nr. ".$planning->group_number." ".$employee->firstname.' '.$employee->name.' ('.$e->pivot->semester_periods_per_week.' SWS -> '.Input::get('semester_periods_per_week').' SWS)';
		}
		$planninglog = new Planninglog();
		$planninglog->add($planning, 1, $action, 1);
		// update
		$planning->employees()->updateExistingPivot(Input::get('employee_id'), array(
				'semester_periods_per_week'=>(Input::get('semester_periods_per_week'))
		), true);
		return Redirect::route('plannings.edit', array($turn->id, $planning->id))->with('message', 'Mitarbeiter erfolgreich aktualisiert.')
																				->with('tabindex', Input::get('tabindex'));
	}

	/**
	* copy employee planning relationship
	* @param Turn $turn
	* @param Planning $planning
	*/
	public function copyEmployee(Turn $turn, Planning $planning)
	{
		$source_planning = Planning::find(Input::get('source_planning_id'));
		$all_employees_copied = true;
		$message = "";
		// if size of $planning->employee is higher than 0, check for duplicates
		if (sizeof($planning->employees) > 0)
		{
			$current_employee_ids = array();
			foreach ($planning->employees as $e) {
				array_push($current_employee_ids, $e->id);
			}
			foreach ($source_planning->employees as $spe) {
				if (!in_array($spe->id, $current_employee_ids))
				{
					$planning->employees()->attach($spe->id, array('semester_periods_per_week' => $spe->pivot->semester_periods_per_week));
					$action = "Mitarbeiter zugeordnet (".$turn->name." ".$turn->year."): ".$planning->course_number." ".$planning->course_title." Gruppen-Nr. ".$planning->group_number." ".$spe->firstname.' '.$spe->name.' ('.$spe->pivot->semester_periods_per_week.' SWS)';
					$planninglog = new Planninglog();
					$planninglog->add($planning, 1, $action, 0);
				}
				else
				{
					$all_employees_copied = false;
					$message .= $spe->firstname.' '.$spe->name.'; ';
				}
			}
		}
		else
		{
			foreach ($source_planning->employees as $e) {
				$planning->employees()->attach($e->id, array('semester_periods_per_week' => $e->pivot->semester_periods_per_week));
				$action = "Mitarbeiter zugeordnet (".$turn->name." ".$turn->year."): ".$planning->course_number." ".$planning->course_title." Gruppen-Nr. ".$planning->group_number." ".$e->firstname.' '.$e->name.' ('.$e->pivot->semester_periods_per_week.' SWS)';
				$planninglog = new Planninglog();
				$planninglog->add($planning, 1, $action, 0);
			}
		}
		if ($all_employees_copied)
			return Redirect::route('plannings.edit', array($turn->id, $planning->id))->with('message', 'Mitarbeiter wurden erfolgreich übernommen.')
																				->with('tabindex', Input::get('tabindex'));
		else
			return Redirect::route('plannings.edit', array($turn->id, $planning->id))->with('error', 'Es konnten nicht alle Mitarbeiter übernommen werden: '.$message)
																				->with('tabindex', Input::get('tabindex'));
	}
	
	/**
	* delete employee planning relationship
	* @param Turn $turn
	* @param Planning $planning
	*/
	public function deleteEmployee(Turn $turn, Planning $planning)
	{
		$employee = Employee::find(Input::get('employee_id'));
		// log
		$action = "Mitarbeiterzuordnung gelöscht (".$turn->name." ".$turn->year."): ".$planning->course_number." ".$planning->course_title." Gruppen-Nr. ".$planning->group_number." ".$employee->firstname.' '.$employee->name;
		$planninglog = new Planninglog();
		$planninglog->add($planning, 1, $action, 2);
		// detach
		$planning->employees()->detach(Input::get('employee_id'));
		return Redirect::route('plannings.edit', array($turn->id, $planning->id))->with('message', 'Mitarbeiter erfolgreich entfernt.')
																				->with('tabindex', Input::get('tabindex'));
	}
	
	/**
	* add a planning room relationship
	* checking for conflicts
	* @param Turn $turn
	* @param Planning $planning
	*/
	public function addRoom(Turn $turn, Planning $planning)
	{
		$room = Room::find(Input::get('room_id'));
		$starttime = date('H:i:s', strtotime(Input::get('start_time')));
		$endtime = date('H:i:s', strtotime(Input::get('end_time')));
		if ($starttime < $endtime)
		{
			// checking if the room is occupied at that day and time
			// TODO check for conflicts with other compulsory modules, when course belongs to compulsory module and is a lecture
			$result = DB::table('planning_room')
						->join('plannings', 'planning_room.planning_id','=','plannings.id')
						->select('planning_room.room_id')
						->where('plannings.turn_id', '=', $turn->id) // Import to select ohne results from the same turn
						->where('planning_room.weekday','=' ,Input::get('weekday'))
						->where('planning_room.room_id','=', $room->id)
						->where(function($query) use ($starttime, $endtime)
						{
							$query->where(function($q1) use ($starttime){
								$q1->where('planning_room.start_time', '<', $starttime)
								->where('planning_room.end_time', '>', $starttime)
								->where('planning_room.end_time', '!=', $starttime);
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
						->first();
			if (sizeof($result) == 0)
			{
				$planning->rooms()->attach($room->id, array(
							'weekday'=>(Input::get('weekday')),
							'start_time'=>$starttime,
							'end_time'=>$endtime,
						));
				// log
				$room = Room::find(Input::get('room_id'));
				$action = "Raum zugeordnet (".$turn->name." ".$turn->year."): ".$planning->course_number." ".
						$planning->course_title." Gruppen-Nr. ".$planning->group_number." ".
						$room->name.' ('.Config::get('constants.weekdays_short')[Input::get('weekday')].', '.
							substr(Input::get('start_time'),0,5).'-'.substr(Input::get('end_time'),0,5).')';
				$planninglog = new Planninglog();
				$planninglog->add($planning, 2, $action, 0);
				return Redirect::route('plannings.edit', array($turn->id, $planning->id))->with('message', 'Raum erfolgreich hinzugefügt.')
																						->with('tabindex', Input::get('tabindex'));
			}
			else 
			{
				// conflict
				// TODO find alternatives to suggest
				$similarrooms = Room::similar($room)->get();
				$alternativrooms = array();
				$freerooms = "Alternative Räume: ";
				// check if they are free
				foreach ($similarrooms as $sr)
				{
					$result = DB::table('planning_room')
								->join('plannings', 'planning_room.planning_id','=','plannings.id')
								->select('planning_room.room_id')
								->where('plannings.turn_id', '=', $turn->id) // Import to select ohne results from the same turn
								->where('planning_room.weekday','=' ,Input::get('weekday'))
								->where('planning_room.room_id','=', $sr->id)
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
								->first();
					if (sizeof($result) == 0)
					{
						// room is not occupied at this time
						array_push($alternativrooms, $sr);
						$freerooms .= $sr->name.' (Plätze: '.$sr->seats.');';
					}
				}
				if (sizeof($alternativrooms) == 0)
					$freerooms .= 'Keine freien Räume zu dieser Zeit.';

				return Redirect::route('plannings.edit', array($turn->id, $planning->id))->with('error', 
						'Es ist Konflikt aufgetreten: Raum '.$room->name.' ('.$room->location.') '.Config::get('constants.weekdays_short')[Input::get('weekday')].', '.Input::get('start_time').'-'.Input::get('end_time').' ist zu dieser Zeit schon belegt. <br>'.$freerooms)
							->with('tabindex', Input::get('tabindex'));
			}
		}
		else 
			return Redirect::route('plannings.edit', array($turn->id, $planning->id))->with('error', 'Die Endzeit liegt vor der Startzeit.')
							->with('tabindex', Input::get('tabindex'));
	}

	/**
	* copy a planning room relationship
	* @param Turn $turn
	* @param Planning $planning
	*/
	public function copyRoom(Turn $turn, Planning $planning)
	{
		$planning_room = DB::table('planning_room')
							->select('*')
							->where('id','=',Input::get('source_planning_room_id'))
							->first();
		$room = Room::find($planning_room->room_id);
		$starttime = $planning_room->start_time;
		$endtime = $planning_room->end_time;
		// checking if the room is occupied at that day and time
		// TODO check for conflicts with other compulsory modules, when course belongs to compulsory module and is a lecture
		$result = DB::table('planning_room')
					->join('plannings', 'planning_room.planning_id','=','plannings.id')
					->select('planning_room.room_id')
					->where('plannings.turn_id', '=', $turn->id) // Import to select ohne results from the same turn
					->where('planning_room.weekday','=' ,$planning_room->weekday)
					->where('planning_room.room_id','=', $room->id)
					->where(function($query) use ($starttime,$endtime)
					{
						$query->where(function($q1) use ($starttime,$endtime) {
							$q1->where('planning_room.start_time', '<', $starttime)
							->where('planning_room.end_time', '>', $starttime);
						})
						->orWhere(function ($q2) use ($starttime,$endtime) {
							$q2->where('planning_room.start_time', '<', $endtime)
							->where('planning_room.end_time', '>', $endtime);
						})
						->orWhere(function ($q3) use ($starttime,$endtime) {
							$q3->where('planning_room.start_time', '=', $starttime)
							->where('planning_room.end_time', '=', $endtime);
						})
						->orWhere(function ($q4) use ($starttime,$endtime) {
							$q4->where('planning_room.start_time', '=', $starttime)
							->where('planning_room.end_time', '<', $endtime);
						})
						->orWhere(function ($q5) use ($starttime,$endtime) {
							$q5->where('planning_room.start_time', '>', $starttime)
							->where('planning_room.end_time', '=', $endtime);
						})
						->orWhere(function ($q6) use ($starttime,$endtime) {
							$q6->where('planning_room.start_time', '>', $starttime)
							->where('planning_room.end_time', '<', $endtime);
						});
					})
					->first();
		if (sizeof($result) == 0)
		{
			$planning->rooms()->attach($room->id, array(
						'weekday'=>($planning_room->weekday),
						'start_time'=>$planning_room->start_time,
						'end_time'=>$planning_room->end_time,
					));
			// log
			$action = "Raum zugeordnet (".$turn->name." ".$turn->year."): ".$planning->course_number." ".
					$planning->course_title." Gruppen-Nr. ".$planning->group_number." ".
					$room->name.' ('.Config::get('constants.weekdays_short')[$planning_room->weekday].', '.
						substr($planning_room->start_time,0,5).'-'.substr($planning_room->end_time,0,5).')';
			$planninglog = new Planninglog();
			$planninglog->add($planning, 2, $action, 0);
			return Redirect::route('plannings.edit', array($turn->id, $planning->id))->with('message', 'Raum erfolgreich hinzugefügt.')
																					->with('tabindex', Input::get('tabindex'));
		}
		else 
		{
			// conflict
			// TODO find alternatives to suggest
			$similarrooms = Room::similar($room)->get();
			$alternativrooms = array();
			$freerooms = "Alternative Räume: ";
			// check if they are free
			foreach ($similarrooms as $sr)
			{
				$result = DB::table('planning_room')
							->join('plannings', 'planning_room.planning_id','=','plannings.id')
							->select('planning_room.room_id')
							->where('plannings.turn_id', '=', $turn->id) // Import to select ohne results from the same turn
							->where('planning_room.weekday','=' ,$planning_room->weekday)
							->where('planning_room.room_id','=', $sr->id)
							->where(function($query) use ($starttime, $endtime)
							{
								$query->where(function($q1) use ($starttime,$endtime) {
									$q1->where('planning_room.start_time', '<', $starttime)
									->where('planning_room.end_time', '>', $starttime);
								})
								->orWhere(function ($q2) use ($starttime,$endtime) {
									$q2->where('planning_room.start_time', '<', $endtime)
									->where('planning_room.end_time', '>', $endtime);
								})
								->orWhere(function ($q3) use ($starttime,$endtime) {
									$q3->where('planning_room.start_time', '=', $starttime)
									->where('planning_room.end_time', '=', $endtime);
								})
								->orWhere(function ($q4) use ($starttime,$endtime) {
									$q4->where('planning_room.start_time', '=', $starttime)
									->where('planning_room.end_time', '<', $endtime);
								})
								->orWhere(function ($q5) use ($starttime,$endtime) {
									$q5->where('planning_room.start_time', '>', $starttime)
									->where('planning_room.end_time', '=', $endtime);
								})
								->orWhere(function ($q6) use ($starttime,$endtime) {
									$q6->where('planning_room.start_time', '>', $starttime)
									->where('planning_room.end_time', '<', $endtime);
								});
							})
							->first();
				if (sizeof($result) == 0)
				{
					// room is not occupied at this time
					array_push($alternativrooms, $sr);
					$freerooms .= $sr->name.' (Plätze: '.$sr->seats.');';
				}
			}
			if (sizeof($alternativrooms) == 0)
			{
				$freerooms .= 'Keine freien Räume zu dieser Zeit.';
			}
			return Redirect::route('plannings.edit', array($turn->id, $planning->id))->with('error', 
					'Es ist Konflikt aufgetreten: Raum '.$room->name.' ('.$room->location.') '.Config::get('constants.weekdays_short')[$planning_room->weekday].', '.$planning_room->start_time.'-'.$planning_room->end_time.' ist zu dieser Zeit schon belegt. <br>'.$freerooms)
						->with('tabindex', Input::get('tabindex'));
		}
	}
	
	/**
	* update a planning room relationship checks for conflicts
	*/
	public function updateRoom(Turn $turn, Planning $planning)
	{
		if (Input::get('room_id_old') == Input::get('room_id')) 
		{
			$room = Room::find(Input::get('room_id'));
			$oldroom = $room;
		}
		else
		{
			$room = Room::find(Input::get('room_id'));
			$oldroom = Room::find(Input::get('room_id_old'));
		}
		$planningroomid = DB::table('planning_room')
							->select('id')
							->where('room_id','=',$oldroom->id)
							->where('planning_id','=', $planning->id)
							->where('weekday','=', Input::get('weekday_old'))
							->where('start_time', '=', Input::get('start_time_old'))
							->where('end_time', '=', Input::get('end_time_old'))
							->first();
		$starttime = date('H:i:s', strtotime(Input::get('start_time')));
		$endtime = date('H:i:s', strtotime(Input::get('end_time')));
		if ($starttime < $endtime)
		{
			//checking if the room is occupied at that day and time
			$result = DB::table('planning_room')
						->join('plannings','plannings.id','=','planning_room.planning_id')
						->select('planning_room.room_id')
						->where('planning_room.weekday','=' ,Input::get('weekday'))
						->where('plannings.turn_id', '=', $turn->id)
// 						->where('planning_room.planning_id', '!=', $planning->id)
						->where('planning_room.room_id','=', $room->id)
						->where('planning_room.id', '!=', $planningroomid->id)
						->where(function($query) use ($starttime,$endtime)
						{
							$query->where(function($q1) use ($starttime){
								$q1->where('planning_room.start_time', '<', $starttime)
								->where('planning_room.end_time', '>', $starttime)
								->where('planning_room.end_time', '!=', $starttime);
							})
							->orWhere(function ($q2) use ($endtime){
								$q2->where('planning_room.start_time', '<', $endtime)
								->where('planning_room.end_time', '>', $endtime);
							})
							->orWhere(function ($q3) use ($starttime,$endtime){
								$q3->where('planning_room.start_time', '=', $starttime)
								->where('planning_room.end_time', '=', $endtime);
							})
							->orWhere(function ($q4) use ($starttime,$endtime){
								$q4->where('planning_room.start_time', '=', $starttime)
								->where('planning_room.end_time', '<', $endtime);
							})
							->orWhere(function ($q5) use ($starttime,$endtime){
								$q5->where('planning_room.start_time', '>', $starttime)
								->where('planning_room.end_time', '=', $endtime);
							})
							->orWhere(function ($q6) use ($starttime,$endtime){
								$q6->where('planning_room.start_time', '>', $starttime)
								->where('planning_room.end_time', '<', $endtime);
							});
						})
						->first();
			if (sizeof($result) == 0)
			{
				// no conflict
// 				$planning->rooms()->updateExistingPivot($room->id, array(
// 						'weekday' => Input::get('weekday'),
// 						'start_time'=> Input::get('start_time'),
// 						'end_time'=> Input::get('end_time'),
// 				), true);
				$action = "Raum aktualisiert (".$turn->name." ".$turn->year."): ".$planning->course_number." ".
						$planning->course_title." Gruppen-Nr. ".$planning->group_number." ".
						$oldroom->name.' -> ('.$room->name.') ('.Config::get('constants.weekdays_short')[Input::get('weekday_old')].', '.
							substr(Input::get('start_time_old'),0,5).'-'.substr(Input::get('end_time_old'),0,5).') -> ('.Config::get('constants.weekdays_short')[Input::get('weekday')].', '.
							substr(Input::get('start_time'),0,5).'-'.substr(Input::get('end_time'),0,5).')';

				DB::table('planning_room')
					->where('id','=', $planningroomid->id)
					->update(array('room_id' => Input::get('room_id'), 'weekday' => Input::get('weekday'), 'start_time'=> Input::get('start_time'), 'end_time'=> Input::get('end_time')));

				$planninglog = new Planninglog();
				$planninglog->add($planning, 2, $action, 1);
				return Redirect::route('plannings.edit', array($turn->id, $planning->id))->with('message', 'Raum erfolgreich aktualisiert.')
																->with('tabindex', Input::get('tabindex'));
			}
			else
			{
				// conflict
				// TODO find alternativ rooms to suggest
				$similarrooms = Room::similar($room)->get();
				$alternativrooms = array();
				$freerooms = "Alternative Räume: ";
				// check if they are free
				foreach ($similarrooms as $sr)
				{
					$result = DB::table('planning_room')
								->join('plannings', 'planning_room.planning_id','=','plannings.id')
								->select('planning_room.room_id')
								->where('plannings.turn_id', '=', $turn->id) // Import to select ohne results from the same turn
								->where('planning_room.weekday','=' ,Input::get('weekday'))
								->where('planning_room.room_id','=', $sr->id)
								->where(function($query) use ($starttime,$endtime)
								{
									$query->where(function($q1) use ($starttime){
										$q1->where('planning_room.start_time', '<', $starttime)
										->where('planning_room.end_time', '>', $starttime);
									})
									->orWhere(function ($q2) use ($endtime){
										$q2->where('planning_room.start_time', '<', $endtime)
										->where('planning_room.end_time', '>', $endtime);
									})
									->orWhere(function ($q3) use ($starttime,$endtime){
										$q3->where('planning_room.start_time', '=', $starttime)
										->where('planning_room.end_time', '=', $endtime);
									})
									->orWhere(function ($q4) use ($starttime,$endtime){
										$q4->where('planning_room.start_time', '=', $starttime)
										->where('planning_room.end_time', '<', $endtime);
									})
									->orWhere(function ($q5) use ($starttime,$endtime){
										$q5->where('planning_room.start_time', '>', $starttime)
										->where('planning_room.end_time', '=', $endtime);
									})
									->orWhere(function ($q6) use ($starttime,$endtime){
										$q6->where('planning_room.start_time', '>', $starttime)
										->where('planning_room.end_time', '<', $endtime);
									});
								})
								->first();
					if (sizeof($result) == 0)
					{
						// room is not occupied at this time
						array_push($alternativrooms, $sr);
						$freerooms .= $sr->name.' (Plätze: '.$sr->seats.');';
					}
				}
				if (sizeof($alternativrooms) == 0)
					$freerooms .= 'Keine freien Räume zu dieser Zeit.';

				return Redirect::route('plannings.edit', array($turn->id, $planning->id))->with('error',
						'Es ist Konflikt aufgetreten: Raum '.$room->name.' ('.$room->location.') '.Config::get('constants.weekdays_short')[Input::get('weekday')].', '.Input::get('start_time').'-'.Input::get('end_time').' ist zu dieser Zeit schon belegt.<br>'.$freerooms)
								->with('tabindex', Input::get('tabindex'));
			}
		}
		else
			return Redirect::route('plannings.edit', array($turn->id, $planning->id))->with('error', 'Die Endzeit liegt vor der Startzeit.')
																						->with('tabindex', Input::get('tabindex'));
		
		$planning->rooms()->updateExistingPivot(Input::get('room_id'), array(
				'semester_periods_per_week'=>(Input::get('semester_periods_per_week')/2)
				), true);
		return Redirect::route('plannings.edit', array($turn->id, $planning->id))->with('message', 'Raum erfolgreich aktualisiert.')
																				->with('tabindex', Input::get('tabindex'));
	}
	
	/**
	* delete a planning room relation
	* @param Turn $turn
	* @param Planning $planning
	*/
	public function deleteRoom(Turn $turn, Planning $planning)
	{
		// TODO überarbeiten
		DB::table('planning_room')
			->where('room_id','=',Input::get('room_id'))
			->where('planning_id', '=', $planning->id)
			->where('weekday', '=', Input::get('weekday'))
			->where('start_time','=', Input::get('start_time'))
			->delete();
		$room = Room::find(Input::get('room_id'));
		$action = "Raumzuordnung gelöscht (".$turn->name." ".$turn->year."): ".$planning->course_number." ".
				$planning->course_title." Gruppen-Nr. ".$planning->group_number." ".
				$room->name.' ('.Config::get('constants.weekdays_short')[Input::get('weekday')].', '.
					substr(Input::get('start_time'),0,5).'-'.substr(Input::get('end_time'),0,5).')';
		$planninglog = new Planninglog();
		$planninglog->add($planning, 2, $action, 2);
		return Redirect::route('plannings.edit', array($turn->id, $planning->id))->with('message', 'Raum erfolgreich entfernt.')
																				->with('tabindex', Input::get('tabindex'));
	}

	/**
	* updates the exam type for a module
	* @param Turn $turn
	* @param Planning $planning
	*/
	public function updateExamType(Turn $turn, Planning $planning)
	{
		foreach ($turn->modules as $m) {
			if ($m->id == Input::get('module_id'))
			{
				$old_exam_type = $m->pivot->exam;
			}
		}
		$turn->modules()->updateExistingPivot(Input::get('module_id'), array('exam' => Input::get('exam_type'), 'updated_at' => new Datetime));
		$action = "Modulabschlussart aktualisiert (".$turn->name." ".$turn->year."): ".$planning->course->module->short." ".$planning->course->module->name."; Abschluss: ".Config::get('constants.exam_type')[$old_exam_type]." -> ".Config::get('constants.exam_type')[Input::get('exam_type')];
		$planninglog = new Planninglog();
		$planninglog->add($planning, 3, $action, 1);
		return Redirect::route('plannings.edit', array($turn->id, $planning->id))->with('message', 'Modulabschluss erfolgreich aktualisiert.')
																				->with('tabindex', Input::get('tabindex'));
	}
	
	/**
	* generates planning from medium term planning for a specific turn
	* @param Turn $turn
	*/
	public function generatePlanningsFromMediumtermplanning(Turn $turn)
	{
		// nice midtermplannings scopeModules(Turn turn), but mediumterms have to be changed for that
		if (Entrust::hasRole('Admin') || Entrust::can('generate_planning_midterm_all')) // role Lehrplanung has to be changed to a permission
			$mediumtermplannings = Mediumtermplanning::specificTurn($turn)->get();
		else
		{
			$rg_ids = Entrust::user()->researchgroupIds();
			$mediumtermplannings = DB::table('mediumtermplannings')
									->join('employee_mediumtermplanning','employee_mediumtermplanning.mediumtermplanning_id','=','mediumtermplannings.id')
									->join('employees','employees.id','=','employee_mediumtermplanning.employee_id')
									->select('mediumtermplannings.id')
									->where('mediumtermplannings.turn_id','=',$turn->id)
									->whereIn('employees.researchgroup_id',$rg_ids)
									->get();
			$mtp_ids = array();
			foreach ($mediumtermplannings as $mediumtermplanning) {
				array_push($mtp_ids, $mediumtermplanning->id);
			}
			$mediumtermplannings = Mediumtermplanning::whereIn('id',$mtp_ids)->get();
		}
		$warnmessage = "Es konnten nicht alle Veranstaltungen aus der mittelfristige Lehrplanung kopiert werden,
					da diese bereits im aktuellen Semester geplant wurden.<br> Folgende Veranstaltungen konnten nicht kopiert werden: ";
		$module = "";
		$listofcoursetypes = CourseType::orderBy('name', 'ASC')->lists('name','id');
		if (sizeof($mediumtermplannings) > 0)
		{
			foreach ($mediumtermplannings as $mtp)
			{
				// check if courses are already planned for this turn
				foreach ($mtp->module->courses as $course)
				{
					if ($listofcoursetypes[$course->course_type_id] == "Vorlesung")
					{
						$plannings = Planning::courseTurn($course,$turn)->get();					
						if (sizeof($plannings) == 0)
						{
							// the course isn't planned yet for this turn
							$planning = new Planning;
							$planning->turn_id = $turn->id;
							$planning->course_id = $course->id;
							$planning->researchgroup_status = 0;
							$planning->board_status = 0;
							$planning->comment = "";
							$planning->room_preference = "";
							$planning->group_number = 1;
							$planning->language = $course->language;
							$planning->course_title = $course->name;
							$planning->course_title_eng = $course->name_eng;
							$planning->course_number = $course->course_number;
							$planning->user_id = Entrust::user()->id;
							// saving the planning
							$planning->save();

							// log
							$action = "Planung generiert (".$turn->name." ".$turn->year."): ".$planning->course_number." ".
							$planning->course_title."; Gruppen-Nr. ".$planning->group_number;
							$planninglog = new Planninglog();
							$planninglog->add($planning, 0, $action, 0);

							$turn = Turn::find($turn->id); // refresh turn to get the current modules()
							$turn->saveExam($planning->course->module);
							// check if there employees assigned to the module
							if (sizeof($mtp->employees) > 0)
							{
								foreach ($mtp->employees as $employee)
								{
									// if the employee is annulled, he/she can be left out
									if ($employee->pivot->annulled == 0)
									{
										$planning->employees()->attach($employee->id,array(
												'semester_periods_per_week' => 0,
										));
										$action = "Mitarbeiter zugeordnet (".$turn->name." ".$turn->year."): ".$planning->course_number." ".$planning->course_title." Gruppen-Nr. ".$planning->group_number." ".$employee->firstname.' '.$employee->name.' (0 SWS)';
										$planninglog = new Planninglog();
										$planninglog->add($planning, 1, $action, 0);
									}
								}
							}
						}
						else
							$module .= $course->course_number.' ('.$mtp->module->short.');';
					}
					
					else
					{
						// generate the number of courses that are needed to match the participant number of the lecture
						$result = DB::table('courses')
											->join('course_types','course_types.id','=','courses.course_type_id')
											->select('courses.participants')
											->where('courses.module_id','=',$course->module_id)
											->where('course_types.name','=','Vorlesung')
											->first();
						if (sizeof($result) > 0) 
						{
							$number_of_groups = ceil($result->participants/$course->participants);
							for ($i=1; $i <= $number_of_groups; $i++) 
							{ 
								$plannings = Planning::courseTurnGroup($course,$turn,$i)->get();					
								if (sizeof($plannings) == 0)
								{
									// the course isn't planned yet for this turn
									$planning = new Planning;
									$planning->turn_id = $turn->id;
									$planning->course_id = $course->id;
									$planning->researchgroup_status = 0;
									$planning->board_status = 0;
									$planning->comment = "";
									$planning->room_preference = "";
									$planning->group_number = $i;
									$planning->language = $course->language;
									$planning->course_title = $course->name;
									$planning->course_title_eng = $course->name_eng;
									$planning->course_number = $course->course_number;
									$planning->user_id = Entrust::user()->id;
									// saving the planning
									$planning->save();

									// log
									$action = "Planung generiert (".$turn->name." ".$turn->year."): ".$planning->course_number." ".
									$planning->course_title."; Gruppen-Nr. ".$planning->group_number;
									$planninglog = new Planninglog();
									$planninglog->add($planning, 0, $action, 0);

									$turn = Turn::find($turn->id); // refresh turn to get the current modules()
									$turn->saveExam($planning->course->module);
									$planninglog = new Planninglog();
								}
								else
									$module .= $course->course_number.' ('.$mtp->module->short.');';
							}
						}
						else
						{
							$plannings = Planning::courseTurn($course,$turn)->get();					
							if (sizeof($plannings) == 0)
							{
								// the course isn't planned yet for this turn
								$planning = new Planning;
								$planning->turn_id = $turn->id;
								$planning->course_id = $course->id;
								$planning->researchgroup_status = 0;
								$planning->board_status = 0;
								$planning->comment = "";
								$planning->room_preference = "";
								$planning->group_number = 1;
								$planning->language = $course->language;
								$planning->course_title = $course->name;
								$planning->course_title_eng = $course->name_eng;
								$planning->course_number = $course->course_number;
								$planning->user_id = Entrust::user()->id;
								// saving the planning
								$planning->save();

								// log
								$action = "Planung generiert (".$turn->name." ".$turn->year."): ".$planning->course_number." ".
								$planning->course_title."; Gruppen-Nr. ".$planning->group_number;
								$planninglog = new Planninglog();
								$planninglog->add($planning, 0, $action, 0);

								$turn = Turn::find($turn->id); // refresh turn to get the current modules()
								$turn->saveExam($planning->course->module);
								// check if there employees assigned to the module
								if (sizeof($mtp->employees) > 0)
								{
									foreach ($mtp->employees as $employee)
									{
										// if the employee is annulled, he/she can be left out
										if ($employee->pivot->annulled == 0)
										{
											$planning->employees()->attach($employee->id,array(
													'semester_periods_per_week' => 0,
											));
											$action = "Mitarbeiter zugeordnet (".$turn->name." ".$turn->year."): ".$planning->course_number." ".$planning->course_title." Gruppen-Nr. ".$planning->group_number." ".$employee->firstname.' '.$employee->name.' (0 SWS)';
											$planninglog = new Planninglog();
											$planninglog->add($planning, 1, $action, 0);
										}
									}
								}
							}
							else
								$module .= $course->course_number.' ('.$mtp->module->short.');';
						}
					}
				}
			}
			if ($module == "")
				return Redirect::route('plannings.indexTurn', $turn->id)->with('message', 'Lehrveranstaltungen erfolgreich aus der mittelfristigen Lehrplanung generiert.');
			else 
				return Redirect::route('plannings.indexTurn', $turn->id)->with('error', $warnmessage.''.$module);
		}
		else 
			return Redirect::route('plannings.indexTurn', $turn->id)->with('error', 'Es existiert keine mittelfristige Planung für dieses Semester.');
		
	}
	
	/**
	* copy given plannings
	* @param Turn $turn
	* @param array $plannings
	* @param boolean $copy_employees
	* @param boolean $copy_comments
	* @param boolean $copy_room_preferences
	*/
	private function copyPlannings(Turn $turn, $plannings, $copy_employees, $copy_comments, $copy_room_preferences)
	{
		$copyall = true;
		$warnmessage = "Es konnten nicht alle Veranstaltungen aus dem letzten Semester kopiert werden,
					da diese bereits im aktuellen Semester geplant wurden.<br> Folgende Veranstaltungen konnten nicht kopiert werden: ";
		foreach ($plannings as $planning)
		{
			$duplicate = Planning::where('course_id','=',$planning->course_id)
								->where('turn_id','=',$turn->id)
								->where('group_number','=',$planning->group_number)
								->where('course_title', '=', $planning->course_title)
								->first();
			$result =  Planning::where('course_id','=',$planning->course_id)
								->where('turn_id','=',$turn->id)
								->get();
			$listofcoursetypes = CourseType::orderBy('short', 'ASC')->lists('short','id');
			if (sizeof($duplicate) == 0)
			{
				// if not, copy it
				// Saving the course for the new turn
				$planningnew = new Planning;
				$planningnew->turn_id = $turn->id;
				$planningnew->course_id = $planning->course_id;
				$planningnew->researchgroup_status = 0;
				$planningnew->board_status = 0;
				$planningnew->group_number = $planning->group_number;
				$planningnew->language = $planning->language;
				$planningnew->user_id = Entrust::user()->id;
				$planningnew->course_title = $planning->course_title;
				$planningnew->course_title_eng = $planning->course_title_eng;
				if ($planning->course->course_type_id == 4 || $planning->course->course_type_id == 1 || $planning->course->course_type_id == 8 || $planning->course->course_type_id == 9)
					$planningnew->course_number = $planning->course_number;
				else
					$planningnew->course_number = $listofcoursetypes[$planning->course->course_type_id].'-'.(sizeof($result)+1);

				if ($copy_comments == 1)
					$planningnew->comment = $planning->comment;

				if ($copy_room_preferences == 1)
					$planningnew->room_preference = $planning->room_preference;

				$planningnew->save();
				// log
				$action = "Planung kopiert (".$turn->name." ".$turn->year."): ".$planningnew->course_number." ".
				$planningnew->course_title."; Gruppen-Nr. ".$planningnew->group_number."; Bemerkung: ".$planningnew->comment."; Raumwunsch: ".
				$planningnew->room_preference;
				$planninglog = new Planninglog();
				$planninglog->add($planningnew, 0, $action, 0);
				
				if ($copy_employees == 1)
				{
					// getting the employees from employee_turn from the old course turn and copy it
					$planning = Planning::find($planning->id);
					$employees = $planning->employees;
					if (sizeof($employees) > 0 )
					{
						foreach ($employees as $employee)
						{
							$planningnew->employees()->attach($employee->id, array(
									'semester_periods_per_week' => $employee->pivot->semester_periods_per_week,
									'created_at' => new Datetime,
									'updated_at' => new Datetime
							));
							$action = "Mitarbeiter zugeordnet (".$turn->name." ".$turn->year."): ".$planningnew->course_number." ".$planningnew->course_title." Gruppen-Nr. ".$planningnew->group_number." ".$employee->firstname.' '.$employee->name.' ('.$employee->pivot->semester_periods_per_week.' SWS)';
							$planninglog = new Planninglog();
							$planninglog->add($planningnew, 1, $action, 0);
						}
					}
				}
				
				// getting exam type
				$turn = Turn::find($turn->id); // refresh turn to get the current modules()
				$turn->saveExam($planning->course->module);
			}
			else
			{
				// if yes, do nothing
				$copyall = false;
				$course = Course::find($planning->course_id);
				$warnmessage .= $course->course_number." (".$planning->group_number.");";
			}
		}
		$result = array();
		$result['copyall'] = $copyall;
		$result['warnmessage'] = $warnmessage;
		return $result;
	}

	/**
	* generate lists seperated by course types
	*/
	private function getCourseTypes(Turn $turn)
	{
		// getting planed modules
		$planned_modules = DB::table('plannings')
								->join('courses','courses.id','=','plannings.course_id')
								->select('courses.module_id')
								->where('plannings.turn_id','=',$turn->id)
								->groupBy('courses.module_id')
								->get();
		if (sizeof($planned_modules) > 0)
		{
			$planned_modules_ids = array();
			foreach ($planned_modules as $plm) {
				array_push($planned_modules_ids, $plm->module_id);
			}
			$lists['bachelor'] = Module::where('degree_id','=',1)->where('individual_courses','=',0)->whereNotIn('id',$planned_modules_ids)->orderBy('name')->lists('name','id'); // TODO ids are hard coded
			$lists['master'] = Module::where('degree_id','=',2)->where('individual_courses','=',0)->whereNotIn('id',$planned_modules_ids)->orderBy('name')->lists('name','id');
		}
		else
		{
			$lists['bachelor'] = Module::where('degree_id','=',1)->where('individual_courses','=',0)->orderBy('name')->lists('name','id'); // TODO ids are hard coded
			$lists['master'] = Module::where('degree_id','=',2)->where('individual_courses','=',0)->orderBy('name')->lists('name','id');
		}
		$plannings = Planning::where('turn_id','=',$turn->id)->get();
		$course_ids = array();
		foreach ($plannings as $p) {
			array_push($course_ids, $p->course_id);
		}
		
		//lectures
		
		if (sizeof($course_ids) > 0)
			$lectures = Course::whereIn('course_type_id',array(1,8))->whereNotIn('id',$course_ids)->where('department_id','=',1)->orderBy('name','ASC')->get();
		else
			$lectures = Course::whereIn('course_type_id',array(1,8))->where('department_id','=',1)->orderBy('name','ASC')->get();

		if (sizeof($lectures) > 0)
		{
			$lecture_list = array();
			foreach ($lectures as $l) {
				$lecture_list = array_add($lecture_list, $l->id, $l->name .' ('.$l->module->short.')');
			}
			$lists['lecture'] = $lecture_list;
		}
		else
			$lists['lecture'] = array();

		$courses = Course::whereNotIn('course_type_id',array(1,8))->where('department_id','=',1)->orderBy('name','ASC')->get(); // TODO remove hard coded ids
		$lists['seminar'] =  array();
		$lists['exercise'] =  array();
		$lists['integrated_seminar'] =  array();
		$lists['proseminar'] =  array();
		$lists['project'] =  array();
		$lists['practical_course'] = array();
		$lists['other'] = array();
		foreach ($courses as $c) {
			switch ($c->course_type_id)
			{
				case 2:
					$lists['seminar'] = array_add($lists['seminar'], $c->id, $c->name.' ('.$c->module->short.')');
				break;
				case 3:
					$lists['integrated_seminar'] = array_add($lists['integrated_seminar'], $c->id, $c->name.' ('.$c->module->short.')');
				break;
				case 4:
					$lists['exercise'] = array_add($lists['exercise'], $c->id, $c->name.' ('.$c->module->short.')');
				break;
				case 5:
					$lists['proseminar'] = array_add($lists['proseminar'], $c->id, $c->name.' ('.$c->module->short.')');
				break;
				case 6:
					$lists['project'] = array_add($lists['project'], $c->id, $c->name.' ('.$c->module->short.')');
				break;
				case 7:
					$lists['practical_course'] = array_add($lists['practical_course'], $c->id, $c->name.' ('.$c->module->short.')');
				break;
				case 8:
					$lists['other'] = array_add($lists['other'], $c->id, $c->name.' ('.$c->module->short.')');
				break;
				case 9:
				case 10:
				case 11:
				default:
					$lists['other'] = array_add($lists['other'], $c->id, $c->name.' ('.$c->module->short.')');
				break;
			}
		}
		return $lists;
	}
	
	/**
	*
	*/
	// public function export()
	// {
	// 	$plannings = Planning::all();
	// 	$employee_planning = DB::table('employee_planning')->select('*')->get();
	// 	$planning_room = DB::table('planning_room')->select('*')->get();
	// 	$planninglogs = Planninglog::all();
	// 	$module_turn = DB::table('module_turn')->select('*')->get();
	// 	$this->layout->content = View::make('plannings.export', compact('plannings','employee_planning', 'planning_room', 'planninglogs', 'module_turn'));
	// }

	/**
	* generate output for the conflict courses
	*/
	private function getConflictCourseSchedule($plannings)
	{
		$listofcoursetypes = CourseType::orderBy('short', 'ASC')->lists('short','id');
		$output = array();
		foreach ($plannings as $p) {
			foreach ($p->rooms as $room) {
				$e = array();
				$e['title'] = $p->course_number. ' '.$listofcoursetypes[$p->course->course_type_id].' '.$p->course_title.' Gruppe: '.$p->group_number;
				$day = $this->getWeekdayDate($room->pivot->weekday);
					
				$e['start'] = $day.'T'.$room->pivot->start_time;
				$e['end'] = $day.'T'.$room->pivot->end_time;
				$e['backgroundColor'] = '#32CD32';
				$e['borderColor'] = '#228B22';
				array_push($output, $e);
			}
		}
		return $output;
	}

	/**
	* generate output for the conflict courses
	* @param array<Planning>
	*/
	private function getSchedule($plannings)
	{
		$listofcoursetypes = CourseType::orderBy('short', 'ASC')->lists('short','id');
		$output = array();
		foreach ($plannings as $p) {
			foreach ($p->rooms as $room) {
				$e = array();
				$e['title'] = $p->course_number. ' '.$listofcoursetypes[$p->course->course_type_id].' '.$p->course->module->short.' ';
				foreach ($p->employees as $employee) {
					$e['title'] .= $employee->name.'; ';
				}
				$day = $this->getWeekdayDate($room->pivot->weekday);
					
				$e['start'] = $day.'T'.$room->pivot->start_time;
				$e['end'] = $day.'T'.$room->pivot->end_time;
				// $e['backgroundColor'] = '#32CD32';
				// $e['borderColor'] = '#228B22';
				array_push($output, $e);
			}
		}
		return $output;
	}
}