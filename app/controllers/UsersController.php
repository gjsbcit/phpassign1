<?php

use LaravelCaptcha\Integration\BotDetectCaptcha;

class UsersController extends \BaseController {

	protected $user;

	public function __construct()
	{
		$this->beforeFilter('guest');
	}

	public function index()
	{
		//return View::make("users/index", ['users' => $this->user->all()]);
	}

	public function create()
	{
		$captcha = $this->getExampleCaptchaInstance();
		return View::make('users.create', array('captchaHtml' => $captcha->Html()));
	}

	public function store()
	{
		$rules = [
				'email' => 'required|email|unique:users',
				'password' => 'required|confirmed|min:6|max:80'
		];

		$validator = Validator::make(Input::only('email', 'password', 'password_confirmation'), $rules);

		// captcha instance of the example page
		$captcha = $this->getExampleCaptchaInstance();

		// validate the user-entered Captcha code when the form is submitted
		$code = Input::get('CaptchaCode');
		$isHuman = $captcha->Validate($code);

		if ($isHuman) {
			// TODO: Captcha validation passed, perform protected  action
			if($validator->fails())
			{
				return Redirect::back()->withInput()->withErrors($validator);
			}

			$confirmation_code = str_random(30);

			Mail::send('emails.verify', compact('confirmation_code'), function($message) {
				$message->to(Input::get('email'), Input::get('email'))->subject('Verify your email address');
			});

			User::create([
					'email' => Input::get('email'),
					'password' => Hash::make(Input::get('password')),
					'confirmation_code' => $confirmation_code
			]);

			Flash::message('Thanks for signing up! Please check your email!');

			return Redirect::route('sessions.create');
		} else {
			// TODO: Captcha validation failed, show error message
			return Redirect::back()
					->withInput()
					->withErrors([
							'credentials' => 'Captcha was wrong'
					]);
		}

	}


	public function show($id)
	{
		return View::make('users.show',
				['u'=>$this->user->whereId($id)->first()]);
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
	public function destroy($id)
	{
		//
	}

	public function confirm($confirmation_code)
	{
		if( !$confirmation_code)
		{
			return Redirect::route('sessions.create');
		}
		$user = User::whereConfirmationCode($confirmation_code)->first();
		if ( !$user )
		{
			return Redirect::route('sessions.create');
		}
		$user ->confirmed = 1;
		$user ->confirmation_code = null;
		$user ->save();
		Flash::message('You have successfully verified your account. You can now login.');
		return Redirect::route('sessions.create');
	}

	private function getExampleCaptchaInstance() {
		// Captcha parameters
		$captchaConfig = [
				'CaptchaId' => 'ExampleCaptcha', // a unique Id for the Captcha instance
				'UserInputId' => 'CaptchaCode', // Id of the Captcha code input textbox
			// The path of the Captcha config file is inside the config folder
				'CaptchaConfigFilePath' => 'captcha_config/ExampleCaptchaConfig.php',
		];
		return BotDetectCaptcha::GetCaptchaInstance($captchaConfig);
	}

}
