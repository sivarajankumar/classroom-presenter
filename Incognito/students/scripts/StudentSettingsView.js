/*
 * The StudentSettingsView renders the information retrieved from models,
 * relating to user settings for students into a form suitable for interaction,
 * a user interface element. StudentSettin.gsVewi inherits from SettingsView
 */

// This function will makes an HTTP Request to the get_courses php script, retrieves
// the courses, and gives the courses to the handleCourses handler. In addition, the
// caller must pass a valid studentId. 
function getCourses(studentId, handleCourses) {
	
	// Make the AJAX call to the backend
	$.post("scripts/get_courses.php",
			{uid: studentId},
			function(data) {
				var results = JSON.parse(data);
				handleCourses(results);
			});
}
