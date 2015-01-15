<?php


use LaravelBook\Ardent\Ardent;
class Department extends Ardent {
	 
	protected $fillable = ['name', 'short'];
	public static $rules = array(
			'name' => 'required|min:3',
			'short'=> 'required|min:2',
	);
	
	/**
	 * return a list of related modules
	 * @return [type] [description]
	 */
	public function modules()
	{
		return $this->hasMany('Module');
	}
	
	/**
	 * returns a list of related research groups
	 * @return [type] [description]
	 */
	public function researchgroups()
	{
		return $this->hasMany('Researchgroup')->orderBy('name', 'asc');
	}
	
	/**
	 * returns a list of related degree courses
	 * @return [type] [description]
	 */
	public function degreecourses()
	{
		return $this->hasMany('DegreeCourse')->orderBy('degree_id','asc')->orderBy('name','asc');
	}

	/**
	 * returns a list of related courses
	 * @return [type] [description]
	 */
	public function courses()
	{
		return $this->hasMany('Course');
	}
}