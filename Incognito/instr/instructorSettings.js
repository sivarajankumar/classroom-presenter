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
	
	$("#courseSubmitButton").click(function(event)
		var courseIs = $("#courseName").val();
		var mailIs = $("#mailingList").val();
		createCourse(courseIs, mailIs);
		place = getCourses(cookieSession_uwid);
		$("#courseInfo").html(place);
	)};
});
 
 
 
 
 



