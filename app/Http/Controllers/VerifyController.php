<?php namespace Bernly\Http\Controllers;

use Bernly\Models\User;

class VerifyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => 'getEmail'
        ]);
    }

    public function getIndex()
    {
        $token = \Hash::make( \Auth::user()->email . \Config::get('app.key') );

        \Mail::send(
            array( 'text' => 'emails.verify' ),
            array( 'token' => $token ),
            function ( $message )
            {
                $message
                    ->to( \Auth::user()->email )
                    ->subject( 'Email Verification' );
            }
        );

        return \Redirect::to( 'user/view' )->with( array(
            'is_edited_email' => \Session::get( 'is_edited_email' ),
            'is_resent' => (bool) \Input::get( 'resent' )
        ));
    }

    public function getEmail()
    {
        $email = rawurldecode( \Input::get( 'address' ) );
        $token = \Input::get( 'token' );

        $user = User::where( 'email', '=', $email )->first();
        $verified = $user && \Hash::check( $email . \Config::get( 'app.key' ), $token );

        if ( $verified ) {
            $user->verified = true;
            $user->save();
        }

       return \View::make( 'email-verification' )->with( 'success',  $verified );
    }
}
