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
	mysql_select_db($database, $db_conn); 

	// Insert the question into the table given
	// all of the relevent fields
	$answered = $_POST['answered'];
	$numvotes = $_POST['numvotes'];
	$text = $_POST['text'];
	$sid = $_POST['sid']; 
	$query = "INSERT INTO Question (qid, text, numvotes, answered, sid) VALUES ()";
	mysql_query($query, $db_conn);	
?>