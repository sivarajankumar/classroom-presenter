<?php
	
	// Change this for whoever is using the php script
	// These variables need to be changed for every person who sets this up
	// Production DB: ashen; 2kV2cNct; ashen_403_Local
	$username = "ashen";
	$password = "2kV2cNct"; 
	$db_name = "ashen_403_Local"; 

	// Connect to server
	$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
 
	if (!$db_conn) {
		die("Failed to connect to the mysql server"); 
	}
	
	// Select the correct database
	mysql_select_db($db_name, $db_conn); 

	// Insert the question/feedback into the table given
	// all of the relevant fields
	
	// These fields are present for both submission types
	$type = $_POST['type'];
	$numvotes = $_POST['numvotes'];
	$text = $_POST['text'];
	$sid = $_POST['sid'];
	
	// Execute the appropriate query depending on whether the submitted text
	//	is a question or a feedback
	if ($type == 'Q')
	{
		$answered = $_POST['answered'];
		$query = sprintf("INSERT INTO Question (text, numvotes, answered, sid) 
						VALUES ('%s', %d, %d, %d)", $text, $numvotes, $answered, $sid);
		if(!mysql_query($query, $db_conn)) {
			die("Query error: " . mysql_error());
		}
	}
	elseif ($type == 'F')
	{
		$isread = $_POST['isread'];
		$query = sprintf("INSERT INTO Feedback (text, numvotes, isread, sid)
						VALUES ('%s', %d, %d, %d)", $text, $numvotes, $isread, $sid);
		if(!mysql_query($query, $db_conn)) {
			die("Query error: " . mysql_error());
		}
	}
	else
	{
		die("Invalid submission type!");
	}
	
?>
