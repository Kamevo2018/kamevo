var start = 0;
var limit = 10;
var reachedMax = false;
$(window).scroll(function () {
    if ($(window).scrollTop() == $(document).height() - $(window).height())
         getData();
    });

$(document).ready(function () {
	getData();
});

$(".like").click(function(){
	$(".likes-tools").addClass('nodisplay');
});

function getData() {
    if (reachedMax)
		return;
		$(".marginer").addClass('.end-flux');
					
	$.ajax({
        url: 'php/data.php',
        method: 'POST',
        dataType: 'text',
        data: {
        	getData: 1,
            start: start,
            limit: limit
        },
        	success: function(response) {
                if (response == 'max')
                    reachedMax = true;
                else {
                    start += limit;
					$(".flux-container").append(response);
					$(".flux-container").after('<br/>');

					// $(".flux-block").each(function(i,e){
					// 	if (i >= 12 && i % 12 == 0){
					// 		var ad = '<div class="flux-block"><div class="flux-block-header"><img src="img/kamico.png" alt="flux-avatar" class="flux-block-avatar"><h4 class="flux-block-author">Publicité</h4><span class="flux-block-date">Kamevo.com</span><span class="flux-block-status">Sponsorisé</span></div><div class="flux-block-content"><p>Ceci est une publication sponsorisée par Kamevo.com</p></div><div class="flux-block-image"><img src="img/pub.png" alt="flux-image" class="flux-block-img"></div></div>';
					// 		$(this).after(ad);
					// 	}
					// });
				}
			}
	});
}