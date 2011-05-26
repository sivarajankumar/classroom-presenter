<?php
	include '../../db_credentials.php';
	// This php script, given a course id, will create a new session for
	// that course
	if (isset($_POST['cid']) && isset($_POST['uid'])) {

		$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
		if (!$db_conn) {
			die("Could not connect");
		}

		mysql_select_db($db_name, $db_conn);
		$uid = $_POST['uid'];	
		
		// First, get the session id
		$cid = $_POST['cid'];
		echo $cid . "+ " . $uid;
		$query = sprintf("SELECT sid FROM Session WHERE cid=%d and uid=%d;", $cid, $uid);
		$results = mysql_query($query, $db_conn);
		
		// Error Check
		if (!$results) {
			die ("Error: " . mysql_error($db_conn)); 
		}

		$row = mysql_fetch_row($results); 
		$sid = $row[0];

		// Now update the session so that it is open
		$query = sprintf("UPDATE Session SET open = 1 WHERE sid = %d;", $sid); 
		$results = mysql_query($query, $db_conn); 

		// Error Check
		if (!$results) {
			die ("Error: " . mysql_error($db_conn)); 
		}

		echo $sid; 
			
	}

?>
