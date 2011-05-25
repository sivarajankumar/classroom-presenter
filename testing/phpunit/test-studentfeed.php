<?php

	class testStudentFeed extends PHPUnit_Framework_Testcase
	{
		public function testHasVoted()
		{
			include 'db_credentials.php';
			
			$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
			if ( !$db_conn )
			{
				die("Could not connect");
			}
			
			mysql_select_db($db_name, $db_conn);
			
			// Wipe the tables
			$query = "DELETE FROM Question";
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			$query = "DELETE FROM QuestionVotedOn";
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			$query = "DELETE FROM Feedback";
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			$query = "DELETE FROM FeedbackVotedOn";
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			
			// Insert some test values 
			$query = "INSERT INTO Question (text, numvotes, answered, sid) VALUES ('test1', 0, 0, 23456)";
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			
			$query = "SELECT qid FROM Question WHERE text = 'test1'";
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			$row = mysql_fetch_row($results);
			$qid1 = $row[0];
			
			$query = "INSERT INTO Question (text, numvotes, answered, sid) VALUES ('test2', 1, 0, 23456)";
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			
			$query = "SELECT qid FROM Question WHERE text = 'test2'";
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			$row = mysql_fetch_row($results);
			$qid2 = $row[0];	
			
			$query = sprintf("INSERT INTO QuestionVotedOn(qid, uid) VALUES (%d, 123)", $qid2);
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			
			include '../../Incognito/students/scripts/studentfeed_lookup_questions.php';
			
			// UID 123 has voted for question test2, but not for test1.
			$voted = hasVoted('Q', $qid1, 123, $db_conn);
			$this->assertEquals(0, $voted);
			
			$voted = hasVoted('Q', $qid2, 123, $db_conn);
			$this->assertEquals(1, $voted);
		}
	}

?>