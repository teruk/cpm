<?php

class ScheduleController extends \BaseController {

	/**
	* default show schedule for a degree course
	*/
	public function getDefaultSchedule()
	{
		$turn = Turn::find(Setting::setting('current_turn')->first()->value); // current turn
		$degreecourse = DegreeCourse::findOrFail(1);
		$this->setScheduleSession($turn->id, $degreecourse->id, 1);

		return Redirect::route('overview.generate_schedule');
	}
	
	/**
	* show schedule for a degree course
	*/
	public function getSpecificSchedule(Turn $turn, DegreeCourse $degreecourse, $semester)
	{
		$this->setScheduleSession($turn->id, $degreecourse->id, $semester);

		return Redirect::route('overview.generate_schedule');
	}

	/**
	* show schedule for a degree course
	*/
	public function grabSchedule()
	{
		$input = Input::all();
		$this->setScheduleSession($input['turn_id'], $input['degreecourse_id'], $input['semester']);

		return Redirect::route('overview.generate_schedule');
	}

	/**
	 * generate the output schedule
	 * @return [type] [description]
	 */
	public function generateSchedule()
	{
		$listofdegreecourses = DegreeCourse::getList();
		$listofturns = Turn::getList();
		$output = $this->generate();
		$turn = Turn::findOrFail(Session::get('overview_schedule_turn'));
		$degreecourse = DegreeCourse::findOrFail(Session::get('overview_schedule_degreecourse'));
		$semester = Session::get('overview_schedule_semester');

		$this->layout->content = View::make('overviews.schedule', compact('output','degreecourse', 'listofdegreecourses', 'listofturns', 'semester', 'turn'));
	}

	/**
	 * store the values in session variables
	 * @param [type] $turnId         [description]
	 * @param [type] $degreecourseId [description]
	 * @param [type] $semester       [description]
	 */
	private function setScheduleSession($turnId, $degreecourseId, $semester)
	{
		Session::set('overview_schedule_turn', $turnId);
		Session::set('overview_schedule_degreecourse', $degreecourseId);
		Session::set('overview_schedule_semester', $semester);
	}

	/**
	* generate the output for a degree course semester for a specific turn
	* @return $output
	*/
	private function generate()
	{
		$semester = Session::get('overview_schedule_semester');
		$degreecourseId = Session::get('overview_schedule_degreecourse');
		$turnId = Session::get('overview_schedule_turn');

		$listofcoursetypes = CourseType::lists('short','id');
		// Get all lectures
		if ($semester > 0)
		{
			// for specific semester of a degree course
			$events = DB::table('planning_room')
					->join('plannings','plannings.id', '=', 'planning_room.planning_id')
					->join('courses', 'courses.id', '=', 'plannings.course_id')
					->join('degree_course_module','degree_course_module.module_id','=','courses.module_id')
					->join('modules', 'modules.id','=','degree_course_module.module_id')
					->join('rooms', 'rooms.id', '=','planning_room.room_id')
					->select('plannings.group_number', 'modules.short', 'rooms.name AS rname', 'courses.name AS cname', 'plannings.course_number', 'courses.course_type_id', 'planning_room.weekday', 'planning_room.start_time', 'planning_room.end_time','degree_course_module.section')
					->where('plannings.turn_id','=',$turnId)
					->where('degree_course_module.degree_course_id','=', $degreecourseId)
					->where('degree_course_module.semester','=', $semester)
					->where('courses.course_type_id', '=', 1)
					->get();
		}
		else
		{
			// for all semesters of a degree course
			$events = DB::table('planning_room')
					->join('plannings','plannings.id', '=', 'planning_room.planning_id')
					->join('courses', 'courses.id', '=', 'plannings.course_id')
					->join('degree_course_module','degree_course_module.module_id','=','courses.module_id')
					->join('modules', 'modules.id','=','degree_course_module.module_id')
					->join('rooms', 'rooms.id', '=','planning_room.room_id')
					->select('plannings.group_number', 'modules.short', 'rooms.name AS rname', 'courses.name AS cname', 'plannings.course_number', 'courses.course_type_id', 'planning_room.weekday', 'planning_room.start_time', 'planning_room.end_time','degree_course_module.section')
					->where('plannings.turn_id','=',$turnId)
					->where('degree_course_module.degree_course_id','=', $degreecourseId)
					->where('courses.course_type_id', '=', 1)
					->groupBy('planning_room.id') // Important
					->get();
		}
		// generate the output
		$output = array();
		foreach ($events as $event)
		{
			$e = array();
			$e['title'] = $event->course_number. ' '.$listofcoursetypes[$event->course_type_id].' '.$event->short.' ('.$event->rname.')';
			$day = $this->getWeekdayDate($event->weekday);
			$e['start'] = $day.'T'.$event->start_time;
			$e['end'] = $day.'T'.$event->end_time;
			if ($event->section == 1)
			{
				if ($event->course_type_id == 1)
				{
					$e['backgroundColor'] = '#32CD32';
					$e['borderColor'] = '#228B22';
				}
			}
			else
			{
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
				->join('degree_course_module','degree_course_module.module_id','=','courses.module_id')
				->join('modules', 'modules.id','=','degree_course_module.module_id')
				->join('rooms', 'rooms.id', '=','planning_room.room_id')
				->select('plannings.group_number', 'modules.short', 'rooms.name AS rname', 'courses.name AS cname', 'plannings.course_number', 'courses.course_type_id', 'planning_room.weekday', 'planning_room.start_time', 'planning_room.end_time','degree_course_module.section')
				->where('plannings.turn_id','=',$turnId)
				->where('degree_course_module.degree_course_id','=', $degreecourseId)
				->where('degree_course_module.semester','=', $semester)
				->whereNotIn('courses.course_type_id', array(1))
				->orderBy('degree_course_module.module_id', 'ASC')
				->orderBy('plannings.course_number','ASC')
				->orderBy('plannings.group_number','ASC')
				->get();
		}
		else
		{
			// for all semesters of a degree course
			$events = DB::table('planning_room')
				->join('plannings','plannings.id', '=', 'planning_room.planning_id')
				->join('courses', 'courses.id', '=', 'plannings.course_id')
				->join('degree_course_module','degree_course_module.module_id','=','courses.module_id')
				->join('modules', 'modules.id','=','degree_course_module.module_id')
				->join('rooms', 'rooms.id', '=','planning_room.room_id')
				->select('plannings.group_number', 'modules.short', 'rooms.name AS rname', 'courses.name AS cname', 'plannings.course_number', 'courses.course_type_id', 'planning_room.weekday', 'planning_room.start_time', 'planning_room.end_time','degree_course_module.section')
				->where('plannings.turn_id','=',$turnId)
				->where('degree_course_module.degree_course_id','=', $degreecourseId)
				->whereNotIn('courses.course_type_id', array(1))
				->orderBy('degree_course_module.module_id', 'ASC')
				->orderBy('plannings.course_number','ASC')
				->orderBy('plannings.group_number','ASC')
				->get();
		}
		$module_short = "";
		$weekday = "";
		$starttime = "";
		$group_number = "";
		$e = array();
		foreach ($events as $event)
		{
			// check if it's the course id, group number
			if ($event->short != $module_short || ($weekday != $event->weekday || $starttime != $event->start_time) || $event->group_number != $group_number)
			{
				if (sizeof($e) > 0)
				{
					if ($event->section == 2)
					{
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
				$e['title'] = $event->course_number. ' '.$listofcoursetypes[$event->course_type_id].'-'.$event->group_number.' '.$event->short.' '.$event->rname;
				$day = $this->getWeekdayDate($event->weekday);
				$e['start'] = $day.'T'.$event->start_time;
				$e['end'] = $day.'T'.$event->end_time;
			}
			else
			{
				$e['title'] .= ', '.$event->rname;
			}
		}
		if (sizeof($e) > 0)
		{
			if ($event->section == 2)
			{
				$e['backgroundColor'] = '#BA55D3';
				$e['borderColor'] = '#4B0082';
			}
			array_push($output, $e); // to push the last exercise group in the array
		}
		return $output;
	}
}
