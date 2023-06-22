<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Classes\custom_auth;

class signup extends Controller
{
    public function index()
    {
        return view('auth.signup');
    }
    public function signup(Request $request)
    {
        $signup = new custom_auth();
        $data = $signup->signup($request);
        
        if($data == "done")
        {
            //make auth login first
            return redirect('/email_verifcation');

        }
        else 
        {
            return $data;
        }
    }
}
