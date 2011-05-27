<?php

	class testInstrFeed extends PHPUnit_Framework_Testcase
	{
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
			$query = "DELETE FROM Feedback";
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
		
		public function testGetAll()
		{
			$db_conn = $this->initAndClearTables();
			
			$this->insertSubmission($db_conn, 'Q', 'test1', 2, 0, 12345);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'F', 'test2', 1, 0, 12345);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'Q', 'test3', 0, 0, 12345);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'F', 'test4', 3, 0, 12345);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'Q', 'test5', 0, 0, 23456);
			
			include_once '../../Incognito/instr/scripts/lookup_questions.php';
			
			$feed = getQuestions(12345, "None", "None");			
			$this->assertEquals(4, count($feed));
			$this->assertEquals('test1', $feed[0]['text']);
			$this->assertEquals('test3', $feed[1]['text']);
			$this->assertEquals('test2', $feed[2]['text']);
			$this->assertEquals('test4', $feed[3]['text']);
			
			$feed = getQuestions(12345, "None", "Newest");
			$this->assertEquals(4, count($feed));
			$this->assertEquals('test4', $feed[0]['text']);
			$this->assertEquals('test3', $feed[1]['text']);
			$this->assertEquals('test2', $feed[2]['text']);
			$this->assertEquals('test1', $feed[3]['text']);
			
			$feed = getQuestions(12345, "None", "Priority");
			$this->assertEquals(4, count($feed));
			$this->assertEquals('test4', $feed[0]['text']);
			$this->assertEquals('test1', $feed[1]['text']);
			$this->assertEquals('test2', $feed[2]['text']);
			$this->assertEquals('test3', $feed[3]['text']);
		}
		
		public function testGetAllQuestions()
		{
			$db_conn = $this->initAndClearTables();
			
			$this->insertSubmission($db_conn, 'Q', 'test1', 2, 0, 12345);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'F', 'test2', 1, 0, 12345);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'Q', 'test3', 0, 0, 12345);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'F', 'test4', 3, 0, 23456);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'Q', 'test5', 0, 0, 12345);
			
			include_once '../../Incognito/instr/scripts/lookup_questions.php';
			
			$feed = getQuestions(12345, "All Questions", "None");
			$this->assertEquals(3, count($feed));
			$this->assertEquals('test1', $feed[0]['text']);
			$this->assertEquals('test3', $feed[1]['text']);
			$this->assertEquals('test5', $feed[2]['text']);
			
			$feed = getQuestions(12345, "All Questions", "Newest");
			$this->assertEquals(3, count($feed));
			$this->assertEquals('test5', $feed[0]['text']);
			$this->assertEquals('test3', $feed[1]['text']);
			$this->assertEquals('test1', $feed[2]['text']);
			
			$feed = getQuestions(12345, "All Questions", "Priority");
			$this->assertEquals(3, count($feed));
			$this->assertEquals('test1', $feed[0]['text']);
			$this->assertEquals('test3', $feed[1]['text']);
			$this->assertEquals('test5', $feed[2]['text']);
		}
		
		public function testGetAllFeedback()
		{
			$db_conn = $this->initAndClearTables();
			
			$this->insertSubmission($db_conn, 'F', 'test1', 2, 0, 12345);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'Q', 'test2', 1, 0, 12345);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'F', 'test3', 0, 0, 12345);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'Q', 'test4', 3, 0, 23456);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'F', 'test5', 0, 0, 12345);
			
			include_once '../../Incognito/instr/scripts/lookup_questions.php';
			
			$feed = getQuestions(12345, "All Feedback", "None");
			$this->assertEquals(3, count($feed));
			$this->assertEquals('test1', $feed[0]['text']);
			$this->assertEquals('test3', $feed[1]['text']);
			$this->assertEquals('test5', $feed[2]['text']);
			
			$feed = getQuestions(12345, "All Feedback", "Newest");
			$this->assertEquals(3, count($feed));
			$this->assertEquals('test5', $feed[0]['text']);
			$this->assertEquals('test3', $feed[1]['text']);
			$this->assertEquals('test1', $feed[2]['text']);
			
			$feed = getQuestions(12345, "All Feedback", "Priority");
			$this->assertEquals(3, count($feed));
			$this->assertEquals('test1', $feed[0]['text']);
			$this->assertEquals('test3', $feed[1]['text']);
			$this->assertEquals('test5', $feed[2]['text']);
		}
		
		public function testGetUnansweredQuestions()
		{
			$db_conn = $this->initAndClearTables();
			
			$this->insertSubmission($db_conn, 'Q', 'test1', 2, 0, 12345);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'F', 'test2', 1, 0, 12345);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'Q', 'test3', 0, 0, 12345);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'F', 'test4', 3, 0, 23456);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'Q', 'test5', 0, 0, 12345);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'Q', 'test6', 4, 1, 23456);
			
			include_once '../../Incognito/instr/scripts/lookup_questions.php';
			
			$feed = getQuestions(12345, "All Questions", "None");
			$this->assertEquals(3, count($feed));
			$this->assertEquals('test1', $feed[0]['text']);
			$this->assertEquals('test3', $feed[1]['text']);
			$this->assertEquals('test5', $feed[2]['text']);
			
			$feed = getQuestions(12345, "All Questions", "Newest");
			$this->assertEquals(3, count($feed));
			$this->assertEquals('test5', $feed[0]['text']);
			$this->assertEquals('test3', $feed[1]['text']);
			$this->assertEquals('test1', $feed[2]['text']);
			
			$feed = getQuestions(12345, "All Questions", "Priority");
			$this->assertEquals(3, count($feed));
			$this->assertEquals('test1', $feed[0]['text']);
			$this->assertEquals('test3', $feed[1]['text']);
			$this->assertEquals('test5', $feed[2]['text']);
		}
		
		public function testGetAnsweredQuestions()
		{
			$db_conn = $this->initAndClearTables();
			
			$this->insertSubmission($db_conn, 'Q', 'test1', 2, 1, 12345);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'F', 'test2', 1, 1, 12345);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'Q', 'test3', 0, 1, 12345);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'F', 'test4', 3, 1, 23456);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'Q', 'test5', 0, 1, 12345);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'Q', 'test6', 4, 0, 23456);
			
			include_once '../../Incognito/instr/scripts/lookup_questions.php';
			
			$feed = getQuestions(12345, "Answered", "None");
			$this->assertEquals(3, count($feed));
			$this->assertEquals('test1', $feed[0]['text']);
			$this->assertEquals('test3', $feed[1]['text']);
			$this->assertEquals('test5', $feed[2]['text']);
			
			$feed = getQuestions(12345, "Answered", "Newest");
			$this->assertEquals(3, count($feed));
			$this->assertEquals('test5', $feed[0]['text']);
			$this->assertEquals('test3', $feed[1]['text']);
			$this->assertEquals('test1', $feed[2]['text']);
			
			$feed = getQuestions(12345, "Answered", "Priority");
			$this->assertEquals(3, count($feed));
			$this->assertEquals('test1', $feed[0]['text']);
			$this->assertEquals('test3', $feed[1]['text']);
			$this->assertEquals('test5', $feed[2]['text']);
		}
		
		public function testGetUnreadFeedback()
		{
			$db_conn = $this->initAndClearTables();
			
			$this->insertSubmission($db_conn, 'F', 'test1', 2, 0, 12345);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'Q', 'test2', 1, 0, 12345);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'F', 'test3', 0, 0, 12345);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'Q', 'test4', 3, 0, 23456);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'F', 'test5', 0, 0, 12345);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'F', 'test6', 4, 1, 23456);
			
			include_once '../../Incognito/instr/scripts/lookup_questions.php';
			
			$feed = getQuestions(12345, "Unread", "None");
			$this->assertEquals(3, count($feed));
			$this->assertEquals('test1', $feed[0]['text']);
			$this->assertEquals('test3', $feed[1]['text']);
			$this->assertEquals('test5', $feed[2]['text']);
			
			$feed = getQuestions(12345, "Unread", "Newest");
			$this->assertEquals(3, count($feed));
			$this->assertEquals('test5', $feed[0]['text']);
			$this->assertEquals('test3', $feed[1]['text']);
			$this->assertEquals('test1', $feed[2]['text']);
			
			$feed = getQuestions(12345, "Unread", "Priority");
			$this->assertEquals(3, count($feed));
			$this->assertEquals('test1', $feed[0]['text']);
			$this->assertEquals('test3', $feed[1]['text']);
			$this->assertEquals('test5', $feed[2]['text']);
		}
		
		public function testGetReadFeedback()
		{
			$db_conn = $this->initAndClearTables();
			
			$this->insertSubmission($db_conn, 'F', 'test1', 2, 1, 12345);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'Q', 'test2', 1, 1, 12345);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'F', 'test3', 0, 1, 12345);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'Q', 'test4', 3, 1, 23456);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'F', 'test5', 1, 1, 12345);
			sleep(1);
			
			$this->insertSubmission($db_conn, 'F', 'test6', 4, 0, 23456);
			
			include_once '../../Incognito/instr/scripts/lookup_questions.php';
			
			$feed = getQuestions(12345, "Read", "None");
			$this->assertEquals(3, count($feed));
			$this->assertEquals('test1', $feed[0]['text']);
			$this->assertEquals('test3', $feed[1]['text']);
			$this->assertEquals('test5', $feed[2]['text']);
			
			$feed = getQuestions(12345, "Read", "Newest");
			$this->assertEquals(3, count($feed));
			$this->assertEquals('test5', $feed[0]['text']);
			$this->assertEquals('test3', $feed[1]['text']);
			$this->assertEquals('test1', $feed[2]['text']);
			
			$feed = getQuestions(12345, "Read", "Priority");
			$this->assertEquals(3, count($feed));
			$this->assertEquals('test1', $feed[0]['text']);
			$this->assertEquals('test5', $feed[1]['text']);
			$this->assertEquals('test3', $feed[2]['text']);
		}
	}

?>