<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use App\Classes\friend_requests_class;
use App\Classes\post_class;
use App\Traits\comman;


class profile extends Controller
{
    use comman;
    public function index()
    {
        $user = User::find(Auth::id());
        $post = new post_class();
        $user_posts = $post->get_posts_of(Auth::id());
        $posts = $post->get_full_data_of_posts($user_posts);

        $friend_req = new friend_requests_class();
        $friend_requests = $friend_req->get_friend_requests(Auth::id());

        $notifications = $user->notifications;

        $data = [
            'user' => $user ,
            'posts' => $posts , 
            'friend_requests' => $friend_requests , 
            'notifications' => $notifications

        ];
        return view('user.profile')->with($data);
    }
    public function go_to_s_profile($id)
    {
        if(Auth::id() == $id )
        {
            return redirect('/profile');
        }
        if(is_numeric($id))
        {
            $user = User::find($id);

            if($user != "" )
            {
                $post = new post_class();
                $posts = $post->get_full_data_of_posts($user->posts);
                $r_buttons = $this->gen_relation_buttons(Auth::id() , $id);
                $notifications = $user->notifications;
                $data = [
                    'user' => $user ,
                    'posts' => $posts ,
                    'relations' => $r_buttons , 
                    'notifications' => $notifications
                ];
                
                return view('user.sp_profile')->with($data);
            }
            else
            {
                return redirect('/search?search=' . $id);
            }
           
        }
        else
        {
            return redirect('/search?search=' . $id);
        }
       
    }
    
    
}
