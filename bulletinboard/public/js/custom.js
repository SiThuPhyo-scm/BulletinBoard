// Show Image whern choose file
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#stp')
                .attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}
// End Show Image

// Show User
$(document).on('click', '#show_user', function () {
    var id = $(this).data('showid');
    $.post('user/showUser', { '_token': $('input[name=_token]').val(), id: id }, function (data) {
        $('.modal-name').text('User Detail');
        $('.userProfile').append("<img src='"+data.profile+"' class='profile border border-info rounded-circle'>");
        $('.userName').text(data.name);
        $('.userEmail').text(data.email);
        $('.userPhone').text(data.phone);
        $('.userAddress').text(data.address);
        $('.userDob').text(data.birthdate);
        $('.userCreated').text(data.createdate);
        $('.userCreateduser').text(data.create_user_id);
        $('.userUpdated').text(data.updatedate);
        $('.userUpdateduser').text(data.updated_user_id);
    });
    $("button").click(function(){
        location.reload(true);
    });
});
// End Show User

// User Delete
function deleteUser(id) {
    var id = id;
    var url = "/user/destory/" + id;
    $(".deleteForm").attr('action', url);
    $(".userID").attr('value', id);
}
// End User Delete

// Show Post
$(document).on('click', '#show_post', function () {
    var id = $(this).data('show-id');
    $.post('post/showPost', { '_token': $('input[name=_token]').val(), id: id }, function (data) {
        $('.modal-name').text('Post Detail');
        $('.postTitle').text(data.title);
        $('.postDesc').text(data.description);
        $('.postStatus').text(data.status);
        $('.postCreate').text(data.createdate);
        $('.postCreateuser').text(data.create_user_id);
        $('.postUpdate').text(data.updatedate);
        $('.postUpdateuser').text(data.updated_user_id);
    });
});
// End Show Post

// Post Delete
function deletePost(id) {
    var id = id;
    var url = "/post/destory/" + id;
    $(".deleteForm").attr('action', url);
    $(".postID").attr('value', id);
}
// End Post Delete

// Footer
$(window).on('load resize', function () {
    $win = window.innerHeight;
    $height = document.getElementById('app').clientHeight;
    if ($height < $win) {
        $('.footer').css('width','100%');
        $('.footer').css('bottom','0');
        $('.footer').css('position','absolute');
    }
});
// End footer

// Prevent BACK button click after SignOut
window.history.forward();
   function noBack() {
      window.history.forward();
   }

//
