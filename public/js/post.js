$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


function send_post()
{
    let p = document.getElementById('n_p').value;
    $.ajax({
            type:'POST',
            url:url + '/new_post',
            data:{post : p},
            success:function(data){
                document.getElementById('n_p').value = "";
                get_posts();
            }
    });
}
$(".comment_input").keyup(function(event) {
    if (event.keyCode === 13) {
        alert("here");
        let post_id =  event.target.getAttribute('data-postid');
        let comment_id =  event.target.getAttribute('id');
        let comment =  document.getElementById(comment_id).value;
       // alert(comment);
        if(comment != "")
        {
            
            gen_comment(comment , post_id);
        }
            
        
    }
});

function gen_comment(com , p_id)
{
    
    $.ajax({
        type:'POST',
        url:url + '/post/comment',
        data:{post_id : p_id , comment: com},
        success:function(data){
            let res = data.msg;
            
        }
    });
  
}


  function add_react(p_id)
  {
    //let p_id =  d.getAttribute("data-postid");

    $.ajax({
        type:'POST',
        url:url + '/post/add_react',
        data:{post_id : p_id},
        success:function(data){
            let res = data.msg;
            document.getElementById('like_' + p_id).innerHTML = "liked";
            document.getElementById('like_' + p_id).setAttribute('onclick','remove_react("' + p_id+'")');
        }
    });
}

    
function remove_react(p_id)
{
    

    $.ajax({
        type:'POST',
        url:url + '/post/remove_react',
        data:{post_id : p_id},
        success:function(data){
            let res = data.msg;
            document.getElementById('like_' + p_id).innerHTML = "like";
            document.getElementById('like_' + p_id).setAttribute('onclick','add_react("' + p_id+'")');
        }
    });
}
//get_posts();
function get_posts()
{
    $.ajax({
        type:'POST',
        url:url + '/post/get_home_posts',
        data:{},
        success:function(data){
            
            var res = JSON.parse(data);
           
            set_posts(res);
        }
    });
}
function set_posts(all_data)
{
    let data = "";
    
    for(let s = 0;s<all_data.length;s++)
    {
        let inside_arr = all_data[s];
        for(let i =0;i<inside_arr.length;i++)
        {
            let post = inside_arr[i];
            data += "<div class='post'>";
            data += '<div class="row  d-flex align-items-center justify-content-center">' ;
            data += '<div>' ;
            data += '<div class="card">' ;
            data += '<div class="d-flex justify-content-between p-2 px-3">' ;

            data += '<div class="d-flex flex-row align-items-center">' ;   
            data += '<img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp" alt="avatar"class="rounded-circle img-fluid" width="50">';
            data += '<div class="d-flex flex-column ml-2">';      
            data += '<span class="font-weight-bold">' + post['post_writer_name']  + '</span>' ;
            data += '<small class="text-primary">Collegues</small>'; 
            data += '</div>' ;   
            data += '</div>' ;
            data += '<div class="d-flex flex-row mt-1 ellipsis"> <small class="mr-2">20 min</small> <i class="fa fa-ellipsis-h"></i> </div>'  ;        

            data += '</div>' ;
            data += '<img src="" class="img-fluid">' ;
            data += '<div class="p-2">' ;
            data += '<p class="text-justify">';
            data += post['post'];
            data += '</p>';

            data += '<hr>';
            data += '<div class="d-flex justify-content-between align-items-center">';
            data += '<div class="react">';
            data += '<button class="btn" id="' + 'like_' + post['post_id'] + '" onclick="' + post['react_fun']  + '" data-postid="' + post['post_id'] +'"><i class="fa-regular fa-thumbs-up"></i>';
            data += '<span>' + post['react_btn'] + '</span>';
            data += '</button>';
                                                
            data += '<button class="btn"><i class="fa-regular fa-comment"></i>' ; 
            data += '<span>comment</span>';
            data += '</button>';
            data += '<button class="btn"> <i class="fa-solid fa-share"></i>';
            data +=  '<span>share</span>' ;
            data +=  '</button>' ;
            data +=  '</div>';

            data += '<div class="d-flex flex-row muted-color"> <span>' + post['comments_num'] + ' comments</span> <span class="ml-2">Share</span> </div>';
            data += '</div>' ;
            data += '<hr>';
            data += '<div class="comments">';

            if(post['comments_num'] > 0)
            {
                let post_comments = post['comments'];
                for(let j=0;j<post['comments_num'];j++)
                {
                    let comment = post_comments[j];
                    
                    data += '<div class="d-flex flex-row mb-2"> <img src="" width="40" class="rounded-image">';
                    data += '<div class="d-flex flex-column ml-2"> <span class="name">' +comment['comment_owner'] + '</span> <small class="comment-text"> ' + comment['comment'] + '</small>' ;                       
                    data += '<div class="d-flex flex-row align-items-center status"> <small>Like</small> <small>Reply</small> <small>Translate</small> <small>18 mins</small> </div>';
                    data += ' </div></div>';
                }
            }
            
            data += '<div class="comment-input">'; 
            data += '<input id="' + post['post_id'] + '" type="text" class="form-control comment_input"  data-postid="' + post['post_id'] + '">';                                      
            data += '</div>';

            data += '</div></div></div></div></div></div>';
            
        }
    
    }
document.getElementById('posts_con').innerHTML = data;
}


