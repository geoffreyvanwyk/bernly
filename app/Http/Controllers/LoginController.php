<?php namespace Bernly\Http\Controllers; 

class LoginController extends Controller
{
    public function getIndex()
    {
        return \Redirect::to( 'log/in' );
    }
    
    public function getIn()
    {
        return \View::make( 'login' );
    }
    
    public function postIn()
    {
        $credentials = [
            'email' => \Input::get( 'email' ),
            'password' => \Input::get( 'password' )
        ];
        $remember = \Input::get( 'remember_me' );
        
        if ( \Auth::attempt( $credentials, $remember ) ) {
            return \Redirect::intended('/');
        }
        
        return \Redirect::to( '/log/in' )->with( array(
            'error' => true,
            'email' => $credentials['email'],
            'password' => $credentials['password']
        ));
    }
    
    public function getOut()
    {
        \Auth::logout();
        
        return \Redirect::to( '/' );
    }
}

