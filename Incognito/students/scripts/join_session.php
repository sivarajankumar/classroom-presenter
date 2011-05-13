<?php

	// This php file, given a student uw email address and a session id
	// will allow a student to join the session
	
	// Make sure we are given the email and the session id
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
		
		// First we need to find the uid
		$mail = $_POST['mail'];
		$sid = $_POST['sid'];
		$query = sprintf("SELECT uid FROM User WHERE email = '%s';", $mail);
		$results = mysql_query($query, $db_conn);
		
		// Check if our query ran
		if (!$results) {
			die("Error: " + mysql_error($db_conn));
		}
		
		$row = mysql_fetch_row($results);
		
		// Now do the insert
		$uid = $row[0];
		$query = sprintf("INSERT INTO Joined VALUES (%d, %d);", $uid, $sid);
		$results = mysql_query($query, $db_conn);
		
		// Check for more errors
		if (!$results) {
			die("Error: " + mysql_error($db_conn));
		}
	}

?>
