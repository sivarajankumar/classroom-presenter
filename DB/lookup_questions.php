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
	$query = sprintf("SELECT * FROM Question WHERE sid = %d", $sid);
	$results = mysql_query($query, $db_conn);
	$rows = array();
	while($r = mysql_fetch_assoc($results))
	{
		$rows[] = array('question'=>$r["text"],'votes'=>$r["numvotes"]);
	}
	echo json_encode($rows);

?>
