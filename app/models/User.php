<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Zizaco\Entrust\HasRole;
use LaravelBook\Ardent\Ardent;

class User extends Ardent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait, HasRole;
	protected $fillable = ['name', 'password', 'email', 'remember_token', 'deactivated','last_login'];
	public static $rules = array(
			'email' => 'required|unique:users',
	);
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	/**
	 * retrieve research groups
	 * @return [type] [description]
	 */
	public function researchgroups()
	{
		return $this->belongsToMany('Researchgroup');
	}

	/**
	 * retrieve an array of ids which the user belongs to
	 * @return [type] [description]
	 */
	public function researchgroupIds()
	{
		$rg_ids = array();
		foreach ($this->researchgroups as $rg) {
			array_push($rg_ids, $rg->id);
		}
		return $rg_ids;
	}

	/**
	 * retrieve the announcements the user made
	 * @return [type] [description]
	 */
	public function announcements()
	{
		return $this->hasMany('Announcement');
	}

	/**
	 * sets deactivated status to false 
	 * @return [type] [description]
	 */
	public function activate()
	{
		$this->deactivated = 0;

		if ($this->updateUniques())
			return true;
	}

	/**
	 * sets deactivated status to true
	 * @return [type] [description]
	 */
	public function deactivate()
	{
		$this->deactivated = 1;

		if ($this->updateUniques())
			return true;
	}

	/**
	 * Updates the name and the email address of the user
	 * @param  [type] $data [description]
	 * @return [boolean]       [description]
	 */
	public function updateUser($data)
	{
		$this->email = $data['email'];
		$this->name = $data['name'];

		if ($this->updateUniques())
			return true;
	}

	public function changePassword($password)
	{
		$this->password = $password;

		if ($this->save())
			return true;
	}

	/**
	 * register a new user
	 * @param  [type] $data [description]
	 * @return [boolean]       [description]
	 */
	public function register($data)
	{
		$this->attributes['email'] = $data['email'];
		$this->attributes['name'] = $data['name'];
		$this->attributes['password'] = Hash::make($data['password']);
		$this->attributes['deactivated'] = 0;
		$this->attributes['last_login'] = new Datetime;

		if ($this->save())
			return true;

	}
}
