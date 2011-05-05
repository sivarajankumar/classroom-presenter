<?php
	
	// Change this for whoever is using the php script
	$database = "schwer_Incognito";

	// Connect to the mysql server
	$db_conn = mysql_connect("cubist.cs.washington.edu", "schwer", "Egh8vF5d"); 

	// Check if we connected properly
	if ($db_conn) {
		die("Could not connect to the mysql server");
	}
	
	// Select the correct database
	mysql_select_db($database, $db_conn); 

	// Insert the question into the table given
	// all of the relevent fields
	$answered = $_POST['answered'];
	$numvotes = $_POST['numvotes'];
	$text = $_POST['text'];
	$sid = $_POST['sid']; 
	$query = "INSERT INTO Question VALUES (  	
?>
