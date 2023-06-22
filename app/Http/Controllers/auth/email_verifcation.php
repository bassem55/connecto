<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Classes\custom_auth;

class email_verifcation extends Controller
{
    public function index()
    {
        return view('auth.email_verifcation');
    }
    public function verify_email($token)
    {
        $verify = new custom_auth();
        return $verify->verify_email($token);
    }
}
