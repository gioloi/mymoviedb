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

			return Redirect::to('login')
				->with('message' , FlashMessage::DisplayAlert("Your account is currently disabled. Please contact the administrator.",'danger'));
		}

		Session::put('current_user', Input::get('username'));
		Session::put('user_access', $user->access);
		Session::put('user_id', $user->id);

		return Redirect::to('/')
			->with('message' , FlashMessage::DisplayAlert("Login successfull",'success'));
		
	}
	else 
	{
		return Redirect::to('login')
			->with('message' , FlashMessage::DisplayAlert("Incorrect Username/Password",'danger'));
	}


} // End function login


public function signup() 
{
	
	$today = date("Y-m-d H:i:s");

	$userdata = array(
		'givenname' => Input::get('givenname'),
		'surname' => Input::get('surname'),
		'username' => Input::get('username'),
		'email' => Input::get('email'),
		'password' => Input::get('password'),
		'password_confirmation' => Input::get('password_confirmation')
		);

	// Set validation rules
	$rules = array(
		'givenname'=>'alpha_num|max:50',
		'surname'=>'alpha_num|max:50',
		'username'=>'required|unique:users,username|alpha_dash|min:5',
		'email'=>'required|unique:users,email|email',
		'password'=>'required|alpha_num|between:6,100|confirmed',
		'password_confirmation' => 'required|alpha_num|between:6,100'
		);

	$validator = Validator::make($userdata, $rules);

	// If validation fails then redirect then user back to the signup screen
	if($validator->fails())
	{
		return Redirect::back()
			->withInput()
			->withErrors($validator);
	}
	else
	{
		$user = new UserModel;
		$user->givenname = Input::get('givenname');
		$user->surname = Input::get('surname');
		$user->username = Input::get('username');
		$user->email = Input::get('email');
		$user->photo = 'No Photo Found';
		$user->password = Hash::make(Input::get('password'));
		$user->active = "1";
		$user->isdel = "0";
		$user->last_login = $today;
		$user->access = "User";

		$user->save();
	}  

	// Once the record has benn saved to the databse redirect to login page
	return Redirect::to('login')
		->with('message' , FlashMessage::DisplayAlert("User account created",'success'));

} //End function signup


} // Ends UserController Class