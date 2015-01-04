<?php

class RolesController extends BaseController {

	/**
	 * show role overview
	 * @return [type] [description]
	 */
	public function index()
	{
		$roles = Role::all();
		$this->layout->content = View::make('roles.index', compact('roles'));
	}

	/**
	 * show specific role
	 * @param  Role   $role [description]
	 * @return [type]       [description]
	 */
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
		{
			Flash::success('Die Rolle wurde erfolgreich angelegt.');
			return Redirect::back();
		}
		Flash::error($role->errors());
		return Redirect::back()->withInput();

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
			{
				Flash::success('Die Rolle wurde aktualisiert.');
				return Redirect::route('roles.show', $role->id);
			}
			
			Flash::error($role->errors());
			return Redirect::route('roles.show', array_get($role->getOriginal(), 'id'))->withInput();
		}
		
		Flash::error('Die Admin-Rolle kann nicht aktualisiert werden!');
		return Redirect::route('roles.show', array_get($role->getOriginal(), 'id'))->withInput();
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
			Flash::success('Die Rolle wurde erfolgreich gelöscht.');
			return Redirect::back();
		}

		Flash::error('Die Rolle konnte nicht gelöscht werden! Grund: Fehlende Rechte.');
		return Redirect::back();
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

		Flash::success('Die Berechtigung wurden erfolgreich aktualisiert.');
		return Redirect::route('roles.show',$role->id)->with('tabindex', Input::get('tabindex'));
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
			Flash::success('Die Zuordnung wurde erfolgreich aufgelöst.');
			return Redirect::route('roles.show',$role->id)->with('tabindex', Input::get('tabindex'));
		}
		
		Flash::error('Die Zuordnung konnte nicht aufgelöst werden. Fehlende Rechte!');
		return Redirect::route('roles.show',$role->id)->with('tabindex', Input::get('tabindex'));
	}
}