$(document).on('click', '.notifications', function(e){
    $('.widget-fade').toggleClass('w-faded');
    $('.notifications-center').toggleClass('nc-displayed');
    $('.notifications-counter').html('');
    $('.notifications-counter').append('0');
    $.ajax({
        url: 'php/seeNotifications.php',
        method: 'POST',
        dataType: 'text',
        data: {
            see: 1
        },success: function(response){
        }
    })
    e.preventDefault();
})
$(document).on('click', '.widget-fade',function(e){
    $('.widget-fade').toggleClass('w-faded');
    $('.notifications-center').toggleClass('nc-displayed');
    e.preventDefault();
})
$(document).on('click', '#nc-closer', function(e){
    $('.widget-fade').toggleClass('w-faded');
    $('.notifications-center').toggleClass('nc-displayed');
    e.preventDefault();
})