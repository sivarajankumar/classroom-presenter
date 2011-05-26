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
			
			include_once '../../Incognito/students/scripts/studentfeed_lookup_questions.php';
			
			// UID 123 has voted for question test2, but not for test1.
			$voted = hasVoted('Q', $qid1, 123, $db_conn);
			$this->assertEquals(0, $voted);
			
			$voted = hasVoted('Q', $qid2, 123, $db_conn);
			$this->assertEquals(1, $voted);
		}
		
		public function testSort()
		{
			// Test sorting by vote count
			$feed = array();
			$feed[0] = array('voted'=>0,'text'=>'test1','answered'=>0,'type'=>'Q','id'=>12345,'numvotes'=>1);
			$feed[1] = array('voted'=>0,'text'=>'test2','answered'=>0,'type'=>'Q','id'=>23456,'numvotes'=>0);
			$feed[2] = array('voted'=>0,'text'=>'test3','isread'=>0,'type'=>'F','id'=>34567,'numvotes'=>2);
			
			$feed = sortResults($feed, "Priority");
			
			$this->assertEquals(3, count($feed));
			$this->assertEquals('test3', $feed[0]['text']);
			$this->assertEquals('test1', $feed[1]['text']);
			$this->assertEquals('test2', $feed[2]['text']);
			
			// Test sorting by time
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
			$query = "DELETE FROM Feedback";
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			
			// Insert test values
			$query = "INSERT INTO Feedback (text, numvotes, isread, sid) VALUES ('test1', 0, 0, 12345)";
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			sleep(1);
			
			$query = "INSERT INTO Question (text, numvotes, answered, sid) VALUES ('test2', 0, 0, 12345)";
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			sleep(1);
			
			$query = "INSERT INTO Feedback (text, numvotes, isread, sid) VALUES ('test3', 0, 0, 12345)";
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			sleep(1);
			
			$query = "INSERT INTO Question (text, numvotes, answered, sid) VALUES ('test4', 0, 0, 12345)";
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			
			$feed = getQuestions(12345, "None", "Newest", 123);
			$this->assertEquals(4, count($feed));
			$this->assertEquals('test4', $feed[0]['text']);
			$this->assertEquals('test3', $feed[1]['text']);
			$this->assertEquals('test2', $feed[2]['text']);
			$this->assertEquals('test1', $feed[3]['text']);
		}
		
		public function testGetAll()
		{
			
		}
		
		public function testGetAllQuestions()
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
			
			// Insert some questions
			$query = "INSERT INTO Question (text, numvotes, answered, sid) VALUES ('test1', 0, 0, 23456)";
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			sleep(1);
			
			$query = "INSERT INTO Question (text, numvotes, answered, sid) VALUES ('test2', 2, 0, 23456)";
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			sleep(1);
			
			$query = "INSERT INTO Question (text, numvotes, answered, sid) VALUES ('test3', 1, 0, 23456)";
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			
			$query = "INSERT INTO Question (text, numvotes, answered, sid) VALUES ('test4', 1, 0, 12345)";
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			
			// Get the QIDs
			$query = "SELECT qid FROM Question WHERE text = 'test1'";
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			$row = mysql_fetch_row($results);
			$qid1 = $row[0];
			
			$query = "SELECT qid FROM Question WHERE text = 'test2'";
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			$row = mysql_fetch_row($results);
			$qid2 = $row[0];
			
			$query = "SELECT qid FROM Question WHERE text = 'test3'";
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			$row = mysql_fetch_row($results);
			$qid3 = $row[0];
			
			// Update QuestionVotedOn
			$query = sprintf("INSERT INTO QuestionVotedOn(qid, uid) VALUES (%d, 123)", $qid2);
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			
			$query = sprintf("INSERT INTO QuestionVotedOn(qid, uid) VALUES (%d, 234)", $qid2);
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			
			$query = sprintf("INSERT INTO QuestionVotedOn(qid, uid) VALUES (%d, 123)", $qid3);
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			
			include_once '../../Incognito/students/scripts/studentfeed_lookup_questions.php';
			
			$feed = getQuestions(23456, "All Questions", "None", 123);
			// should have:
			//	test1 (hasn't voted)
			//	test2 (has voted)
			//	test3 (has voted)
			$this->assertEquals(3, count($feed));
			$this->assertEquals('test1', $feed[0]['text']);
			$this->assertEquals(0, $feed[0]['voted']);
			$this->assertEquals('test2', $feed[1]['text']);
			$this->assertEquals(1, $feed[1]['voted']);
			$this->assertEquals('test3', $feed[2]['text']);
			$this->assertEquals(1, $feed[2]['voted']);
			
			$feed = getQuestions(23456, "All Questions", "Newest", 123);
			// should have:
			//	test3
			//	test2
			//	test1
			$this->assertEquals(3, count($feed));
			$this->assertEquals('test3', $feed[0]['text']);
			$this->assertEquals('test2', $feed[1]['text']);
			$this->assertEquals('test1', $feed[2]['text']);
			
			$feed = getQuestions(23456, "All Questions", "Priority", 123);
			// should have:
			//	test2
			//	test3
			//	test1
			$this->assertEquals(3, count($feed));
			$this->assertEquals('test2', $feed[0]['text']);
			$this->assertEquals('test3', $feed[1]['text']);
			$this->assertEquals('test1', $feed[2]['text']);
		}
		
		public function testGetAllFeedback()
		{
			
		}
		
		public function testGetUnansweredQuestions()
		{
			
		}
		
		public function testGetAnsweredQuestions()
		{
			
		}
		
		public function testGetUnreadFeedback()
		{
			
		}
		
		public function testGetReadFeedback()
		{
			
		}
	}

?>