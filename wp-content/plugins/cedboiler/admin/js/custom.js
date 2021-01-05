(function( $ ) {
    'use strict';
    $('.wrapper').on('click', '.save' , function() {
        //var d=$(this).data('post');
        var selectedPost = new Array();
        var n = $(".post:checked").length;
        if (n > 0){
            $(".post:checked").each(function(){
                selectedPost.push($(this).val());
            });
        }
        alert(selectedPost);
        $.ajax({
            url: ajax_object.ajaxurl,
            type: 'post',
            data: {
                'action':'ced_save_post_type',
                //posttype : d ,
                selectedPost :selectedPost

            },
            success: function( response ) {
                alert(response);
            },
        });
    });
})( jQuery );
