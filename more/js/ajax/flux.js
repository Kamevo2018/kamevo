$(document).on('click','.flux-block-delete',function(e){
    e.preventDefault();
    $(this).parent().children('.flux-block-delete-more').toggleClass('delete-block-undisplayed');
});
$(document).on('click','.flux-block-delete-link',function(e){
    e.preventDefault();
    $(this).parent().parent().parent().fadeOut(100);
    var value = $(this).parent().parent().parent().attr('id');
    $.ajax({
        url: 'php/flux_delete.php',
        method: 'POST',
        dataType: 'text',
        data: {
            delete: 1,
            value: value
        },success: function(response){
            window.location.href = "https://kamevo.com";
    } })
});