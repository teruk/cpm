<?php

class RolesController extends BaseController 
{

	/**
	 * show role overview
	 * @return [type] [description]
	 */
	public function index()
	{
		$roles = Role::all();
		return View::make('roles.index', compact('roles'));
	}

	/**
	 * show specific role
	 * @param  Role   $role [description]
	 * @return [type]       [description]
	 */
	public function edit(Role $role)
	{
		return View::make('roles.editInformation', compact('role'));
	}

	/**
	* save a new role
	*/
	public function store()
	{
		$role = new Role();
		$role->name = Input::get('name');
		$role->description = Input::get('description');
		if ( $role->save() ) {
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
		if ($role->name != "Admin") {
			$role->name = Input::get('name');
			$role->description = Input::get('description');
			if ( $role->save() ) {
				Flash::success('Die Rolle wurde aktualisiert.');
				return Redirect::route('roles.show', $role->id);
			}
			
			Flash::error($role->errors());
			return Redirect::back()->withInput();
		}
		
		Flash::error('Die Admin-Rolle kann nicht aktualisiert werden!');
		return Redirect::back()->withInput();
	}

	/**
	* delete a role
	* @param Role $role
	*/
	public function destroy(Role $role)
	{
		// if user is has the role 'Admin', he can't be deleted
		if ($role->name != "Admin") {
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
		if (sizeof($role->perms) > 0) {
			foreach ($role->perms as $perm) {
				array_push($role_permissions_ids, $perm->id);
			}
			$permissions = Permission::whereNotIn('id',$role_permissions_ids)->get();
		} else
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
		return Redirect::back()->with('tabindex', Input::get('tabindex'));
	}

	/**
	 * show role permissions
	 * @param  Role   $role [description]
	 * @return [type]       [description]
	 */
	public function showPermissions(Role $role)
	{
		// determe available permissions
		$availablePermissions = Permission::all();
		$selectedPermissionIds = array();
		$availablePermissionIds = array();
		foreach ($role->perms as $p) {
			array_push($selectedPermissionIds, $p->id);
		}

		foreach ($availablePermissions as $x) {
			array_push($availablePermissionIds, $x->id);
		}

		$availablePermissionIds = array_diff($availablePermissionIds, $selectedPermissionIds);
		if (sizeof($availablePermissionIds) > 0)
			$availablePermissions = Permission::whereIn('id',$availablePermissionIds)->get();
		else
			$availablePermissions = array();
		return View::make('roles.permissions', compact('role', 'availablePermissions'));
	}

	/**
	 * show role users
	 * @param  Role   $role [description]
	 * @return [type]       [description]
	 */
	public function showUsers(Role $role)
	{
		return View::make('roles.users', compact('role'));
	}
}
