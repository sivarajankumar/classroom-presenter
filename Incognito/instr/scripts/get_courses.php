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
       // $query2 = sprintf("SELECT DISTINCT c.cid, c.name, s.open FROM User u, Teaches t, Course c, Session s WHERE u.email = '%s' AND t.uid = u.uid AND t.cid = c.cid AND s.cid = t.cid;", $email);
		$query2 = sprintf("SELECT DISTINCT c.cid, c.name FROM Teaches t, Course c WHERE t.uid = %d AND t.cid = c.cid;", $uid);
		$results2 = mysql_query($query2, $db_conn);
		
		// Then return the results in HTML form
		$open = 0; 
		while ($row = mysql_fetch_row($results2)) {
			// for each course, also check to see if a session is already open.
			$query3 = sprintf("Select sid from Session where open = 1 and cid = %d;", $row[0]);
			$results3 = mysql_query($query3, $db_conn);
			// if a session row already exists then the session is already open
			if ($row2 = mysql_fetch_row($results3)) {
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
