<?php

class SessionsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		if (Auth::check()) {
			return Redirect::action('HomeController@index')->with('user', Auth::user()->email);
		}else{
			return Redirect::route('sessions.create'); //form
		}

	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		if(Auth::check()) // opposite of Auth::guest()
		{
			return Redirect::action('HomeController@index')->with('user', Auth::user()->email);
		}
		return View::make('sessions.create'); // form

	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$remember = (Input::has('remember')) ? true : false;

		$user = User::whereEmail(Input::get('email'))->first();

		//if the user is not locked count number of attempts
		if($user->locked == 0) {
			if(Session::has('loginAttempts')) {
				$loginAttempts = Session::get('loginAttempts');
				if($loginAttempts > 2) {
					if(Session::has('passwordResetSent')) {
						Session::set('passwordResetSent' , 1);
					} else {
						Session::put('passwordResetSent' , 1);
					}
					$user->locked = 1;
					$user->save();
				}
			} else {
				Session::put('loginAttempts', 0);
			}
		}

		$rules = [
				'email' => 'required|exists:users',
				'password' => 'required'
		];

		$input = Input::only('email', 'password');

		$validator = Validator::make($input, $rules);

		if($validator->fails())
		{
			return Redirect::back()->withInput()->withErrors($validator);
		}

		$auth = Auth::attempt([
			'email' => Input::get('email'),
			'password' => Input::get('password'),
			'confirmed' => 1,
			'locked' => 0
		], $remember);

		if ($auth)
		{
			if(Session::has('loginAttempts')) {
				Session::set('loginAttempts' , 0);
			}

			Flash::message('Welcome back!');

			return Redirect::action('HomeController@index');

		} else {
//			call function increase login attempts for this email then send email
			if(Session::get('passwordResetSent') == 1) {
				Session::set('passwordResetSent', 0);
				$new_pass = str_random(4);
				$user_email = Input::get('email');
				$user->password = Hash::make($new_pass);
				$user->save();

				Mail::send('emails.new_pass_account_locked', compact('new_pass', 'user_email'), function($message) {
					$message->to(Input::get('email'), Input::get('email'))->subject('Account Locked, New Password');
				});

			} else {

				if(Session::has('loginAttempts')) {
					$loginAttempts = Session::get('loginAttempts');
					Session::set('loginAttempts' , $loginAttempts + 1);
				}
			}

			if($user->locked == 1) {
				Flash::message('Account needs to be confirmed! Please check email');
			}

			return Redirect::back()
					->withInput()
					->withErrors([
							'credentials' => 'Your username/password combination was incorrect.'
					]);
		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy()
	{
		Auth::logout();
		return Redirect::route('sessions.create'); // form
	}




}
