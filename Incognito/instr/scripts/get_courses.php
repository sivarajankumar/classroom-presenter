<?php

	// This php script get's all of the courses that a instructor 
	// teaches and prints some html for buttons
	
	// Check if we are given an email
	if (isset($_POST['email'])) {
		
		// Connect to our database (change for different user) 
		$username = "schwer";
		$password = "Egh8vF5d";
		$db_name = "schwer_Incognito";
		
		$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
		if (!$db_conn) {
			die("Could not connect");
		}
		
		mysql_select_db($db_name, $db_conn);
		
		// Query the database for all courses that the teacher teaches
		$email = $_POST['email'];
		$query = sprintf("SELECT c.name, s.open FROM User u, Teaches t, Course c, Session s WHERE u.email = '%s' AND t.uid = u.uid AND t.cid = c.cid AND s.cid = t.cid;", $email);
		$results = mysql_query($query, $db_conn);
		
		// Then return the results in HTML form
		while ($row = mysql_fetch_row($results)) {
			
			// Check if the course is closed
			if ($row[1] == 1) {
				
				echo  "<button class='closeOptionButton'  id=' . $row[0] . '>Close?</button>";
		
			} else {
				
				echo  "<button class='openOptionButton' id=' . $row[0] . '>Open?</button>";
				
			}
		}
	}

?>