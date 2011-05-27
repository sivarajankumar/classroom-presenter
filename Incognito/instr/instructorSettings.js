 /* This file handles the events for Instructor Settings page. */
  function printToScreen(data){
	$("#courseInfo").html(data);
 }

function getCourse(data) {
	// This is just a place holder for when the cid's are returned to us
}


  var courseId;
  var mailIs;

// This function will create a cookie with the session id in it
function setSession(sessionId) {
	$.cookie("sid", sessionId, {expires: 7, path: '/' }); 
}

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
		startSession($(this).attr('id'), $uid, setSession);
		getCourses($uid, printToScreen);
        
        	//$.cookie("sid", $(this).attr('id'), { expires: 7, path: '/' });
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


setInterval("refreshFeed()", 1000); // refresh every 1000 milliseconds

function refreshFeed() {
    $uid = $.cookie('uid');
    if($uid != null) {
        getCourses($uid, printToScreen);
    }
}

$("#timeline").live('click', function(event){
	mypopup();
});
function mypopup(){
    mywindow = window.open("graph.php", "mywindow", "location=0,status=1,scrollbars=0,  width=300,height=300");
    mywindow.moveTo(0, 0);
}
 
 
 
 
 



