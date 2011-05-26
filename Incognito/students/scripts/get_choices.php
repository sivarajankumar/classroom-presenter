<?php

    // Given a multiple-choice survey we can get all
    // of the choices for that survey

    include '../../db_credentials.php';
    
    // Check for the correct arguments
	if (isset($_POST['sid'])) {
    
        // Connect and select the correct database
		$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
		if (!$db_conn) {
			die("Could not connect");
		}
		
		mysql_select_db($db_name, $db_conn);
        
        // Before retrieving Multiple Choice surveys
        // Need to do some checking
        $sid = $_POST['sid'];
		$query = sprintf("SELECT text FROM Choices WHERE sid = %d;", $sid);
		$results = mysql_query($query, $db_conn);
	
		// Error check
		if (!$results) {
			die("Error: " . mysql_error($db_conn));
		}
        
        while ($row = mysql_fetch_row($results)) {
            $choice = str_replace(" ","_",$row[0]);
            echo '<input type=radio name=option value='.$choice.'>'.$row[0].'</input><br />';
        }
        
    }
    
?>
	