 /* This file handles the events for Instructor Settings page. */
  function printToScreen(data){
	$("#courseInfo").html(data);
 }

  function setSession(data) {
  	sessionId = data; 
  }

  var sessionId;
  var courseId;
  var mailIs;

 $(document).ready(function() {
	
	//initially puts courses on page

	getCourses($.cookie("uid"),printToScreen);

	// ends a session
   $(".closeOptionButton").live('click',function(event) {
		endSession($(this).attr('id'));
		getCourses($.cookie("uid"), printToScreen);
	});
   
    //starts a session
	$(".openOptionButton").live('click',function(event) { 
		startSession($(this).attr('id'), setSession);
		getCourses($.cookie("uid"), printToScreen); 
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

	// Adds a student
	$("#addStudentButton").live('click',function(event) {
		var cookie = $.cookie("uid");
                var student = $("#studentToAdd").val();
		var course = $("#studentCourseButton").val();
		updateStudents(student, course);
	});
});
 
 
 
 
 



