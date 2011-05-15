<?php

	// This function will delete a course given a course id.
	
	if (isset($_POST['cid'])) {
		
		// Connect to the database
		$username = "schwer";
		$password = "Egh8vF5d";
		$db_name = "schwer_Incognito";

		$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
		if (!$db_conn) {
			die("Could not connect");
		}

		mysql_select_db($db_name, $db_conn);
		
		// Delete the course
		$cid = $_POST['cid'];
		$query = sprintf("DELETE FROM Course WHERE cid = %d;", $cid);
		$results = mysql_query($query, $db_conn);
		
		// Error checking
		if ($results) {
			die("Error: " + mysql_error($db_conn));
		}
	}

?>