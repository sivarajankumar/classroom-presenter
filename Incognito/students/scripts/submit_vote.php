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
	
	$type = $_POST['type'];			// Type of the submission ('Q' or 'F')
	$id = $_POST['id'];				// ID of the question or feedback
	$username = $_POST['username'];	// User's alias
	$vote = $_POST['vote'];			// "true" if we want to submit a vote, "false" if we want to undo a previous submission
	
	// Do a preliminary query to get the student's user ID for later use
	$uidquery = sprintf("SELECT uid FROM Student WHERE alias = '%s'", $username);
	$uidresult = mysql_query($uidquery, $db_conn);
	$uidrow = mysql_fetch_assoc($uidresult);
	$uid = (int)$uidrow["uid"];	

	if ( $type == 'Q' )
	{
		// Get the current vote count
		$query = sprintf("SELECT numvotes FROM Question WHERE qid = %d", $id);
		$result = mysql_query($query, $db_conn);
		$r = mysql_fetch_assoc($result);
		$vote_count = (int)$r["numvotes"];		

		if ($vote == "true")
		{
			// submit a vote
			$vote_count = $vote_count + 1;
			$query = sprintf("UPDATE Question SET numvotes = %d WHERE qid = %d", $vote_count, $id);
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
		else
		{
			// undo a vote submission
			$vote_count = $vote_count - 1;
			$query = sprintf("UPDATE Question SET numvotes = %d WHERE qid = %d", $vote_count, $id);
			if(!mysql_query($query, $db_conn)) {
				die("Query error: " . mysql_error());
			}
			else {
				$query = sprintf("DELETE FROM QuestionVotedOn WHERE qid = %d AND uid = %d", $id, $uid);
				if(!mysql_query($query, $db_conn)) {
					die("Query error: " . mysql_error());
				}
			}
		}
		
	}
	elseif ( $type == 'F' )
	{
		// Get the current vote count
		$query = sprintf("SELECT numvotes FROM Feedback WHERE fid = %d", $id);
		$result = mysql_query($query, $db_conn);
		$r = mysql_fetch_assoc($result);
		$vote_count = (int)$r["numvotes"];
		
		if ($vote == "true")
		{
			// submit a vote
			$vote_count = $vote_count + 1;
			$query = sprintf("UPDATE Feedback SET numvotes = %d WHERE fid = %d", $vote_count, $id);
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
		else 
		{
			// undo a vote submission
			$vote_count = $vote_count - 1;
			$query = sprintf("UPDATE Feedback SET numvotes = %d WHERE qid = %d", $vote_count, $id);
			if(!mysql_query($query, $db_conn)) {
				die("Query error: " . mysql_error());
			}
			else {
				$query = sprintf("DELETE FROM FeedbackVotedOn WHERE fid = %d AND uid = %d", $id, $uid);
				if(!mysql_query($query, $db_conn)) {
					die("Query error: " . mysql_error());
				}
			}
		}
		
	}

?>
