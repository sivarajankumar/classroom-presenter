<?php

	// This file looks up all questions associated with a given session

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
	
	// Now query the database for all of the questions associated
	// with the current session
	$sid = $_POST['sid'];
	$query = sprintf("SELECT text FROM Survey, FreeResponse WHERE sessionid = 22222 and Survey.sid = FreeResponse.sid", $sid);
	$results = mysql_query($query, $db_conn);

	echo "what is going on?";
	echo "<br />";
	
	while($row = mysql_fetch_array($result))
 	{
		echo "hello";
  		echo "Question: " . $row['text'] . "    cool!";
  		echo "<br />";
	}


?>
