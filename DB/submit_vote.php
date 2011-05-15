<?php

	// This script submits a vote for a question or feedback

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
	$username = $_POST['username'];
	
	// Do a preliminary query to get the student's user ID for later use
	$uidquery = sprintf("SELECT uid FROM Student WHERE alias = '%s'", $username);
	$uidresult = mysql_query($uidquery, $db_conn);
	$uidrow = mysql_fetch_assoc($uidresult);
	$uid = (int)$uidrow["uid"];
	
	if ( $type == 'Q' )
	{
		$query = sprintf("SELECT numvotes FROM Question WHERE qid = %d", $id);
		$result = mysql_query($query, $db_conn);
		$r = mysql_fetch_assoc($result);
		$votes = (int)$r["numvotes"];
		
		$votes = $votes + 1;
		$query = sprintf("UPDATE Question SET numvotes = %d WHERE qid = %d", $votes, $id);
		if(!mysql_query($query, $db_conn)) {
			die("Query error: " . mysql_error());
		}
		else {
			$query = sprintf("INSERT INTO QuestionVotedOn (uid, qid) VALUES (%d, %d)", $uid, $id);
			if(!mysql_query($query, $db_conn)) {
				die("Query error: " . mysql_error());
			}
		}
	}
	elseif ( $type == 'F' )
	{
		$query = sprintf("SELECT numvotes FROM Feedback WHERE fid = %d", $id);
		$result = mysql_query($query, $db_conn);
		$r = mysql_fetch_assoc($result);
		$votes = (int)$r["numvotes"];
		
		$votes = $votes + 1;
		$query = sprintf("UPDATE Feedback SET numvotes = %d WHERE fid = %d", $votes, $id);
		if(!mysql_query($query, $db_conn)) {
			die("Query error: " . mysql_error());
		}
		else {
			$query = sprintf("INSERT INTO FeedbackVotedOn (uid, fid) VALUES (%d, %d)", $uid, $id);
			if(!mysql_query($query, $db_conn)) {
				die("Query error: " . mysql_error());
			}
		}
	}

?>