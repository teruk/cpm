<?php

use LaravelBook\Ardent\Ardent;
class CourseType extends Ardent {
	
	protected $fillable = ['name', 'short', 'description'];
	public static $rules = array(
			'name' => 'required|unique:course_types',
			'short' => 'required|unique:course_types'
	);
	public $timestamps = false;
	protected $table = 'course_types';
	
	public function courses()
	{
		return $this->hasMany('Course');
	}
}