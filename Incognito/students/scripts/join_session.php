<?php
	include '../../db_credentials.php';
	// This php file, given a student uw email address and a session id
	// will allow a student to join the session
	
	// Make sure we are given the email and the session id
	if (isset($_POST['uid']) && isset($_POST['sid'])) {
		
		// Connect to our database (change for different user) 
		//$username = "schwer";
		//$password = "Egh8vF5d";
		//$db_name = "schwer_Incognito";
		
		$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
		if (!$db_conn) {
			die("Could not connect");
		}
		
		mysql_select_db($db_name, $db_conn);
		
		$sid = $_POST['sid'];
		
		// Now do the insert
		$uid = $_POST['uid'];
		$query = sprintf("INSERT INTO Joined (sid, uid) VALUES (%d, %d);", $sid, $uid);
		$results = mysql_query($query, $db_conn);
		
		// Check for more errors
		if (!$results) {
			die("Error: " + mysql_error($db_conn));
		}
	}

?>
