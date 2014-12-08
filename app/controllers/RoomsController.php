<?php

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
class RoomsController extends BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /rooms
	 *
	 * @return Response
	 */
	public function index()
	{
		$rooms = Room::all();
		$listofroomtypes = RoomType::orderBy('name','ASC')->lists('name','id');
		$this->layout->content = View::make('rooms.index', compact('rooms','listofroomtypes'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /rooms/create
	 *
	 * @return Response
	 */
	public function create()
	{
// 		$this->layout->content = View::make('degree_courses.index');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /rooms
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$room = new Room($input);

		if (Input::get('beamer')==1)
			$room->beamer = Input::get('beamer');
		else 
			$room->beamer = 0;

		if (Input::get('blackboard')==1)
			$room->blackboard = Input::get('blackboard');
		else
			$room->blackboard = 0;

		if (Input::get('overheadprojector')==1)
			$room->overheadprojector = Input::get('overheadprojector');
		else
			$room->overheadprojector = 0;

		if (Input::get('accessible')==1)
			$room->accessible = Input::get('accessible');
		else
			$room->accessible = 0;
		
		if ( $room->save() )
			return Redirect::route('rooms.index')->with('message', 'Raum erfolgreich erstellt!');
		else
			return Redirect::route('rooms.index')->withInput()->withErrors( $room->errors() );
	}

	/**
	 * Display the specified resource.
	 * GET /rooms/{id}
	 *
	 * @param  int  Room $room
	 * @return Response
	 */
	public function show(Room $room)
	{	
		$listofroomtypes = RoomType::orderBy('name','ASC')->lists('name','id');
		$this->layout->content = View::make('rooms.show', compact('room', 'listofroomtypes'));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /rooms/{id}
	 *
	 * @param  int  Room $room
	 * @return Response
	 */
	public function update(Room $room)
	{
		$input = Input::all();
		$room->fill($input);
		if (Input::get('beamer')==1)
			$room->beamer = Input::get('beamer');
		else
			$room->beamer = 0;

		if (Input::get('blackboard')==1)
			$room->blackboard = Input::get('blackboard');
		else
			$room->blackboard = 0;

		if (Input::get('overheadprojector')==1)
			$room->overheadprojector = Input::get('overheadprojector');
		else
			$room->overheadprojector = 0;

		if (Input::get('accessible')==1)
			$room->accessible = Input::get('accessible');
		else
			$room->accessible = 0;
 
		if ( $room->updateUniques() )
			return Redirect::route('rooms.show', $room->id)->with('message', 'Der Raum wurde aktualisiert.');
		else
			return Redirect::route('rooms.show', array_get($room->getOriginal(), 'id'))->withInput()->withErrors( $room->errors() );
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /rooms/{id}
	 *
	 * @param  int  Room $room
	 * @return Response
	 */
	public function destroy(Room $room)
	{
		$room->delete();
		return Redirect::route('rooms.index')->with('message', 'Raum erfolgreich gelöscht.');
	}
	
	/**
	* returns the schedule of a room
	*/
	public function overview()
	{
		if (Session::get('turn_id') == "" && Session::get('room_id') == "")
		{
			$turn = Turn::find(Setting::setting('current_turn')->first()->value);
			$room = Room::find(5);
		}
		else 
		{
			$turn = Turn::find(Session::get('turn_id'));
			$room = Room::find(Session::get('room_id'));
		}
		$output = $this->getRoomTurnSchedule($room, $turn);
		$listofturns = Turn::getList();
		$listofrooms = Room::getList();
		$listofroomtypes = RoomType::orderBy('name','ASC')->lists('name','id');
		$turns = Turn::all();
		$this->layout->content = View::make('rooms.overview', compact('output', 'outputTurns','room','turn','listofrooms', 'listofturns','listofroomtypes'));
	}

	/**
	* returns the schedule of a room
	*/
	public function getOverview()
	{
		return Redirect::route('rooms.overview')->with('turn_id', Input::get('turn_id'))
											->with('room_id', Input::get('room_id'));
	}

	/**
	* returns the schedule of a room
	*/
	public function showRoomSchedule(Turn $turn, Room $room)
	{
		return Redirect::route('rooms.overview')->with('turn_id', $turn->id)
											->with('room_id', $room->id);
	}
	
	/**
	* default show schedule for a degree course
	*/
	public function schedule()
	{
		$turn = Turn::find(Setting::setting('current_turn')->first()->value);
		$degreecourse = DegreeCourse::find(1);
		return Redirect::route('schedule.semester', array($turn->id, $degreecourse->id, 1));
	}
	
	/**
	* show schedule for a degree course
	*/
	public function getSchedule(Turn $turn, DegreeCourse $degreecourse, $semester)
	{
		if ($semester == "alle")
			$output = $this->getDegreecourseSemesterTurnSchedule($turn, $degreecourse, 0);
		else
			$output = $this->getDegreecourseSemesterTurnSchedule($turn, $degreecourse, $semester);

		$listofdegreecourses = DegreeCourse::getList();
		$listofturns = Turn::getList();
		$this->layout->content = View::make('rooms.schedule', compact('output','degreecourse','turn','listofdegreecourses', 'listofturns', 'semester'));
	}

	/**
	* show schedule for a degree course
	*/
	public function getDegreeCourseSchedule()
	{
		return Redirect::route('schedule.semester', array(Input::get('turn_id'), Input::get('degreecourse_id'), Input::get('semester')));
	}

	/**
	* generate the output for a degree course semester for a specific turn
	* @return $output
	*/
	private function getDegreecourseSemesterTurnSchedule(Turn $turn, DegreeCourse $degreecourse, $semester)
	{
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
					->where('plannings.turn_id','=',$turn->id)
					->where('degree_course_module.degree_course_id','=', $degreecourse->id)
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
					->where('plannings.turn_id','=',$turn->id)
					->where('degree_course_module.degree_course_id','=', $degreecourse->id)
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
				->where('plannings.turn_id','=',$turn->id)
				->where('degree_course_module.degree_course_id','=', $degreecourse->id)
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
				->where('plannings.turn_id','=',$turn->id)
				->where('degree_course_module.degree_course_id','=', $degreecourse->id)
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
	
	/**
	* generates room schedule output for the calender
	* @return $output
	*/
	private function getRoomTurnSchedule(Room $room, Turn $turn)
	{
		$events = DB::table('planning_room')
					->join('plannings','plannings.id', '=', 'planning_room.planning_id')
					->join('courses', 'courses.id', '=', 'plannings.course_id')
					->join('course_types', 'course_types.id', '=','courses.course_type_id')
					->select('plannings.group_number', 'courses.name', 'plannings.course_number', 'course_types.short', 'planning_room.weekday', 'planning_room.start_time', 'planning_room.end_time')
					->where('plannings.turn_id','=',$turn->id)
					->where('planning_room.room_id','=', $room->id)
					->get();
		$output = array();
		foreach ($events as $event)
		{
			$e = array();
			$e['title'] = $event->course_number. ' '.$event->short.' '.$event->name.' Gruppe: '.$event->group_number;
			$day = $this->getWeekdayDate($event->weekday);
				
			$e['start'] = $day.'T'.$event->start_time;
			$e['end'] = $day.'T'.$event->end_time;
			if ($event->short == "VL")
			{
				$e['backgroundColor'] = '#32CD32';
				$e['borderColor'] = '#228B22';
			}
			array_push($output, $e);
		}
		return $output;
// 		return Redirect::route('rooms.overview')->with('output',$output);
	}

}