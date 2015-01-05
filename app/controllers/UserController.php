<?php
class UserController extends BaseController {

public $restful = true;

/**
  * Display listing of the resource
  *
  * @return Response
  */

public function login()
{
	// Set the user array to gather data from login form

	$userdata = array(
		'username' => Input::get('username'),
		'password' => Input::get('password')
		);		

	if(Auth::check())
	{
		return Redirect::to('/');
	}

	if(Auth::attempt($userdata))
	{
		// Grab user record
		$user = UserModel::find(Auth::user()->id);

		// If the user account is disabled then send user back to login screen
		if($user->active=='0')
		{
			Auth::logout();
			Session::flush();

			return Redirect::to('login');
		}

		Session::put('current_user', Input::get('username'));
		Session::put('user_access', $user->access);
		Session::put('user_id', $user->id);

		// Set the user.last_login to todays date and save the record
		$user->last_login = $today;
		$user->save();

		return Redirect::to('/');
		
	}
	else 
	{
		return Redirect::to('login');
	}


} // End function login


} // Ends UserController Class