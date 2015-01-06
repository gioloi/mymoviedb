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

// Check authentication prior to allowing the user access to the content
Route::group(array('before' => 'auth'), function()
{
	Route::get('/', array('as' => 'home', 'uses' => 'HomeController@index'));
});


// Route to the login page
Route::get('login', function()
{
	return View::make('login.loginform')
		->with('title', 'Login');
});

// Route to the login page for post
Route::post('login', 'UserController@login');

//Route to logout
Route::get('logout', function()
{
	Auth::logout();
	Session::flush();
	return Redirect::to('login')
	->with('message' , FlashMessage::DisplayAlert("Logout successfull",'info'));
});

// Route to signup form
Route::get('signup', function()
{
	return View::make('user.signup')
		->with('title', 'Signup');
});

// Route to the signup page for post
Route::post('signup', 'UserController@signup');