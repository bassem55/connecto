@extends('layouts.app')
@section('head')
    <link href="{{ asset('css/chat_page.css') }}" rel="stylesheet">
@endsection
@section('content')
<main class="content">
    <div class="container p-0">

		<div class="card">
			<div class="row g-0">
				<div class="col-12 col-lg-5 col-xl-3 border-right" style="overflow-y: scroll;">

					<div class="px-4 d-none d-md-block">
						<div class="d-flex align-items-center">
							<div class="flex-grow-1">
								<input type="text" class="form-control my-3" placeholder="Search...">
							</div>
						</div>
					</div>

					@foreach($friends as $friend)
						<div onclick="show_chat('{{$friend["friend_id"]}}' , '{{$friend["friend_name"]}}')" class="list-group-item list-group-item-action border-0">
							<!--<div class="badge bg-success float-right">5</div> -->
							<div class="d-flex align-items-start">
								<img src="https://bootdey.com/img/Content/avatar/avatar5.png" class="rounded-circle mr-1" alt="Vanessa Tucker" width="40" height="40">
								<div class="flex-grow-1 ml-3">
									{{$friend['friend_name']}}
									<div class="small"><span class="fas fa-circle chat-online"></span> Online</div>
								</div>
							</div>
						</div>
					@endforeach
				
					<hr class="d-block d-lg-none mt-1 mb-0">
				</div>
				<div class="col-12 col-lg-7 col-xl-9">
					<div class="py-2 px-4 border-bottom d-none d-lg-block">
						<div class="d-flex align-items-center py-1">
							<div class="position-relative">
								<img src="https://bootdey.com/img/Content/avatar/avatar3.png" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
							</div>
							<div class="flex-grow-1 pl-3">
								<a id="chat_name" href="{{url('/profile/' . $friends[0]["friend_id"])}}">{{$friends[0]['friend_name'] }}</a>
								<div class="text-muted small"><em>Typing...</em></div>
							</div>
							<div>
								<button class="btn btn-primary btn-lg mr-1 px-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone feather-lg"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg></button>
								<button class="btn btn-info btn-lg mr-1 px-3 d-none d-md-inline-block"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-video feather-lg"><polygon points="23 7 16 12 23 17 23 7"></polygon><rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect></svg></button>
								<button class="btn btn-light border btn-lg px-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal feather-lg"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg></button>
							</div>
						</div>
					</div>

					<div class="position-relative">
						<div class="chat-messages p-4" id="chat_room">

						@foreach($chat as $chat_row)
							@if($chat_row['msg_who'] == "from")
							<div class="chat-message-right pb-4">
								<div>
									<img src="https://bootdey.com/img/Content/avatar/avatar1.png" class="rounded-circle mr-1" alt="Chris Wood" width="40" height="40">
									<!--<div class="text-muted small text-nowrap mt-2">2:33 am</div>-->
								</div>
								<div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
									<!--<div class="font-weight-bold mb-1">You</div>-->
									{{$chat_row['msg']}}
								</div>
							</div>
							@endif
							@if($chat_row['msg_who'] == "to")
							<div class="chat-message-left pb-4">
								<div>
									<img src="https://bootdey.com/img/Content/avatar/avatar3.png" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
									<!--<div class="text-muted small text-nowrap mt-2">2:34 am</div>-->
								</div>
								<div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">
									<!--<div class="font-weight-bold mb-1">Sharon Lessman</div>-->
									{{$chat_row['msg']}}
								</div>
							</div>
							@endif

						@endforeach
						</div>
					</div>

					<div class="flex-grow-0 py-3 px-4 border-top">
						<div class="input-group">
							<input type="text" id="msg" class="form-control" placeholder="Type your message">
							<button class="btn btn-primary" onclick="send_msg()">Send</button>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</main>
@endsection
@section('script')
	<script src="{{asset('js/chat_page.js')}}"></script>
@endsection