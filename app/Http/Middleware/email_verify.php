<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;

use App\Models\User;
use Auth;

class email_verify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = User::find(Auth::id());

        //return $user;
        if($user->email_verified_at == null)
        {
            //user email not verified yet

            //return "Your Email Not Verified Yet Check Your Mail";
            return redirect('/email_verifcation');
        } 

        return $next($request);
    }
}
