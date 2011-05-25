<?php

	include '../../db_credentials.php';

	// This php script get's the alias for a student given a email
	
	if (isset($_POST['uid'])) {
		
		$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
		if (!$db_conn) {
			die("Could not connect");
		}

		mysql_select_db($db_name, $db_conn);
		
        $uid = $_POST['uid'];
		$query = sprintf("SELECT email FROM User WHERE uid = %d;", $uid);
		$results = mysql_query($query, $db_conn);
		
		// Error check
		if (!$results) {
			die("Error: " + mysql_error($db_conn));
		}
		
		// Get the uid and then do the update
		$row = mysql_fetch_row($results);
        
		// Write the query to get the alias the database
		$mail = $row[0];
		$query = sprintf("SELECT s.alias FROM Student s, User u WHERE u.email = '%s' AND s.uid = u.uid",
						$mail);
		$results = mysql_query($query, $db_conn);
		
		// Error check
		if (!$results) {
			die("Error: " + mysql_error($db_conn));
		}
		
		$row = mysql_fetch_row($results);
		echo $row[0];
	}

?>
