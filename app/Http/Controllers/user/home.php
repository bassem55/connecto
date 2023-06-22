<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\post_class;
use App\Models\User;
use Auth;
use App\Traits\comman;

class home extends Controller
{
    use comman;
    public function index()
    {
        $user = User::find(Auth::id());
        $post = new post_class();
        $friends_posts =  $post->get_friends_posts(Auth::id());
        
        $notifications = $user->notifications;
        
        $friends = $this->owner_friends(Auth::id());
        if($friends == "")
        {
            $friends = [];
        }
        
        
        $data = [
            'user' => $user ,
            'friends_posts' => $friends_posts ,
            'friends' => $friends , 
            'notifications' => $notifications
        ];
        return view('user.home')->with($data);
    }
    
}
