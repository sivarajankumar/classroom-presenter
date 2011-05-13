 /* This file handles the events for Instructor Settings page. */
  function printToScreen(data){
	$("#courseInfo").html(data);
 }
 
 $(document).ready(function() {
	var sessionId;
	var courseId;
	//initially puts courses on page
	getCourses("schwer@cs.washington.edu",printToScreen);
 
	// starts a session
   $(".closeOptionButton").live('click',function(event) {
		sessionId = startSession($(this).attr('id'));
	});
   
    //ends a session
	$(".openOptionButton").live('click',function(event) { 
		endSession(sessionId);
	});
	
	//Adds a course given course, mailingList
	$("#courseSubmitButton").click(function(event){
		var courseIs = $("#courseName").val();
		var mailIs = $("#mailingList").val();
		courseId = createCourse(courseIs, mailIs);
		getCourses("schwer@cs.washington.edu",printToScreen);
		$("#courseInfo").html(place);
	});
});
 
 
 
 
 



