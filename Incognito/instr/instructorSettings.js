 /* This file handles the events for Instructor Settings page. */
  function printToScreen(data){
	$("#courseInfo").html(data);
 }

function getCourse(data) {
	// This is just a place holder for when the cid's are returned to us
}

  function setSession(data) {
  	sessionId = data; 
  }

  var sessionId;
  var courseId;
  var mailIs;

 $(document).ready(function() {
	
    // alert($.cookie("uid"));
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
        
        $.cookie("sid", $(this).attr('id'), { expires: 7 });
	});
	
	//Adds a InstructorID, courseName, mailingList, callbackFunction
	$("#courseSubmitButton").click(function(event){
		var courseIs = $("#courseName").val();
		mailIs = $("#mailingList").val();
		courseId = insertCourse($.cookie("uid"), courseIs, mailIs, getCourse);
		getCourses($.cookie("uid"),printToScreen);
	});
	
	//user deletes a course
	$(".courseRemoveButton").live('click',function(event) {
		deleteCourse($.cookie("uid"), $(this).attr('id'));
		getCourses($.cookie("uid"),printToScreen);
	});
	
	
	//Adds a student
	$(".addStudentButton").live('click',function(event) {
		//var cookie = $.cookie("uid");
		//alert(cookie);
		// var student = $("#studentToAdd").val();
		updateStudents($.cookie("uid"), $(this).attr('id'));
	});
});
 
 
 
 
 



