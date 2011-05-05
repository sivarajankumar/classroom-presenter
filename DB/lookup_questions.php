<?php

	// This file looks up all questions associated with a given session

	// Connect to the database

	// These variables need to be changed for every person who sets this up
	$username = "schwer";
	$password = "Egh8vF5d"; 
	$db_name = "schwer_Incognito"; 

	$db_conn = mysql_connect("cubist.ccs.washington.edu", $username, $password);
 
	if ($db_conn) {
		die("Failed to connect to the mysql server"); 
	}

	mysql_select_db($db_name, $db_conn); 
	
	// Now query the database for all of the questions associated
	// with the current session
	$sid = $_POST['sid'];
	$query = sprintf("SELECT * FROM Question WHERE sid = %d", $sid);
	$results = mysql_query($query, $db_conn);

	// Echo the results of the query
	echo json_encode($results);  
?>
