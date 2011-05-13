<?php

	// Given an email address and a session id, remove the student from
	// the session. 
	
	// Ensure we have the proper variables declared
	if (isset($_POST['mail']) && isset($_POST['sid'])) {
		
		// Connect to our database (change for different user) 
		$username = "schwer";
		$password = "Egh8vF5d";
		$db_name = "schwer_Incognito";
		
		$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
		if (!$db_conn) {
			die("Could not connect");
		}
		
		mysql_select_db($db_name, $db_conn);
		
		// Now fetch the user's uid
		$mail = $_POST['mail'];
		$sid = $_POST['sid'];
		$query = sprintf("SELECT uid FROM User WHERE email = '%s';", $mail);
		$results = mysql_query($query, $db_conn);
		
		// Check for errors
		if (!$results) {
			die("Error: " + mysql_error($db_conn));
		}
		
		// Now delete the uid, sid tuple from Joined
		$row = mysql_fetch_row($results);
		$uid = $row[0];
		$query = sprintf("DELETE FROM Joined WHERE uid = %d AND sid = %d;", 
							$uid, $sid);
		$results = mysql_query($query, $db_conn);
		
		// Now check the results again
		if (!$results) {
			die("Error: " + mysql_error($db_conn));
		}
	}

?>