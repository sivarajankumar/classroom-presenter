<?php
	
	function connectToDB()
	{
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
		return $db_conn;
	}
	
	function submit($type, $numvotes, $text, $sid, $uid)
	{
		$db_conn = connectToDB(); 
		
		$text = mysql_real_escape_string($text, $db_conn);

		// Insert the question/feedback into the table given
		// all of the relevant fields
		
		// Do a preliminary query to get the student's user ID for later use
		//$uidquery = sprintf("SELECT uid FROM Student WHERE alias = '%s'", $alias);
		//$uidresult = mysql_query($uidquery, $db_conn);
		//$uidrow = mysql_fetch_assoc($uidresult);
		//$uid = (int)$uidrow["uid"];
		
		
		// Execute the appropriate query depending on whether the submitted text
		//	is a question or a feedback
		if ($type == 'Q')
		{
			// Check if it already exists
			$query = sprintf("SELECT * FROM Question WHERE text = '%s'", $text);
			$results = mysql_query($query, $db_conn);
			
			if ($r = mysql_fetch_assoc($results))	// did the query return anything?
			{
				// If the question already exists (and the student hasn't already voted for it),
				//	submit a vote for the question instead of adding a duplicate submission.
				$qid = $r["qid"];
				$votes = $r["numvotes"];
				$query = sprintf("SELECT * FROM QuestionVotedOn WHERE qid = %d AND uid = %d", $qid, $uid);
				$results = mysql_query($query, $db_conn);
				
				if ( !($r = mysql_fetch_assoc($results)))	// Only do something if the student hasn't already voted for the question
				{
					// submit the vote
					$votes = $votes + 1;
					$query = sprintf("UPDATE Question SET numvotes = %d WHERE qid = %d", $votes, $qid);
					$results = mysql_query($query, $db_conn);
					
					// update QuestionVotedOn
					$query = sprintf("INSERT INTO QuestionVotedOn(qid, uid) VALUES (%d, %d)", $qid, $uid);
					$results = mysql_query($query, $db_conn);
				}
			}
			else
			{
				//$answered = $_POST['answered'];
				$query = sprintf("INSERT INTO Question (text, numvotes, answered, sid) 
								VALUES ('%s', %d, %d, %d)", $text, $numvotes, 0, $sid);
				if(!mysql_query($query, $db_conn)) {
					die("Query error: " . mysql_error());
				}
			}
		}
		elseif ($type == 'F')
		{
			// Check if it already exists
			$query = sprintf("SELECT * FROM Feedback WHERE text = '%s'", $text);
			$results = mysql_query($query, $db_conn);
			
			if ($r = mysql_fetch_assoc($results))	// did the query return anything?
			{
				// If the comment already exists (and the student hasn't already voted for it),
				//	submit a vote for the comment instead of adding a duplicate submission.
				$fid = $r["fid"];
				$votes = $r["numvotes"];
				$query = sprintf("SELECT * FROM FeedbackVotedOn WHERE fid = %d AND uid = %d", $fid, $uid);
				$results = mysql_query($query, $db_conn);
				
				if ( !($r = mysql_fetch_assoc($results)))	// Only do something if the student hasn't already voted for the comment
				{
					// submit the vote
					$votes = $votes + 1;
					$query = sprintf("UPDATE Feedback SET numvotes = %d WHERE fid = %d", $votes, $fid);
					$results = mysql_query($query, $db_conn);
					
					// update FeedbackVotedOn
					$query = sprintf("INSERT INTO FeedbackVotedOn(fid, uid) VALUES (%d, %d)", $fid, $uid);
					$results = mysql_query($query, $db_conn);
				}
			}
			else
			{
				//$isread = $_POST['isread'];
				$query = sprintf("INSERT INTO Feedback (text, numvotes, isread, sid)
								VALUES ('%s', %d, %d, %d)", $text, $numvotes, 0, $sid);
				if(!mysql_query($query, $db_conn)) {
					die("Query error: " . mysql_error());
				}
			}
		}
		else
		{
			die("Invalid submission type!");
		}
	}
	
	// These fields are present for both submission types
	$type = $_POST['type'];
	$numvotes = $_POST['numvotes'];
	$text = $_POST['text'];
	$sid = $_POST['sid'];
	$uid = $_POST['uid'];
	submit($type, $numvotes, $text, $sid, $uid);
?>
