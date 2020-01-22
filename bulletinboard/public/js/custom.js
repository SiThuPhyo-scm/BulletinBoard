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
        $('.userName').text(data.name);
        $('.userEmail').text(data.email);
        $('.userPhone').text(data.phone);
        $('.userAddress').text(data.address);
        $('.userDob').text(data.dob);
    });
});
// End Show User

// User Delete
function deleteUser(id) {
    var id = id;
    var url = "/user/destory" + id;
    $(".deleteForm").attr('action', url);
    $(".userID").attr('value', id);
}
// End User Delete

// Show Post
$(document).on('click', '#show_post', function () {
    var id = $(this).data('show-id');
    $.post('/showPost', { '_token': $('input[name=_token]').val(), id: id }, function (data) {
        $('.modal-name').text('Post Detail');
        $('.postTitle').text(data.title);
        $('.postDesc').text(data.desc);
        $('.postStatus').text(data.status);
    });
});
// End Show Post

// Post Delete
function deletePost(id) {
    var id = id;
    var url = "/post/" + id;
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
