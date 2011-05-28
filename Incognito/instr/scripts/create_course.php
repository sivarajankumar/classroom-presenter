<?php
	include '../../db_credentials.php';
	// This file adds a new course to the database and returns the cid
	
	// Check if the proper variables were sent
	if (isset($_POST['uid'])) {
		// Connect to our database (change for different user) 
		// Connect to the database
		//$username = "ashen";
		//$password = "2kV2cNct";
		//$db_name = "ashen_403_Local";
		$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
		if (!$db_conn) {
			die("Could not connect");
		}
		
		mysql_select_db($db_name, $db_conn);
		
		// First check if the user is a student
		$uid = $_POST['uid'];
		$query = sprintf("SELECT * FROM Student WHERE uid = %d;", $uid);
		$results = mysql_query($query, $db_conn);
		
		// Insert the course
		$name = $_POST['name'];
		$mailinglist = $_POST['mailinglist'];
		$query = sprintf("INSERT INTO Course (name, mailinglist) VALUES ('%s', '%s');", 
							$name, $mailinglist);
		$results = mysql_query($query, $db_conn);
		
		// Do some error checking
		if (!$results) {
			die("Error: " + mysql_error($db_conn));
		}
		
		// We also need to insert the course id and the uid pair into the 
		// Teaches table, but first we need to get the uid
		$query = sprintf("SELECT cid FROM Course WHERE name = '%s' AND mailinglist = '%s' ORDER BY cid DESC;",
							$name, $mailinglist);
		$results = mysql_query($query, $db_conn);
		
		$row = mysql_fetch_row($results);
		$cid = $row[0];
	
		// Now insert the pair
		$query = sprintf("INSERT INTO Teaches VALUES (%d, %d);", $uid, $cid);
		$results = mysql_query($query, $db_conn);

		// Error checking
		if(!$results) {
			die("Error" + mysql_error($db_conn));
		}
	
		// Return the cid back to the user
		echo $cid; 
	}

?>
