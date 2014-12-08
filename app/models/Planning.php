<?php

use LaravelBook\Ardent\Ardent;
class Planning extends Ardent {
	
	protected $fillable = ['turn_id', 'course_id','group_number', 'board_status', 'researchgroup_status', 'language', 'comment','user_id','course_title','course_title_eng','course_number', 'room_preference'];
	public static $rules = array(
			'group_number' => 'required',
			'board_status' => 'required',
			'researchgroup_status' => 'required',
			'language' => 'required',
	);
	
	public function turn()
	{
		return $this->belongsTo('Turn');
	}
	
	public function course()
	{
		return $this->belongsTo('Course');
	}
	
	public function employees()
	{
		return $this->belongsToMany('Employee')->withPivot('semester_periods_per_week','created_at','updated_at');
	}
	
	public function rooms()
	{
		return $this->belongsToMany('Room')->withPivot('weekday','start_time','end_time','created_at','updated_at');
	}

	public function planninglogs()
	{
		return $this->hasMany('Planninglog');
	}
	public function user()
	{
		return $this->belongsTo('User');
	}
	
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
	 * Returns the courses which could be in conflikt with the current planning
	 * but only lectures will be returned
	 * @return array of plannings
	 */
	public function getConflictCourses()
	{
		// get all the degree courses where the target module is mandatory
		$conflictplannings = array();
		$degreecourses = DB::table('degree_course_module')
							->join('sections', 'sections.id','=', 'degree_course_module.section') 
							->select('degree_course_module.degree_course_id', 'degree_course_module.semester')
							->where('sections.name','=', 'Pflicht')
							->where('degree_course_module.module_id','=',$this->course->module_id) // TODO it needs to be checked, if the course belongs to a module
							->get();
		// get all modules which in the same semester as the target module and also mandatory
		$modules = array();
		foreach ($degreecourses as $dg)
		{
			$result = DB::table('degree_course_module')
						->select('module_id')
						->where('degree_course_id','=',$dg->degree_course_id)
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
							->where('course_type_id','=',1) // Check before if it's a "Vorlesung"
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
	* Returns true, if the course exists
	* @return boolean
	*/
	public static function checkDuplicate(Turn $turn, Course $course, $group_number)
	{
		$result = static::where('course_id','=',$course->id)
					->where('turn_id','=',$turn->id)
					->where('group_number','=',$group_number)
					->first();
		if (sizeof($result) == 0)
			return false;
		else			
			return true;
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
		$this->course_number = $course->course_number;
		$this->course_title = $course->name;
		$this->course_title_eng = $course->name_eng;
		$this->semester_periods_per_week = $course->semester_periods_per_week;
		$this->user_id = Entrust::user()->id;
		$this->teaching_assignment = 0;
		if ($input['board_status'] != "")
			$this->board_status = 1;
		if ($input['researchgroup_status'] != "")
			$this->researchgroup_status = 1;
	}
}