<?php

	// This php script will take a student id and echo an array containing 
	// all of the courses that the student belongs too given a student id.
	
	// Check if we are given a student id
	if (isset($_POST['uid'])) {
		
		// Connect to our database (change for different user) 
		$username = "schwer";
		$password = "Egh8vF5d";
		$db_name = "schwer_Incognito";
		
		$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
		if (!$db_conn) {
			die("Could not connect");
		}
		
		mysql_select_db($db_name, $db_conn);
		
		// Do an check to ensure that the user is a student
		$uid = $_POST['uid'];
		$query = sprintf("SELECT * FROM Student WHERE s.uid = %d;", $uid);
		$results = mysql_query($query, $db_conn);
		
		// Check if we have no results
		if (!mysql_fetch_row($results)) {
			die("Not a student");
		}
		
		// Now run the query to fetch all of the courses
		$query = sprintf("SELECT c.cid, c.name, c.mailinglist FROM Course c, Attends a WHERE a.uid = %d AND a.cid = c.cid;",
						$uid);
		$results = mysql_query($query, $db_conn);
		
		// Now fetch all of the results and store it in an array
		$rows;
		$i = 0; 
		while ($row = mysql_fetch_row($results)) {
			$rows[$i] = $row;
			$i++; 
		}
		
		echo json_encode($rows);
	}

?>