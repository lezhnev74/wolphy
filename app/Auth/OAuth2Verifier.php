<?php namespace Wolphy\Auth;

use Illuminate\Support\Facades\Auth;

class OAuth2Verifier {
    public function verify($username, $password)
    {
        $credentials = [
            'email'    => $username,
            'password' => $password,
        ];


        if (Auth::once($credentials)) {
            return Auth::user()->id;
        }


        //if account was not found
        return false;
    }
}
