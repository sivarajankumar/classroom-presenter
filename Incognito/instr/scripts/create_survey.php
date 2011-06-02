<?php

	// This php script creates a survey given a session id, text (Question), 
	// and a type argument. 
	//
	// Note that the possible arguments for the type are the following:
	// Type: 'mc' Create a multiple choice survey
	//		 'fr' Create a free response survey

	include '../../db_credentials.php';
		
	// Check if we are given the correct arguments
	if (isset($_POST['sid']) && isset($_POST['text']) && isset($_POST['type'])) {
		
		// Connect and select the correct database
		$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
		if (!$db_conn) {
			die("Could not connect");
		}
		
		mysql_select_db($db_name, $db_conn);
		
		// First insert the survey into the survey table
		$type = $_POST['type'];
		$sid = $_POST['sid'];
		$query = sprintf("INSERT INTO Survey (sessionid, open) VALUES (%d, 0);", $sid);
		$results = mysql_query($query, $db_conn);
	
		// Error check
		if (!$results) {
			die("Error: " . mysql_error($db_conn));
		}
		
		// Now we need to get the survey id from the survey we just created
		$query = sprintf("SELECT sid FROM Survey WHERE sessionid = %d ORDER BY sid DESC;",
							$sid);
		$results = mysql_query($query, $db_conn);
		
		// Error check
		if (!$results) {
			die("Error: " . mysql_error($db_conn));
		}
		
		// Then get the surveyId
		$row = mysql_fetch_row($results);
		$surveyId = $row[0];
		
		// Now we need to form queries depending on whether we insert into
		// the MultipleChoice table or the FreeResponse table
		$text = $_POST['text'];
		if ($type == 'mc') {
			$query = sprintf("INSERT INTO MultipleChoice VALUES (%d, '%s');", 
								$surveyId, $text);
		} else if ($type == 'fr') {
			$query = sprintf("INSERT INTO FreeResponse VALUES (%d, '%s');",
								$surveyId, $text);
		} else {
			die("Incorrect Argument");
		}
		
		// Now execute the query
		$results = mysql_query($query, $db_conn);
		
		// Error check
		if (!$results) {
			die("Error: " . mysql_error($db_conn));
		}
		
		// If we did a multiple choice survey, we need to insert the 
		// choices
		if ($type == 'mc' && isset($_POST['choices'])) {
			
			$choices = json_decode($_POST['choices']);
			echo $choices;
			// Go through each choices and insert it in the Choices table
			for ($i = 0; $i < count($choices); $i++) {
				$query = sprintf("INSERT INTO Choices VALUES (%d, 0, '%s');",
									$surveyId, $choices[$i]);
				$results = mysql_query($query, $db_conn);
				
				// Error check
				if (!$results) {
					die("Error: " . mysql_error($db_conn));
				}
			}
		}
		
		// Respond with the new survey id
		echo $surveyId; 
	}

?>
