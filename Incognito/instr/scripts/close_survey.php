<?php

	// Given a survey id, this php script will set a 
	// survey as closed. 

	include 'db_credentials.php';
	
	// Check if the survey id was set
	if (isset($_POST['sid'])) {
		
		// Connect and select the correct database
		$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
		if (!$db_conn) {
			die("Could not connect");
		}
		
		mysql_select_db($db_name, $db_conn);
		
		// Update the survey
		$sid = $_POST['sid'];
		$query = sprintf("UPDATE Survey SET open = 0 WHERE sid = %d;", $sid);
		$results = mysql_query($query, $db_conn);
		
		if (!$results) {
			die("Error: " . mysql_error($db_conn));
		}
	}

?>
