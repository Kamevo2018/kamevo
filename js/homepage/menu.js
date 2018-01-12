$('a[href^="#top"]').click(function(e){
	$('html, body').animate({
		scrollTop: 0
	}, 'slow');
	e.preventDefault();
});