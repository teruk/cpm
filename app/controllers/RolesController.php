<?php

class RolesController extends BaseController {

	public function index()
	{
		$roles = Role::all();
		$this->layout->content = View::make('roles.index', compact('roles'));
	}

	public function show(Role $role)
	{
		// set nav tab
		if (sizeof(Session::get('tabindex')) == "")
			$tabindex = "home";
		else
			$tabindex = Session::get('tabindex');

		// determe available permissions
		$available_permissions = Permission::all();
		$selected_permissions_ids = array();
		$available_permissions_ids = array();
		foreach ($role->perms as $p) {
			array_push($selected_permissions_ids, $p->id);
		}

		foreach ($available_permissions as $x) {
			array_push($available_permissions_ids, $x->id);
		}

		$available_permissions_ids = array_diff($available_permissions_ids, $selected_permissions_ids);
		if (sizeof($available_permissions_ids) > 0)
			$available_permissions = Permission::whereIn('id',$available_permissions_ids)->get();
		else
			$available_permissions = array();

		$this->layout->content = View::make('roles.show', compact('role','available_permissions', 'tabindex'));
	}

	/**
	* save a new role
	*/
	public function store()
	{
		$role = new Role();
		$role->name = Input::get('name');
		$role->description = Input::get('description');
		if ( $role->save() )
			return Redirect::route('roles.index', $role->id)->with('message', 'Die Rolle wurde erfolgreich angelegt.');
		else
			return Redirect::route('roles.index', array_get($role->getOriginal(), 'id'))->withInput()->withErrors( $role->errors() );

	}

	/**
	* update role
	* @param Role $role
	*/
	public function update(Role $role)
	{
		if ($role->name != "Admin")
		{
			$role->name = Input::get('name');
			$role->description = Input::get('description');
			if ( $role->save() )
				return Redirect::route('roles.show', $role->id)->with('message', 'Die Rolle wurde aktualisiert.');
			else
				return Redirect::route('roles.show', array_get($role->getOriginal(), 'id'))->withInput()->withErrors( $role->errors() );
		}
		else
			return Redirect::route('roles.show', array_get($role->getOriginal(), 'id'))->withInput()->with('error','Die Admin-Rolle kann nicht aktualisiert werden!');
	}

	/**
	* delete a role
	* @param Role $role
	*/
	public function destroy(Role $role)
	{
		// if user is has the role 'Admin', he can't be deleted
		if ($role->name != "Admin")
		{
			$role->delete();
			return Redirect::route('roles.index')->with('message', 'Die Rolle wurde erfolgreich gelöscht.');
		}
		else
			return Redirect::route('roles.index')->with('error', 'Die Rolle konnte nicht gelöscht werden! Grund: Fehlende Rechte.');
	}

	/**
	* update the permissions that are assigned to a role
	* @param Role $role
	*/
	public function updatePermission(Role $role)
	{
		$role_permissions_ids = array();
		if (sizeof($role->perms) > 0)
		{
			foreach ($role->perms as $perm) {
				array_push($role_permissions_ids, $perm->id);
			}
			$permissions = Permission::whereNotIn('id',$role_permissions_ids)->get();
		}
		else
			$permissions = Permission::all();
		// check the current attached permissions, if there is any changed
		foreach ($role->perms as $p) {
			if(Input::get($p->name) == "")
				$role->detachPermission($p->id);
		}
		// check the unattached permissions
		foreach ($permissions as $ps) {
			if (Input::get($ps->name) != "")
				$role->attachPermission($ps->id);
		}
		return Redirect::route('roles.show',$role->id)->with('message', 'Die Berechtigung wurden erfolgreich aktualisiert.')
			->with('tabindex', Input::get('tabindex'));
	}

	/**
	* detach permission
	* @param Role $role
	*/
	public function detachPermission(Role $role)
	{
		$permission = Permission::find(Input::get('permission_id'));
		if (Entrust::hasRole('Admin') || Entrust::can('detach_role_permission'))
		{
			$role->detachPermission($permission);
			return Redirect::route('roles.show',$role->id)->with('message', 'Die Zuordnung wurde erfolgreich aufgelöst.')
					->with('tabindex', Input::get('tabindex'));
		}
		else
			return Redirect::route('roles.show',$role->id)->with('error', 'Die Zuordnung konnte nicht aufgelöst werden. Fehlende Rechte!')
					->with('tabindex', Input::get('tabindex'));
	}
}