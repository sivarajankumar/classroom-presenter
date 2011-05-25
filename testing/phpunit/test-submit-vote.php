<?php

	// This test suite tests submit_vote.php.
	// NOTE: You MUST make sure the database connection parameters
	//	in submit_vote.php are the same as those in these tests!
	class testSubmitVote extends PHPUnit_Framework_Testcase
	{
		public function testAddVoteToQuestion()
		{
			// Connect to DB
			include 'db_credentials.php';
			
			$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
			if ( !$db_conn )
			{
				die("Could not connect");
			}
			
			mysql_select_db($db_name, $db_conn);
			
			// Wipe the Questions table
			$query = "DELETE FROM Question";
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			
			// Insert a test question
			$query = "INSERT INTO Question (text, numvotes, answered, sid) VALUES ('test', 0, 0, 23456)";
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			
			// Retrieve the test question's ID
			$query = "SELECT qid FROM Question WHERE text = 'test'";
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			$row = mysql_fetch_row($results);
			$qid = $row[0];
			
			$_POST['type'] = 'Q';
			$_POST['id'] = $qid;
			$_POST['uid'] = 123;
			$_POST['vote'] = "true";
			
			include '../../Incognito/students/scripts/submit_vote.php';
			
			// Check that the vote count is right
			$query = "SELECT * FROM Question WHERE numvotes = 1";
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			$this->assertEquals(1, mysql_num_rows($results));
			
			// Check that QuestionVotedOn was updated correctly
			$query = sprintf("SELECT * FROM QuestionVotedOn WHERE qid = %d AND uid = 123", $qid);
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			$this->assertEquals(1, mysql_num_rows($results));
		}
		
		public function testAddVoteToFeedback()
		{
			// Connect to DB
			$username = 'furby16';
			$password = 'oYveR99b';
			$db_name = 'furby16_incognito';
			$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
			if ( !$db_conn )
			{
				die("Could not connect");
			}
			
			mysql_select_db($db_name, $db_conn);
			
			// Wipe the Feedback table
			$query = "DELETE FROM Feedback";
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			
			// Insert a test comment
			$query = "INSERT INTO Feedback (text, numvotes, isread, sid) VALUES ('test', 0, 0, 23456)";
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			
			// Retrieve the test comment's ID
			$query = "SELECT fid FROM Feedback WHERE text = 'test'";
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			$row = mysql_fetch_row($results);
			$fid = $row[0];
			
			$_POST['type'] = 'F';
			$_POST['id'] = $fid;
			$_POST['uid'] = 123;
			$_POST['vote'] = "true";
			
			include '../../Incognito/students/scripts/submit_vote.php';
			
			// Check that the vote count is right
			$query = "SELECT * FROM Feedback WHERE numvotes = 1";
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			$this->assertEquals(1, mysql_num_rows($results));
			
			// Check that QuestionVotedOn was updated correctly
			$query = sprintf("SELECT * FROM FeedbackVotedOn WHERE fid = %d AND uid = 123", $fid);
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			$this->assertEquals(1, mysql_num_rows($results));
		}
		
		//public function testRemoveVoteFromQuestion()
		//{
		//	
		//}
		
		//public function testRemoveVoteFromFeedback()
		//{
		//	
		//}
	}

?>