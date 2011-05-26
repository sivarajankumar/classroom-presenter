<?php
	include '../../db_credentials.php';
	// This php script get's all of the courses that a instructor 
	// teaches and prints some html for buttons

	// Check if we are given an email
	if (isset($_POST['uid'])) {
		
		// Connect to our database (change for different user) 
		// Connect to the database
		//$username = "ashen";
		//$password = "2kV2cNct";
		//$db_name = "ashen_403_Local";
		
		$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
		if (!$db_conn) {
			die("Could not connect");
		}
		
		mysql_select_db($db_name, $db_conn);
		
		// Query the database for all courses that the teacher teaches
		$uid = $_POST['uid'];
        
        $query = sprintf("SELECT email FROM User WHERE uid = %d;", $uid);
		$results = mysql_query($query, $db_conn);
		
		$row = mysql_fetch_row($results);
		$email = $row[0];
        
		$query2 = sprintf("SELECT DISTINCT c.cid, c.name, s.open FROM User u, Teaches t, Course c, Session s WHERE u.email = '%s' AND t.uid = u.uid AND t.cid = c.cid AND s.cid = t.cid;", $email);
		$results2 = mysql_query($query2, $db_conn);
		
		// Then return the results in HTML form
		$open = 0; 
		while ($row = mysql_fetch_row($results2)) {
			
			// Check if the course is closed
			if ($row[2] == 1) {
				
				echo  "<br />$row[1]: <button class='closeOptionButton' id='$row[0]'>Close?</button>
						<button id='$row[0]' class='courseRemoveButton'>Delete</button>
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
