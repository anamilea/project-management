<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends \Laravel\Nova\Http\Controllers\LoginController {
    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        return view('home');
    }

    protected function loginUser(Request $request)
    {
    
        return response('WHATEVER');
    }

    public function index()
    {
        return view('auth.login');
    }
}