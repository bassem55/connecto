<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Classes\custom_auth;

class login extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $login = new custom_auth();
        return $login->login($request);
       
    }
    public function verify_email($token)
    {
        $verify = new custom_auth();
        return $verify->verify_email($token);
    }
    
}
