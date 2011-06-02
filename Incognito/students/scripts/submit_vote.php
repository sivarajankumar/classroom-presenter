<?php

	if (!function_exists('connectToDB'))
	{
		function connectToDB()
		{
			// Connect to the database
			include '../../db_credentials.php';

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
		// Given a submission ID and type, get the vote count for it.
		function getCurrentVotes($type, $id, $db_conn)
		{
			if ($type == 'Q')
			{
				$query = sprintf("SELECT numvotes FROM Question WHERE qid = %d", $id);
			}
			else
			{
				$query = sprintf("SELECT numvotes FROM Feedback WHERE fid = %d", $id);
			}
			
			$result = mysql_query($query, $db_conn);
			if (!$result)
			{
				die("Error: " . mysql_error($db_conn));
			}
			$r = mysql_fetch_assoc($result);
			$vote_count = (int)$r["numvotes"];	
			return $vote_count;
		}
	}
	
	if (!function_exists('submitVote'))
	{
		// Submits a vote for the given submission, tied to the specified UID.
		function submitVote($type, $vote_count, $id, $uid, $db_conn)
		{
			$vote_count = $vote_count + 1;
			if ($type == 'Q')
			{
				// Update the vote count
				$query = sprintf("UPDATE Question SET numvotes = %d WHERE qid = %d", $vote_count, $id);
				if(!mysql_query($query, $db_conn)) {
					die("Query error: " . mysql_error());
				}
				else {
					// Insert a row into QuestionVotedOn, indicating $uid has voted for $id
					$query = sprintf("INSERT INTO QuestionVotedOn (uid, qid) VALUES (%d, %d)", $uid, $id);
					if(!mysql_query($query, $db_conn)) {
						die("Query error: " . mysql_error());
					}
				}
			}
			else
			{
				// Update the voute count
				$query = sprintf("UPDATE Feedback SET numvotes = %d WHERE fid = %d", $vote_count, $id);
				if(!mysql_query($query, $db_conn)) {
					die("Query error: " . mysql_error());
				}
				else {
					// Insert a row into FeedbackVotedOn, indicating $uid has voted for $id
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
		// Removes the specified user's vote from the specified submission.
		function undoVote($type, $vote_count, $id, $uid, $db_conn)
		{
			$vote_count = $vote_count - 1;
			
			if ($type == 'Q')
			{
				// Update the voute count
				$query = sprintf("UPDATE Question SET numvotes = %d WHERE qid = %d", $vote_count, $id);
				if(!mysql_query($query, $db_conn)) {
					die("Query error: " . mysql_error());
				}
				else {
					// Remove the row from QuestionVotedOn that indicates $uid has voted for $id
					$query = sprintf("DELETE FROM QuestionVotedOn WHERE qid = %d AND uid = %d", $id, $uid);
					if(!mysql_query($query, $db_conn)) {
						die("Query error: " . mysql_error());
					}
				}
			}
			else
			{
				// Update the voute count
				$query = sprintf("UPDATE Feedback SET numvotes = %d WHERE fid = %d", $vote_count, $id);
				if(!mysql_query($query, $db_conn)) {
					die("Query error: " . mysql_error());
				}
				else {
					// Remove the row from FeedbackVotedOn that indicates $uid has voted for $id
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
		// Given a submission ID and type, executes the appropriate action
		//	depending on the parameters coming from the frontend.
		function processVote($type, $id, $uid, $vote)
		{
			// Connect to the database
			$db_conn = connectToDB();
			
			if ( $type == 'Q' )	// the submission is a question
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
			elseif ( $type == 'F' )	// the submission is a feedback
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

	if ( isset() && isset() && isset() && isset() )
	{
		$type = $_POST['type'];			// Type of the submission ('Q' or 'F')
		$id = $_POST['id'];				// ID of the question or feedback
		$uid = $_POST['uid'];			// User's ID
		$vote = $_POST['vote'];			// "true" if we want to submit a vote, "false" if we want to undo a previous submission
		processVote($type, $id, $uid, $vote);
	}
?>
