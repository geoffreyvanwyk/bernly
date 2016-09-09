<?php namespace Bernly\Http\Controllers;

use Hash;
use Mail;
use Illuminate\Http\Request;

use Bernly\Models\User;

class VerifyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => 'getEmail'
        ]);
    }

    public function getIndex(Request $request)
    {
        $token = Hash::make(auth()->user()->email . config('app.key') );

        Mail::send(
            array( 'text' => 'emails.verify' ),
            array( 'token' => $token ),
            function ( $message )
            {
                $message
                    ->to( auth()->user()->email )
                    ->subject( 'Email Verification' );
            }
        );

        return redirect('user/view')->with([
            'is_edited_email' => $request->session()
                                         ->get( 'is_edited_email' ),
            'is_resent' => (bool) $request->input('resent')
        ]);
    }

    public function getEmail(Request $request)
    {
        $email = rawurldecode($request->input('address'));
        $token = $request->input('token');

        $user = User::where('email', $email)->first();
        $verified = $user && Hash::check($email . config('app.key'), $token);

        if ($verified) {
            $user->verified = true;
            $user->save();
        }

       return view('email-verification')->with('success',  $verified);
    }
}
