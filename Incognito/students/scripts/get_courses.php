<?php
	include 'db_credentials.php';
	// This php script will take a student id and echo an array containing 
	// all of the courses that the student belongs too given a student id.
	
	// Check if we are given a user id
	if (isset($_POST['email'])) {
		
		// Connect to our database (change for different user) 
		//$username = "schwer";
		//$password = "Egh8vF5d";
		//$db_name = "schwer_Incognito";

		
		$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
		if (!$db_conn) {
			die("Could not connect");
		}
		
		mysql_select_db($db_name, $db_conn);
		
		// Now run the query to fetch all of the courses
		$email = $_POST['email'];
		$query = sprintf("SELECT DISTINCT u.uid, s.sid, a.cid, s.open, c.name FROM User u, Attends a, Session s, Course c WHERE u.email = '%s' AND a.uid = u.uid AND s.cid = a.cid AND c.cid = a.cid;",
						$email);
		$results = mysql_query($query, $db_conn);
	
		// First do some error checking
		if (!$results) {
			die("Error: " + mysql_error($db_conn));
		}
		
		// Now fetch all of the results and echo
		while ($row = mysql_fetch_row($results)) {
			 
			// Check the open status of the session
			if ($row[3] == 1) {
				
				// Check if the user has joined
				$query = sprintf("SELECT * FROM Joined WHERE uid = %d AND sid = %d;",
								$row[0], $row[1]);
				$result = mysql_query($query, $db_conn);
				if (mysql_num_rows($result) == 0) {
					
					echo "<p class =\""  . $row[4] . "\">" . $row[4] .
					"<button id=\"" . $row[1] . "\" class=\"joinButton\">Join Session</button><button id=\"" .
					$row[2] . "\" class=\"courseRemoveButton\">Delete</button></p>";

				} else {
					
					echo "<p class =\""  . $row[4] . "\">" . $row[4] . 
					"<button id=\"" . $row[1] . "\" class=\"quitButton\">Quit Session</button><button id=\"" . 
					$row[2] . "\" class=\"courseRemoveButton\">Delete</button></p>";
					
				}
			} else {
				
				echo "<p class =\""  . $row[4] . "\">" . $row[4] . 
				"<button id=\"" . $row[2] . "\" class=\"courseRemoveButton\">Delete</button></p>";
				
			}

		}
	}

?>
