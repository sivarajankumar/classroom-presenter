<?php

	// This php script takes a survey id, an answer, and a survey type and submits the
	// answer to the Answers table. In addition, we need a uid if the survey is a free
	// response.
	// 
	// Type Argument: 'mc' submits multiple choice answers
	//				  'fr' submits a free response answer
	
	// Include the db_credentials
	include 'db_credentials.php';

	// Check if the variables are set
	if(isset($_GET['sid']) && isset($_GET['answer']) && isset($_GET['type'])) {
		
		// Connect and select the correct database
		$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
		if (!$db_conn) {
			die("Could not connect");
		}
		
		mysql_select_db($db_name, $db_conn);
		
		// Now run the queries on the db based on the type of survey
		$type = $_GET['type'];
		if($type == "mc") {
			
			// First see how many of that type of answer there are 
			$answer = $_GET['answer'];
			$sid = $_GET['sid'];
			$query = sprintf("SELECT count FROM Choices WHERE sid = %d AND text = '%s';", 
								$sid, $answer);
			$results = mysql_query($query, $db_conn);
			
			// Error Check
			if (!$results) {
				die("Error: " . mysql_error($db_conn));
			}
			
			$row = mysql_fetch_row($results);
			$count = $row[0] + 1;
			
			// Now Update the count + 1
			$query = sprintf("UPDATE Choices SET count = %d WHERE sid = %d AND text = '%s';",
								$count, $sid, $answer);
			$results = mysql_query($query, $db_conn);
			
			// Error check
			if (!$results) {
				die("Error" . mysql_error($db_conn));
			}
		} else if ($type == "fr") {
			
			// First check if we are given a uid
			if (isset($_GET['uid'])) {
			
				// Insert the answer into the table with the appropriate values
				$answer = $_GET['answer'];
				$sid = $_GET['sid'];
				$uid = $_GET['uid'];
					
				$query = sprintf("INSERT INTO Answer (sid, text, uid) VALUES (%d, '%s', %d);",
									$sid, $answer, $uid);
				$results = mysql_query($query, $db_conn);
				
				// Error check
				if (!$results) {
					die("Error: " . mysql_error($db_conn));
				}
			}
		}
	}

?>
