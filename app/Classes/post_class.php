<?php

namespace App\Classes;

use App\Models\post;
use App\Models\comment;
use App\Models\friend;
use App\Traits\comman;
use App\Models\User;
use App\Models\react;
use Auth;


class post_class
{
    use comman;
    public function create_post($post , $owner_id)
    {
        $post_in = new post();
        $post_in->post = $post;
        $post_in->user_id = $owner_id;
        $post_in->save();
    }
    public function create_comment($comment , $comment_owner_id , $post_id)
    {
        $comment_m = new comment();
        $comment_m->comment = $comment ;
        $comment_m->user_id = $comment_owner_id;
        $comment_m->post_id = $post_id;
        $comment_m->save();
    }
    public function add_react($post_id , $react_owner_id)
    {
        $react = new react();
        $react->react_owner_id = $react_owner_id;
        $react->post_id = $post_id;
        $react->save();
        return "done"; 
    }
    public function remove_react($post_id , $react_owner_id)
    {
        react::where(
            [
                ['post_id' , $post_id] ,
                ['react_owner_id' , $react_owner_id]
            ])->delete();
        return "done";
    }
    public function get_friends_posts($owner_id)
    {
        $data = [];
        $data_counter = 0;
        $friends = $this->owner_friends($owner_id);
        if($friends != "")
        {
            foreach($friends as $friend_row)
            {
                $friend_posts = $this->get_posts_of($friend_row['friend_id']);
                $posts_full = $this->get_full_data_of_posts($friend_posts);

                $data[$data_counter] = $posts_full;
                $data_counter++; 
            }
            return $data;

        }
        else
        {
            return [];
        }

        
           
    }
   
    public function get_posts_of($id)
    {
        $posts = post::orderby('created_at', 'DESC')->where('user_id' , $id)->get();
        return $posts;
        //$user = User::find($id)->orderBy('created_at', 'asc')->get();
        //$posts = $user->posts;
        //return $posts;
    }
    private function owner_like_or_not($reacts , $owner_id) 
    {
        foreach($reacts as $react)
        {
            if($owner_id == $react->react_owner_id)
            {
                return  true;
            }
        }
        return false;
    }
    public function get_full_data_of_posts($posts)
    {
        //this function will get posts array and will return an array that have all data

        $data = []; // will be contain as posts and posts data(comments , ...)  
        $counter =0;
        foreach($posts as $post)
        {
            $post_data =  post::find($post->id);
           
            $comments_data = $post_data->comments;//array
            $reacts_data = $post_data->reacts; //array
            $react_btn = "";
            $react_fun = "";
            if($this->owner_like_or_not($reacts_data , Auth::id()))
            {
                $react_btn = "Liked";
                $react_fun = "remove_react('" .$post->id ."')";
            }
            else
            {
                $react_btn = "Like";
                $react_fun = "add_react('" .$post->id ."')";
            }

            $comments = [];
            $comments_counter = 0;
            foreach($comments_data as $comment)
            {
                $comment_data = comment::find($comment->id);
                $comments[$comments_counter] = [
                    "comment_owner" => $comment_data->comment_writer->name ,
                    "comment"       => $comment_data->comment,
                    "comment_owner_id" => $comment_data->user_id
                    //"replaies"  => "infuture",    // in future will be added it is will be like comments
                    
                ];
                $comments_counter++;
            }
            $comments_num = count($comments_data);

            $data[$counter] = [
                "post_writer_name" => $post_data->writer->name ,
                "post_writer_id" => $post_data->user_id ,
                "post_id" => $post->id ,
                "post" => $post->post ,
                "reacts" => $reacts_data ,
                "react_btn" => $react_btn ,
                "react_fun" => $react_fun ,
                "comments_num" => $comments_num , //num of post comments
                "comments" => $comments , //array that we create it 
            ];
            $counter++; 
        }
        return $data;
    }
}
?>