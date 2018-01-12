
		 	var start = 0;
             var limit = 10;
             var reachedMax = false;
             var group = $('.flux-container').attr('id');
 
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
                        limit: limit,
                        group: group
                    },
                    success: function(response) {
                         if (response == 'max')
                             reachedMax = true;
                         else {
                             start += limit;
                             $(".flux-container").append(response);
                             $(".flux-container").after('<br/>');
 
                         }
                     }
                 });
             }