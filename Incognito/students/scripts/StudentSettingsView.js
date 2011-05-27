/*
 * The StudentSettingsView renders the information retrieved from models,
 * relating to user settings for students into a form suitable for interaction,
 * a user interface element. StudentSettin.gsVewi inherits from SettingsView
 */

// This function, given a student email and an alias, will change the student's
// alias to the given alias. In addition, this will update the state of the 
// database. 
function addAlias(studentId, studentAlias) {
	$.post("scripts/add_alias.php",
			{uid: studentId, alias: studentAlias});
}

// This function, given a student email and a callback function, this function
// does the HTTP request and then calls the callback function when the response 
// comes back. The response contains the alias of the student. 
function getAlias(studentId, callback) {
	$.post("scripts/get_alias.php",
			{uid: studentId},
			function(data) {
				callback(data);
			});
}

// This function, given a session id and a student email, will remove a student
// from a session
function exitSession(studentId, sessionId) {
	$.post("scripts/exit_session.php",
			{uid: studentId, sid: sessionId});
}

// This function, given a session id and a student email, will add that student
// to the given session. 
function joinSession(studentId, sessionId) {
	$.post("scripts/join_session.php",
			{uid: studentId, sid: sessionId});
}

// This function will makes an HTTP Request to the get_courses php script, retrieves
// the courses, and gives the courses to the handleCourses handler. In addition, the
// caller must pass a valid studentId. 
function getCourses(uid, handleCourses) {
	// Make the AJAX call to the backend
	$.post("scripts/get_courses.php",
			{uid: uid},
			function(data) {
				handleCourses(data);
			});
}

// This function, given a studentId and a courseId will 
// add to the database that the student is attending the course.
//
// TODO: Add a error handling function, need to coordinate with
//		 front-end team about this. 
function addCourse(studentId, courseId) {
	
	// Make the AJAX call to the backend
	$.post("scripts/add_course.php",
			{uid: studentId, cid: courseId});
}

// This function, given a studentId and a courseId will remove
// the student from attendance of that specific course. 
//
// TODO: Add a error handling function, need to coordinate with
//       the front-end team about this. 
function removeCourse(studentId, courseId) {
	
	// Make the AJAX call to the backend
	$.post("scripts/delete_course.php",
			{uid: studentId, cid: courseId});
}
