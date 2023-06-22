<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Classes\search_class;
use Auth;
use App\Models\User;
use App\Traits\comman;

class search extends Controller
{
    use comman;
    public function search(Request $req)
    {
      $user = User::find(Auth::id());
      $notifications = $user->notifications;
      $search = new search_class();
      $res =  $search->make_search($req->search);
        $data = [
          'data' => $res ,
          'notifications' => $notifications
        ]; 
      return view('user.search')->with($data);
    }
}
