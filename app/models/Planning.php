<?php

use LaravelBook\Ardent\Ardent;
class Planning extends Ardent {
	
	protected $fillable = ['turn_id', 'course_id','group_number', 'board_status', 'researchgroup_status', 'language', 'comment','user_id','course_title','course_title_eng','course_number', 'room_preference'];
	public static $rules = array(
			'group_number' => 'required',
			'board_status' => 'required',
			'researchgroup_status' => 'required',
			'language' => 'required',
			'room_preference' => 'required'
	);
	
	/**
	 * fetch associated turn
	 * @return [type] [description]
	 */
	public function turn()
	{
		return $this->belongsTo('Turn');
	}
	
	/**
	 * fetch associated course
	 * @return [type] [description]
	 */
	public function course()
	{
		return $this->belongsTo('Course');
	}
	
	/**
	 * fetch associated employees
	 * @return [type] [description]
	 */
	public function employees()
	{
		return $this->belongsToMany('Employee')->withPivot('semester_periods_per_week','created_at','updated_at');
	}
	
	/**
	 * fetch associated rooms
	 * @return [type] [description]
	 */
	public function rooms()
	{
		return $this->belongsToMany('Room')->withPivot('weekday','start_time','end_time','created_at','updated_at');
	}

	/**
	 * fetch associated planning logs
	 * @return [type] [description]
	 */
	public function planninglogs()
	{
		return $this->hasMany('Planninglog');
	}

	/**
	 * fetch associated user
	 * @return [type] [description]
	 */
	public function user()
	{
		return $this->belongsTo('User');
	}
	
	/**
	 * scope to get related plannings
	 * 
	 * @param  [type] $query     [description]
	 * @param  [type] $plannings [description]
	 * @return [type]            [description]
	 */
	public function scopeRelated($query, $plannings)
	{
		return $query->whereIn('id',$plannings);
	}
	
	/**
	* Scope to get plannings with the same course id and turn id
	*/
	public function scopeCourseTurn($query, Course $course, Turn $turn)
	{
		return $query->where('course_id','=', $course->id)
					->where('turn_id','=', $turn->id);
	}

	/**
	* Scope to get plannings with the same course id, group number and turn id
	*/
	public function scopeCourseTurnGroup($query, Course $course, Turn $turn, $group)
	{
		return $query->where('course_id','=', $course->id)
					->where('turn_id','=', $turn->id)
					->where('group_number', '=', $group);
	}
	
	/**
	 * Scope for plannings with the same course
	 */
	public function scopeCourses($query, Course $course)
	{
		return $query->where('course_id', '=', $course->id);
	}
	
	/**
	 *	Scope for plannings with specific courses in a specific turn
	 *	Used in PlanningsController
	 */
	public function scopeCourseRangeTurn($query, $courserange, $turnid)
	{
		return $query->whereIn('course_id', $courserange)
					->where('turn_id','=',$turnid);
	}

	/**
	 * Scope to get all plannings from the same turn
	 */
	public function scopeTurnCourses($query, Turn $turn)
	{
		return $query->where('turn_id','=',$turn->id);
	}

	/**
	 * Scope to check if there is already a course with the same course id, turn id and group number
	 */
	public function scopeCheckDuplicate($query, $courseId, $turnId, $groupNumber)
	{
		return $query->where('course_id','=',$courseId)
					->where('turn_id','=',$turnId)
					->where('group_number','=',$groupNumber);
	}

	/**
	 * Scope to check if there is already a course with the same course id, turn id and group number
	 */
	public function scopeCheckDuplicateIndividualCourse($query, $courseId, $turnId, $courseTitle)
	{
		return $query->where('course_id','=',$courseId)
					->where('turn_id','=',$turnId)
					->where('course_title','=',$courseTitle);
	}

	/**
	 * scope to check if a room is available at a given weekday and time
	 * 
	 * @param  [type] $query     [description]
	 * @param  [type] $turnId    [description]
	 * @param  [type] $roomId    [description]
	 * @param  [type] $weekday   [description]
	 * @param  [type] $starttime [description]
	 * @param  [type] $endtime   [description]
	 * @return [type]            [description]
	 */
	public function scopeCheckRoomAvailability($query, $turnId, $roomId, $weekday, $starttime, $endtime)
	{
		return $query->join('planning_room', 'planning_room.planning_id','=','plannings.id')
					->where('plannings.turn_id', '=', $turnId) // Import to select ohne results from the same turn
					->where('planning_room.weekday','=' ,$weekday)
					->where('planning_room.room_id','=', $roomId)
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
					});
	}

	/**
	 * [scopeCheckRoomAvailabilityUpdate description]
	 * @param  [type] $query          [description]
	 * @param  [type] $turnId         [description]
	 * @param  [type] $roomId         [description]
	 * @param  [type] $weekday        [description]
	 * @param  [type] $starttime      [description]
	 * @param  [type] $endtime        [description]
	 * @param  [type] $planningRoomId [description]
	 * @return [type]                 [description]
	 */
	public function scopeCheckRoomAvailabilityUpdate($query, $turnId, $roomId, $weekday, $starttime, $endtime, $planningRoomId)
	{
		return $query->join('planning_room','plannings.id','=','planning_room.planning_id')
						->where('planning_room.weekday','=' ,$weekday)
						->where('plannings.turn_id', '=', $turnId)
						->where('planning_room.room_id','=', $roomId)
						->where('planning_room.id', '!=', $planningRoomId)
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
						});
	}

	/**
	 * scope to delete a specific room assignment
	 * @param  [type] $query      [description]
	 * @param  [type] $roomId     [description]
	 * @param  [type] $planningId [description]
	 * @param  [type] $weekday    [description]
	 * @param  [type] $starttime  [description]
	 * @return [type]             [description]
	 */
	public function scopeDetachRoomAssignment($query, $roomId, $planningId, $weekday, $starttime)
	{
		return $query->join('planning_room', 'planning_room.planning_id', '=', 'plannings.id')
					->where('planning_room.room_id','=', $roomId)
					->where('planning_room.planning_id', '=', $planningId)
					->where('planning_room.weekday', '=', $weekday)
					->where('planning_room.start_time','=', $starttime);
	}

	/**
	 * Returns the courses which could be in conflikt with the current planning
	 * but only lectures will be returned
	 * @return array of plannings
	 */
	public function getConflictCourses()
	{
		// get all the degree courses where the target module is mandatory
		$conflictplannings = array();
		$degreecourses = DB::table('degreecourse_module')
							->join('sections', 'sections.id','=', 'degreecourse_module.section') 
							->select('degreecourse_module.degreecourse_id', 'degreecourse_module.semester')
							->where('sections.name','=', 'Pflicht')
							->where('degreecourse_module.module_id','=',$this->course->module_id) // TODO it needs to be checked, if the course belongs to a module
							->get();
		// get all modules which in the same semester as the target module and also mandatory
		$modules = array();
		foreach ($degreecourses as $dg)
		{
			$result = DB::table('degreecourse_module')
						->select('module_id')
						->where('degreecourse_id','=',$dg->degreecourse_id)
						->where('semester','=',$dg->semester)
						->where('section', '=', 1)
						->where('module_id','!=', $this->course->module_id)
						->get();
			foreach ($result as $r)
			{
				array_push($modules, $r->module_id);
			}
		}
		// remove the duplicates
		$modules = array_unique($modules);
		// get all lectures
		if (sizeof($modules) > 0)
		{
			$courses = Course::whereIn('module_id',$modules)
							->where('coursetype_id','=',1) // Check before if it's a "Vorlesung"
							->get();
			$conflictplannings = array();
			if (sizeof($courses) > 0)
			{
				$courserange = array();
				foreach ($courses as $course)
				{
					array_push($courserange, $course->id);
				}
				$conflictplannings = Planning::courseRangeTurn($courserange,$this->turn_id)->get();
			}
		}
		return $conflictplannings;
	}

	/**
	* Stores the information in the planning object
	* @param Turn $turn
	* @param Array $input
	* @param Course $course
	*/
	public function store(Turn $turn, $input, Course $course)
	{
		// check for duplicates
		$this->turn_id = $turn->id;
		$this->course_id = $course->id;
		$this->researchgroup_status = 0;
		$this->board_status = 0;
		$this->comment = $input['comment'];
		$this->room_preference = $input['room_preference'];
		$this->group_number = $input['group_number'];
		$this->language = $input['language'];

		if (array_key_exists('course_number', $input))
			$this->course_number = $input['course_number'];
		else
			$this->course_number = $course->course_number;

		if (array_key_exists('course_title', $input))
			$this->course_title = $input['course_title'];
		else
			$this->course_title = $course->name;

		if (array_key_exists('course_title_eng', $input))
			$this->course_title_eng = $input['course_title_eng'];
		else
			$this->course_title_eng = $course->name_eng;

		if (array_key_exists('semester_periods_per_week', $input))
			$this->semester_periods_per_week = $input['semester_periods_per_week'];
		else
			$this->semester_periods_per_week = $course->semester_periods_per_week;
		
		$this->user_id = Entrust::user()->id;
		$this->teaching_assignment = 0;
		if ($input['board_status'] != "")
			$this->board_status = 1;
		if ($input['researchgroup_status'] != "")
			$this->researchgroup_status = 1;
	}

	/**
	 * copy an old planning in to a new turn
	 * @param  Planning $planning [description]
	 * @param  Turn     $turn     [description]
	 * @param  [type]   $options  [description]
	 * @return [type]             [description]
	 */
	public function copy(Planning $planning, Turn $turn, $options)
	{
		$this->turn_id = $turn->id;
		$this->course_id = $planning->course->id;
		$this->researchgroup_status = 0;
		$this->board_status = 0;
		$this->group_number = $planning->group_number;
		$this->language = $planning->language;
		$this->course_title = $planning->course->name;
		$this->course_title_eng = $planning->course->name_eng;
		$this->semester_periods_per_week = $planning->course->semester_periods_per_week;
		$this->user_id = Entrust::user()->id;

		// identify if a generic course number is needed
		if ($planning->course->module->individual_courses == 0)
			$this->course_number = $planning->course->course_number;
		else
			$this->course_number = $planning->course->coursetype->short.' '.time();
		
		// check the options
		if (array_key_exists('comments', $options))
			$this->comment = 1;
		else
			$this->comment = 0;

		if (array_key_exists('room_preferences', $options))
			$this->room_preference = 1;
		else
			$this->room_preference = 0;

		if ($this->save())
			return true;
	}

	public function generatePlanning(Turn $turn, Course $course, $groupNumber)
	{
		$this->turn_id = $turn->id;
		$this->course_id = $course->id;
		$this->researchgroup_status = 0;
		$this->board_status = 0;
		$this->comment = "";
		$this->room_preference = "Angaben fehlen!";
		$this->group_number = $groupNumber;
		$this->language = $course->language;
		$this->course_title = $course->name;
		$this->course_title_eng = $course->name_eng;
		$this->course_number = $course->course_number;
		$this->user_id = Entrust::user()->id;
	}

	/**
	 * update the information of the planning
	 * @param  [type] $input [description]
	 * @return [type]        [description]
	 */
	public function updateInformation($input)
	{
		$this->comment = $input['comment'];
		$this->room_preference = $input['room_preference'];
		$this->language = $input['language'];
		$this->course_number = $input['course_number'];
		$this->course_title_eng = $input['course_title_eng'];
		$this->course_title = $input['course_title'];
		$this->researchgroup_status = $input['researchgroup_status'];
		$this->board_status = $input['board_status'];

		if ($this->updateUniques())
			return true;
	}

	/**
	 * delete a specific room assignment
	 * @param  [type] $input [description]
	 * @return [type]        [description]
	 */
	public function deleteRoomAssignment($input)
	{
		DB::table('planning_room')
			->where('room_id','=',$input['room_id'])
			->where('planning_id', '=', $this->id)
			->where('weekday', '=', $input['weekday'])
			->where('start_time','=', $input['start_time'])
			->delete();
	}
}