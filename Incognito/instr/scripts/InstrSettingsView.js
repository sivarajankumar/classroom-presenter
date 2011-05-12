/*
 * This view is made to handle updating the instructor's setting view. This
 * javascript file contains all of the functions necessary to do this. In 
 * addition, this javascript file contains all of the fields necessary to 
 * manage the state of the setting view.  
 */

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
	
