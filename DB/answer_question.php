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
	
	$type = $_POST['type'];
	$id = $_POST['id'];
	$flag = $_POST['answer'];
	$query = null;
	
	if ($type == 'Q')
	{
		if ($flag == "true")
		{
			$query = sprintf("UPDATE Question SET answered = 1 WHERE qid = %d", $id);
		}
		else
		{
			$query = sprintf("UPDATE Question SET answered = 0 WHERE qid = %d", %id)
		}
		
		if(!mysql_query($query, $db_conn))
		{
			die("Query error: " . mysql_error());
		}
	}
	elseif ($type == 'F')
	{
		if ($flag == "true")
		{
			$query = sprintf("UPDATE Feedback SET isread = 1 WHERE fid = %d", $id);
		}
		else
		{
			$query = sprintf("UPDATE Feedback SET isread = 0 WHERE fid = %d", $id);
		}
		
		if(!mysql_query($query, $db_conn))
		{
			die("Query error: " . mysql_error());
		}
	}
	
?>