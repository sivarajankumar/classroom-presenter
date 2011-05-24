<?php
	
	include 'db_credentials.php';
	
	// Connect to the database and insert an arbitrary question
	$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
	if (!$db_conn) {
		die("Could not connect");
	}
	
	mysql_select_db($db_name, $db_conn);
	
	
	// This test script tests the scripts that are designed to update
	// the state in the database when an instructor marks a question as
	// answered or feedback marked as read.
	class testAnswerQuestion extends PHPUnit_Framework_TestCase
	{
	
		// This function adds feedback to the database
		public function addFeedback($read) {
			
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
		public function addQuestion($answered) {
			
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
			
			return $qid
		}
	
		// This function tests adding a student
		public function answerQuestion() {
			
			// Add a question
			$qid = addQuestion(0);
			
			// Test setting the question to answered
			$_POST['id'] = $qid;
			$_POST['type'] = "Q";
			$_POST['flag'] = "true";
	
			include "../../Incognito/students/scripts/answer_question.php";
				
			// Now run a query to ensure that the flag is set to true
			$query = "SELECT answered FROM Question WHERE qid = " . $qid . ";";
			$results = mysql_query($query, $db_conn);
				
			// Error check
			if (!$results) {
				die("Error: " . mysql_error($db_conn));
			}
				
			$row = mysql_fetch_row($results);
				
			$this->assertEquals(1, $row[0]);
		}
		
		// This function tests the ability to change a question
		// from answered to unanswered
		public function unanswerQuestion() {
			
			// Add a question
			$qid = addQuestion(1);
			
			// Then test unanswering the question
			$_POST['id'] = $qid;
			$_POST['type'] = "Q";
			$_POST['flag'] = "false";
				
			include "../../Incognito/students/scripts/answer_question.php";
				
			// Now run a query to ensure that the flag is set to false
			$query = "SELECT answered FROM Question WHERE qid = " . $qid . ";";
			$results = mysql_query($query, $db_conn);
				
			// Error check
			if (!$results) {
				die("Error: " . mysql_error($db_conn));
			}
				
			$row = mysql_fetch_row($results);
				
			$this->assertEquals(0, $row[0]);
		}
		
		// This function marks a piece of feedback as unread and 
		// tests whether the state was changed in the database
		public function unreadFeedback() {
			
			// First, add a piece of feedback we can unread
			$fid = addFeedback(1);
			
			// Then test unanswering the question
			$_POST['id'] = $fid;
			$_POST['type'] = "F";
			$_POST['flag'] = "false";
				
			include "../../Incognito/students/scripts/answer_question.php";
				
			// Now run a query to ensure that the flag is set to false
			$query = "SELECT answered FROM Feedback WHERE fid = " . $qid . ";";
			$results = mysql_query($query, $db_conn);
				
			// Error check
			if (!$results) {
				die("Error: " . mysql_error($db_conn));
			}
				
			$row = mysql_fetch_row($results);
				
			$this->assertEquals(0, $row[0]);
		}
	
		// This function attempts to read a piece of feedback and
		// tests whether the state was changed in the database
		public function readFeedback() {

			// First, add a piece of feedback we can read
			$fid = addFeedback(0);
			
			// Test setting the question to answered
			$_POST['id'] = $fid;
			$_POST['type'] = "F";
			$_POST['flag'] = "true";
	
			include "../../Incognito/students/scripts/answer_question.php";
				
			// Now run a query to ensure that the flag is set to true
			$query = "SELECT answered FROM Feedback WHERE fid = " . $fid . ";";
			$results = mysql_query($query, $db_conn);
				
			// Error check
			if (!$results) {
				die("Error: " . mysql_error($db_conn));
			}
				
			$row = mysql_fetch_row($results);
				
			$this->assertEquals(1, $row[0]);
		}
		
		// This function runs all of the tests on the answering of questions/feedback
		public function testQF() {
			
			answerQuestion(); 
			unanswerQuestion(); 
			readFeedback();
			unreadFeedback(); 
		}
	}
	
?>