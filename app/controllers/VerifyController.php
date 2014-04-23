<?php

class VerifyController extends BaseController
{
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
        
    }
}