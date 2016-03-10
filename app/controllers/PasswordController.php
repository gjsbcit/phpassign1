<?php

class PasswordController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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
	public function update()
	{

	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function remind()
	{
		return View::make('password.remind');
	}

	public function request()
	{
		$new_pass = str_random(4);
		$user = User::whereEmail(Input::get('email'))->first();
		$user_email = Input::get('email');

		$user->password = Hash::make($new_pass);
		$user->locked = 1;
		$user->save();

		Mail::send('emails.new_pass', compact('new_pass', 'user_email'), function($message) {
			$message->to(Input::get('email'), Input::get('email'))->subject('New password');
		});

		Flash::message('An email has been sent for your new password!');

		return Redirect::route('sessions.create');
	}

	public function reset($token)
	{
		return View::make('password.reset')->with('token', $token);
	}

	public function confirm($user_email) {
		$user = User::whereEmail($user_email)->first();
		Flash::message('Account confirmed! Please log back in with new password!');
		$user->locked = 0;
		$user->save();
		return Redirect::route('sessions.create');
	}

	public function account_locked_confirm($user_email) {
		if(Session::has('loginAttempts')) {
			Session::set('loginAttempts' , 0);
		}
		$user = User::whereEmail($user_email)->first();
		Flash::message('A break-in attempt was detected on your account. Account confirmed! Please log back in with new password!');
		$user->locked = 0;
		$user->save();
		return Redirect::route('sessions.create');
	}



}
