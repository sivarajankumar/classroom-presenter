<?php
	include 'db_credentials.php';
	// Given an email address and a session id, remove the student from
	// the session. 
	
	// Ensure we have the proper variables declared
	if (isset($_POST['uid']) && isset($_POST['sid'])) {
		
		// Connect to our database (change for different user) 
		//$username = "schwer";
		//$password = "Egh8vF5d";
		//$db_name = "schwer_Incognito";
		
		$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
		if (!$db_conn) {
			die("Could not connect");
		}
		
		mysql_select_db($db_name, $db_conn);
		
		$sid = $_POST['sid'];
		$query = sprintf("DELETE FROM Joined WHERE uid = %d AND sid = %d;", 
							$uid, $sid);
		$results = mysql_query($query, $db_conn);
		
		// Now check the results again
		if (!$results) {
			die("Error: " + mysql_error($db_conn));
		}
	}

?>
