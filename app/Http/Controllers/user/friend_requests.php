<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Classes\friend_requests_class;
use Auth;

class friend_requests extends Controller
{
    public function send_friend_request(Request $req)
    {

        if($req->has('id'))
        {
            $friend = new friend_requests_class();
            $res = $friend->friend_request(Auth::id() , $req->id);
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
                    "status" => false ,
                    "msg"    => "error",
                ]);
            }
        }
    }
    public function cancel_friend_request(Request $req)
    {
        if($req->has('id'))
        {
            $friend = new friend_requests_class();
            $res = $friend->cancel_request(Auth::id() , $req->id);
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
                    "status" => false ,
                    "msg"    => "error",
                ]);
            }
        }
    }
    public function accpet_friend_request(Request $req)
    {
        
        if($req->has('id'))
        {
            $friend = new friend_requests_class();
            $res = $friend->accept_request(Auth::id() , $req->id);
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
                    "status" => false ,
                    "msg"    => "error",
                ]);
            }
        }
    }
    public function reject_friend_request(Request $req)
    {
        if($req->has('id'))
        {
            $friend = new friend_requests_class();
            $res = $friend->reject_request(Auth::id() , $req->id);
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
                    "status" => false ,
                    "msg"    => "error",
                ]);
            }

        }
    }
   
}
