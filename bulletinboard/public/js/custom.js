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

$(document).on('click','#show_user',function() {
    var id=$(this).data('showid');
    console.log(id);
    $.post('/showUser',{'_token':$('input[name=_token]').val() ,id:id},function(data){
        $('.modal-name').text('User Detail');
        $('.userName').text(data.name);
        $('.userEmail').text(data.email);
    });
});


$(document).on('click','#show_post',function(){
    var id=$(this).data('show-id');
    console.log(id);
    $.post('/showPost',{'_token':$('input[name=_token]').val() ,id:id},function(data){
        $('.modal-title').text('Post Detail');
        $('.postTitle').text(data.title);
        $('.postDesc').text(data.desc);
    });
});
