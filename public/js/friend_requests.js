$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function add_friend(friend_id)
{


    $.ajax({
        type:'POST',
        url:url + '/friend/add_friend',
        data:{id : friend_id},
        success:function(data){
           what_next("add" , friend_id);
        }
    });
}
function accept_request(friend_id)
{
    $.ajax({
        type:'POST',
        url:url + '/friend/accept_friend',
        data:{id : friend_id},
        success:function(data){
            what_next("accept" , friend_id);
            
        }
    });
}
function cancel_request(friend_id)
{
    $.ajax({
        type:'POST',
        url:url + '/friend/cancel_request',
        data:{id : friend_id},
        success:function(data){
            what_next("cancel" , friend_id);
            
        }
    });
}
function reject_request(friend_id)
{
    $.ajax({
        type:'POST',
        url:url + '/friend/reject_request',
        data:{id : friend_id},
        success:function(data){
            what_next("reject" , friend_id);
            
        }
    });
}