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
        console.log("Here");

        $.ajax({
            type: 'POST',
            url: "/ajaxRequest",
            data:{user_id:user_id},
            success: function(response){
                console.log(response.success);
                if (jQuery.isEmptyObject(data.success.attached)){
                    cObj.find("strong").text("Follow");
                    cObj.parent("div").find(".tl-follower").text(parseInt(c)-1);
                } else {
                    cObj.find("strong").text("Unfollow");
                    cObj.parent("div").find(".tl-follower").text(parseInt(c)+1);
                }
            }
        });
    });
});