<?php
	include '../../db_credentials.php';
	// This php script adds a student to a class given a email and a 
	// course id
	echo $uid;
	// Check if the email and cid have been set
	if (isset($_POST['uid']) && isset($_POST['cid'])) {
		
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
		
		// First get the uid for the student based off of the email
		$uid = $_POST['uid'];
		$cid = $_POST['cid'];

		$query = sprintf("INSERT INTO Attends (uid, cid) VALUES (%d, %d);", $uid, $cid);
		$results = mysql_query($query, $db_conn);

		// Do some error checking
		if (!$results) {
			die("Error: " + mysql_error($db_conn));
		}
	}

?>
