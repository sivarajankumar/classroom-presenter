<?php
	include '../../db_credentials.php';
	// This function, given a student email and an alias
	// will update the student's alias. 
	
	if (isset($_POST['uid']) && isset($_POST['alias'])) {
		
		// Connect to our database (change for different user) 
		//$username = "schwer";
		//$password = "Egh8vF5d";
		//$db_name = "schwer_Incognito";
		
		$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
		if (!$db_conn) {
			die("Could not connect");
		}
		
		mysql_select_db($db_name, $db_conn);

		$uid = $_POST['uid'];
		$alias = $_POST['alias'];
		$query = sprintf("UPDATE Student SET alias = '%s' WHERE uid = %d;", $alias, $uid);
		$results = mysql_query($query, $db_conn);
		
		// Error Check
		if (!$results) {
			die("Error: " + mysql_error($db_conn));
		}
	}

?>
