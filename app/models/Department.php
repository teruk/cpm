<?php


use LaravelBook\Ardent\Ardent;
class Department extends Ardent {
	 
	protected $fillable = ['name', 'short'];
	public static $rules = array(
			'name' => 'required|min:3',
			'short'=> 'required|min:2',
	);
	
	public function modules()
	{
		return $this->hasMany('Module');
	}
	
	public function researchgroups()
	{
		return $this->hasMany('Researchgroup')->orderBy('name', 'asc');
	}
	
	public function degreecourses()
	{
		return $this->hasMany('DegreeCourse')->orderBy('degree_id','asc')->orderBy('name','asc');
	}
	
	public function courses()
	{
		return $this->hasMany('Course');
	}
}