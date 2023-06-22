<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

use App\Classes\chat_class;
use App\Models\User;

class chat extends Controller
{
    public function index()
    {
        $user = User::find(Auth::id());
        $notifications = $user->notifications;

        $chat_c = new chat_class();
        $friends = $chat_c->get_all_chats(Auth::id());
        $first_chat = $chat_c->get_msgs(Auth::id() , $friends[0]['friend_id']);
        
        $data = [
            'user' => $user ,
            'notifications' => $notifications ,
            'friends' => $friends , //array
            'chat' => $first_chat // array
        ];
       
        return view("user.chat")->with($data);
    }
    public function send_msg(Request $req)
    {
        if($req->has('msg') && $req->has('to_id'))
        {
            $chat_c = new chat_class();
            $res = $chat_c->send_mssg($req->msg , Auth::id() , $req->to_id);
            if($res == "done")
            {
                return response()->json([
                    "status" => true ,
                    "msg"    => "done",
                ]);
            }
            else
            {
                return response()->json([
                    "status" => true ,
                    "msg"    => $res,
                ]);
            }
            
        }
        else
        {
            return response()->json([
                "status" => true ,
                "msg"    => "error",
            ]);
        }
        
    }
    public function get_chat(Request $req)
    {
        if($req->has('friend_id'))
        {
            $chat_c = new chat_class();
            $res = $chat_c->get_msgs( Auth::id() , $req->friend_id);

            return response()->json([
                "status" => true ,
                "data"    => json_encode($res),
            ]);
            
        }
    }
    public function get_chat_test()
    {
        $chat_c = new chat_class();
        $res = $chat_c->get_msgs( Auth::id() , 2);
        return json_encode($res);
    }

}
