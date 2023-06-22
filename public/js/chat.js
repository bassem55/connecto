$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
let chat_id = 0; // defult value
let chat_name = "";

setInterval(function(){
    if(chat_id != 0)
    {
        show_chat(chat_id , chat_name);
    }
    
}, 1000);



function show_chat(friend_id , friend_name)
{
    
    document.getElementById('chat_room').style.display = "block";
    document.getElementById('chat_name').innerHTML = friend_name;
    chat_id = friend_id;
    chat_name = friend_name;
    get_chat(friend_id);
}
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
            chat += '<div class="d-flex flex-row justify-content-end mb-4 pt-1">';
            chat += '<div>' ;
            chat += '<p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">' + row['msg'] +'</p>' ;
            // chat .= '<p class="small me-3 mb-3 rounded-3 text-muted d-flex justify-content-end">00:06</p>';
            chat += ' </div>';
            chat += '<img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3-bg.webp" alt="avatar 1" style="width: 45px; height: 100%;">' ;
            chat += '</div>';
        }
        else if(row['msg_who'] == "to")
        {
            chat += '<div class="d-flex flex-row justify-content-start">';
            chat += '<img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3-bg.webp" alt="avatar 1" style="width: 45px; height: 100%;">' ;
            chat += '<div>' ;
            chat += '<p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">' + row['msg'] + '</p>' ;
            // $chat .= '<p class="small ms-3 mb-3 rounded-3 text-muted">23:58</p>';
            chat += '</div>';
            chat += '</div>';
        }
       
    }
    
    document.getElementById('chat_content').innerHTML = chat ;
    
}