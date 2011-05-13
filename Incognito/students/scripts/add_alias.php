<?php

	// This function, given a student email and an alias
	// will update the student's alias. 
	
	if (isset($_POST['mail']) && isset($_POST['alias'])) {
		
		// Connect to our database (change for different user) 
		$username = "schwer";
		$password = "Egh8vF5d";
		$db_name = "schwer_Incognito";
		
		$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
		if (!$db_conn) {
			die("Could not connect");
		}
		
		mysql_select_db($db_name, $db_conn);
		
		// Find the uid of the student
		$mail = $_POST['mail'];
		$query = sprintf("SELECT uid FROM User WHERE email = '%s';", $mail);
		$results = mysql_query($query, $db_conn);
		
		// Error check
		if (!$results) {
			die("Error: " + mysql_error($db_conn));
		}
		
		// Get the uid and then do the update
		$row = mysql_fetch_row($results);
		$uid = $row[0];
		$alias = $_POST['alias'];
		$query = sprintf("UPDATE Student SET alias = '%s' WHERE uid = %d;", $alias, $uid);
		$results = mysql_query($query, $db_conn);
		
		// Error Check
		if (!$results) {
			die("Error: " + mysql_error($db_conn));
		}
	}

?>
