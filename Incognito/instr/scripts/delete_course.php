<?php
	
	// Include the db credentials
	include "../../db_credentials.php";	
	 
	// This function will delete a course given a course id.
	if (isset($_POST['cid']) && isset($_POST['uid'])) {
			
		$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
		if (!$db_conn) {
			die("Could not connect");
		}

		mysql_select_db($db_name, $db_conn);
		
		// Get the userid
		$uid = $_POST['uid']; 
		
		// Delete the course
		$cid = $_POST['cid'];
		$query = sprintf("DELETE FROM Course WHERE cid = %d;", $cid);
		$results = mysql_query($query, $db_conn);

		// Error checking
		if (!$results) {
			die("Error: " + mysql_error($db_conn)); 
		}
		
		// Delete the teaches relationship
		$query = sprintf("DELETE FROM Teaches WHERE uid = %d;", $uid); 
		$results = mysql_query($query, $db_conn);   
		
		// Error checking
		if (!$results) {
			die("Error: " + mysql_error($db_conn));
		}

		// Remove the session
		$query = sprintf("DELETE FROM Session WHERE cid = %d AND uid = %d;", $cid, $uid);
		$results = mysql_query($query, $db_conn);

		// Error check
		if (!$results) {
			die("Error: " + mysql_error($db_conn));
		} 
	}

?>
