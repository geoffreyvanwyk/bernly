<?php

class LoginController extends BaseController
{
    public function getIndex()
    {
        return Redirect::to( 'log/in' );
    }
    
    public function getIn()
    {
        return View::make( 'login' );
    }
    
    public function postIn()
    {
        $credentials = [
            'email' => Input::get( 'email' ),
            'password' => Input::get( 'password' )
        ];
        
        if (Auth::attempt( array( $credentials, Input::get( 'remember_me' ) ) ) ) {
            return Redirect::intended('/');
        }
        
        return Redirect::to( '/log/in' )->with( array(
            'error' => true,
            'email' => $email,
            'password' => $password
        ));
    }
    
    public function getOut()
    {
        Auth::logout();
        
        return Redirect::to( '/' );
    }
}
