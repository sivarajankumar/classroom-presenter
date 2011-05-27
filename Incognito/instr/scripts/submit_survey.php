<?php
	
	include '../../db_credentials.php';

    // Check for the correct arguments
    if (isset($_POST['text'])) {
        // Check if we connected properly
        if (!$db_conn) {
            die("Could not connect to the mysql server");
        }
        
        // Select the correct database
        mysql_select_db($database, $db_conn); 

        // Insert the question into the table given
        // all of the relevent fields
        $text = $_POST['text'];
        $sid = $_POST['sid'];
        echo $text;
        $sql_query1 = sprintf("INSERT INTO Survey (sessionid) VALUES (%d);", $sid);
        $results1 = mysql_query($query, $db_conn);
		
		// Do some error checking
		if (!$results1) {
			die("Error: " + mysql_error($db_conn));
		}
        
        // Getting the the most recent survey added
        $sql_query2 = sprintf("SELECT sid FROM Survey ORDER BY sid DESC;");
        $results2 = mysql_query($query1, $db_conn);
        
        // Do some more error checking
		if (!$results2) {
			die("Error: " + mysql_error($db_conn));
		}
        
        
    }
?>
