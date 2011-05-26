<?php
	include '../../db_credentials.php';
	// This php script, given a course id, will create a new session for
	// that course
	if (isset($_POST['cid']) && isset($_POST['uid'])) {

		$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
		if (!$db_conn) {
			die("Could not connect");
		}

		mysql_select_db($db_name, $db_conn);
		$uid = $_POST['uid'];	
		$cid = $_POST['cid'];
		
		// Insert an open session into the session table
		$query = sprintf("INSERT INTO Session (cid, uid, open) VALUES (%d, %d, 1);", $cid, $uid); 
		$results = mysql_query($query, $db_conn); 

		// Error Check
		if (!$results) {
			die ("Error: " . mysql_error($db_conn)); 
		}

		// Now return the session id that was just created
		$query = sprintf("SELECT sid FROM Session WHERE cid = %d AND uid = %d;", $uid, $cid); 
		$results = mysql_query($query, $db_conn); 

		// Error Check
		if (!$results) {
			die("Error: " . mysql_error($db_conn)); 
		} 

		$row = mysql_fetch_row($results);
		echo $row[0];
			
	}

?>
