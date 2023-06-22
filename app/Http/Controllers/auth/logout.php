<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Classes\custom_auth;

class logout extends Controller
{
    public function logout(Request $request)
    {
        $logout = new  custom_auth();
        return $logout->logout($request);
    }
}
