<?php
	include '../../db_credentials.php';
	// This file, given a sid, will end the session
	
	if (isset($_POST['cid'])) {
		
		// Connect to the database
		$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
		if (!$db_conn) {
			die("Could not connect");
		}

		mysql_select_db($db_name, $db_conn);
	
		// First we need to get the session id
		$cid = $_POST['cid'];
		$query = sprintf("SELECT sid FROM Session WHERE cid = %d;", $cid); 
		$results = mysql_query($query, $db_conn);

		// Error Check
		if (!$results) {
			die ("Error: " . mysql_error($db_conn)); 
		}

		$row = mysql_fetch_row($results);
		$sid = $row[0];
		
		// Get the fid, qid, and surveyId for all of the questions, feedback, and surveys
		// we want to delete
		$query = sprintf("SELECT qid FROM Question WHERE sid = %d;", $sid); 
		$results = mysql_query($query, $db_conn); 

		// Error Check
		if (!$results) {
			die ("Error: " . mysql_error($db_conn)); 
		}

		// Now delete every entry in QuestionVotedOn and then delete each question
		while ($row = mysql_fetch_row($results)) {
			$query = sprintf("DELETE FROM QuestionVotedOn WHERE qid = %d;", $row[0]);
			$result = mysql_query($query, $db_conn); 
			
			// Error check
			if (!$result) {
				die ("Error: " . mysql_error($db_conn)); 
			}

			$query = sprintf("DELETE FROM Question WHERE qid = %d;", $row[0]); 
			$result = mysql_query($query, $db_conn); 

			// Error Check
			if (!$result) {
				die ("Error: " . mysql_error($db_conn)); 
			}
		}
		
		// Do they same thing for feedback
		$query = sprintf("SELECT fid FROM Feedback WHERE sid = %d;", $sid); 
		$results = mysql_query($query, $db_conn); 

		// Error Check
		if (!$results) {
			die ("Error: " . mysql_error($db_conn)); 
		}

		// Now delete every entry in QuestionVotedOn and then delete each question
		while ($row = mysql_fetch_row($results)) {
			$query = sprintf("DELETE FROM FeedbackVotedOn WHERE fid = %d;", $row[0]);
			$result = mysql_query($query, $db_conn); 
			
			// Error check
			if (!$result) {
				die ("Error: " . mysql_error($db_conn)); 
			}

			$query = sprintf("DELETE FROM Feedback WHERE fid = %d;", $row[0]); 
			$result = mysql_query($query, $db_conn); 

			// Error Check
			if (!$result) {
				die ("Error: " . mysql_error($db_conn)); 
			}
		}
				
		// Same thing for Survey
		$query = sprintf("SELECT sid FROM Survey WHERE sessionid = %d;", $sid); 
		$results = mysql_query($query, $db_conn); 

		// Error Check
		if (!$results) {
			die ("Error: " . mysql_error($db_conn)); 
		}

		// Now delete every entry in QuestionVotedOn and then delete each question
		while ($row = mysql_fetch_row($results)) {
			
			// Have to delete from Answer, Choices, MultipleChoice, and FreeResponse
			$query = sprintf("DELETE FROM Answer WHERE sid = %d;", $row[0]);
			$result = mysql_query($query, $db_conn); 
			
			// Error check
			if (!$result) {
				die ("Error: " . mysql_error($db_conn)); 
			}
			
			$query = sprintf("DELETE FROM Choices WHERE sid = %d;", $row[0]);
			$result = mysql_query($query, $db_conn); 
			
			// Error check
			if (!$result) {
				die ("Error: " . mysql_error($db_conn)); 
			}
			
			$query = sprintf("DELETE FROM MultipleChoice WHERE sid = %d;", $row[0]); 
			$result = mysql_query($query, $db_conn); 

			// Error Check
			if (!$result) {
				die ("Error: " . mysql_error($db_conn)); 
			}

			$query = sprintf("DELETE FROM FreeResponse WHERE sid = %d;", $row[0]);
			$result = mysql_query($query, $db_conn); 
			
			// Error check
			if (!$result) {
				die ("Error: " . mysql_error($db_conn)); 
			}

			// Finally delete the survey
			$query = sprintf("DELETE FROM Survey WHERE sid = %d;", $row[0]); 
			$result = mysql_query($query, $db_conn); 

			// Error check
			if (!$result) {
				die ("Error: " . mysql_error($db_conn));
			}
		}

		// Now we can finally delete the session
		$query = sprintf("DELETE FROM Session WHERE open = 1 and cid = %d;", $cid);
		$results = mysql_query($query, $db_conn);
		
		// Error check
		if (!$results) {
			die ("Error" . mysql_error($db_conn)); 
		}
	}

?>
