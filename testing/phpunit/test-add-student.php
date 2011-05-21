<?php

	class testTesting extends PHPUnit_Framework_TestCase
	{
		
		// This function tests adding a student
		public function testAddStudent() {
			include 'db_credentials.php';
	
			// Connect to the database and insert an arbitrary student
			$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
			if (!$db_conn) {
				die("Could not connect");
			}
		
			mysql_select_db($db_name, $db_conn);
			
			// First add a test student and test class into the database
			$query = "INSERT INTO User (email) VALUES ('test')";
			$results = mysql_query($query, $db_conn);
			
			// Error Check
			if (!$results) {
				die("Error: " . mysql_error($db_conn));
			}
			
			// First we need to retreive the newly created uid
			$query = "SELECT uid FROM User WHERE email = 'test' ORDER BY uid DESC;";
			$results = mysql_query($query, $db_conn);
			
			// Error Check
			if (!$results) {
				die("Error: " . mysql_error($db_conn));
			}
			
			// Now get the user id from the query
			$row = mysql_fetch_row($results);
			$uid = $row[0];
			
			// Now insert into the student table
			$query = "INSERT INTO Student (uid, netid) VALUES (" . $uid . ", 'test');";
			$results = mysql_query($query, $db_conn);
			
			// Error Check
			if (!$results) {
				die("Error: " . mysql_error($db_conn));
			}
			
			// Now insert a test course
			$query = "INSERT INTO Course (name, mailinglist) VALUES ('test', 'test@test.com');";
			$results = mysql_query($query, $db_conn);
			
			// Error Check
			if (!$results) {
				die("Error: " . mysql_error($db_conn));
			}
			
			// Fetch the course number
			$query = "SELECT cid FROM Course WHERE name = 'test' ORDER BY cid DESC;";
			$results = mysql_query($query, $db_conn);
			
			// Error Check
			if (!$results) {
				die("Error: " . mysql_error($db_conn));
			}
			
			$row = mysql_fetch_row($results);
			$cid = $row[0];
			
			// Now test the add student script
			$_POST['uid'] = $uid;
			$_POST['cid'] = $cid; 
			
			include '../../Incognito/students/scripts/addStudent.php';
			
			// Now run a query on the Attends table to see if the uid, cid 
			// pair is in the Attends table
			$query = "SELECT * FROM Attends WHERE cid = " . $cid . " uid = " . $uid . ";";
			$results = mysql_query($query, $db_conn);
			
			// Error Check
			if (!$results) {
				die("Error: " + mysql_error($db_conn));
			}
			
			$this->assertEquals(1, mysql_num_rows($results));
		}
	}