<?php

class UsersController extends BaseController {

	/**
	* Overview of all users
	*/
	public function index()
	{
		$users = User::all();
		return View::make('users.index', compact('users'));
	}

	/**
	*
	*/
	public function edit(User $user)
	{
		// determe which roles can be assigned to the user
		if (Entrust::hasRole('Admin'))
			$available_roles = Role::lists('name','id');
		elseif (Entrust::can('attach_user_role'))
			$available_roles = Role::where('name', '!=', 'Admin')->lists('name','id');
		else
			$available_roles = array();

		$selected_roles = array();
		foreach ($user->roles() as $role) {
			$selected_roles = array_add($selected_roles, $role->id, $role->name);
		}

		$available_roles = array_diff($available_roles, $selected_roles);

		// determe the available researchgroups
		$available_researchgroups = ResearchGroup::lists('name','id');
		$selectedResearchgroups = array();
		foreach ($user->researchgroups() as $researchgroup) {
			$selectedResearchgroups = array_add($selectedResearchgroups, $researchgroup->id, $researchgroup->name);
		}

		$available_researchgroups = array_diff($available_researchgroups, $selectedResearchgroups);
		return View::make('users.editInformation', compact('user','available_roles', 'available_researchgroups'));
	}

	/**
	 * edit users researchgroups
	 * @param  User   $user [description]
	 * @return [type]       [description]
	 */
	public function editResearchgroups(User $user)
	{
		// determe the available researchgroups
		$availableResearchgroups = ResearchGroup::lists('name','id');
		$selectedResearchgroups = array();
		foreach ($user->researchgroups() as $researchgroup) {
			$selectedResearchgroups = array_add($selectedResearchgroups, $researchgroup->id, $researchgroup->name);
		}

		$availableResearchgroups = array_diff($availableResearchgroups, $selectedResearchgroups);

		return View::make('users.editResearchgroups', compact('user', 'availableResearchgroups'));
	}

	/**
	 * edit user roles
	 * @param  User   $user [description]
	 * @return [type]       [description]
	 */
	public function editRoles(User $user)
	{
		// determe which roles can be assigned to the user
		if (Entrust::hasRole('Admin'))
			$availableRoles = Role::lists('name','id');
		elseif (Entrust::can('attach_user_role'))
			$availableRoles = Role::where('name', '!=', 'Admin')->lists('name','id');
		else
			$availableRoles = array();

		$selectedRoles = array();
		foreach ($user->roles as $role) {
			$selectedRoles = array_add($selectedRoles, $role->id, $role->name);
		}

		$availableRoles = array_diff($availableRoles, $selectedRoles);

		return View::make('users.editRoles', compact('user', 'availableRoles'));
	}

	/**
	 * shot set new password form
	 * @param  User   $user [description]
	 * @return [type]       [description]
	 */
	public function editPassword(User $user)
	{
		return View::make('users.password', compact('user'));
	}

	/**
	 * show user status
	 * @param  User   $user [description]
	 * @return [type]       [description]
	 */
	public function editStatus(User $user)
	{
		return View::make('users.status', compact('user'));
	}

	/**
	 * save a new user
	 * @return [type] [description]
	 */
	public function store()
	{
		$input = Input::all();
		if ($input['password'] == $input['password_repeat'])
		{
			$user = new User();
			if ($user->register($input))
			{
				Flash::success('Der Benutzer wurde erfolgreich.');
				return Redirect::back();
			}

			Flash::error($user->errors());
			return Redirect::back()->withInput();
		}
		
		Flash::error('Die Passwörter stimmen nicht überein!');
		return Redirect::back()->withInput();
	}

	/**
	 * update a user
	 * @param  User   $user [description]
	 * @return [type]       [description]
	 */
	public function update(User $user)
	{
		Session::set('users_tabindex', 'home');

		if ( $user->updateUser(Input::all()) )
		{
			Flash::success('Die Benutzerinformationen wurden aktualisiert.');
			return Redirect::back();
		}

		Flash::error($user->errors());
		return Redirect::back();
	}

	/**
	* set a new password for the user
	* @param User $user
	*/
	public function setNewPassword(User $user)
	{
		Session::set('users_tabindex', 'secret');
		// check if both passwords are the same
		if (Input::get('password') == Input::get('password_repeat'))
		{
			if ($user->changePassword(Hash::make(Input::get('password'))))
			{
				Flash::success('Das Passwort wurde erfolgreich aktualisiert.');
				return Redirect::back();
			}

			Flash::error('Die Passwortänderung konnte nicht gespeichert werden.');
			return Redirect::back();
		}
		
		Flash::error('Die Passwörter stimmen nicht überein!');
		return Redirect::back();
	}

	/**
	 * reactive the deactivated user
	 * @param  User   $user [description]
	 * @return [type]       [description]
	 */
	public function activate(User $user)
	{
		Session::set('users_tabindex', 'deactivation');

		if ($user->activate())
		{
			Flash::success('Der Benutzer wurde erfolgreich aktiviert!');
			return Redirect::back();
		}
		
		Flash::error('Der Benutzer konnte nicht aktiviert werden!');
		return Redirect::back();
	}

	/**
	* deactivate the activated user
	* @param User $user
	*/
	public function deactivate(User $user)
	{
		Session::set('users_tabindex', 'deactivation');
		if ($user->deactivate())
		{
			Flash::success('Der Benutzer wurde erfolgreich deaktiviert!');
			return Redirect::back();
		}
		
		Flash::error('Der Benutzer konnte nicht deaktiviert werden!');
		return Redirect::back();
	}

	/**
	* deletes the user
	* @param User $user
	*/
	public function destroy(User $user)
	{
		// if user is has the role 'Admin', he can't be deleted
		if (!$user->hasRole('Admin'))
		{
			$user->delete();
			Flash::success('Der Benutzer wurde erfolgreich gelöscht!');
			return Redirect::back();
		}
		
		Flash::error('Der Benutzer konnte nicht gelöscht werden! Grund: Benutzer ist Administrator.');
		return Redirect::back();
	}

	/**
	* attach a role
	* @param User $user
	*/
	public function attachRole(User $user)
	{
		Session::set('users_tabindex', 'roles');

		$role = Role::findOrFail(Input::get('role_id'));
		$user->attachRole($role);

		Flash::success('Die Rolle wurde erfolgreich zugeordnet.');
		return Redirect::back();
	}

	/**
	* detach a role 
	* @param User $user
	*/
	public function detachRole(User $user)
	{
		Session::set('users_tabindex', 'roles');

		$role = Role::findOrFail(Input::get('role_id'));
		if ($role->name == "Admin")
		{
			if ($user->hasRole('Admin') && $user->id != Auth::id())
			{
				$user->detachRole($role);
				Flash::success('Die Zuordnung wurde erfolgreich aufgelöst.');
				return Redirect::back();
			}
			
			Flash::error('Die Zuordnung konnte nicht aufgelöst werden.');
			return Redirect::back();
		}
		
		$user->detachRole($role);
		Flash::success('Die Zuordnung wurde erfolgreich aufgelöst.');
		return Redirect::back();
	}

	/**
	* attach a research group
	* @param User $user
	*/
	public function attachResearchgroup(User $user)
	{
		Session::set('users_tabindex', 'researchgroups');

		$researchgroup = ResearchGroup::find(Input::get('researchgroup_id'));
		$user->researchgroups()->attach($researchgroup->id);

		Flash::success('Der Arbeitsbereich wurde erfolgreich zugeordnet.');
		return Redirect::back();
	}

	/**
	 * detach a research group
	 * @param  User   $user [description]
	 * @return [type]       [description]
	 */
	public function detachResearchgroup(User $user)
	{
		Session::set('users_tabindex', 'researchgroups');

		$researchgroup = ResearchGroup::find(Input::get('researchgroup_id'));
		$user->researchgroups()->detach($researchgroup->id);

		Flash::success('Die Zuordnung wurde erfolgreich aufgelöst.');
		return Redirect::back();
	}
}