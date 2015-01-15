<?php

use LaravelBook\Ardent\Ardent;
class Course extends Ardent {
	
	protected $fillable = [
		'name',
		'name_eng', 
		'course_number', 
		'coursetype_id', 
		'module_id', 
		'participants', 
		'language', 
		'semester_periods_per_week', 
		'department_id'
		];

	public static $rules = [
			'name' => 'required',
			'course_number' => 'required|unique:courses|min:3',
			'coursetype_id' => 'required',
			'participants' => 'required|min:1',
			'language' => 'required',
			'semester_periods_per_week' => 'required|min:0',
		];
		
	protected $table = 'courses';
	
	/**
	 * returns the course type relation
	 * @return [type] [description]
	 */
	public function coursetype()
	{
		return $this->belongsTo('Coursetype');
	}
	
	/**
	 * returns the module relation
	 * @return [type] [description]
	 */
	public function module()
	{
		return $this->belongsTo('Module');
	}
	
	/**
	 * returns the department relation
	 * @return [type] [description]
	 */
	public function department()
	{
		return $this->belongsTo('Department');
	}

	/**
	 * returns the related plannings
	 * @return [type] [description]
	 */
	public function plannings()
	{
		return $this->hasMany('Planning');
	}

	/**
	* returns only specific course types
	**/
	public function scopeCommonCourses($query, $coursetype_range)
	{
		return $query->whereIn('coursetype_id',$coursetype_range)->orderBy('course_number','DESC');
	}

	/**
	 * returns the lecture course of a module
	 * @param  [type] $query  [description]
	 * @param  Course $course [description]
	 * @return [type]         [description]
	 */
	public function scopeRelatedLecture($query, Course $course)
	{
		return $query->join('coursetypes','coursetypes.id','=','courses.coursetype_id')
					->select('courses.participants')
					->where('courses.module_id','=',$course->module_id)
					->where('coursetypes.name','=','Vorlesung');
	}
}