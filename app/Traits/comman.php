<?php 
namespace App\Traits;

use App\Models\friend_request;
use App\Models\friend;
use App\Models\User;
use App\Models\notification;


trait comman
{
    public function send_notification($notification , $to_id)
    {
            //simplay send notifiactions are store notifcation in database

            $noti = new notification();
            $noti->notification = $notification;
            $noti->to_id = $to_id;
            $noti->save(); 
            return "done";
            
    } 
    public function get_name($id)
    {
        $user = User::find($id);
        return $user->name;
    }
    public function owner_friends($owner_id)
    {
        $friends = [];
        $friends_counter = 0;
        $friends_data = friend::select('friend_id_1' , 'friend_id_2')->where([
            ['friend_id_1' , $owner_id]
        ])->orWhere([
            ['friend_id_2' , $owner_id]
        ])->get();

        if(count($friends_data) > 0)
        {
            foreach($friends_data as $friend_row)
            {
                $friend_name = "";
                $friend_id = "";
                if($friend_row->friend_id_1 == $owner_id)
                {
                    //it is meanning that friend_row->friend_id_2 is the id of friend of owner
                    $friend_name = $this->get_name($friend_row->friend_id_2);
                    $friend_id = $friend_row->friend_id_2;
                }
                else if($friend_row->friend_id_2 == $owner_id)
                {
                    //it is meanning that friend_row->friend_id_1 is the id of friend of owner
                    $friend_name = $this->get_name($friend_row->friend_id_1); 
                    $friend_id = $friend_row->friend_id_1;

                }
                $friends[$friends_counter] = [
                    'friend_name' => $friend_name ,
                    'friend_id' => $friend_id
                ];
                $friends_counter++;

            }
        }
        if($friends_counter > 0 )
        {
            return $friends;
        }
        else
            return "";
    }
    
    public function gen_relation_buttons($owner_id , $friend_id)
    {
        //this function use to know what the relation between owner ocount and the another id that(he search about him or anything)
        //and will return array 4 varable that have the functions name and the name button     
        $relation = $this->friend_stutus($owner_id , $friend_id);
        
                
                $fun_name_1 = "";
                $fun_name_2 = "";
                $relation_1 = "";
                $relation_2 = "";
                if($relation == "friends")
                {
                    $relation_1 = "Friends";
                    $fun_name_1 = "";

                    $relation_2 = "Massage";
                    $fun_name_2 = "show_chat('" .$friend_id . "')";

                }
                else if($relation == "Cancel Freiend Request")
                {
                    $relation_1 = "Cancel Friend Request ";
                    $fun_name_1 = "cancel_request('" . $friend_id . "')";

                    $relation_2 = "Massage";
                    $fun_name_2 = "show_chat('" .$friend_id . "')";
                }
                else if($relation == "Confirm Friend Request")
                {
                    $relation_1 = "Accept Request" ;
                    $fun_name_1 = "accept_request('" . $friend_id . "')";

                    $relation_2 = "Reject Request ";
                    $fun_name_2 = "reject_request('" . $friend_id . "')";
                }
                else if($relation == "My Profile")
                {
                    
                    $relation_1 = "Profile";
                    $fun_name_1 = "";

                    $relation_2 = "";
                    $fun_name_2 = "";
                    
                }
                else if ($relation == "Add Friend")
                {
                    $relation_1 = "Add Friend";
                    $fun_name_1 = "add_friend(" . $friend_id . ")";

                    $relation_2 = "Massage";
                    $fun_name_2 = "show_chat('" .$friend_id . "')";

                }
                $data = [
                    "relation_1" => $relation_1 ,
                    "relation_2" => $relation_2 ,
                    "fun_name_1" => $fun_name_1 ,
                    "fun_name_2" => $fun_name_2 ,
                ];
                return $data;
    }
    
    public function friend_stutus($id1 , $id2)
    {
        //this function used to know this two users (id1 , id2) friends or sent friend requrst to other or nothing


        //in our system we store smaill id in first colum ==> friend_id_1
        $id_1 = $id2;
        $id_2 = $id1;
        if($id1 < $id2)
        {
            $id_1 = $id1;
            $id_2 = $id2;
        }

        //search in friends table
        $data_friends = friend::select('friend_id_1')->where([
           [ 'friend_id_1' , $id_1 ] ,
           [ 'friend_id_2' , $id_2 ] 
        ])->get();
        if(count($data_friends) > 0)
        {
            //so they friends
            return "friends";
        }
        //search in friend requests table if id1 sent friend request
        $data_requests_1 = friend_request::select('sent_id' , 'recive_id')->where([
            ['sent_id' , $id1] ,
            ['recive_id' , $id2]
        ])->get();

        if(count($data_requests_1) > 0)
        {
            //it mean that id1 sent friend request to id2
            return "Cancel Freiend Request";
        }
        $data_requests_2 = friend_request::select('sent_id' , 'recive_id')->where([
            ['sent_id' , $id2 ] ,
            ['recive_id' , $id1]
        ])->get();

        if(count($data_requests_2) > 0 )
        {
            //it is mean that id2 sent friend request to id1
            return "Confirm Friend Request";
        }

        //if user search about himself
        if($id1 == $id2)
            return "My Profile";

        
        return "Add Friend" ;
    }
    
}