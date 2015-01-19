<?php

use LaravelBook\Ardent\Ardent;
class Module extends Ardent {
	
	/*
	 * added through automatic model
	 * array needs to be filled with the models attribute
	 * alternativly you can use $guarded
	 * used package: Laravel-4-Generators by Jeffrey Way
	 * https://github.com/JeffreyWay/Laravel-4-Generators
	 */
	protected $fillable = ['name', 'name_eng', 'short', 'credits', 'rotation_id', 'exam_type', 'language', 'degree_id', 'department_id', 'individual_courses']; // dependencies Way Generators 2
// 	protected $guarded = []; // Alternativ to $fillable Way Generators 2
	
	/*
	 * $rules is used for the server side validation of the
	 * input
	 * used package: Ardent by Max Ehsan
	 * https://github.com/laravelbook/ardent
	 * Based on the Aware bundle for Larval 3 by Colby Rabideau
	 */
	public static $rules = array(
			'name' => 'required|min:3',
			'name_eng' => 'min:3',
			'short'		=> 'required|min:2|unique:modules',
			'credits'	=> 'required|min:0',
			'exam_type' => 'required',
			'language' 	=> 'required',
			'degree_id'	=> 'required',
			'department_id' => 'required',
	);
	
	/**
	 * returns a list of related degree courses
	 * @return [type] [description]
	 */
	public function degreecourses()
	{
		return $this->belongsToMany('Degreecourse')->withPivot('section','semester');
	}

	/**
	 * return a list of related specialist regulations
	 * @return [type] [description]
	 */
	public function specialistregulations()
	{
		return $this->belongsToMany('Specialistregulation')
					->withPivot('section', 'semester')
					->orderBy('specialistregulation_id', 'ASC')
					->orderBy('semester','ASC')
					->orderBy('section','ASC');
	}
	
	/**
	 *  return a list of related mediumtermplannings
	 * @return [type] [description]
	 */
	public function mediumtermplannings()
	{
		return $this->hasMany('Mediumtermplanning');
	}
	
	/** returns a list of related departments */
	public function department()
	{
		return $this->belongsTo('Department');
	}

	/** returns a list of related degrees */
	public function degree()
	{
		return $this->belongsTo('Degree');
	}

	/**
	 * returns a list of related rotations
	 * @return [type] [description]
	 */
	public function rotation()
	{
		return $this->belongsTo('Rotation');
	}
	
	/**
	 * returns a list of related courses
	 * @return [type] [description]
	 */
	public function courses()
	{
		return $this->hasMany('Course');
	}

	/** returns a list of related turns */
	public function turns()
	{
		return $this->belongsToMany('Turn')->withPivot('exam');
	}
	
	/**
	 * Set the scope for bachlor modules
	 */
	public function scopeBachelor($query)
	{
		return $query->where('degree_id','=',1);
	}
	
	/**
	 * Set the scope for master modules
	 */
	public function scopeMaster($query)
	{
		return $query->where('degree_id','=',2);
	}

	/**
	 * Checks if a combination of degree course and semester already exists
	 * if not, the combination will be saved
	 * @return boolean
	 */
	public function saveDegreeCourse($data)
	{
		foreach ($this->specialistregulations as $specialistregulation) {
			if ($specialistregulation->id == $data['specialistregulationId'])
			{
				if ($specialistregulation->pivot->semester == $data['semester'])
					return false;
			}
		}
		// attaching degree course to module
		$this->specialistregulations()->attach($data['specialistregulationId'], [
				'section' => $data['section'],
				'semester' => $data['semester'],
				'created_at' => new Datetime
				]);
		return true;
	}
}