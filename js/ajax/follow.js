$('.group-subscribe').click(function(e){
    if($(this).html() == '<p class="group-info backorange"><b>Suivre ce groupe</b></p>'){
        $(this).html('<p class="group-info backorange"><b>Ne plus suivre ce groupe</b></p>');
    }else{
        $(this).html('<p class="group-info backorange"><b>Suivre ce groupe</b></p>');
    }
    e.preventDefault();
})

function follow(id,user){
    $.ajax({
        url: 'php/follow.php',
        method: 'POST',
        dataType: 'text',
        data: {
            follow: 1,
            id: id,
            user: user
        },success: function(response){
            
        }
    })
}