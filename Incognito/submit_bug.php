<?php

	// Connect to the database

	// These variables need to be changed for every person who wants to use their local db.
	// Production DB: ashen; 2kV2cNct; ashen_403_Local
	$username = "ashen";
	$password = "2kV2cNct";
	$db_name = "ashen_403_Local";

	$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
 
	if (!$db_conn) {
		die("Failed to connect to the mysql server"); 
	}

	mysql_select_db($db_name, $db_conn); 
	
	$summary = $_POST['summary'];
	$description = $_POST['description'];
	echo "Summary = " . $summary;
	echo "Description = " . $description;
	
	$query = sprintf("INSERT INTO BugReports(summary, description) VALUES ('%s', '%s')", $summary, $description);
	if(!mysql_query($query, $db_conn))
	{
		die("Query error: " . mysql_error());
	}

?>