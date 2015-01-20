<?php

use LaravelBook\Ardent\Ardent;
class Degree extends Ardent 
{
	
	protected $fillable = ['name'];
	public static $rules = array(
			'name' => 'required|unique:degrees',
	);
	
	/**
	 * returns the related degreecoures
	 * @return [type] [description]
	 */
	public function degreecourses()
	{
		return $this->hasMany('Degreecourse');
	}
	
	/**
	 * returns the related modules
	 * @return [type] [description]
	 */
	public function modules()
	{
		return $this->hasMany('Module');
	}
}
