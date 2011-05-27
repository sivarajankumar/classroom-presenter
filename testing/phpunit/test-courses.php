<?php

	class testCourses extends PHPUnit_Framework_TestCase
	{

		// This function creates a database connection
		public function connectToDatabase() {
			
			include "../../db_credentials.php";
			
			// Connect to the database and insert an arbitrary question
			$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
			if (!$db_conn) {
				die("Could not connect");
			}
	
			mysql_select_db($db_name, $db_conn);
			
			return $db_conn; 
		}
		
		// This function initializes the database given a test instructor
		// and a test student. Returns an array where the first index is the
		// uid of the instructor and the second is the uid of the student
		public function init($instructor, $student) {
			
			$db_conn = $this->connectToDatabase(); 
			
			// Now insert the instructor into the user table and the instructor
			// table
			$query = sprintf("INSERT INTO User (email) VALUES ('%s');", $instructor);
			$results = mysql_query($query, $db_conn);
			
			// Error Check
			if (!$results) {
				die ("Error: " . mysql_error($db_conn));
			}
			
			// Get the uid for the instructor
			$query = sprintf("SELECT uid FROM User WHERE email = '%s';", $instructor); 
			$results = mysql_query($query, $db_conn);
			
			// Error Check
			if (!$results) {
				die ("Error: " . mysql_error($db_conn));
			}
			
			$row = mysql_fetch_row($results);
			$iuid = $row[0];
			
			$query = sprintf("INSERT INTO Instructor VALUES (%d);", $iuid);
			$results = mysql_query($query, $db_conn);
			
			// Error Check
			if (!$results) {
				die ("Error: " . mysql_error($db_conn));
			}
			
			// Now do the same for the student
			$query = sprintf("INSERT INTO User (email) VALUES ('%s');", $student);
			$results = mysql_query($query, $db_conn);
			
			// Error check
			if (!$results) {
				die ("Error: " . mysql_error($db_conn));
			}
			
			// Get the uid
			$query = sprintf("SELECT uid FROM User WHERE email = '%s';", $student);
			$results = mysql_query($query, $db_conn);
			
			// Error check
			if (!$results) {
				die ("Error: " . mysql_error($db_conn));
			}
			
			$row = mysql_fetch_row($results);
			$suid = $row[0];
			
			$query = sprintf("INSERT INTO Student (uid) VALUES (%d);", $suid);
			$results = mysql_query($query, $db_conn);
			
			// Error Check
			if (!$results) {
				die ("Error: " . mysql_error($db_conn));
			}
			
			$uids[0] = $iuid; 
			$uids[1] = $suid; 
			return $uids; 
		}
		
		// This function adds a course to the database
		public function addCourse($courseName, $iuid) {
			
			$_POST['uid'] = $iuid;
			$_POST['name'] = $courseName; 
			
			include "../../Incognito/instr/scripts/create_course.php";
			
			// Check to make sure that the course was in fact inserted 
			$db_conn = $this->connectToDatabase();
			
			$query = sprintf("SELECT * FROM Course WHERE cid = %d;", $cid);
			$results = mysql_query($query, $db_conn);
			
			// Error check
			if (!$results) {
				die ("Error: " . mysql_error($db_conn));
			}
			
			$this->assertEquals(1, mysql_num_rows($results));
		}
		
		// This function adds a series of courses and returns the array of courses created
		public function addCourses($iuid) {
			
			// Define the number of courses we will create
			$NUM_COURSES = 20;
			
			$courses; 
			for ($i = 0; $i < $NUM_COURSES; $i++) {
				$courses[$i] = "" . rand(1000, 9999);
				addCourse($courseName, $iuid);
			}
			
			return $courses; 
		}
		
		// This test function goes through the entire sequence of events for a 
		// proper use and initialization of courses
		public function testUseCourses() {
			
			// Make instructors and students
			$instructor = "test-inst";
			$student = "test-stdnt";
			$uids = init($instructor, $student);
			$courses = addCourses($uids[0]);
		}
	}

?>