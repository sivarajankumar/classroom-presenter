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

	getCourses(333,printToScreen);

	// ends a session
   $(".closeOptionButton").live('click',function(event) {
		endSession($(this).attr('id'));
		getCourses(333, printToScreen);
	});
   
    //starts a session
	$(".openOptionButton").live('click',function(event) { 
		startSession($(this).attr('id'), setSession);
		getCourses(333, printToScreen);
        
        $.cookie("sid", $(this).attr('id'), { expires: 7 });
	});
	
	//Adds a InstructorID, courseName, mailingList, callbackFunction
	$("#courseSubmitButton").click(function(event){
		var courseIs = $("#courseName").val();
		mailIs = $("#mailingList").val();
		courseId = insertCourse(333, courseIs, mailIs, getCourse);
		getCourses(333,printToScreen);
	});
	
	//user deletes a course
	$(".courseRemoveButton").live('click',function(event) {
		deleteCourse(333, $(this).attr('id'));
		getCourses(333,printToScreen);
	});
	
	
	//Adds a student
	$(".addStudentButton").live('click',function(event) {
		//var cookie = $.cookie("uid");
		//alert(cookie);
		// var student = $("#studentToAdd").val();
		updateStudents(333, $(this).attr('id'));
	});
});

$("#timeline").live('click', function(event){
	mypopup();
});
function mypopup(){
    mywindow = window.open("https://cubist.cs.washington.edu/~ashen/Incognito/instr/graph.php", "mywindow", "location=0,status=1,scrollbars=0,  width=300,height=300");
    mywindow.moveTo(0, 0);
}
 
 
 
 
 



