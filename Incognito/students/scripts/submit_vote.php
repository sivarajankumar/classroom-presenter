<?php

	if (!function_exists('connectToDB'))
	{
		// This script submits a vote for a question or feedback
		function connectToDB()
		{
			// Connect to the database

			include 'db_credentials.php';

			$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
		 
			if (!$db_conn) {
				die("Failed to connect to the mysql server"); 
			}

			mysql_select_db($db_name, $db_conn);
			return $db_conn;
		}
	}
	
	if (!function_exists('getCurrentVotes'))
	{
		function getCurrentVotes($type, $id, $db_conn)
		{
			// Get the current vote count
			if ($type == 'Q')
			{
				$query = sprintf("SELECT numvotes FROM Question WHERE qid = %d", $id);
			}
			else
			{
				$query = sprintf("SELECT numvotes FROM Feedback WHERE fid = %d", $id);
			}
			
			$result = mysql_query($query, $db_conn);
			$r = mysql_fetch_assoc($result);
			$vote_count = (int)$r["numvotes"];	
			return $vote_count;
		}
	}
	
	if (!function_exists('submitVote'))
	{
		function submitVote($type, $vote_count, $id, $uid, $db_conn)
		{
			$vote_count = $vote_count + 1;
			if ($type == 'Q')
			{
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
		}
	}	
	
	if (!function_exists('undoVote'))
	{
		function undoVote($type, $vote_count, $id, $uid, $db_conn)
		{
			$vote_count = $vote_count - 1;
			
			if ($type == 'Q')
			{
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
			else
			{
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
	}
	
	if (!function_exists('processVote'))
	{
		function processVote($type, $id, $uid, $vote)
		{
			// Connect to the database
			$db_conn = connectToDB();
			
			if ( $type == 'Q' )
			{
				// Get the current vote count
				$vote_count = getCurrentVotes($type, $id, $db_conn);	

				if ($vote == "true")
				{
					// submit a vote
					submitVote($type, $vote_count, $id, $uid, $db_conn);
				}
				else
				{
					// undo a vote submission
					undoVote($type, $vote_count, $id, $uid, $db_conn);
				}
				
			}
			elseif ( $type == 'F' )
			{
				// Get the current vote count
				$vote_count = getCurrentVotes($type, $id, $db_conn);
				
				if ($vote == "true")
				{
					// submit a vote
					submitVote($type, $vote_count, $id, $uid, $db_conn);
				}
				else 
				{
					// undo a vote submission
					undoVote($type, $vote_count, $id, $uid, $db_conn);
				}
				
			}
		}
	}	

	$type = $_POST['type'];			// Type of the submission ('Q' or 'F')
	$id = $_POST['id'];				// ID of the question or feedback
	$uid = $_POST['uid'];			// User's ID
	$vote = $_POST['vote'];			// "true" if we want to submit a vote, "false" if we want to undo a previous submission
	processVote($type, $id, $uid, $vote);
?>
