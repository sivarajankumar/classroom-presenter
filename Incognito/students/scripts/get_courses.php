<?php
	include '../../db_credentials.php';
	// This php script will take a student id and echo an array containing 
	// all of the courses that the student belongs too given a student id.
	
	// Check if we are given a user id
	if (isset($_POST['uid'])) {
		
		// Connect to our database (change for different user) 
		//$username = "schwer";
		//$password = "Egh8vF5d";
		//$db_name = "schwer_Incognito";

		$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
		if (!$db_conn) {
			die("Could not connect");
		}		
		mysql_select_db($db_name, $db_conn);
//		$uid = 1;		
		$uid = $_POST['uid'];
		//$query = sprintf("SELECT DISTINCT u.uid, s.sid, a.cid, s.open, c.name 
		//FROM User u, Attends a, Session s, Course c WHERE u.uid = %d AND 
		//a.uid = u.uid AND s.cid = a.cid AND c.cid = a.cid;",$uid);
		$query = sprintf("SELECT DISTINCT a.cid, c.name FROM Attends a, Course c WHERE c.cid = a.cid AND a.uid = %d", $uid);
		$results = mysql_query($query, $db_conn);
	
		// First do some error checking
		if (!$results) {
			die("Error: " + mysql_error($db_conn));
		}
		
		// Now fetch all of the results and echo
		$joined = 0;
		while ($row = mysql_fetch_row($results)) {
			// Check the open status of the session
			$query2 = sprintf("SELECT sid FROM Session WHERE cid = %d and open = 1", $row[0]);
			$results2 = mysql_query($query2, $db_conn);
			
			if (mysql_num_rows($results2) == 1) {
				$row2 = mysql_fetch_row($results2);
				// Check if the user has joined
				$query = sprintf("SELECT * FROM Joined WHERE uid = %d AND sid = %d;", $uid, $row2[0]);
				$result = mysql_query($query, $db_conn);
				if (mysql_num_rows($result) == 0 && !$joined) {
					
					//echo "<p class =\""  . $row[4] . "\">" . $row[4] .
					//" <button id=\"" . $row[1] . "\" class=\"joinButton\">Join Session</button><button id=\"" .
					//$row[2] . "\" class=\"courseRemoveButton\">Delete</button></p>";
					echo "<p class =\""  . $row[1] . "\">" . $row[1] .
					" <button id=\"" . $row2[0] . "\" class=\"joinButton\">Join Session</button><button id=\"" .
					$row[0] . "\" class=\"courseRemoveButton\">Delete</button></p>";
					
				} else if (mysql_num_rows($result) && $joined) {
					//echo "<p class =\""  . $row[4] . "\">" . $row[4] . 
					//	" <button id=\"" . $row[2] . "\" class=\"courseRemoveButton\">Delete</button></p>";
					echo "<p class =\""  . $row[1] . "\">" . $row[1] . 
						" <button id=\"" . $row[0] . "\" class=\"courseRemoveButton\">Delete</button></p>";
				} else {
					//echo "<p class =\""  . $row[4] . "\">" . $row[4] . 
					//" <button id=\"" . $row[1] . "\" class=\"quitButton\">Quit Session</button>";
					echo "<p class =\""  . $row[1] . "\">" . $row[1] . 
					" <button id=\"" . $row2[0] . "\" class=\"quitButton\">Quit Session</button>";
					$joined = 1; 	
				}
			} else {
				//echo "<p class =\""  . $row[4] . "\">" . $row[4] . 
				//" <button id=\"" . $row[2] . "\" class=\"courseRemoveButton\">Delete</button></p>";
				echo "<p class =\""  . $row[1] . "\">" . $row[1] . 
				" <button id=\"" . $row[0] . "\" class=\"courseRemoveButton\">Delete</button></p>";
			}

		}
	}

?>
