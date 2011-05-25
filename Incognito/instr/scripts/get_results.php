<?php

	// Given survey id this php script will return the current results of the 
	// survey.
	
	include '../../db_credentials.php';
	
	// Check if we are given an sid
	if ($_POST['sid']) {
		
		// Connect and select the correct database
		$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
		if (!$db_conn) {
			die("Could not connect");
		}
		
		mysql_select_db($db_name, $db_conn);
		
		// Run the query, first check the Choices DB 
		$sid = $_POST['sid'];
		$query = sprintf("SELECT text, count FROM Choices WHERE sid = %d;", $sid);
		$results = mysql_query($query, $db_conn);
		
		// Check for errors
		if (!$results) {
			die("Error: " . mysql_error($db_conn));
		}
		
		// Check the number of results
		if (mysql_num_rows($results) > 0) {
			
			$rows;
			$i = 0; 
			while ($row = mysql_fetch_row($results)) {
				$rows[$i] = $row; 
				$i++;
			}
			
			echo json_encode($rows);
		} else {
			
			// Search the free response answers
			$query = sprintf("SELECT text FROM Answer WHERE sid = %d;", $sid);
			$results = mysql_query($query, $db_conn);
			
			// Check for errors
			if (!$results) {
				die("Error: " . mysql_error($db_conn));
			}
			
			$rows;
			$i = 0; 
			while ($row = mysql_fetch_row($results)) {
				$rows[$i] = $row; 
				$i++; 
			}
			
			echo json_encode($rows);
		}
	}

?>
