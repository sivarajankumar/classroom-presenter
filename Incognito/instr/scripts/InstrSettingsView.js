/*
 * This view is made to handle updating the instructor's setting view. This
 * javascript file contains all of the functions necessary to do this. In 
 * addition, this javascript file contains all of the fields necessary to 
 * manage the state of the setting view.  
 */

// This variable keeps track of the most recent cid added to the database. The
// cid will be -1 when it is first initialized and after it has been asked for
// by the caller. 
var cid = -1; 

// This function will take a user id, course name, and course email. Given this
// information, the function will insert a new course into the database. 
function insertCourse(uid, name, mailingList) {
	
	// Do the AJAX call
	$.post("create_course.php", {uid: uid, name: name, mailinglist: mailingList}, 
			function(data) {
				cid = data; 
			});
}

// This function will return the most recent cid from the most recent course
// created. If this function returns -1, that means that the cid has not changed
// since the last time you fetched it. Otherwise, it will return the most recent
// cid from the most recent course added to the database.
function getMostRecentCid() {
	var temp = cid; 
	
	// Set the cid back to -1
	cid = -1;
	
	return temp;
}