 /* This file handles the events for Instructor Settings page. */
  function printToScreen(data){
	//$("#courseInfo").html(data);
 }
 
 $(document).ready(function() {
	var sessionId;
	var courseId;
	var mailIs;
	//initially puts courses on page
	getCourses($.cookie("session"),printToScreen);
 
	// starts a session
   $(".closeOptionButton").live('click',function(event) {
		sessionId = startSession($(this).attr('id'));
	});
   
    //ends a session
	$(".openOptionButton").live('click',function(event) { 
		endSession(sessionId);
	});
	
	//Adds a InstructorID, courseName, mailingList, callbackFunction
	$("#courseSubmitButton").click(function(event){
		var courseIs = $("#courseName").val();
		mailIs = $("#mailingList").val();
		courseId = insertCourse($.cookie("session"), courseIs, mailIs, printToScreen);
		getCourses($.cookie("session"),printToScreen);
		//$("#courseInfo").html(place);
	});
	
	//user deletes a course
	$(".courseRemoveButton").live('click',function(event) {
		deleteCourse($.cookie("session"), $(this).attr('id'), mailIs, printToScreen);
		getCourses($.cookie("session"),printToScreen);
	});
});
 
 
 
 
 



