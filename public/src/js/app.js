// var body = 1;
var App = {}
App.init = function(){
    var scope = this;
    scope.handleUpdatePost();
    scope.popUpModal();
    scope.handleLike();
}

App.popUpModal = function(){
    $('.post .interaction').on('click', '.edit-post', function(e) {
        e.preventDefault();
        var postID = $(e.target).attr('data-id');
        $('#edit-post-modal').modal('show');
        $('.hidden-post-id').val(postID);
        $('#post-body-modal').val('').val($('.post-' + postID).text()).focus();
    });
}

App.handleUpdatePost = function(){
    $('#save-post-modal').on('click', function() {
        var postID = $('.hidden-post-id').val();
        var data = {body: $('#post-body-modal').val(), postID: postID, _token: token };

        $.ajax({
            url: '/post/' + postID + '/edit',
            method: 'POST',
            data: data,
            dataType: 'JSON',
            statusCode:{
                401: function(){
                    $('#edit-post-modal').modal('show');
                    alert('Please login!');
                    window.location.href = "/";
                }
            }

        })
        . done(function(resp){
            $('.post-' + postID).text('').text(resp.body);
            $('#edit-post-modal').modal('hide');
        });
    })
}

App.handleLike = function(){
    $('.post').on('click', '.like',function(e) {
        var postID = $(e.target).attr('data-id');
        var status = $(e.target).text();
        
        $.ajax({
            method: "POST",
            url: '/post/like/' + postID,
            data: {status: status, _token: token, postID: postID},
            statusCode:{
                404: function(){
                    alert('Error!');
                },
                401: function(){
                    alert('Please login!');
                    window.location.href = "/login";
                }
            }
        })
         .done(function() {
            var text = (status === 'Like') ? 'Dislike' : 'Like';
            $(e.target).text('').text(text);
        });
    });
}