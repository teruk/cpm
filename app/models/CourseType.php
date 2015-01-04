<?php

use LaravelBook\Ardent\Ardent;
class CourseType extends Ardent {
	
	protected $fillable = ['name', 'short', 'description'];
	public static $rules = array(
			'name' => 'required|unique:coursetypes',
			'short' => 'required|unique:coursetypes'
	);
	public $timestamps = false;
	protected $table = 'coursetypes';
	
	public function courses()
	{
		return $this->hasMany('Course');
	}
}