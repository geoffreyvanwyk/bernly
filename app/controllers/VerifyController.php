<?php

class VerifyController extends BaseController
{
    public function __construct()
    {
        $this->beforeFilter( 'auth', array( 'except' => 'getEmail' ) );
    }

    public function getIndex()
    {
        $token = Hash::make( Auth::user()->email );
    
        Mail::send( array( 'text' => 'emails.verify' ), array( 'token' => $token ), function ( $message )
        {
            $message
                ->to( Auth::user()->email )
                ->subject( 'Email Verification' );
        });
        
        return Redirect::to( '/' );
    }
    
    public function getEmail()
    {
        $email = Input::get( 'address' );
        $token = Input::get( 'token' );
        $success = false;
        
        if ( Hash::check( $email, $token ) ) {
        
            $user = User::where( 'email', '=', $email )->firstOrFail();
            $user->verified = true;
            $user->save();
            
            $success = true;
            
        }
        
       return View::make( 'email-verification' )->with( 'success',  $success );
    }
}