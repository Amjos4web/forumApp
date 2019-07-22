
require('./bootstrap');

import Vue from 'vue'
import VueChatScroll from 'vue-chat-scroll'
Vue.use(VueChatScroll)

window.Vue = require('vue');

Vue.component('message', require('./components/message.vue'));

const app = new Vue({
    el: '#app',
    
    data: {
        message: '',
        chat: {
            message:[],
            user:[],
            color:[],
        },
    },
    
    methods: {
        send(){
            if (this.message.length != 0){
                this.chat.message.push(this.message);
                this.chat.user.push("You");
                this.chat.color.push("success");
                axios.post('/send', {
                    message : this.message,
                  })
                  .then(response =>  {
                    console.log(response);
                    this.message = '';
                  })
                  .catch(error =>  {
                    console.log(error);
                  });
            }
            
        }
    },

    mounted() {
        Echo.private('chat')
            .listen('myLaravelFirstApp\\Events\\ChatEvent', (e) => {
                this.chat.message.push(e.message); 
                this.chat.user.push(e.user);
                this.chat.color.push("warning");
                console.log('received');
                console.log(e);
        });
    }
    
});

$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $('.action-follow').click(function(){
        var user_id = $(this).data('id');
        var cObj = $(this);
        var c = $(this).parent("div").find(".tl-follower").text();
        
        $.ajax({
            type: 'POST',
            url: 'ajaxRequest',
            data:{user_id:user_id},
            success: function(response){
                if (jQuery.isEmptyObject(response.success.attached)){
                    cObj.find("strong").text("Follow");
                    cObj.parent("div").find(".tl-follower").text(parseInt(c)-1);
                } else {
                    cObj.find("strong").text("Unfollow");
                    cObj.parent("div").find(".tl-follower").text(parseInt(c)+1);
                }
            }
        });
    });

    $('.fa-heart').click(function(){
        const id = $(this).attr('data-id');
        const cObj = $(this);
        const c = $(this).parent().find(".likers").text();
        $.ajax({
            type: 'POST',
            url: 'like',
            data:{id:id},
            success: function(response){
                if (jQuery.isEmptyObject(response.success.attached)){
                    cObj.parent().find(".likers").text(parseInt(c)-1);
                    $(cObj).removeClass('like-post');
                } else {
                    cObj.parent().find(".likers").text(parseInt(c)+1);
                    $(cObj).addClass('like-post');
                }
            }
        });
    });

    $('.likeComment').click(function(){
        const id = $(this).attr('data-id');
        const cObj = $(this);
        const c = $(this).parent().find(".likers").text();
        $.ajax({
            type: 'POST',
            url: 'likeComment',
            data:{
                "id":id,
                "_token": "{{ csrf_token() }}", 
            },
            success: function(response){
                if (response.success){
                    cObj.parent().find(".likers").text(parseInt(c)-1);
                    $(cObj).removeClass('like-comment');
                } else {
                    cObj.parent().find(".likers").text(parseInt(c)+1);
                    $(cObj).addClass('like-comment');
                }
            }
        });
    });

    $('#addComment').click(function(){
        $('#comment-form').fadeToggle("slow");
    });

   
    $('.editComment').click(function(){
        $self = $(this);
        const comment_id = $(this).data('id');
        const comment = $(this).parent().find('#comment-body'+comment_id).text();
        $('#editCommentText').val(comment);
        $('#storeCommentID').val(comment_id);
    });
    
    $('#editCommentForm').on('submit', function(e){
        e.preventDefault();
        const comment_id = $('#storeCommentID').val();
       
        $.ajax({
            type: "PUT",
            url: '/editComment/'+comment_id,
            data: $('#editCommentForm').serialize(),
            success: function(response){
                const d = document.getElementById('message');
                const errorMessage = 'Unable to edit comment';
                d.style.display = 'none';
                if (response.success){
                    $('#comment-body'+comment_id).text(response.success.body);
                    $('#editComment').modal("hide");
                } else {
                    d.innerHTML = errorMessage;
                    d.style.color = 'red';
                    d.style.display = 'block';
                }
            }
            
        });
    });

    // reponse template
  

    $('.replyBtn').click(function(){
        const $self = $(this);
        const comment_id = $(this).data('id');
        const post_id = $('#post_id').val();
        $('#storeCommentID2').val(comment_id);
        $('#storePostID').val(post_id);
        $('#replyCommentText').val("");
       
    });

    function showError(response){
        if (response.success == false){
            const d = document.getElementById('message');
            const errorMessage = 'Unable to edit comment';
            d.innerHTML = errorMessage;
            d.style.color = 'red';
            d.style.display = 'block';
        } 
    }

    

    $('#replyForm').on('submit', function(e){
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        const comment_id = $('#storeCommentID2').val();
        const comment = $('#replyCommentText').val();
        const post_id = $('#post_id').val();

        console.log(post_id);
        // get profile image
        const profile_image = $('#profile-image').val();


        // get user name
        let user_name = $('#user-name').val();

        // get user id
        let user_id = $('#user-id').val();

        // get comment user name
        let comment_user_name = $('#comment-user-name').val();

        // get comment user id
        const comment_user_id = $('#comment-user-id').val();

        if (user_id == comment_user_id){
            user_name = 'You';
        }

        const reply_template = '<div class="well well-sm" id="commentReply">'+
            '<p style="font-size: 16px; color: cadetblue"><i class="fa fa-reply"></i> Reply</p>'+
            '<div class="row">'+
            
            '<div class="col-md-2">'+
            
                `<img src="/storage/images/${profile_image}" class="user-image" alt="${user_name}">`+
            '</div>'+
            '<div class="col-md-10">'+
                `<p><i class="fa fa-user"></i> <strong>
                    ${user_name}`+
                 `</strong> Replied <label style="color: cadetblue"></label>${comment_user_name}'s Comment`+

                '<div class="comment-body">'+
                `<p id="comment-body${comment_id}"><i class="fa fa-edit"></i> ${comment}</p>`+
                
                '</div>'+
        '</div><br><br>'+
        '</div><br>'+
        '</div>'

      
        if (comment.length !== 0){
            $.ajax({
                type: "POST",
                url: '/replyComment',
                
                data: {
                    comment_id: comment_id,
                    comment: comment,
                    post_id: post_id,
                },
                success: function(response){
                    if (response.success){
                        //const pElement = $('#commentSection'+comment_id).find('#comment-section'+comment_id);
                       // $('#comment-body'+comment_id).text(response.success.body);
                        $('#commentSection'+comment_id).append(reply_template);
                        $('#replyComment').modal("hide");
                    } else {
                        showError(response);
                    }
                },
                error: function(response){
                    showError(response);
                }
                
            });
        } else {
            e.preventDefault();
        }
        
    });

    $('.like-btn').hover(function(){
        $('.liker-details').fadeToggle(600);
    });

    $('.likeBtn').hover(function(){
        const post_id = $(this).data('id');
        $('.liker-details-home'+post_id).fadeToggle(600);

    });


    var page = 1;
	$(window).scroll(function() {
	    if($(window).scrollTop() + $(window).height() >= $(document).height()) {
	        page++;
	        loadMoreData(page);
	    }
	});


	function loadMoreData(page){
	  $.ajax({
        url: '?page=' + page,
        type: "get",
        beforeSend: function()
        {
            $('.ajax-load').show();
        }
        })
        .done(function(data)
        {
            if(data.html == ""){
                $('.ajax-load').html("No more feeds found");
                return;
            }
            $('.ajax-load').hide();
            const $dataFromServer = $(data.html);
            $dataFromServer.find(".likeBtn").each(function(){
                $(this).hover(function(){
                    const post_id = $(this).data('id');
                    $('.liker-details-home'+post_id).fadeToggle(600);

                });
            })
            $("#post-data").append($dataFromServer);
        })
        .fail(function(jqXHR, ajaxOptions, thrownError)
        {
            $('.ajax-load').html("Unable to fetch more feeds");
            return;
        });
	}
});
