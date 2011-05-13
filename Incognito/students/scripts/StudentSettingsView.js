/*
 * The StudentSettingsView renders the information retrieved from models,
 * relating to user settings for students into a form suitable for interaction,
 * a user interface element. StudentSettin.gsVewi inherits from SettingsView
 */

// This function will makes an HTTP Request to the get_courses php script, retrieves
// the courses, and gives the courses to the handleCourses handler. In addition, the
// caller must pass a valid studentId. 
function getCourses(studentEmail, handleCourses) {
	
	// Make the AJAX call to the backend
	$.post("scripts/get_courses.php",
			{uid: studentEmail},
			function(data) {
				var results = JSON.parse(data);
				handleCourses(results);
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
