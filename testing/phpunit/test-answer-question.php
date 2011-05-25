<?php
	 
		
	
	// This test script tests the scripts that are designed to update
	// the state in the database when an instructor marks a question as
	// answered or feedback marked as read.
	class testAnswerQuestion extends PHPUnit_Framework_TestCase
	{
		// This function sends test values to the script we are testing. In this case it is 
		// the answer-question script
		public function sendTestValues($id, $type, $flag) {
			
			// Test setting the question to answered
			$_POST['type'] = $type;
			$_POST['id'] = $id; 
			$_POST['flag'] = $flag;  	
			include_once "../../Incognito/instr/scripts/answer_question.php";
			answer($type, $id, $flag); 
		}
	
		// This function handles all of the connecting to a db
		public function connectToDatabase() {
			
			include 'db_credentials.php';
	
			// Connect to the database and insert an arbitrary question
			$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
			if (!$db_conn) {
				die("Could not connect");
			}
	
			mysql_select_db($db_name, $db_conn);
			
			return $db_conn; 
		}
		
		// This function adds feedback to the database
		public function addFeedback($read, $db_conn) {
			
			// Insert the Feedback
			$query = "INSERT INTO Feedback (text, numvotes, isread) VALUES ('test', 0, ". $read . ");";
			$results = mysql_query($query, $db_conn);
				
			// Error check
			if (!$results) {
				die("Error: " + mysql_error($db_conn));
			}
				
			// Get the question id
			$query = "SELECT fid FROM Feedback WHERE text = 'test' ORDER BY fid DESC;";
			$results = mysql_query($query, $db_conn);
				
			// Error Check
			if (!$results) {
				die("Error: " . mysql_error($db_conn));
			}
				
			$row = mysql_fetch_row($results);
			$fid = $row[0];
			
			return $fid;
		}
		
		// This function adds a question to the database
		public function addQuestion($answered, $db_conn) {
			
			// Insert the question
			$query = "INSERT INTO Question (text, numvotes, answered) VALUES ('test', 0, " . $answered . ");";
			$results = mysql_query($query, $db_conn);

			// Error check
			if (!$results) {
				die("Error: " + mysql_error($db_conn));
			}

			// Get the question id
			$query = "SELECT qid FROM Question WHERE text = 'test' ORDER BY qid DESC;";
			$results = mysql_query($query, $db_conn);

			// Error Check
			if (!$results) {
				die("Error: " . mysql_error($db_conn));
			}

			$row = mysql_fetch_row($results);
			$qid = $row[0];
			
			return $qid;
		}
	
		// This function tests adding a student
		public function testAnswerQ() {
			$db_conn = $this->connectToDatabase();
			
			// Add a question
			$qid = $this->addQuestion(0, $db_conn);
			
			// Send the test values
			$this->sendTestValues($qid, "Q", "true"); 	
			
			// Now run a query to ensure that the flag is set to true
			$db_conn = $this->connectToDatabase(); 
			$query = "SELECT answered FROM Question WHERE qid = " . $qid . ";";
			$results = mysql_query($query, $db_conn);
				
			// Error check
			if (!$results) {
				die("Error: " . mysql_error($db_conn));
			}
				
			$row = mysql_fetch_row($results);
			$ans = (integer)$row[0];	
			$this->assertEquals(1, $ans);
		}
		
		// This function tests the ability to change a question
		// from answered to unanswered
		public function testUnanswerQuestion() {
			$db_conn = $this->connectToDatabase();
	
			// Add a question
			$qid = $this->addQuestion(1, $db_conn);
			
			// Then test unanswering the question
			$this->sendTestValues($qid, "Q", "false"); 		
		
			// Now run a query to ensure that the flag is set to false
			$query = "SELECT answered FROM Question WHERE qid = " . $qid . ";";
			$results = mysql_query($query, $db_conn);
				
			// Error check
			if (!$results) {
				die("Error: " . mysql_error($db_conn));
			}
				
			$row = mysql_fetch_row($results);
				
			$this->assertEquals(0, (int)$row[0]);
		}
		
		// This function marks a piece of feedback as unread and 
		// tests whether the state was changed in the database
		public function testUnreadFeedback() {
			$db_conn = $this->connectToDatabase();
	
			// First, add a piece of feedback we can unread
			$fid = $this->addFeedback(1, $db_conn);
			
			// Then test unanswering the question
			$this->sendTestValues($fid, "F", "false"); 			
	
			// Now run a query to ensure that the flag is set to false
			$query = "SELECT isread FROM Feedback WHERE fid = " . $fid . ";";
			$results = mysql_query($query, $db_conn);
				
			// Error check
			if (!$results) {
				die("Error: " . mysql_error($db_conn));
			}
				
			$row = mysql_fetch_row($results);
			$this->assertEquals(0, (int)$row[0]);
		}
	
		// This function attempts to read a piece of feedback and
		// tests whether the state was changed in the database
		public function testReadFeedback() {
			$db_conn = $this->connectToDatabase();

			// First, add a piece of feedback we can read
			$fid = $this->addFeedback(0, $db_conn);
			
			// Test setting the question to answered
			$this->sendTestValues($fid, "F", "true"); 			
	
			// Now run a query to ensure that the flag is set to true
			$query = "SELECT isread FROM Feedback WHERE fid = " . $fid . ";";
			$results = mysql_query($query, $db_conn);
				
			// Error check
			if (!$results) {
				die("Error: " . mysql_error($db_conn));
			}
				
			$row = mysql_fetch_row($results);
				
			$this->assertEquals(1, (int)$row[0]);
		}
	}
	
?>
