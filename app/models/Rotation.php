<?php

use LaravelBook\Ardent\Ardent;
class Rotation extends Ardent {
	
	protected $fillable = ['name'];
	public static $rules = array(
			'name' => 'required|unique:rotations',
	);
	
	public function modules()
	{
		return $this->hasMany('Module');
	}
}