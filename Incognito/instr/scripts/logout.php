<?php
include '../../db_credentials.php';
	// This php script does all the logout dirty work
	$uid = $_COOKIE["uid"];
  	if ($uid) {
		// Connect to server
		$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
	 
		if (!$db_conn) {
			die("Failed to connect to the mysql server"); 
		}
		// Select the correct database
		mysql_select_db($db_name, $db_conn); 
	  
		// Prepare and execute Query
		// Get the session that the instructor has open
		// There should only be one

		$query = sprintf("SELECT sid FROM `Session` WHERE uid = '%d';", $uid);
		$results = mysql_query($query, $db_conn);
		//error check
		if(!mysql_query($query, $db_conn)) {
			die("Query error: " . mysql_error());
		}
		// get the rows from the results, should be one or zero
		$row = mysql_fetch_row($results);
		if($row){
			$sid = $row[0];
			// close the session down
			$query = sprintf("DELETE FROM Session where sid = %d;", $sid);
			$results = mysql_query($query, $db_conn);
			// Error checking
			if (!$results) {
				die("Error: " + mysql_error($db_conn));
			}
			// now kick all students out
			$query = sprintf("DELETE FROM `Joined` where sid = %d;", $sid);	
			$results = mysql_query($query, $db_conn);
	
			// Error checking
			if (!$results) {
				die("Error: " + mysql_error($db_conn));
			}
		}
		mysql_close($db_conn);
	}
	// delete cookie
	setcookie("uid", "", time()-3600,"/");
	setcookie("sid", "", time()-3600,"/");
	header("Location: http://cubist.cs.washington.edu/~ashen/Incognito/login.php");

?>
