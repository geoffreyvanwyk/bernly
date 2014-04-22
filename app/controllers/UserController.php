<?php

class UserController extends BaseController 
{

	public function getIndex()
	{
		return Redirect::to( '/' );
	}

	public function getAdd()
	{
		return View::make( 'user.add' );
	}
	
	public function postAdd()
	{
        $email = Input::get( 'email' );
        $password = Input::get( 'password' );
        $confirm_password = Input::get( 'confirm_password' );
        
        if ( ! $this->isEmailValid( $email ) ) {
            return Redirect::to( '/user/add' )->with( array(
                'email_class' => 'has-error',
                'email_error' => 'The email you entered is invalid. It should be similar to john@example.com',
                'email' => $email,
                'password' => $password,
                'confirm_password' => $confirm_password
            ));
        }
        
        if ( ! $this->isPasswordValid( $password ) ) {
            return Redirect::to( '/user/add' )->with( array(
                'password_class' => 'has-error',
                'password_error' => 'Password should be at least 10 characters long.',
                'email' => $email,
                'password' => $password,
                'confirm_password' => $confirm_password
            ));
        }
        
        if ( ! $this->isPasswordConfirmed( $password, $confirm_password ) ) {
            return Redirect::to( '/user/add' )->with( array(
                'confirm_password_class' => 'has-error',
                'confirm_password_error' => 'The passwords do not match.',
                'email' => $email,
                'password' => $password,
                'confirm_password' => $confirm_password
            ));
        }
        
        $user = new User;
        $user->email = $email;
        $user->password = Hash::make( $password );
        $user->setRememberToken( 'remember' );
        $user->save();
        
        Auth::login( $user );
        
        return Redirect::to( '/' );
	}
	
	/**
	 * @summary Responds to HTTP GET /user/view. Displays the logged-in user's profile.
	 *
	 * @return Response
	 */
	public function getView()
	{
        return View::make( 'user.view' );
	}
	
	/**
	 * @summary Responds to HTTP GET /user/edit-email. Displays email edit form.
	 * 
	 * @return Response
	 */
	public function getEditEmail()
	{
        return View::make( 'user.edit-email' );
	}
	
    /**
     * @summary Responds to HTTP POST /user/edit-email. Updates logged-in user's email address, then
     * displays user's profile with a success message.
     * 
     * @return Response
     */
    public function postEditEmail()
    {
        $email = Input::get( 'email' );
        
        if ( ! $this->isEmailValid( $email ) ) {
            return Redirect::to( '/user/edit-email' )->with( array(
                'email_class' => 'has-error',
                'email_error' => 'The email you entered is invalid. It should be similar to john@example.com',
                'email' => $email
            ));
        }
        
        $user = User::find( Auth::user()->id );
        $user->email = $email;
        $user->save();
        
        return Redirect::to('/user/view')->with( 'is_edited', true );
    }
    
    /**
     * @summary Responds to HTTP GET /user/edit-password. Displays password edit form.
     * 
     * @return Response
     */
    public function getEditPassword()
    {
        return View::make( 'user.edit-password' );
    }
    
    /**
     * @summary Responds to HTTP POST /user/edit-password. Updates logged-in user's password, then displays
     * user's profile with a success message.
     * 
     * @return Response
     */
    public function postEditPassword()
    {
        $password = Input::get( 'password' );
        $confirm_password = Input::get( 'confirm_password' );
        
        if ( ! $this->isPasswordValid( $password ) ) {
            return Redirect::to( '/user/edit-password' )->with( array(
                'password_class' => 'has-error',
                'password_error' => 'Password should be at least 10 characters long.',
                'email' => $email,
                'password' => $password,
                'confirm_password' => $confirm_password
            ));
        }
        
        if ( ! $this->isPasswordConfirmed( $password, $confirm_password ) ) {
            return Redirect::to( '/user/edit-password' )->with( array(
                'confirm_password_class' => 'has-error',
                'confirm_password_error' => 'The passwords do not match.',
                'email' => $email,
                'password' => $password,
                'confirm_password' => $confirm_password
            ));
        }
        
        $user = User::find( Auth::user()->id );
        $user->password = Hash::make( $password );
        $user->save();
        
        return Redirect::to('/user/view')->with( 'is_edited', true );
    }
    
	private function isEmailValid( $email )
	{
        return preg_match( 
            "/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/", 
            $email 
        );
	}
	
    private function isPasswordValid( $password )
    {
        return strlen( $password ) >= 10;
    }
    
    private function isPasswordConfirmed( $password, $confirm_password )
    {
        return $password === $confirm_password;
    }
}