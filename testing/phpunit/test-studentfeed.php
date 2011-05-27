<?php

	class testStudentFeed extends PHPUnit_Framework_Testcase
	{
		public function testHasVoted()
		{
			$db_conn = $this->initAndClearTables();
			
			$this->insertSubmission($db_conn, 'Q', 'test1', 0, 0, 23456);
			$qid1 = $this->getSubmissionID($db_conn, 'Q', 'test1');
			
			$this->insertSubmission($db_conn, 'Q', 'test2', 1, 0, 23456);
			$qid2 = $this->getSubmissionID($db_conn, 'Q', 'test2');
			$this->addToVotedOn($db_conn, 'Q', $qid2, 123);
			
			include_once '../../Incognito/students/scripts/studentfeed_lookup_questions.php';
			
			// UID 123 has voted for question test2, but not for test1.
			$voted = hasVoted('Q', $qid1, 123, $db_conn);
			$this->assertEquals(0, $voted);
			
			$voted = hasVoted('Q', $qid2, 123, $db_conn);
			$this->assertEquals(1, $voted);
		}
		
		public function initAndClearTables()
		{
			include 'db_credentials.php';
			
			$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
			if ( !$db_conn )
			{
				die("Could not connect");
			}
			
			mysql_select_db($db_name, $db_conn);
			
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
			
			return $db_conn;
		}
		
		public function insertSubmission($db_conn, $type, $text, $numvotes, $flag, $sid)
		{
			$query = null;
			if ($type == 'Q')
			{
				$query = sprintf("INSERT INTO Question (text, numvotes, answered, sid) VALUES ('%s', %d, %d, %d)", $text, $numvotes, $flag, $sid);
			}
			else
			{
				$query = sprintf("INSERT INTO Feedback (text, numvotes, isread, sid) VALUES ('%s', %d, %d, %d)", $text, $numvotes, $flag, $sid);
			}
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
		}
		
		public function addToVotedOn($db_conn, $type, $id, $uid)
		{
			$query = null;
			if ($type == 'Q')
			{
				$query = sprintf("INSERT INTO QuestionVotedOn (qid, uid) VALUES (%d, %d)", $id, $uid);
			}
			else
			{
				$query = sprintf("INSERT INTO FeedbackVotedOn (fid, uid) VALUES (%d, %d)", $id, $uid);
			}
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
		}
		
		public function getSubmissionID($db_conn, $type, $text)
		{
			$query = null;
			if ($type == 'Q')
			{
				$query = sprintf("SELECT qid FROM Question WHERE text = '%s'", $text);
			}
			else
			{
				$query = sprintf("SELECT fid FROM Feedback WHERE text = '%s'", $text);
			}
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			$row = mysql_fetch_row($results);
			$id = $row[0];
			return $id;
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
			$db_conn = $this->initAndClearTables();
			
			// Insert test values
			$this->insertSubmission($db_conn, 'F', 'test1', 0, 0, 12345);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'Q', 'test2', 0, 0, 12345);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'F', 'test3', 0, 0, 12345);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'Q', 'test4', 0, 0, 12345);
			
			$feed = getQuestions(12345, "None", "Newest", 123);
			$this->assertEquals(4, count($feed));
			$this->assertEquals('test4', $feed[0]['text']);
			$this->assertEquals('test3', $feed[1]['text']);
			$this->assertEquals('test2', $feed[2]['text']);
			$this->assertEquals('test1', $feed[3]['text']);
		}
		
		public function testGetAll()
		{
			$db_conn = $this->initAndClearTables();
			
			$this->insertSubmission($db_conn, 'Q', 'test1', 0, 0, 12345);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'F', 'test2', 3, 0, 12345);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'Q', 'test3', 2, 0, 12345);
			$id = $this->getSubmissionID($db_conn, 'Q', 'test3');
			$this->addToVotedOn($db_conn, 'Q', $id, 123);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'F', 'test4', 1, 0, 12345);
			$id = $this->getSubmissionID($db_conn, 'F', 'test4');
			$this->addToVotedOn($db_conn, 'F', $id, 123);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'Q', 'test5', 0, 0, 23456);
			
			include_once '../../Incognito/students/scripts/studentfeed_lookup_questions.php';
			
			$feed = getQuestions(12345, "None", "None", 123);
			// test1 (not voted)
			// test2 (not voted)
			// test3 (voted)
			// test4 (voted)
			$this->assertEquals(4, count($feed));
			$this->assertEquals('test1', $feed[0]['text']);
			$this->assertEquals(0, $feed[0]['voted']);
			$this->assertEquals('test3', $feed[1]['text']);
			$this->assertEquals(1, $feed[1]['voted']);
			$this->assertEquals('test2', $feed[2]['text']);
			$this->assertEquals(0, $feed[2]['voted']);
			$this->assertEquals('test4', $feed[3]['text']);
			$this->assertEquals(1, $feed[3]['voted']);
			
			$feed = getQuestions(12345, "None", "Newest", 123);
			// test4
			// test3
			// test2
			// test1
			$this->assertEquals(4, count($feed));
			$this->assertEquals('test4', $feed[0]['text']);
			$this->assertEquals(1, $feed[0]['voted']);
			$this->assertEquals('test3', $feed[1]['text']);
			$this->assertEquals(1, $feed[1]['voted']);
			$this->assertEquals('test2', $feed[2]['text']);
			$this->assertEquals(0, $feed[2]['voted']);
			$this->assertEquals('test1', $feed[3]['text']);
			$this->assertEquals(0, $feed[3]['voted']);
			
			$feed = getQuestions(12345, "None", "Priority", 123);
			// test2
			// test3
			// test4
			// test1
			$this->assertEquals(4, count($feed));
			$this->assertEquals('test2', $feed[0]['text']);
			$this->assertEquals(0, $feed[0]['voted']);
			$this->assertEquals('test3', $feed[1]['text']);
			$this->assertEquals(1, $feed[1]['voted']);
			$this->assertEquals('test4', $feed[2]['text']);
			$this->assertEquals(1, $feed[2]['voted']);
			$this->assertEquals('test1', $feed[3]['text']);
			$this->assertEquals(0, $feed[3]['voted']);
		}
		
		public function testGetAllQuestions()
		{
			$db_conn = $this->initAndClearTables();
			
			//insertSubmission($db_conn, $type, $text, $numvotes, $flag, $sid)
			//getSubmissionID($db_conn, $type, $text)
			//addToVotedOn($db_conn, $type, $id, $uid)
			$this->insertSubmission($db_conn, 'Q', 'test1', 0, 0, 23456);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'Q', 'test2', 2, 0, 23456);
			$id = $this->getSubmissionID($db_conn, 'Q', 'test2');
			$this->addToVotedOn($db_conn, 'Q', $id, 123);
			$this->addToVotedOn($db_conn, 'Q', $id, 234);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'Q', 'test3', 1, 0, 23456);
			$id = $this->getSubmissionID($db_conn, 'Q', 'test3');
			$this->addToVotedOn($db_conn, 'Q', $id, 123);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'Q', 'test4', 1, 0, 12345);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'F', 'test5', 0, 0, 23456);
			
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
			$db_conn = $this->initAndClearTables();
			
			//insertSubmission($db_conn, $type, $text, $numvotes, $flag, $sid)
			//getSubmissionID($db_conn, $type, $text)
			//addToVotedOn($db_conn, $type, $id, $uid)
			$this->insertSubmission($db_conn, 'F', 'test1', 0, 0, 23456);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'F', 'test2', 2, 0, 23456);
			$id = $this->getSubmissionID($db_conn, 'F', 'test2');
			$this->addToVotedOn($db_conn, 'F', $id, 123);
			$this->addToVotedOn($db_conn, 'F', $id, 234);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'F', 'test3', 1, 0, 23456);
			$id = $this->getSubmissionID($db_conn, 'F', 'test3');
			$this->addToVotedOn($db_conn, 'F', $id, 123);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'F', 'test4', 1, 0, 12345);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'Q', 'test5', 0, 0, 23456);
			
			include_once '../../Incognito/students/scripts/studentfeed_lookup_questions.php';
			
			$feed = getQuestions(23456, "All Feedback", "None", 123);
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
			
			$feed = getQuestions(23456, "All Feedback", "Newest", 123);
			// should have:
			//	test3
			//	test2
			//	test1
			$this->assertEquals(3, count($feed));
			$this->assertEquals('test3', $feed[0]['text']);
			$this->assertEquals('test2', $feed[1]['text']);
			$this->assertEquals('test1', $feed[2]['text']);
			
			$feed = getQuestions(23456, "All Feedback", "Priority", 123);
			// should have:
			//	test2
			//	test3
			//	test1
			$this->assertEquals(3, count($feed));
			$this->assertEquals('test2', $feed[0]['text']);
			$this->assertEquals('test3', $feed[1]['text']);
			$this->assertEquals('test1', $feed[2]['text']);
		}
		
		public function testGetUnansweredQuestions()
		{
			$db_conn = $this->initAndClearTables();
			
			$this->insertSubmission($db_conn, 'Q', 'test1', 0, 0, 23456);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'Q', 'test2', 0, 1, 23456);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'Q', 'test3', 2, 0, 23456);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'F', 'test4', 0, 0, 23456);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'Q', 'test5', 0, 0, 12345);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'Q', 'test6', 1, 0, 23456);
			
			include_once '../../Incognito/students/scripts/studentfeed_lookup_questions.php';
			
			$feed = getQuestions(23456, "Unanswered", "None", 123);
			$this->assertEquals(3, count($feed));
			$this->assertEquals('test1', $feed[0]['text']);
			$this->assertEquals('test3', $feed[1]['text']);
			$this->assertEquals('test6', $feed[2]['text']);
			
			$feed = getQuestions(23456, "Unanswered", "Newest", 123);
			$this->assertEquals(3, count($feed));
			$this->assertEquals('test6', $feed[0]['text']);
			$this->assertEquals('test3', $feed[1]['text']);
			$this->assertEquals('test1', $feed[2]['text']);
			
			$feed = getQuestions(23456, "Unanswered", "Priority", 123);
			$this->assertEquals(3, count($feed));
			$this->assertEquals('test3', $feed[0]['text']);
			$this->assertEquals('test6', $feed[1]['text']);
			$this->assertEquals('test1', $feed[2]['text']);
		}
		
		public function testGetAnsweredQuestions()
		{
			$db_conn = $this->initAndClearTables();
			
			$this->insertSubmission($db_conn, 'Q', 'test1', 0, 1, 23456);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'Q', 'test2', 0, 0, 23456);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'Q', 'test3', 2, 1, 23456);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'F', 'test4', 0, 1, 23456);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'Q', 'test5', 0, 1, 12345);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'Q', 'test6', 1, 1, 23456);
			
			include_once '../../Incognito/students/scripts/studentfeed_lookup_questions.php';
			
			$feed = getQuestions(23456, "Answered", "None", 123);
			$this->assertEquals(3, count($feed));
			$this->assertEquals('test1', $feed[0]['text']);
			$this->assertEquals('test3', $feed[1]['text']);
			$this->assertEquals('test6', $feed[2]['text']);
			
			$feed = getQuestions(23456, "Answered", "Newest", 123);
			$this->assertEquals(3, count($feed));
			$this->assertEquals('test6', $feed[0]['text']);
			$this->assertEquals('test3', $feed[1]['text']);
			$this->assertEquals('test1', $feed[2]['text']);
			
			$feed = getQuestions(23456, "Answered", "Priority", 123);
			$this->assertEquals(3, count($feed));
			$this->assertEquals('test3', $feed[0]['text']);
			$this->assertEquals('test6', $feed[1]['text']);
			$this->assertEquals('test1', $feed[2]['text']);
		}
		
		public function testGetUnreadFeedback()
		{
			$db_conn = $this->initAndClearTables();
			
			$this->insertSubmission($db_conn, 'F', 'test1', 0, 0, 23456);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'F', 'test2', 0, 1, 23456);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'F', 'test3', 2, 0, 23456);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'Q', 'test4', 0, 0, 23456);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'F', 'test5', 0, 0, 12345);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'F', 'test6', 1, 0, 23456);
			
			include_once '../../Incognito/students/scripts/studentfeed_lookup_questions.php';
			
			$feed = getQuestions(23456, "Unread", "None", 123);
			$this->assertEquals(3, count($feed));
			$this->assertEquals('test1', $feed[0]['text']);
			$this->assertEquals('test3', $feed[1]['text']);
			$this->assertEquals('test6', $feed[2]['text']);
			
			$feed = getQuestions(23456, "Unread", "Newest", 123);
			$this->assertEquals(3, count($feed));
			$this->assertEquals('test6', $feed[0]['text']);
			$this->assertEquals('test3', $feed[1]['text']);
			$this->assertEquals('test1', $feed[2]['text']);
			
			$feed = getQuestions(23456, "Unread", "Priority", 123);
			$this->assertEquals(3, count($feed));
			$this->assertEquals('test3', $feed[0]['text']);
			$this->assertEquals('test6', $feed[1]['text']);
			$this->assertEquals('test1', $feed[2]['text']);
		}
		
		public function testGetReadFeedback()
		{
			$db_conn = $this->initAndClearTables();
			
			$this->insertSubmission($db_conn, 'F', 'test1', 0, 1, 23456);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'F', 'test2', 0, 0, 23456);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'F', 'test3', 2, 1, 23456);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'Q', 'test4', 0, 1, 23456);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'F', 'test5', 0, 1, 12345);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'F', 'test6', 1, 1, 23456);
			
			include_once '../../Incognito/students/scripts/studentfeed_lookup_questions.php';
			
			$feed = getQuestions(23456, "Read", "None", 123);
			$this->assertEquals(3, count($feed));
			$this->assertEquals('test1', $feed[0]['text']);
			$this->assertEquals('test3', $feed[1]['text']);
			$this->assertEquals('test6', $feed[2]['text']);
			
			$feed = getQuestions(23456, "Read", "Newest", 123);
			$this->assertEquals(3, count($feed));
			$this->assertEquals('test6', $feed[0]['text']);
			$this->assertEquals('test3', $feed[1]['text']);
			$this->assertEquals('test1', $feed[2]['text']);
			
			$feed = getQuestions(23456, "Read", "Priority", 123);
			$this->assertEquals(3, count($feed));
			$this->assertEquals('test3', $feed[0]['text']);
			$this->assertEquals('test6', $feed[1]['text']);
			$this->assertEquals('test1', $feed[2]['text']);
		}
	}

?>