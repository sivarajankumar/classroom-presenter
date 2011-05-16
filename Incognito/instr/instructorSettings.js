 /* This file handles the events for Instructor Settings page. */
  function printToScreen(data){
	$("#courseInfo").html(data);
 }
 
 $(document).ready(function() {
	var sessionId;
	var courseId;
	var mailIs;
	//initially puts courses on page

	getCourses($.cookie("uid"),printToScreen);

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
		courseId = insertCourse($.cookie("uid"), courseIs, mailIs, printToScreen);
		getCourses($.cookie("uid"),printToScreen);
	});
	
	//user deletes a course
	$(".courseRemoveButton").live('click',function(event) {
		deleteCourse($.cookie("uid"), $(this).attr('id'));
		getCourses($.cookie("uid"),printToScreen);
	});
	
	
	//Adds a student
	$("#addStudentButton").live('click',function(event) {
		//var cookie = $.cookie("uid");
		//alert(cookie);
		var student = $("#studentToAdd").val();
		var course = $("#studentCourseButton").val();
		updateStudents(student, course);
		alert("student added!");
	});
});
 
 
 
 
 



