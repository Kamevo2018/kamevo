 $(document).on('click','.b-dislike',function(e){
    e.preventDefault();
    if($(this).parent().hasClass('disliked')){
        $(this).parent().removeClass('disliked');
        $(this).parent().parent().children('.progress').fadeTo(500,0.7);
        $(this).parent().parent().children('.progress').fadeTo(500,1).delay(500);
    }else{
        if($(this).parent().parent().children('.like').hasClass('liked')){
            $(this).parent().parent().children('.like').removeClass('liked');
        }
        $(this).parent().addClass('disliked');
        $(this).parent().parent().children('.progress').fadeTo(500,0.7);
        $(this).parent().parent().children('.progress').fadeTo(500,1).delay(500);

    }
})
 $(document).on('click','.b-like',function(e){
    e.preventDefault();
    if($(this).parent().hasClass('liked')){
        $(this).parent().removeClass('liked');
        $(this).parent().parent().children('.progress').fadeTo(500,0.7);
        $(this).parent().parent().children('.progress').fadeTo(500,1).delay(500);
    }else{
        if($(this).parent().parent().children('.dislike').hasClass('disliked')){
            $(this).parent().parent().children('.dislike').removeClass('disliked');
        }
        $(this).parent().addClass('liked');
        $(this).parent().parent().children('.progress').fadeTo(500,0.7);
        $(this).parent().parent().children('.progress').fadeTo(500,1).delay(500);
    }
})
function dislike(id,user){
    $.ajax({
        url: 'php/dislike.php',
        method: 'POST',
        dataType: 'text',
        data: {
            dislike: 1,
            id: id,
            user: user
        },success: function(disliked){
                $.ajax({
                    url: 'php/getValue.php',
                    method: 'POST',
                    dataType: 'text',
                    data: {
                        progress: 1,
                        id: id
                    },success: function(ratio){
                        document.getElementById('progress'+id).value = ratio;
                    }
                })
            }
    })
}

function like(id,user){
    $.ajax({
        url: 'php/like.php',
        method: 'POST',
        dataType: 'text',
        data: {
            like: 1,
            id: id,
            user: user
        },success: function(disliked){
                $.ajax({
                    url: 'php/getValue.php',
                    method: 'POST',
                    dataType: 'text',
                    data: {
                        progress: 1,
                        id: id
                    },success: function(ratio){
                        document.getElementById('progress'+id).value = ratio;
                    }
                })
            }
    })
}