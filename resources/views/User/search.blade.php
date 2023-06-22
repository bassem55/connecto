@extends('layouts.app')
@section('head')
<link href="{{ asset('css/search.css') }}" rel="stylesheet">
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

<div class="container">
<div class="row ng-scope">
  
    <div class="col-md-9 col-md-pull-3">

    @if($data != "")
    @foreach($data as $result_data)
        <section class="search-result-item">
            <a class="image-link" href="#"><img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp" alt="avatar"
              class="rounded-circle img-fluid" style="width: 150px;">
            </a>
            <div class="search-result-item-body">
                <div class="">
                    <div class="float-left">
                        <h4 class="search-result-item-heading"><a href="{{url('/profile/' . $result_data['id'])}}">{{$result_data['name']}}</a></h4>
                        
                       <!-- <p class="description">descraption descraption descraption descraption descraption</p> -->
                    </div>
                    <div class="float-right">
                        <button id="btn_1" type="button" class="btn btn-primary inline" onclick="{{$result_data['fun_name_1']}}" >{{$result_data['relation_1']}}</button>
                        <button id="btn_2" type="button" class="btn btn-outline-primary ms-1 inline" onclick="{{$result_data['fun_name_2']}}">{{$result_data['relation_2']}}</button>
                    </div>
                </div>
            </div>
        </section>

        @endforeach
        @endif
       
        
        
        <div class="text-align-center">
            <ul class="pagination pagination-sm">
                <li class="disabled"><a href="#">Prev</a>
                </li>
                <li class="active"><a href="#">1</a>
                </li>
                <li><a href="#">2</a>
                </li>
                <li><a href="#">3</a>
                </li>
                <li><a href="#">4</a>
                </li>
                <li><a href="#">5</a>
                </li>
                <li><a href="#">Next</a>
                </li>
            </ul>
        </div>
    </div>
</div>
</div>
@endsection
@section('script')
<script src="{{asset('js/friend_requests.js')}}"></script>
@endsection