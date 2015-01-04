<?php

use LaravelBook\Ardent\Ardent;
class Degree extends Ardent {
	
	protected $fillable = ['name'];
	public static $rules = array(
			'name' => 'required|unique:degrees',
	);
	
	public function degreecourses()
	{
		return $this->hasMany('Degreecourse');
	}
	
	public function modules()
	{
		return $this->hasMany('Module');
	}
}