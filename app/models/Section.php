<?php

use LaravelBook\Ardent\Ardent;
class Section extends Ardent 
{
	
	protected $fillable = ['name'];

	public static $rules = array(
			'name' => 'required|unique:sections',
	);	
}
