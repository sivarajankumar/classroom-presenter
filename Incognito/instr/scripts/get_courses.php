<?php
	include '../../db_credentials.php';
	// This php script get's all of the courses that a instructor 
	// teaches and prints some html for buttons

	// Check if we are given a uid
	if (isset($_POST['uid'])) {
 
		$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
		if (!$db_conn) {
			die("Could not connect");
		}
		
		mysql_select_db($db_name, $db_conn);
		$uid = $_POST['uid'];
		
		// Query the database for all courses that the teacher teaches
       		$query = sprintf("SELECT DISTINCT c.cid, c.name FROM User u, Teaches t, Course c WHERE u.uid = %d AND t.uid = u.uid AND t.cid = c.cid;", $uid);
		$results = mysql_query($query, $db_conn);

		// Error Check
		if (!$results) {
			die("Error: " . mysql_error($db_conn)); 
		}		

		// Then return the results in HTML form
		$open = 0; 
		while ($row = mysql_fetch_row($results)) {
			
			// See if there is an open session for the course
			$query = sprintf("SELECT * FROM Session WHERE cid = %d AND open = 1;", $row[0]); 
			$results1 = mysql_query($query, $db_conn); 
			
			// Error check
			if (!$results1) {
				die("Error: " . mysql_error($db_conn)); 
			}

			// for each course, also check to see if a session is already open.
			// if a session row already exists then the session is already open
			if (mysql_num_rows($results1) > 0) {
				echo  "<br />$row[1]: <button class='closeOptionButton' id='$row[0]'>Close?</button>
						Student NetId: <input type='text' id='studentToAdd'/>
                        			<button id='$row[0]' class='addStudentButton'>Add Student</button>";
				$open = 1;
			} else if (!$open) {
				
				echo  "<br />$row[1]: <button class='openOptionButton' id='$row[0]'>Open?</button>
						<button id='$row[0]' class='courseRemoveButton'>Delete</button>
						Student NetId: <input type='text' id='studentToAdd'/>
                        			<button id='$row[0]' class='addStudentButton'>Add Student</button>";
				
			} else {
				
				echo "<br />$row[1]: <button id='$row[0]' class='courseRemoveButton'>Delete</button>
					Student NetId: <input type='text' id='studentToAdd'/>
					<button id='$row[0]' class='addStudentButton'>Add Student</button>";
			}
			echo "<p />";
		}
	}

?>
