<?php
include 'db_credentials.php';
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
		// Remove user from any session
		$query = sprintf("DELETE FROM `Joined` WHERE uid = '%d';", $uid);
		$results = mysql_query($query, $db_conn);
			
		if(!mysql_query($query, $db_conn)) {
			die("Query error: " . mysql_error());
		}	
		mysql_close($db_conn);
	}
	// delete cookie
	setcookie("uid", "", time()-3600);
	setcookie("csenetid_l", "", time()-3600);
	setcookie("alias", "", time()-3600);
	header("Location: http://cubist.cs.washington.edu/~ashen/Incognito/login.php");
?>