@extends('layouts.app')
@section('head')
<link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <link href="{{ asset('css/gen_post.css') }}" rel="stylesheet">
    <link href="{{ asset('css/chat.css') }}" rel="stylesheet">
@endsection
@section('content')

<div class="container" style="position:relative; margin-top:10px;">
    <div class="row">
        <div class="col-lg-3 d-none d-md-block">
            <ul class="list-group shadow bg-white rounded sticky-top">
                <div id="plist" class="people-list ">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-search"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Search...">
                    </div>
                    <ul class="list-unstyled chat-list mt-2 mb-0">    
                            @foreach($friends as $friend_row)
                                <li class="clearfix">
                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp" alt="avatar"class="rounded-circle img-fluid">
                                    <div class="about" onclick="show_chat('{{$friend_row["friend_id"]}}' , '{{$friend_row["friend_name"]}}')">
                                        <div class="name" > {{$friend_row['friend_name']}} </div>
                                        <div class="status"> <i class="fa fa-circle offline"></i> left 7 mins ago </div>                                            
                                    </div>
                                </li>
                            @endforeach
                    </ul>
                </div>     
            </ul>
            <hr class="d-sm-none">
        </div>
        <div class="col-md-5">
            <div class="card shadow bg-white rounded">
                
            <div class="">
                <div class="card">
                
                
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
                <div class="card" style="background-color: #eee;" id="posts_con">

                @foreach($friends_posts as $friend_post)
                    @foreach($friend_post as $post)
                        <div class="post">
                            <div class="row  d-flex align-items-center justify-content-center">
                                <div>
                                    <div class="card">
                                        <div class="d-flex justify-content-between p-2 px-3">
                                            <div class="d-flex flex-row align-items-center"> <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp" alt="avatar"class="rounded-circle img-fluid" width="50">
                                                <div class="d-flex flex-column ml-2"> <a href="{{url('/profile/' . $post["post_writer_id"])}}" class="font-weight-bold">{{ $post['post_writer_name'] }}</a> <small class="text-primary">Collegues</small> </div>
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
                                                    <div class="d-flex flex-column ml-2"> <a class="name" href="{{url('/profile/' . $comment['comment_owner_id'])}}">{{$comment['comment_owner']}}</a> <small class="comment-text">{{$comment['comment']}}</small>
                                                        <div class="d-flex flex-row align-items-center status"> <small>Like</small> <small>Reply</small> <small>Translate</small> <small>18 mins</small> </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                                
                                                <div class="comment-input"> 
                                                    <input id="{{$post['post_id']}}" type="text" class="form-control comment_input"  data-postid="{{$post['post_id']}}">
                                                   <!-- <div class="fonts"> 
                                                        <i class="fa fa-camera"></i> 
                                                    </div>-->
                                                </div>
                                                <button id="comment_btn" style="display:none" onclick="gen_comment('{{$post["post_id"]}}')"></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            
                    @endforeach
                @endforeach
                </div>
            </div>






            </div>
            <hr class="d-sm-none">
        </div>
        <div class="col-md-4 d-none d-md-block" >
            <ul class="list-group shadow bg-white rounded sticky-top">
                

                <section style="background-color: #eee;height: 300px;display:none;" id="chat_room">
                    <div class="row" >
                        <div class="card" id="chat2">
                            <div class="card-header d-flex justify-content-between align-items-center p-3">
                                <h5 class="mb-0" id="chat_name">Chat</h5>
                            
                            </div>
                            <div id="chat_content" class="card-body" data-mdb-perfect-scrollbar="true" style="background-color: #eee;overflow:scroll;overflow-x: hidden;position: relative; height: 300px;">

                            <!--
                                <div class="d-flex flex-row justify-content-start">
                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3-bg.webp"
                                    alt="avatar 1" style="width: 45px; height: 100%;">
                                <div>
                                    <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">Hi</p>
                                    
                                    
                                    <p class="small ms-3 mb-3 rounded-3 text-muted">23:58</p>
                                </div>
                                </div>

                                <div class="divider d-flex align-items-center mb-4">
                                <p class="text-center mx-3 mb-0" style="color: #a2aab7;">Today</p>
                                </div>

                                <div class="d-flex flex-row justify-content-end mb-4 pt-1">
                                
                                <div>
                                    <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">Hiii, I'm good.</p>
                                    <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">How are you doing?</p>
                                    <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">Long time no see! Tomorrow
                                    office. will
                                    be free on sunday.</p>
                                    <p class="small me-3 mb-3 rounded-3 text-muted d-flex justify-content-end">00:06</p>
                                </div>
                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava4-bg.webp"
                                    alt="avatar 1" style="width: 45px; height: 100%;">
                                </div>
                        
-->

                            </div>
                            <div class="card-footer text-muted d-flex justify-content-start align-items-center p-3">
                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3-bg.webp"
                                alt="avatar 3" style="width: 40px; height: 100%;">
                                <input id="msg" type="text" class="form-control form-control-lg" id="exampleFormControlInput1"
                                placeholder="Type message">
                                <a class="ms-1 text-muted" href="#!"><i class="fas fa-paperclip"></i></a>
                                <a class="ms-3 text-muted" href="#!"><i class="fas fa-smile"></i></a>
                                <button onclick="send_msg()" class="ms-3" href="#"><i class="fas fa-paper-plane"></i></button>
                            </div>
                        </div>
                    </div>
                </section>


            </ul>
           
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{asset('js/post.js')}}"></script>
<script src="{{asset('js/chat.js')}}"></script>
@endsection