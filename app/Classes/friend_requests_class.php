<?php 
namespace App\Classes;

use App\Models\friend_request;
use App\Models\friend;
use App\Models\User;

use App\Traits\comman;


class friend_requests_class
{
    use comman;
    public function get_friend_requests($owner_id)
    {
        $friend_requests = [];
        $friend_requests_counter = 0 ;
        $data = friend_request::select('sent_id')->where('recive_id' , $owner_id)->get();

        if(count($data) > 0)
        {
            foreach($data as $row)
            {
                $friend_data = User::find($row->sent_id);

                $friend_requests[$friend_requests_counter] = [
                    'friend_name' => $friend_data->name ,
                    'friend_id' => $friend_data->id ,
                    'friend_url' => url('/profile/' . $friend_data->id )
                ];
                $friend_requests_counter++;
            }
        }
        return $friend_requests;
    }
    public function friend_request($from , $to)
    {
        $friend_s = $this->friend_stutus($from , $to);
        if($friend_s == "Add Friend")
        {
            //so he can send friend request
            
            $f_request = new friend_request();
            $f_request->sent_id = $from;
            $f_request->recive_id = $to;
            $f_request->save();

            $from_name = $this->get_name($from);
            $noti = $from_name . " Sent To You friend request" ;
            $this->send_notification($noti , $to);

            return "done";
        }
        else
        {
            //any user can not able to see bottom of (add friend) if he friend or aleardy sent friend request 
            //but we should make possible ervey thing 
            return "error";
        }
    }
    public function accept_request($id1 , $id2)
    {
        //to accept request we should add two ids to friends table
        //and remove two ids from friend_requests table

        $res = $this->friend_stutus($id1 , $id2);
        if($res == "Confirm Friend Request")
        {
            //to sure that id1 recive friend request from id2 and will be friends

            $id_1 = $id1;
            $id_2 = $id2;
            if($id1 > $id2)
            {
                $id_1 = $id2;
                $id_2 = $id1;
            }
            $friend_d = new friend();
            $friend_d->friend_id_1 = $id_1;
            $friend_d->friend_id_2 = $id_2;
            $friend_d->save();

            //delete friend request from friend reuests table

            $request = friend_request::where(
                [
                    ['sent_id'  , $id2] ,
                    ['recive_id' , $id1]
                ])->delete();

                //here we will send notification to another user to tell him that owner accept request
                $from_name = $this->get_name($id1);
                $noti = $from_name . " Accept your friend request";
                $this->send_notification($noti , $id2);
                
            return "done";

        }
        else
        {
            return "error";
        }

    }
    public function reject_request($id1 , $id2)
    {
        //in this function the another user(id2) sent request to $id1 and $id1 will reject the request
        //so we just delete the request from friend_requests table 
        //or if we want to store everything in system we can add colum to table named rejected or stutus if we want to store what happen in request

        $res = $this->friend_stutus($id1 , $id2);
        if($res == "Confirm Friend Request")
        {
            friend_request::where(
                [
                    ['sent_id' , $id2] , 
                    ['recive_id' , $id1 ]
                ])->delete();

                return "done";
        }
        else
        {
            return "error";
        }
    }
    public function cancel_request($id1 , $id2)
    {
        //in this function the user(id1) sent request to id2 and he will cancel the request
        $res = $this->friend_stutus($id1 , $id2);
        if($res == "Cancel Freiend Request")
        {
            $f_requests = friend_request::where(
                [
                    ['sent_id' , $id1] ,
                    ['recive_id' , $id2]
                ])->delete();

            return "done";
        }
        else
        {
            return "error";
        }
    }
}
?>