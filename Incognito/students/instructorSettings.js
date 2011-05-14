 $(document).ready(function() {
	var sessionId;
	var place = getCourses(cookieSession_uwid);
	$("#courseInfo").html(place);
 
   $(".closeOptionButton").live('click',function(event) {
		sessionId = startSession($(this).attr('id'));
	});
   
	$(".openOptionButton").live('click',function(event) { 
		endSession(sessionId);
	});
});
 
 
 
 
 



