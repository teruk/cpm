<?php

use LaravelBook\Ardent\Ardent;
class Course extends Ardent {
	
	protected $fillable = ['name','name_eng', 'course_number', 'coursetype_id', 'module_id', 'participants', 'language', 'semester_periods_per_week', 'department_id'];
	public static $rules = array(
			'name' => 'required',
			'course_number' => 'required|unique:courses|min:3',
			'coursetype_id' => 'required',
			'participants' => 'required|min:1',
			'language' => 'required',
			'semester_periods_per_week' => 'required|min:0',
	);
	protected $table = 'courses';
	
	public function coursetype()
	{
		return $this->belongsTo('CourseType');
	}
	
	public function module()
	{
		return $this->belongsTo('Module');
	}
	
	public function department()
	{
		return $this->belongsTo('Department');
	}

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
}