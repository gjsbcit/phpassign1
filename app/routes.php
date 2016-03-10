<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

//Route::get('/', function()
//{
//	return View::make('hello');
//});
//HomePage
Route::resource('home', "HomeController");
//Registration
Route::resource('users', 'UsersController');
Route::get('register/verify/{confirmationCode}', [
		'as' => 'confirmation_path',
		'uses' => 'UsersController@confirm'
]);
//Login
Route::resource('sessions', 'SessionsController');

Route::get('/', [
		'as' => 'login',
		'uses' => 'SessionsController@create',
]);

Route::get('logout', [
		'as' => 'logout',
		'uses' => 'SessionsController@destroy',
]);

//Password Reset
Route::get('password/reset', array(
		'uses' => 'PasswordController@remind',
		'as' => 'password.remind'
));
Route::post('password/reset', array(
		'uses' => 'PasswordController@request',
		'as' => 'password.request'
));

Route::get('password/confirm/{email}', [
	'as' => 'confirm_new_pass',
	'uses' => 'PasswordController@confirm'
]);

Route::get('password/account_locked/{email}', [
		'as' => 'confirm_account_locked',
		'uses' => 'PasswordController@account_locked_confirm'
]);