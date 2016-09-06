<?php

namespace Bernly\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function getIndex()
    {
        return redirect('log/in');
    }

    public function getIn()
    {
        return view('login');
    }

    public function postIn(Request $request)
    {
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];

        $remember = $request->input('remember_me');

        if (auth()->attempt($credentials, $remember)) {
            return redirect('/');
        }

        return redirect('/log/in')->with([
            'error' => true,
            'email' => $credentials['email'],
            'password' => $credentials['password']
        ]);
    }

    public function getOut()
    {
        auth()->logout();
        return redirect('/');
    }
}
