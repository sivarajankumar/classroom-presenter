<?php
	include '../../db_credentials.php';
	// This php script, given a course id, will create a new session for
	// that course
	
	if (isset($_POST['cid'])) {
		// Connect to the database
		// Connect to the database
		//$username = "ashen";
		//$password = "2kV2cNct";
		//$db_name = "ashen_403_Local";

		$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
		if (!$db_conn) {
			die("Could not connect");
		}

		mysql_select_db($db_name, $db_conn);
		
		// Now insert a new session into the Session table
		$cid = $_POST['cid'];
		$query = sprintf("UPDATE Session SET open = 1 WHERE cid = %d;", $cid);
		$results = mysql_query($query, $db_conn);
		// Error Check
		if (!$results) {
			die("Error: " + mysql_error($db_conn));
		}
		
		// Find the sid that was just created
		$query = sprintf("SELECT sid FROM Session WHERE cid = %d ORDER BY sid DESC;", $cid);
		$results = mysql_query($query, $db_conn);
		
		// Error check
		if (!$results) {
			die("Error: " + mysql_error($db_conn));
		}
		
		$row = mysql_fetch_row($results);
		echo $row[0];
	}

?>
