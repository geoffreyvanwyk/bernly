<?php

class UserController extends BaseController {

	public function getIndex()
	{
		return Redirect::to( '/' );
	}

	public function getRegister()
	{
		return View::make( 'register' );
	}
	
	public function postRegister()
	{
		$user = new User;
		$user->email = Input::get( 'email' );
		$user->password = Hash::make( Input::get( 'password' ) );
		$user->setRememberToken('remember');
		$user->save();
		
		return Redirect::to( '/' );
	}
	
	public function getLogin()
	{
		return View::make( 'login' );
	}
	
	public function postLogin()
	{
		
	}
}