<?php

use LaravelBook\Ardent\Ardent;
class Degreecourse extends Ardent 
{
	
	protected $fillable = ['name', 'short', 'degree_id', 'department_id'];
	public static $rules = array(
		'name' => 'required|min:5',
		'short' => 'required|min:3',
		'degree_id' => 'required',
		'department_id' => 'required'
	);

	protected $table = 'degreecourses';

	/**
	 * Returns a list of modules which are assigned to the degree course
	 * @return [type] [description]
	 */
	public function modules()
	{
		return $this->belongsToMany('Module')->withPivot('section', 'semester')->orderBy('semester','asc')->orderBy('section','asc');
	}
	
	/**
	 * returns the department object which this degree course belongs to
	 * @return [type] [description]
	 */
	public function department()
	{
		return $this->belongsTo('Department');
	}
	
	/**
	 * return the degree object which this degree course belongs to
	 * @return [type] [description]
	 */
	public function degree()
	{
		return $this->belongsTo('Degree');
	}

	/**
	 * returns a list of related specialist regulations
	 * @return [type] [description]
	 */
	public function specialistregulations()
	{
		return $this->hasMany('Specialistregulation');
	}

	/**
	 * returns presentable degree course
	 * @return [type]
	 */
	public function present()
	{
		return $this->degree->name.' '.$this->name;
	}

	/**
	* Return a list with all degree course in the constallation <degree name> <degree course name>
	* @return array<list>
	*/
	public static function getList()
	{
		$list = array();
		foreach (static::orderBy('degree_id','ASC')->orderBy('name','ASC')->get() as $degreecourse)
		{
			$list = array_add($list, $degreecourse->id, $degreecourse->degree->name.' '.$degreecourse->name);
		}
		return $list;
	}
}
