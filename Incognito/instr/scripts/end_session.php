<?php
	include 'db_credentials.php';
	// This file, given a sid, will end the session
	
	if (isset($_POST['sid'])) {
		
		// Connect to the database
		//$username = "ashen";
		//$password = "2kV2cNct";
		//$db_name = "ashen_403_Local";

		$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
		if (!$db_conn) {
			die("Could not connect");
		}

		mysql_select_db($db_name, $db_conn);
		
		// Delete the session from the Session table
		$sid = $_POST['sid'];
		$query = sprintf("DELETE FROM Session WHERE sid = %d;", $sid);
		$results = mysql_query($query, $db_conn);
		
		// Error Checking
		if (!$results) {
			die("Error: " + mysql_error($db_conn));
		}
	}

?>