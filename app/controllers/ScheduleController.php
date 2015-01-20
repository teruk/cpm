<?php

class ScheduleController extends \BaseController 
{
	
	/**
	 * get a schedule for a default degree course
	 * @param  Turn   $turn [description]
	 * @return [type]       [description]
	 */
	public function getDefaultSchedule(Turn $turn)
	{
		$specialistregulation = Specialistregulation::first();
		$this->setScheduleSession($turn->id, $specialistregulation->id, 1);

		return Redirect::route('showSelectedSchedule_path');
	}

	/**
	 * get schedule for a specific degree course semester
	 * @param  Turn         $turn         [description]
	 * @param  Specialistregulation $specialistregulation [description]
	 * @param  [type]       $semester     [description]
	 * @return [type]                     [description]
	 */
	public function getSchedule(Turn $turn, Specialistregulation $specialistregulation, $semester)
	{
		$this->setScheduleSession($turn->id, $specialistregulation->id, $semester);

		return Redirect::route('showSelectedSchedule_path');
	}

	/**
	* show schedule for a degree course
	*/
	public function fetchSchedule()
	{
		$input = Input::all();
		$this->setScheduleSession($input['turnId'], $input['specialistregulationId'], $input['semester']);

		return Redirect::route('showSelectedSchedule_path');
	}

	/**
	 * generate the output schedule
	 * @return [type] [description]
	 */
	public function generateSchedule()
	{
		$specialistregulations = Specialistregulation::getList();
		$turns = Turn::getAvailableTurns();
		
		$turn = Turn::findOrFail(Session::get('overview_schedule_turn'));
		$specialistregulation = Specialistregulation::findOrFail(Session::get('overview_schedule_specialistregulation'));
		$semester = Session::get('overview_schedule_semester');

		$output = $this->generate();

		$this->layout->content = View::make('overviews.schedule', compact('output','specialistregulation', 'specialistregulations', 'turns', 'semester', 'turn'));
	}

	/**
	 * store the values in session variables
	 * @param [type] $turnId         [description]
	 * @param [type] $degreecourseId [description]
	 * @param [type] $semester       [description]
	 */
	private function setScheduleSession($turnId, $specialistregulationId, $semester)
	{
		Session::set('overview_schedule_turn', $turnId);
		Session::set('overview_schedule_specialistregulation', $specialistregulationId);
		Session::set('overview_schedule_semester', $semester);
	}

	/**
	* generate the output for a degree course semester for a specific turn
	* @return $output
	*/
	private function generate()
	{
		$semester = Session::get('overview_schedule_semester');
		$specialistregulationId = Session::get('overview_schedule_specialistregulation');
		$turnId = Session::get('overview_schedule_turn');

		$coursetypes = CourseType::lists('short','id');
		// Get all lectures
		if ($semester > 0) {
			// for specific semester of a degree course
			$events = DB::table('planning_room')
					->join('plannings','plannings.id', '=', 'planning_room.planning_id')
					->join('courses', 'courses.id', '=', 'plannings.course_id')
					->join('module_specialistregulation','module_specialistregulation.module_id','=','courses.module_id')
					->join('modules', 'modules.id','=','module_specialistregulation.module_id')
					->join('rooms', 'rooms.id', '=','planning_room.room_id')
					->select('plannings.group_number', 'modules.short', 'rooms.name AS rname', 'courses.name AS cname', 'plannings.course_number', 'courses.coursetype_id', 'planning_room.weekday', 'planning_room.start_time', 'planning_room.end_time','module_specialistregulation.section')
					->where('plannings.turn_id','=',$turnId)
					->where('module_specialistregulation.specialistregulation_id','=', $specialistregulationId)
					->where('module_specialistregulation.semester','=', $semester)
					->where('courses.coursetype_id', '=', 1)
					->get();
		} else {
			// for all semesters of a degree course
			$events = DB::table('planning_room')
					->join('plannings','plannings.id', '=', 'planning_room.planning_id')
					->join('courses', 'courses.id', '=', 'plannings.course_id')
					->join('module_specialistregulation','module_specialistregulation.module_id','=','courses.module_id')
					->join('modules', 'modules.id','=','module_specialistregulation.module_id')
					->join('rooms', 'rooms.id', '=','planning_room.room_id')
					->select('plannings.group_number', 'modules.short', 'rooms.name AS rname', 'courses.name AS cname', 'plannings.course_number', 'courses.coursetype_id', 'planning_room.weekday', 'planning_room.start_time', 'planning_room.end_time','module_specialistregulation.section')
					->where('plannings.turn_id','=',$turnId)
					->where('module_specialistregulation.specialistregulation_id','=', $specialistregulationId)
					->where('courses.coursetype_id', '=', 1)
					->groupBy('planning_room.id') // Important
					->get();
		}
		// generate the output
		$output = array();
		foreach ($events as $event) {
			$e = array();
			$e['title'] = $event->course_number. ' '.$coursetypes[$event->coursetype_id].' '.$event->short.' ('.$event->rname.')';
			$day = $this->getWeekdayDate($event->weekday);
			$e['start'] = $day.'T'.$event->start_time;
			$e['end'] = $day.'T'.$event->end_time;
			if ($event->section == 1) {
				if ($event->coursetype_id == 1) {
					$e['backgroundColor'] = '#32CD32';
					$e['borderColor'] = '#228B22';
				}
			} else {
				$e['backgroundColor'] = '#BA55D3';
				$e['borderColor'] = '#4B0082';
			}
			array_push($output, $e);
		}
		// get all course types except lectures
		if ($semester > 0)
		{
			// for a specific semester of a degree course
			$events = DB::table('planning_room')
				->join('plannings','plannings.id', '=', 'planning_room.planning_id')
				->join('courses', 'courses.id', '=', 'plannings.course_id')
				->join('module_specialistregulation','module_specialistregulation.module_id','=','courses.module_id')
				->join('modules', 'modules.id','=','module_specialistregulation.module_id')
				->join('rooms', 'rooms.id', '=','planning_room.room_id')
				->select('plannings.group_number', 'modules.short', 'rooms.name AS rname', 'courses.name AS cname', 'plannings.course_number', 'courses.coursetype_id', 'planning_room.weekday', 'planning_room.start_time', 'planning_room.end_time','module_specialistregulation.section')
				->where('plannings.turn_id','=',$turnId)
				->where('module_specialistregulation.specialistregulation_id','=', $specialistregulationId)
				->where('module_specialistregulation.semester','=', $semester)
				->whereNotIn('courses.coursetype_id', array(1))
				->orderBy('module_specialistregulation.module_id', 'ASC')
				->orderBy('plannings.course_number','ASC')
				->orderBy('plannings.group_number','ASC')
				->get();
		} else {
			// for all semesters of a degree course
			$events = DB::table('planning_room')
				->join('plannings','plannings.id', '=', 'planning_room.planning_id')
				->join('courses', 'courses.id', '=', 'plannings.course_id')
				->join('module_specialistregulation','module_specialistregulation.module_id','=','courses.module_id')
				->join('modules', 'modules.id','=','module_specialistregulation.module_id')
				->join('rooms', 'rooms.id', '=','planning_room.room_id')
				->select('plannings.group_number', 'modules.short', 'rooms.name AS rname', 'courses.name AS cname', 'plannings.course_number', 'courses.coursetype_id', 'planning_room.weekday', 'planning_room.start_time', 'planning_room.end_time','module_specialistregulation.section')
				->where('plannings.turn_id','=',$turnId)
				->where('module_specialistregulation.specialistregulation_id','=', $specialistregulationId)
				->whereNotIn('courses.coursetype_id', array(1))
				->orderBy('module_specialistregulation.module_id', 'ASC')
				->orderBy('plannings.course_number','ASC')
				->orderBy('plannings.group_number','ASC')
				->get();
		}
		$module_short = "";
		$weekday = "";
		$starttime = "";
		$group_number = "";
		$e = array();
		foreach ($events as $event) {
			// check if it's the course id, group number
			if (
				$event->short != $module_short || 
				(
					$weekday != $event->weekday || 
					$starttime != $event->start_time
				) || 
				$event->group_number != $group_number
			) {
				if (sizeof($e) > 0) {
					if ($event->section == 2) {
						$e['backgroundColor'] = '#BA55D3';
						$e['borderColor'] = '#4B0082';
					}
					array_push($output, $e);
				}

				$module_short = $event->short;
				$weekday = $event->weekday;
				$starttime = $event->start_time;
				$group_number = $event->group_number;
				$e = array();
				$e['title'] = $event->course_number. ' '.$coursetypes[$event->coursetype_id].'-'.$event->group_number.' '.$event->short.' '.$event->rname;
				$day = $this->getWeekdayDate($event->weekday);
				$e['start'] = $day.'T'.$event->start_time;
				$e['end'] = $day.'T'.$event->end_time;
			} else {
				$e['title'] .= ', '.$event->rname;
			}
		}

		if (sizeof($e) > 0) {
			if ($event->section == 2) {
				$e['backgroundColor'] = '#BA55D3';
				$e['borderColor'] = '#4B0082';
			}
			array_push($output, $e); // to push the last exercise group in the array
		}

		return $output;
	}
}
