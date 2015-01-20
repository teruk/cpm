<?php


use LaravelBook\Ardent\Ardent;
class Researchgroup extends Ardent 
{
	
	protected $fillable = ['name', 'short', 'department_id','created_at', 'updated_at'];
	
	public static $rules = array(
			'name' => 'required|min:5|unique:researchgroups',
			'short' => 'required|min:2',
			'department_id' => 'required',
	);
	
	/**
	 * returns a list of related employees
	 * @return [type] [description]
	 */
	public function employees()
	{
		return $this->hasMany('Employee');
	}
	
	/**
	 * returns a list of related departments
	 * @return [type] [description]
	 */
	public function department()
	{
		return $this->belongsTo('Department');
	}

	/**
	 * returns a list of related users
	 * @return [type] [description]
	 */
	public function users()
	{
		return $this->belongsToMany('User');
	}
}
