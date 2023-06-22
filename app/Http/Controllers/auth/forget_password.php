<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Classes\custom_auth;

class forget_password extends Controller
{
    public function go_to_forget()
    {
        return view('auth.forget_password');
    }
    public function send_mail(Request $request)
    {
        if(isset($request->email))
        {
            $forget = new custom_auth();
            $res = $forget->send_forget_mail($request->email);
            return redirect()->back()->with(['msg' => $res]);
        }
        
        
        
    }
    public function go_to_reset($token)
    {
        return view('auth.reset_password')->with('token' , $token);
    }
    public function reset_password(Request $request)
    {
        
        if(isset($request->token)  && isset($request->password) && isset($request->password_confirmation))
        {
            
            $reset = new custom_auth();
            $res = $reset->reset_password($request);

            if($res == "done")
            {
                return redirect('/login');
            }
            else
            {
                return $res;
            }
        }
       
        

        
    }
}
