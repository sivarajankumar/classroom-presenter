 $(document).ready(function() {
	var place = getCourses(cookieSession_uwid);
	$("#courseInfo").html(place);
	
   $(".joinButton").live('click',function(event) {
		joinSession(cookieSession_uwid, $(this).attr('id'));
	});
   
	$(".quitButton").live('click',function(event) { 
		exitSession(cookieSession_uwid, $(this).attr('id'));
	});
	
	$(".courseRemoveButton").live('click',function(event) {
		deleteCourse(cookieSession_uwid, $(this).attr('id'));
		place = getCourses(cookieSession_uwid);
		$("#courseInfo").html(place);
	});

});
 
 
 
 
 



