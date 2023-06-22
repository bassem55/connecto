<?php 
namespace App\Classes;
use App\Models\chat;
use App\Traits\comman;

class chat_class
{
    use comman;
    public function send_mssg($msg , $from_id , $to_id)
    {
        $ms = new chat();
        $ms->from_id = $from_id;
        $ms->msg = $msg;
        $ms->to_id = $to_id;
        $ms->save();
        return "done";
        
    }
    public function get_msgs($owner_id , $owner_friend_id)
    {
        $all_msgs = chat::select('from_id' , 'msg' , 'to_id')->where([
            ['from_id' , $owner_friend_id] , 
            ['to_id' , $owner_id]
        ])->orWhere([
            ['from_id' , $owner_id] , 
            ['to_id' , $owner_friend_id]

        ])->get();

        if(count($all_msgs) > 0)
        {
            $data = [];
            $data_counter = 0;
            foreach($all_msgs as $msg_row)
            {
                $msg_who = "";
                if($msg_row->from_id == $owner_id && $msg_row->to_id == $owner_friend_id)
                {
                    $msg_who = "from";
                }
                else if($msg_row->from_id == $owner_friend_id && $msg_row->to_id == $owner_id)
                {
                    $msg_who = "to";
                }
                $data[$data_counter] = [
                    "msg" => $msg_row->msg ,
                    "msg_who" => $msg_who
                ];
                $data_counter++;
            }

            return $data;
        }
        
    }

    public function get_all_chats($owner_id)
    {
        //this function will use to return all chats that user make it 
        $chats = chat::select('msg' , 'from_id' , 'to_id')->where([
            ['from_id' , $owner_id] 
            ])->orWhere([
            ['to_id' , $owner_id]
        ])->get();
        $friends = []; //friends of user that make chat with him
        $friends_counter = 0;
        if(count($chats) > 0)
        {
            foreach($chats as $chat)
            {
                if($chat->from_id == $owner_id)
                {
                    $friend_id = $chat->to_id;//friend
                }
                else if($chat->to_id == $owner_id)
                {
                    $friend_id = $chat->from_id;//friend
                }
                $friends[$friends_counter] = $friend_id; //!!!!!take care this array will cotain repeated ids 
                $friends_counter++;
            }
        }
        $data = [];
        $data_counter = 0;
        if($friends_counter > 0)
        {
            //here will store friends without repeated
            $unrepeated_friends =  $this->delete_repeated_items($friends);
            foreach($unrepeated_friends as $friend)
            {
                $data[$data_counter] = [
                    'friend_id' => $friend ,
                    'friend_name' => $this->get_name($friend)
                ];
                $data_counter++;
            }
            return $data;

        }
        else
             return "null" ;
    }
    private function delete_repeated_items($items)
    {
        $new_items = [];
        $new_items_counter = 0;

        foreach($items as $item)
        {
           if($this->is_found($item , $new_items) == false)
            {
                $new_items[$new_items_counter] = $item;
                $new_items_counter++;
            }
        }
        return $new_items;
    }
    private function is_found($item , $arr)
    {
        foreach($arr as $row)
        {
            if($item == $row)
            {
                return true;
            }
        }
        return false;
    } 
}
?>