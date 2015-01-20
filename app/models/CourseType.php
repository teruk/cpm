<?php

use LaravelBook\Ardent\Ardent;
class Coursetype extends Ardent 
{
	
	protected $fillable = ['name', 'short', 'description'];

	public static $rules = array(
			'name' => 'required|unique:coursetypes',
			'short' => 'required|unique:coursetypes'
	);

	public $timestamps = false;
	
	/**
	 * [courses description]
	 * @return [type] [description]
	 */
	public function courses()
	{
		return $this->hasMany('Course');
	}
}
