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
	$uid = $.cookie('uid');
	getCourses($uid, printToScreen);

	// ends a session
   $(".closeOptionButton").live('click',function(event) {
		endSession($(this).attr('id'));
		getCourses($uid, printToScreen);
		$.cookie('sid', "", {expires: -1, path: '/'});
	});
   
    //starts a session
	$(".openOptionButton").live('click',function(event) { 
		startSession($(this).attr('id'), setSession);
		getCourses($uid, printToScreen);
        
        $.cookie("sid", $(this).attr('id'), { expires: 7, path: '/' });
	});
	
	//Adds a InstructorID, courseName, mailingList, callbackFunction
	$("#courseSubmitButton").click(function(event){
		var courseIs = $("#courseName").val();
		mailIs = $("#mailingList").val();
		courseId = insertCourse($uid, courseIs, mailIs, getCourse);
		getCourses($uid, printToScreen);
	});
	
	//user deletes a course
	$(".courseRemoveButton").live('click',function(event) {
		// if session is open , need to prompt to close session first
		deleteCourse($uid, $(this).attr('id'));
		// must delete only one course
		getCourses($uid,printToScreen);
	});
	
	
	//Adds a student
	$(".addStudentButton").live('click',function(event) {
		//var cookie = $.cookie("uid");
		//alert(cookie);
		// var student = $("#studentToAdd").val();
		updateStudents($uid, $(this).attr('id'));
	});
});

$("#timeline").live('click', function(event){
	mypopup();
});
function mypopup(){
    mywindow = window.open("https://cubist.cs.washington.edu/~ashen/Incognito/instr/graph.php", "mywindow", "location=0,status=1,scrollbars=0,  width=300,height=300");
    mywindow.moveTo(0, 0);
}
 
 
 
 
 



