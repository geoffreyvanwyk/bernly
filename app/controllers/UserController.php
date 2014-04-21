<?php

class UserController extends BaseController 
{

	public function getIndex()
	{
		return Redirect::to('/');
	}

	public function getRegister()
	{
		return View::make('register');
	}
	
	public function postRegister()
	{
		$user = new User;
		$user->email = Input::get('email');
		$user->password = Hash::make( Input::get('password'));
		$user->setRememberToken('remember');
		$user->save();
		
		return Redirect::to('/');
	}
	
	public function getLogin()
	{
		return View::make( 'login' );
	}
	
	public function postLogin()
	{
        $email = Input::get('email');
        $password = Input::get('password');
        
        if (Auth::attempt(array('email' => $email, 'password' => $password))) {
            return Redirect::intended('/');
        }
        
        return Redirect::to('/user/login')->with(array(
            'error' => 'Authentication failed.',
            'email' => $email,
            'password' => $password
        ));
	}
	
	public function getLogout()
	{
        Auth::logout();
        
        return Redirect::to('/');
	}
}