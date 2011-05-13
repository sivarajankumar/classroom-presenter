/*
 * This view is made to handle updating the instructor's setting view. This
 * javascript file contains all of the functions necessary to do this. In 
 * addition, this javascript file contains all of the fields necessary to 
 * manage the state of the setting view.  
 */

// This function, given a courseId, will create a session for that course
function startSession(courseId) {
	$.post("scripts/start_session.php",
			{cid: courseId});
}

// This function, given a sessionId, will end and delete that session
function endSession(sessionId) {
	$.post("scripts/end_session.php",
			{sid: sessionId});
}

// This function will make an http request to retreive 
// course information pertaining to a specific instructor
// given the email of the instructor. In addition, you must
// provide a callback function that will be called with the 
// HTTP response. 
function getCourses(instrMail, callback) {
	
	// Make the HTTP request
	$.post("scripts/get_courses.php",
			{mail: instrMail},
			function(data) {
				callback(data);
			});
}

// This function will make an http request to the create_course
// php script that will insert a course in our database. This
// function takes a userId, a courseName, a mailingList, and 
// a function getCid that passes the cid back to the front-end.  
function insertCourse(userId, courseName, mailingList, getCid) {
	
	// Do the AJAX call
	$.post("scripts/create_course.php", 
		{uid: userId, name: courseName, mailinglist: mailingList}, 
		function(data) {
			getCid(data);
		});
}

// This function takes a courseId and a student email and then adds the student
// to the course. 
//
// TODO: Eventually this function will have some sort of handler that informs
// 		 the caller of whether or not the student was successfully added to the 
//		 course. 
function updateStudents(studentEmail, courseId) {
	
	// Make the HTTP requeset through AJAX
	$.post("scripts/addStudent.php",
			{email: studentEmail, cid: courseId});
}
	
