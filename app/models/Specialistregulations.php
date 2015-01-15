<?php

use Eloquent;

class Specialistregulations extends Eloquent 
{
	protected $fillable = ['degreecourse_id', 'turn_id', 'active'];

	public $rules = [
		'degreecourse_id' => 'required',
		'turn_id' => 'required',
		'active' => 'min:0|max:1'
		];

	/**
	 * returns the related degree course
	 * @return [type] [description]
	 */
	public function degreecourse()
	{
		return $this->belongsTo('Degreecourse');
	}

	/**
	 * returns the related turn
	 * @return [type] [description]
	 */
	public function turn()
	{
		return $this->belongsTo('Turn');
	}

	/**
	 * return a list of related modules
	 * @return [type] [description]
	 */
	public function modules()
	{
		return $this->belongsToMany('Module')->withPivot('section', 'semester')->orderBy('semester','asc')->orderBy('section','asc');
	}

	/**
	 * sets the specialist regualations active
	 */
	public function setSpecialistregulationActive()
	{
		$this->attributes['active'] = 1;
	}

	/**
	 * set the specialist regualtions inactive
	 */
	public function setSpecialistregulationInactive()
	{
		$this->attributes['active'] = 0;
	}

	/**
	 * sets the attributes for the module
	 * @param [type] $input [description]
	 */
	public function setAttributes($input)
	{
		$this->attributes['degreecourse_id'] = $input['degreecourseId'];
		$this->attributes['turn_id'] = $input['turnId'];
		$this->attributes['active'] = $input['active'];
	}
}