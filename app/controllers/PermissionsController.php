<?php

class permissionsController extends BaseController {

	/**
	 * [index description]
	 * @return [type] [description]
	 */
	public function index()
	{
		$permissions = Permission::all();
		$this->layout->content = View::make('permissions.index', compact('permissions'));
	}

	/**
	 * [show description]
	 * @param  Permission $permission [description]
	 * @return [type]                 [description]
	 */
	public function show(Permission $permission)
	{
		if (sizeof(Session::get('tabindex')) == "")
			$tabindex = "home";
		else 
			$tabindex = Session::get('tabindex');

		$this->layout->content = View::make('permissions.show', compact('permission', 'tabindex'));
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
		return Redirect::route('permissions.index', array_get($permission->getOriginal(), 'id'))->withInput();

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
			return Redirect::route('permissions.show', $permission->id);
		}
		
		Flash::error( $permission->errors() );
		return Redirect::route('permissions.show', array_get($permission->getOriginal(), 'id'))->withInput();
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