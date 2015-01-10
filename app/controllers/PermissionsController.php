<?php

class permissionsController extends BaseController {

	/**
	 * [index description]
	 * @return [type] [description]
	 */
	public function index()
	{
		$permissions = Permission::all();
		return View::make('permissions.index', compact('permissions'));
	}

	/**
	 * [show description]
	 * @param  Permission $permission [description]
	 * @return [type]                 [description]
	 */
	public function edit(Permission $permission)
	{

		return View::make('permissions.editInformation', compact('permission'));
	}

	/**
	 * [store description]
	 * @return [type] [description]
	 */
	public function store()
	{
		$permission = new Permission();
		$permission->name = Input::get('name');
		$permission->name = Input::get('display_name');
		$permission->description = Input::get('description');

		if ( $permission->save() )
		{
			Flash::success('Die Berechtigung wurde erfolgreich angelegt.');
			return Redirect::back();
		}

		Flash::error($permission->errors());
		return Redirect::back()->withInput();

	}

	/**
	 * [update description]
	 * @param  Permission $permission [description]
	 * @return [type]                 [description]
	 */
	public function update(Permission $permission)
	{
		$permission->name = Input::get('name');
		$permission->name = Input::get('display_name');
		$permission->description = Input::get('description');
		if ( $permission->save() )
		{
			Flash::success('Die Berechtigung wurde aktualisiert.');
			return Redirect::back();
		}
		
		Flash::error( $permission->errors() );
		return Redirect::back()->withInput();
	}

	/**
	 * [destroy description]
	 * @param  Permission $permission [description]
	 * @return [type]                 [description]
	 */
	public function destroy(Permission $permission)
	{
		// if user is has the permission 'Admin', he can't be deleted
		$permission->delete();
		Flash::success('Die Berechtigung wurde erfolgreich gelöscht.');
		return Redirect::back();
	}
}