<?php

	// This php script will return all surveys given a session id
	// that the surveys belong too. In addition, this php script
	// takes variables indicating how the results are to be filtered/sorted.
	// In addition, check if the user wants to filter by open or closed. Note
	// that we take a -1 if the user does not want to filter by open or closed. 
	//
	// Filtering arguments: 'mc' for only multiple choice
	//						'fr' for only free response
	//						'none' for no filters
	//
	// Sorting Arguments: 	'mr' for most recent surveys
	//						'none' for no sorting

	// Get our current db_crendentials
	include 'db_credentials.php';		

	// Check for the correct arguments
	if (isset($_POST['sid']) && isset($_POST['filter']) && isset($_POST['sort'])
			&& isset($_POST['open'])) {
		
		// Connect and select the correct database
		$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
		if (!$db_conn) {
			die("Could not connect");
		}
		
		mysql_select_db($db_name, $db_conn);
		
		// Now start building our query
		$query = ""; 
		
		// Check the filter argument
		$filter = $_POST['filter'];
		$sid = $_POST['sid'];
		if ($filter == 'mc') {
			$query = sprintf("SELECT mc.sid, mc.text FROM Survey s, MultipleChoice mc 
								WHERE s.sid = mc.sid AND s.sessionId = %d", 
								$sid); 
		} else if ($filter == 'fr') {
			$query = sprintf("SELECT fr.sid, fr.text FROM Survey s, FreeResponse fr 
								WHERE s.sid = fr.sid AND s.sessionId = %d", 
								$sid);
		} else if ($filter == 'none') {
			$query = sprintf("SELECT * FROM ((SELECT 'mc', s.sid, mc.text, s.open 
								FROM Survey s, MultipleChoice mc WHERE s.sid = mc.sid 
								AND s.sessionId = %d) UNION (SELECT 'fr', s.sid, fr.text, 
								s.open FROM Survey s, FreeResponse fr WHERE s.sid = fr.sid 
								AND s.sessionId = %d)) as sub", 
								$sid, $sid);
		} else {
			die("Incorrect filter argument");
		}
					
		// Check whether we want open or closed
		$open = $_POST['open'];
		if ($open == 1) {
			$query = $query . " WHERE sub.open = 1";
		} else if ($open == 0) {
			$query = $query . " WHERE sub.open = 0";
		} else if ($open != -1) {
			die("Incorrect arguments");
		}

			
		// Now check the sort argument
		$sort = $_POST['sort'];
		if ($sort == 'mr' && $filter == 'none') {
			$query = $query . " ORDER BY sub.sid DESC;";
		} else if ($sort == 'mr') {
			$query = $query . " ORDER BY s.sid DESC;"; 
		} else if ($sort == 'none') {
			$query = $query . ";";
		} else {
			die("Incorrect sort argument"); 
		}
		
		// Now run the query and return the results
		$results = mysql_query($query, $db_conn);
		
		// Error Check
		if (!$results) {
			die("Error: " . mysql_error($db_conn));
		}
		
		// For now I am just going to echo a json_encoded array,
		// this can change later if we want to echo direct HTML code
		$rows;
		$i = 0;
        echo "<table id=surveyFeed>";
		while ($row = mysql_fetch_row($results)) {
            echo "<tr class=alt>";
            
            // Print out # of responses - currently prints out the id
            echo "<td class=surveytype>".$row[0]."</td>";
            
            // Print out the question for the survey
            echo "<td class=question>".$row[1]."</td>";
            
            // Print out the Respond button
            echo "<td class=response><button type=button id=question_".$row[0].">Respond</button></td>";

            echo "</tr>";
		}
        echo "</table>";
	}

?>
