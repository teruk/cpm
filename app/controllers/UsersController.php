<?php

class UsersController extends BaseController {

	/**
	* Overview of all users
	*/
	public function index()
	{
		$users = User::all();
		$this->layout->content = View::make('users.index', compact('users'));
	}

	/**
	*
	*/
	public function show(User $user)
	{
		// set nav tab
		if (Session::get('users_tabindex') == "")
			Session::set('users_tabindex', 'home');

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
		$selected_researchgroups = array();
		foreach ($user->researchgroups() as $researchgroup) {
			$selected_researchgroups = array_add($selected_researchgroups, $researchgroup->id, $researchgroup->name);
		}

		$available_researchgroups = array_diff($available_researchgroups, $selected_researchgroups);
		$this->layout->content = View::make('users.show', compact('user','available_roles', 'available_researchgroups'));
	}

	/**
	* save a new user
	*/
	public function store()
	{
		$input = Input::all();
		if ($input['password'] == $input['password_repeat'])
		{
			$user = new User();
			if ($user->register($input))
				return Redirect::back()->with('message', 'Der Benutzer wurde erfolgreich.');

			return Redirect::back()->withInput()->withErrors( $user->errors() );
		}
		else 
			return Redirect::back()->withInput()->with('error', 'Die Passwörter stimmen nicht überein!');
	}

	/**
	* update the user
	* @param User $user
	*/
	public function update(User $user)
	{
		Session::set('users_tabindex', 'home');

		if ( $user->updateUser(Input::all()) )
			return Redirect::back()->with('message', 'Die Benutzerinformationen wurden aktualisiert.');

		return Redirect::back()->withErrors( $user->errors() );
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
				return Redirect::back()->with('message', 'Das Passwort wurde erfolgreich aktualisiert.');

			return Redirect::back()->with('error','Die Passwortänderung konnte nicht gespeichert werden.');
		}
		else
			return Redirect::back()->with('error', 'Die Passwörter stimmen nicht überein!');
	}

	/**
	* reactive the deactivated user
	* @param User $user
	*/
	public function activate(User $user)
	{
		Session::set('users_tabindex', 'deactivation');

		if ($user->activate())
			return Redirect::back()->with('message', 'Der Benutzer wurde erfolgreich aktiviert.');
		
		return Redirect::back()->with('error', 'Der Benutzer konnte nicht aktiviert werden!');
	}

	/**
	* deactivate the activated user
	* @param User $user
	*/
	public function deactivate(User $user)
	{
		Session::set('users_tabindex', 'deactivation');
		if ($user->deactivate())
			return Redirect::back()->with('message', 'Der Benutzer wurde erfolgreich deaktiviert.');
		
		return Redirect::back()->with('error', 'Der Benutzer konnte nicht deaktiviert werden!');
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
			return Redirect::back()->with('message', 'Der Benutzer wurde erfolgreich gelöscht.');
		}
		else
			return Redirect::back()->with('error', 'Der Benutzer konnte nicht gelöscht werden! Grund: Benutzer ist Administrator.');
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

		return Redirect::back()->with('message', 'Die Rolle wurde erfolgreich zugeordnet.');
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
				return Redirect::back()->with('message', 'Die Zuordnung wurde erfolgreich aufgelöst.');
			}
			else
				return Redirect::back()->with('error', 'Die Zuordnung konnte nicht aufgelöst werden.');
		}
		else
		{
			$user->detachRole($role);
			return Redirect::back()->with('message', 'Die Zuordnung wurde erfolgreich aufgelöst.');
		}
	}

	/**
	* attach a research group
	* @param User $user
	*/
	public function attachResearchGroup(User $user)
	{
		Session::set('users_tabindex', 'researchgroups');

		$researchgroup = ResearchGroup::find(Input::get('researchgroup_id'));
		$user->researchgroups()->attach($researchgroup->id);

		return Redirect::back()->with('message', 'Der Arbeitsbereich wurde erfolgreich zugeordnet.');
	}

	/**
	* detach a research group
	* @param User $user
	*/
	public function detachResearchGroup(User $user)
	{
		Session::set('users_tabindex', 'researchgroups');

		$researchgroup = ResearchGroup::find(Input::get('researchgroup_id'));
		$user->researchgroups()->detach($researchgroup->id);

		return Redirect::back()->with('message', 'Die Zuordnung wurde erfolgreich aufgelöst.');
	}
}