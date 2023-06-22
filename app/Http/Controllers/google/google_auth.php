<?php

namespace App\Http\Controllers\google;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class google_auth extends Controller
{
    public function index()
    {
        return Socialite::driver('google')->stateless()->redirect();
        //return Socialite::driver('google')->redirect();
    }
    public function login()
    {
        /*
        $google_user = Socialite::driver('google')->user();

        $user = User::updateOrCreate([
            'google_id' => $google_user->id,
        ], [
            'name' => $google_user->name,
            'email' => $google_user->email,
            'google_token' => $google_user->token,
            //'github_refresh_token' => $githubUser->refreshToken,
        ]);
     
        Auth::login($user);
     
        return redirect('/home');

        */
        $user = Socialite::driver('google')->stateless()->user();
        $this->_registerorLoginUser($user);
        return redirect()->route('home');
     
    }
    protected function _registerOrLoginUser($data){
        $user = User::where('email',$data->email)->first();
          if(!$user){
             $user = new User();
             $user->name = $data->name;
             $user->email = $data->email;
             $user->google_id = $data->id;
             $user->google_token = $data->token;
             $user->avatar = $data->avatar;
             $user->save();
          }
        Auth::login($user);
        }
}
