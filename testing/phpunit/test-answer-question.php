<?php

	class testTesting extends PHPUnit_Framework_TestCase
	{
		
		// This function tests adding a student
		public function testAnswerQuestion() {
			include 'db_credentials.php';
			
			// Connect to the database and insert an arbitrary question
			$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
			if (!$db_conn) {
				die("Could not connect");
			}
		
			mysql_select_db($db_name, $db_conn);
			
			// Insert the question
			$query = "INSERT INTO Question (text, numvotes, answered) VALUES ('test', 0, 0);";
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
		
		public function testAnswerFeedback() {
			// This function tests adding a student
		public function testAnswerQuestion() {
			include 'db_credentials.php';
			
			// Connect to the database and insert an arbitrary question
			$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
			if (!$db_conn) {
				die("Could not connect");
			}
		
			mysql_select_db($db_name, $db_conn);
			
			// Insert the question
			$query = "INSERT INTO Feedback (text, numvotes, isread) VALUES ('test', 0, 0);";
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
	}

?>