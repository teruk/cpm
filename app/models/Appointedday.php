<?php

use LaravelBook\Ardent\Ardent;
class Appointedday extends Ardent {
	
	protected $fillable = ['subject', 'content', 'read_more', 'date'];
	public static $rules = array(
			'subject' => 'required',
			'content' => 'required|min:3',
			'read_more' => 'required',
			'date' => 'required',
	);
}