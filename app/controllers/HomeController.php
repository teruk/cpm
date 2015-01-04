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
		$this->layout->content = View::make('index');
	}

	/**
	 * show log in form
	 * @return [type] [description]
	 */
	public function showLogin()
	{
		$this->layout->content = View::make('login');
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

		if ($validator->fails()) {
			return Redirect::to('login')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {
			$userdata = array(
				'email' => Input::get('email'),
				'password' => Input::get('password')
			);

			if (Auth::attempt($userdata)) {
				if (Entrust::user()->inactive == 0)
				{
					$user = Entrust::user();
					$user->last_login = new Datetime;
					$user->save();
					Flash::success('Sie haben sich erfolgreich eingeloggt.');
					return Redirect::to('home');
				}
				else
				{
					Auth::logout();
					Flash::error('Dieser Account wurde deaktiviert! Bitte kontaktieren Sie den Administrator.');
					return Redirect::to('login');
				}
			} else

			Flash::error('Login fehlgeschlagen! E-Mail-Adresse oder Passwort ungültig!');
			return Redirect::to('login');
		}
	}

	/**
	 * log user out
	 * @return [type] [description]
	 */
	public function doLogout()
	{
		Auth::logout();
		return Redirect::to('login');
	}

}
