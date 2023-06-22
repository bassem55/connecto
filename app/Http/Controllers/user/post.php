<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Classes\post_class;

class post extends Controller
{
   
    public function get_home_posts(Request $req)
    {
        $post = new post_class();
        $friends_posts =  $post->get_friends_posts(Auth::id());
        return json_encode($friends_posts);
    }
    
    public function new_post(Request $req)
    {
        if($req->has('post') && $req->post != "")
        {
            $post = new post_class();
            $post->create_post($req->post , Auth::id());

            return response()->json([
                "status" => true ,
                "msg"    => "done",
            ]);
        }
    }
    public function new_comment(Request $req)
    {
       
        if($req->has('post_id') && $req->has('comment'))
        {
            $post = new post_class();
            $post->create_comment($req->comment , Auth::id() , $req->post_id);
            return response()->json([
                "status" => true ,
                "msg"    => "done",
            ]);
        }
        
    }
    public function add_react(Request $req)
    {
        if($req->has('post_id'))
        {
            $post = new post_class();
            $post->add_react($req->post_id , Auth::id());
            return response()->json([
                "status" => true ,
                "msg"    => "done",
            ]);
        }
    }
    public function remove_react(Request $req)
    {
        if($req->has('post_id'))
        {
            $post = new post_class();
            $post->remove_react($req->post_id , Auth::id());
            return response()->json([
                "status" => true ,
                "msg"    => "done",
            ]);
        }
    }
}
