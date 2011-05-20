<?php

	// This php script, given a session id counts
	// the number of questions asked in the last 5 minutes (this may change)
	// In addition, we are given a time so that we can return an array that
	// has the following format: a = {time, count}

	include 'db_credentials.php'; 
	
	// Ensure that we are given a session id
	if (isset($_POST['id']) && isset($_POST['time'])) {
		
		// Connect and select the correct database
		$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
		if (!$db_conn) {
			die("Could not connect");
		}
		
		mysql_select_db($db_name, $db_conn);
		
		// Query the database for all of the questions in this 
		// session that are within 5 minutes of the time
		$sid = $_POST['sid'];
		$query = sprintf("SELECT count(*) FROM Question WHERE ((NOW() - time) < 5)
							AND sid = %d;", $sid);
		$results = mysql_query($query, $db_conn);
		
		// Error Checking
		if (!$results) {
			die("Error: " . mysql_error($db_conn));
		}
		
		// Do the response
		$row = mysql_fetch_row($results);
		$time = $_POST['time'];
		$response[0] = $time; 
		$response[1] = $row[0];
		
		echo json_encode($response);
	}

?>
