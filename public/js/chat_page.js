$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
setInterval(function(){
    if(chat_id != 0)
    {
        show_chat(chat_id , chat_name);
    }
    
}, 1000);
let chat_id = 0; // defult value
let chat_name = "";
function send_msg()
{
    let msg = document.getElementById('msg').value;
    
    let all_data = {};
    all_data['msg'] = msg;
    all_data['to_id'] = chat_id;
    $.ajax({
        type:'POST',
        url:url + '/chat/send_msg',
        data:all_data,
        success:function(data){
          get_chat(chat_id);
          document.getElementById('msg').value = "";
        }
    });
}
function show_chat(friend_id , friend_name)
{
    document.getElementById('chat_name').innerHTML = friend_name;
    chat_id = friend_id;
    chat_name = friend_name;
    document.getElementById('chat_name').setAttribute('href',url + '/profile/' + chat_id);
    get_chat(friend_id);
}
function get_chat(fr_id)
{
    $.ajax({
        type:'POST',
        url:url + '/chat/get_chat',
        data:{friend_id : fr_id},
        success:function(r){
            let res = JSON.parse(r.data);
            //alert(res.length);
            //document.getElementById('chat_content').innerHTML = res;
            set_chat(res);
        }
    });
}
function set_chat(chat_arr)
{
   // alert(chat_arr[0]['msg_who']);
    //document.getElementById('chat_room').innerHTML = "";
    let chat = "";

    for(let i=0;i<chat_arr.length;i++)
    {
        let row = chat_arr[i];
        if(row['msg_who'] == "from")
        { 					
            chat += '<div class="chat-message-right pb-4">' ;
            chat += '<div>' ;
            chat += '<img src="https://bootdey.com/img/Content/avatar/avatar1.png" class="rounded-circle mr-1" alt="Chris Wood" width="40" height="40">';
            //chat += '<div class="text-muted small text-nowrap mt-2">2:33 am</div>' ;
            chat += '</div>';
            chat += '<div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">' ;
            //chat += '<div class="font-weight-bold mb-1">You</div>' ;
            chat += row['msg'];
            chat += '</div>';
            chat += '</div>';
        }
        else if(row['msg_who'] == "to")
        {
            chat += '<div class="chat-message-left pb-4">';
            chat += '<div>';
            chat += '<img src="https://bootdey.com/img/Content/avatar/avatar3.png" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">';
            //chat += '<div class="text-muted small text-nowrap mt-2">2:34 am</div>';
            chat += '</div>';
            chat += '<div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">';
            //chat += '<div class="font-weight-bold mb-1">Sharon Lessman</div>';
            chat += row['msg'];
            chat += '</div>';
            chat += '</div>';
        }
    }

    document.getElementById('chat_room').innerHTML = chat ;
}