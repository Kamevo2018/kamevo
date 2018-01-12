$('.top-search-bar').keyup(function(){
    var value = $('.top-search-bar').val();
    if(value ==  ''){
        $('.input-results').removeClass('r-displayed');
        $('.top-search-bar').removeClass('top-sb-nb');
    }else{
        $.ajax({
        url: 'php/search.php',
        method: 'POST',
        dataType: 'text',
        data: {
            search: 1,
            value: value
        },success: function(response){
                $('.i-res').replaceWith(' ');
                $('.input-results').append(response);
        }
    })
        $('.input-results').addClass('r-displayed');
        $('.top-search-bar').addClass('top-sb-nb');
    }
})
$('.top-search-bar').blur(function() {
    if(mousedownHappened){
        $('.top-search-bar').focus();
        mousedownHappened = false;
    }
    else{
        $('.top-search-bar').removeClass('top-sb-nb');
        $('.input-results').removeClass('r-displayed');
    }
});

var mousedownHappened = false;
$('.input-results').mousedown(function() {
    mousedownHappened = true;
});