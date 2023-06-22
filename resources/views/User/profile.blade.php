@extends('layouts.app')
@section('head')
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <link href="{{ asset('css/gen_post.css') }}" rel="stylesheet">
    <style>
        .post_con
        {
            margin-bottom: 5%;
            
        }
        .post
        {
            margin-top:5%;
        }
    </style>
     <script>
      
      function what_next(current_state , id)
      {
        let fun_name_1 = "";
        let fun_name_2 = "";
        let btn_1 = "";
        let btn_2 = "";

        if(current_state == "add")
        {
          fun_name_1 = 'cancel_request(' + id +')';
          fun_name_2 = 'show_chat(' + id + ')';

          btn_1 = "Cancel Friend Request";
          btn_2 = "Massage";
          
        }
        else if(current_state == "cancel")
        {
          fun_name_1 = 'add_friend(' + id +')';
          fun_name_2 = 'show_chat(' + id + ')';

          btn_1 = "Add Friend";
          btn_2 = "Massage";
        }
        else if(current_state == "accept")
        {
          fun_name_1 = '';
          fun_name_2 = 'show_chat(' + id + ')';

          btn_1 = "Friends";
          btn_2 = "Massage";
        }
        else if(current_state == "reject")
        {
          fun_name_1 = 'add_friend(' + id +')';
          fun_name_2 = 'show_chat(' + id + ')';

          btn_1 = "Add Friend";
          btn_2 = "Massage";
        }
        document.getElementById('btn_1').innerHTML = btn_1;
        document.getElementById('btn_2').innerHTML = btn_2;

        document.getElementById('btn_1').setAttribute('onclick',fun_name_1);
        document.getElementById('btn_2').setAttribute('onclick',fun_name_2);
      }
    </script>
    
@endsection

@section('content')

<section style="background-color: #eee;">
  <div class="container py-5">
   
    <div class="row">
      <div class="col-lg-4">
        <div class="card mb-4">
          <div class="card-body text-center">
            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp" alt="avatar"class="rounded-circle img-fluid" style="width: 150px;">
            <h5 class="my-3">{{$user->name}}</h5>
            <p class="text-muted mb-1"></p>
            <p class="text-muted mb-4"></p>
           
          </div>
        </div>
        <div class="card mb-4 mb-lg-0">
          <div class="card-body p-0">
            <ul class="list-group list-group-flush rounded-3">
                @foreach($friend_requests as $f_request)
                <li class="list-group-item">
                    <a class="float-left" href="{{$f_request['friend_url']}}"> {{$f_request['friend_name']}}</a>
                    <div class="float-right">
                        <button id="btn_1" type="button" class="btn btn-primary" onclick="accept_request('{{$f_request["friend_id"]}}')" >Accept</button>
                        <button id="btn_2" type="button" class="btn btn-outline-primary ms-1" onclick="reject_request('{{$f_request["friend_id"]}}')">Reject</button>
                    </div>
                </li>
                @endforeach
            </ul>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="card mb-4">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Full Name</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">{{$user->name}}</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Email</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">{{$user->email}}</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Phone</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">0{{$user->phone_number}}</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Mobile</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">0{{$user->phone_number}}</p>
              </div>
            </div>
          </div>
        </div>
        <div class="card mb-4" style="background-color: #eee;">

            <div class="card post_con">

                    <div class="bootstrap snippets ">
                        <div class="row">
                            <div >
                                <div class="well well-sm well-social-post">
                            
                                <textarea class="form-control" placeholder="What's in your mind?" id="n_p"></textarea>
                                <ul class='list-inline post-actions'>
                                    <li><a href="#"><span class="glyphicon glyphicon-camera"></span></a></li>
                                    <li><a href="#" class='glyphicon glyphicon-user'></a></li>
                                    <li><a href="#" class='glyphicon glyphicon-map-marker'></a></li>
                                    <li class='pull-right'><input type="button" onclick="send_post()" class='btn btn-primary btn-xs' value="post"></li>
                                </ul>
                            
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>



            @foreach($posts as $post)
                <div class="post">
                    <div class="row d-flex align-items-center justify-content-center">
                        <div>
                            <div class="card">
                                <div class="d-flex justify-content-between p-2 px-3">
                                    <div class="d-flex flex-row align-items-center"> <img src="" width="50" class="rounded-circle">
                                        <div class="d-flex flex-column ml-2"> <a href="{{  url('/profile/'.$post['post_writer_id'])}}" class="font-weight-bold">{{ $post['post_writer_name'] }}</a> <small class="text-primary">Collegues</small> </div>
                                    </div>
                                    <div class="d-flex flex-row mt-1 ellipsis"> <small class="mr-2">20 min</small> <i class="fa fa-ellipsis-h"></i> </div>
                                </div> <img src="" class="img-fluid">
                                <div class="p-2">
                                    <p class="text-justify">
                                    {{$post['post']}} 
                                        </p>
                                    <hr>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="react">
                                            <button class="btn" id="like_{{$post['post_id']}}" onclick="{{$post['react_fun']}}" data-postid="{{$post['post_id']}}"><i class="fa-regular fa-thumbs-up"></i>
                                                  <span>{{$post['react_btn']}}</span>
                                            </button>
                                            <button class="btn"><i class="fa-regular fa-comment"></i>
                                                <span>comment</span>
                                            </button>
                                            <button class="btn"> <i class="fa-solid fa-share"></i>
                                                <span>share</span>
                                            </button>
                                        </div>
                                        <div class="d-flex flex-row muted-color"><span>{{$post['comments_num']}}comments</span><span class="ml-2">Share</span> </div>
                                    </div>
                                    <hr>
                                    <div class="comments">

                                    @foreach($post['comments'] as $comment)
                                        <div class="d-flex flex-row mb-2"> <img src="" width="40" class="rounded-image">
                                            <div class="d-flex flex-column ml-2"> <a class="name" href="{{url('/profile/' . $comment['comment_owner_id'])}}" >{{$comment['comment_owner']}}</a> <small class="comment-text">{{$comment['comment']}}</small>
                                                <div class="d-flex flex-row align-items-center status"> <small>Like</small> <small>Reply</small> <!--<small>Translate</small>--> <small>18 mins</small> </div>
                                            </div>
                                        </div>
                                    @endforeach
                                        
                                        <div class="comment-input"> <input type="text" class="form-control">
                                            <div class="fonts"> <i class="fa fa-camera"></i> </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    
            @endforeach

        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('script')
<script src="{{asset('js/post.js')}}"></script>
<script src="{{asset('js/friend_requests.js')}}"></script>
@endsection