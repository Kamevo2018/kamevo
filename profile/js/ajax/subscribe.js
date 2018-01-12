function subscribe(user){
	$.ajax({
		url: 'php/subscribe.php',
        method: 'POST',
        dataType: 'text',
        data: {
            subscribe: 1,
			user: user
        },
        success: function(response) {
			if(response == 'subed'){
				$('.subtn').replaceWith('<span class="bold subtn">Abonné</span>');
			}else{
				$('.subtn').replaceWith('<span class="red subtn">S\'abonner</span>');
			}
		}
	})
}