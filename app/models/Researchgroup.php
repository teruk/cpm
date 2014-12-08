<?php


use LaravelBook\Ardent\Ardent;
class Researchgroup extends Ardent {
	
	protected $fillable = ['name', 'short', 'department_id','created_at', 'updated_at'];
	
	public static $rules = array(
			'name' => 'required|min:5|unique:researchgroups',
			'short' => 'required|min:2',
			'department_id' => 'required',
	);
	
	public function employees()
	{
		return $this->hasMany('Employee');
	}
	
	public function department()
	{
		return $this->belongsTo('Department');
	}

	public function users()
	{
		return $this->belongsToMany('User');
	}
}