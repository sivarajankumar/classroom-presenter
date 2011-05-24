<?php
	include 'db_credentials.php';
	// This php script file, given a unique student id and a session id
	// will add the student as someone who attends that course.
	
	// First check that we are given a uid (user id) and a session id (sid)
	if (isset($_POST['uid']) && isset($_POST['cid'])) {
		
		// Connect to the database
		//$username = "schwer";
		//$password = "Egh8vF5d";
		//$db_name = "schwer_Incognito";
		
		$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
		if (!$db_conn) {
			die("Could not connect");
		}
		
		mysql_select_db($db_name, $db_conn);
		
		// Now insert the student, session pair in the attends table
		$uid = $_POST['uid'];
		$sid = $_POST['cid'];
		$query = sprintf("INSERT INTO Attends VALUES (%d, %d);", $uid, $sid);
		$results = mysql_query($query, $db_conn);
		
		// Do some error checking
		if (!$results) {
			die("Error: " + mysql_error($db_conn));
		}
	}

?>
