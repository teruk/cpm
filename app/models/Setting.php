<?php

use LaravelBook\Ardent\Ardent;
class Setting extends Ardent {
	
	protected $fillable = ['name', 'display_name', 'value'];
	public static $rules = array(
			'name' => 'required',
			'value' => 'required'
	);
	
	/**
	* Scope to get a specific setting
	*/
	public function scopeSetting($query, $name)
	{
		return $query->where('name','=', $name);
	}
}