<?php

	// Connect to the database

	include 'db_credentials.php';

	$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
 
	if (!$db_conn) {
		die("Failed to connect to the mysql server"); 
	}

	mysql_select_db($db_name, $db_conn); 
	
	if ( isset($_POST['summary']) && isset($_POST['description']) && isset($_POST['source']) )
	{
		$summary = $_POST['summary'];
		$description = $_POST['description'];
		$source = $_POST['source'];
		
		$query = sprintf("INSERT INTO BugReports(summary, description) VALUES ('%s', '%s')", $summary, $description);
		if(!mysql_query($query, $db_conn))
		{
			die("Query error: " . mysql_error());
		}
	
		if ( $source == "student" )
			header("Location: students/student_bugreport.php");
		elseif ( $source == "instr" )
			header("Location: instr/instr_bugreport.php");
	}
?>