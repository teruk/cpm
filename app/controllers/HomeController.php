<?php

use Illuminate\Support\Facades\Input;
class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/
	
	
	/**
	 * home page
	 * @return [type] [description]
	 */
	public function getIndex()
	{
		return View::make('index');
	}

	/**
	 * show log in form
	 * @return [type] [description]
	 */
	public function showLogin()
	{
		return View::make('pages.login');
	}

	/**
	 * check if credentials are correkt and then log in
	 * @return [type] [description]
	 */
	public function doLogin()
	{
		$rules = array(
			'email' => 'required|email',
			'password' => 'required|alphaNum|min:3'
		);

		$validator = Validator::make(Input::all(),$rules);

		if ($validator->fails()) 
		{
			Flash::error($validator);
			return Redirect::to('login')->withInput(Input::except('password'));
		} 
		else 
		{
			$userdata = array(
				'email' => Input::get('email'),
				'password' => Input::get('password')
			);

			if (Auth::attempt($userdata)) 
			{
				if (Entrust::user()->inactive == 0)
				{
					$user = Entrust::user();
					$user->last_login = new Datetime;
					$user->save();
					Flash::success('Sie haben sich erfolgreich eingeloggt.');
					return Redirect::route('dashboard_path');
				}
				else
				{
					Auth::logout();
					Flash::error('Dieser Account wurde deaktiviert! Bitte kontaktieren Sie den Administrator.');
					return Redirect::route('login_path');
				}
			}

			Flash::error('Login fehlgeschlagen! E-Mail-Adresse oder Passwort ungültig!');
			return Redirect::route('login_path')->withInput();
		}
	}

	/**
	 * log user out
	 * @return [type] [description]
	 */
	public function doLogout()
	{
		Auth::logout();
		return Redirect::route('login_path');
	}

}
