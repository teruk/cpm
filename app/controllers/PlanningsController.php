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
		$current_turn = Turn::findOrFail(Setting::setting('current_turn')->first()->value);
		return Redirect::route('plannings.indexTurn', $current_turn->id);
	}

	/**
	*
	*/
	public function indexTurn(Turn $display_turn)
	{
		if (Entrust::hasRole('Admin') || Entrust::can('view_planning') || Entrust::user()->researchgroups->count() > 0)
		{
			$current_turn = Turn::findOrFail(Setting::setting('current_turn')->first()->value);
			$next_turn = Turn::nextTurn($current_turn)->first();
			$afternext_turn = Turn::turnAfterNext($current_turn)->first();
			// set the turn which will be displayed
			$before_turns = Turn::beforeTurns($display_turn)->get();
			$planned_courses = $this->getPlannedCourses($display_turn);

			$listofcoursetypes = CourseType::orderBy('short', 'ASC')->lists('short','id');
			// checking if the predecessor turn contains planned courses
			$predecessorturn = $display_turn->getPredecessor();
			$pastcourses = 0;
			if (!is_numeric($predecessorturn))
				$pastcourses = Planning::where('turn_id', '=', $predecessorturn->id)->count();
			$lists = $this->getCourseTypes($display_turn);
			$this->layout->content = View::make('plannings.index', compact('current_turn','next_turn', 'afternext_turn','before_turns','planned_courses', 'display_turn', 'lists', 'pastcourses', 'listofcoursetypes'));
		}
		
		Flash::error('Sie besitzen nicht die nötigen Rechte, um diesen Bereich zu betreten.');
		return Redirect::back();
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
			$rg_ids = $this->getIds(Entrust::user()->researchgroups);
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
	 * show all plannings
	 * 
	 * @param  Turn   $turn [description]
	 * @return [type]       [description]
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
		$current_turn = Turn::findOrFail(Setting::setting('current_turn')->first()->value);
		return Redirect::route('plannings.showSchedule',$current_turn->id);
	}

	/**
	* show week schedule
	* @param Turn $turn
	*/
	public function showSchedule(Turn $turn)
	{
		$current_turn = Turn::findOrFail(Setting::setting('current_turn')->first()->value);
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
		$current_turn = Turn::findOrFail(Setting::setting('current_turn')->first()->value);
		return Redirect::route('plannings.showRoomPreference',$current_turn->id);
	}

	/**
	* show room preference
	*/
	public function showRoomPreference(Turn $turn)
	{
		$current_turn = Turn::findOrFail(Setting::setting('current_turn')->first()->value);
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
			$course = Course::findOrFail($planning->course_id); // TODO checking if it's a problem, when a course doesn't belong to a module
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
		
		Flash::error('Sie besitzen keine Rechte für diesen Bereich!');
		return Redirect::route('home');
	}
	
	/**
	* update a specific planning
	* @param Turn $turn
	* @param Planning $planning
	*/
	public function update(Turn $turn, Planning $planning)
	{
		$duplicate = false;
		$input = Input::all();
		// check if the group number has changed
		if ($input['group_number'] != $planning->group_number)
		{
			// number has changed, check for a duplicate
			if (Planning::checkDuplicate($planning->course_id, $turn->id, $input['group_number'])->count() == 0)
				$planning->group_number = $input['group_number'];
			else
				$duplicate = true;
		}
		if ($planning->updateInformation($input))
		{
			// updating comment and room preferences
			Planning::where('turn_id','=',$turn->id)->where('course_number','=',$planning->course_number)->update(array(
				'comment' => $planning->comment, 'room_preference' => $planning->room_preference));
			// log
			$planninglog = new Planninglog();
			$planninglog->logUpdatedPlanning($planning, $turn);

			if (!$duplicate)
				return Redirect::back()->with('message', 'Veranstaltung erfolgreich aktualisiert.');
			
			return Redirect::back()->with('message', 'Veranstaltung erfolgreich aktualisiert.')
										->with('error', 'Die Gruppen-Nr konnte nicht aktualisiert werden, da schon eine Gruppe mit der selben Nummer existiert!');
		}

		Flash::error($planning->errors());
		return Redirect::back()->withInput();
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
				$oldResearchGroupStatus = $p->researchgroup_status;
				$oldBoardStatus = $p->board_status;

				$p->board_status = Input::get('board_status');
				$p->researchgroup_status = Input::get('researchgroup_status');
				$p->save();

				$planninglog = new Planninglog();
				$planninglog->logUpdatedPlanningStatus($planning, $turn, $oldBoardStatus, $oldResearchGroupStatus);
			}
			Flash::success('Die Status wurden erfolgreich aktualisiert.');
			return Redirect::route('plannings.statusOverview', $turn->id);
		}

		Flash::error('Es wurden keine Veranstaltungen ausgewählt.');
		return Redirect::route('plannings.statusOverview', $turn->id);
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
		$planninglog = new Planninglog();
		$planninglog->logDeletedPlanning($planning, $turn);

		$planning->delete();

		Flash::success('Veranstaltung erfolgreich gelöscht.');
		return Redirect::route('plannings.indexTurn', $turn->id);
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
		// log
		$planninglog = new Planninglog();
		$planninglog->logUpdatedPlanningExam($planning, $turn);

		Flash::success('Modulabschluss erfolgreich aktualisiert.');
		return Redirect::route('plannings.edit', array($turn->id, $planning->id))->with('tabindex', Input::get('tabindex'));
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
							$planning->room_preference = "Information fehlt!";
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

							$turn = Turn::findOrFail($turn->id); // refresh turn to get the current modules()
							$turn->saveExam($planning->course->module);
							// check if there employees assigned to the module
							if ($mtp->employees->count() > 0)
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

									$turn = Turn::findOrFail($turn->id); // refresh turn to get the current modules()
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

								$turn = Turn::findOrFail($turn->id); // refresh turn to get the current modules()
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
			{
				Flash::success('Lehrveranstaltungen erfolgreich aus der mittelfristigen Lehrplanung generiert.');
				return Redirect::back();
			}
			
			Flash::error($warnmessage.''.$module);
			return Redirect::back();
		}
		
		Flash::error('Es existiert keine mittelfristige Planung für dieses Semester.');
		return Redirect::back();
		
	}
	
	

	/**
	* generate lists seperated by course types
	*/
	private function getCourseTypes(Turn $turn)
	{
		// getting planed modules
		$planned_modules = Planning::with(array('course' => function($query)
			{
				$query->groupBy('module_id');
			}))->where('turn_id', '=', $turn->id)->get();

		if (sizeof($planned_modules) > 0)
		{
			$planned_modules_ids = $this->getIds($planned_modules);

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