<?php

class permissionsController extends BaseController {

	public function index()
	{
		$permissions = Permission::all();
		$this->layout->content = View::make('permissions.index', compact('permissions'));
	}

	public function show(Permission $permission)
	{
		if (sizeof(Session::get('tabindex')) == "")
		{
			$tabindex = "home";
		}
		else {
			$tabindex = Session::get('tabindex');
		}
		$this->layout->content = View::make('permissions.show', compact('permission', 'tabindex'));
	}

	public function store()
	{
		$permission = new Permission();
		$permission->name = Input::get('name');
		$permission->name = Input::get('display_name');
		$permission->description = Input::get('description');
		if ( $permission->save() )
			return Redirect::route('permissions.index', $permission->id)->with('message', 'Die Berechtigung wurde erfolgreich angelegt.');
		else
			return Redirect::route('permissions.index', array_get($permission->getOriginal(), 'id'))->withInput()->withErrors( $permission->errors() );

	}

	public function update(Permission $permission)
	{
		$permission->name = Input::get('name');
		$permission->name = Input::get('display_name');
		$permission->description = Input::get('description');
		if ( $permission->save() )
			return Redirect::route('permissions.show', $permission->id)->with('message', 'Die Berechtigung wurde aktualisiert.');
		else
			return Redirect::route('permissions.show', array_get($permission->getOriginal(), 'id'))->withInput()->withErrors( $permission->errors() );
	}

	public function destroy(Permission $permission)
	{
		// if user is has the permission 'Admin', he can't be deleted
			$permission->delete();
			return Redirect::route('permissions.index')->with('message', 'Die Berechtigung wurde erfolgreich gelöscht.');
	}
}