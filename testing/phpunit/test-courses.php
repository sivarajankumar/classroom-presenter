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
		
		// This function adds a course to the database given a course name,
		// an instructor uid, and a flag indicating whether the uid is in fact
		// an instructor
		public function addCourse($courseName, $iuid) {
			
			$_POST['uid'] = $iuid;
			$_POST['name'] = $courseName;
			$_POST['mailinglist'] = 'test';  
			
			include "../../Incognito/instr/scripts/create_course.php";
			
			// Make sure that we actually got a cid back
			$num_results = 0;
			if (isset($cid)) { 
				
				// Check to make sure that the course was in fact inserted
				$db_conn = $this->connectToDatabase();
					

				$query = sprintf("SELECT * FROM Course WHERE cid = %d;", $cid);
				$results = mysql_query($query, $db_conn);
					
				// Error check
				if (!$results) {
					die ("Error: " . mysql_error($db_conn));
				}
				
				$num_results = mysql_num_rows($results);
			}
			
			// Check if we are do the test on an instructor a student
			$this->assertEquals(1, $num_results);
		}
		
		// This function adds a series of courses and returns the array of courses created
		// given an instructor uid, and given a student id, tests that a student cannot
		// create a course.
		public function addCourses($iuid, $suid) {
			
			// Define the number of courses we will create
			$NUM_COURSES = 20;
			
			$courses; 
			for ($i = 0; $i < $NUM_COURSES; $i++) {
				$courses[$i] = "" . rand(1000, 9999);
				$this->addCourse($courses[$i], $iuid);
			}
			
			return $courses; 
		}
		
		// This function adds a student to a course. Like I mentioned before, since
		// I have other unit tests for the add student script, I will assume that it
		// is working.
		public function addStudent($uid, $cid) {
			$_POST['uid'] = $uid;
			$_POST['cid'] = $cid; 
			
			include "../../Incognito/instr/scripts/addStudent.php";
		}
		
		// This function opens a session for a paritcular course given 
		// a course id and an instructor id
		public function openSession($cid, $uid) {
			
			$_POST['uid'] = $uid; 
			$_POST['cid'] = $cid; 
			
			include "../../Incognito/instr/scripts/start_session.php";

			// First see if we got a result back
			$num_results = 0; 
			$sid = 0;
			if (isset($row[0])) {
				
				// Then query the database to see if the session is in the db
				$db_conn = $this->connectToDatabase(); 
				
				$sid = $row[0];
				$query = sprintf("SELECT * FROM Session WHERE sid = %d;", $sid);
				$results = mysql_query($query, $db_conn);
				
				// Error check
				if (!$results) {
					die ("Error: " . mysql_error($db_conn));
				}
				
				$num_results = mysql_num_rows($results);
			}
			
			// Should be a session that we just created
			$this->assertEquals(1, $num_results);
			return $sid;
		}
		
		// This function has a student join a session and checks to make sure
		// that the student actually joined the session
		public function joinSession($sid, $uid) {
			
			$_POST['uid'] = $uid;
			$_POST['sid'] = $sid; 
			
			include "../../Incognito/students/scripts/join_session.php";
			
			// Now query the database to see if the student made it into the Joined table
			$db_conn = $this->connectToDatabase(); 
			
			$query = sprintf("SELECT * FROM Joined WHERE sid = %d AND uid = %d;", $sid, $uid);
			$results = mysql_query($query, $db_conn);
			
			// Error check
			if (!$results) {
				die ("Error: " . mysql_error($db_conn));
			}
			
			// If we an entry in the Joined table then the script passes
			$this->assertEquals(1, mysql_num_rows($results));
		}
		
		// This test function goes through the entire sequence of events for a 
		// proper use and initialization of courses
		public function testUseCourses() {
			
			// Make instructors and students
			$instructor = "test-inst";
			$student = "test-stdnt";
			$uids = $this->init($instructor, $student);
			$courses = $this->addCourses($uids[0], $uids[1]);
			
			// Next we want to add the student to the courses (Note,
			// I already created a unit test for this script, so I am
			// going to assume it works)
			for ($i = 0; $i < sizeof($courses); $i++) {	
				$this->addStudent($uids[1], $courses[$i]);
			}
			
			// Now that we have added the student to all of the courses we can
			// open a session for half of the courses
			$sessions;
			for ($i = 0; $i < sizeof($courses); $i++) {
				$sessions[$i] = $this->openSession($courses[$i], $uids[0]);
			}
			
			// Now have the student join the sessions for each of the courses
			for ($i = 0; $i < sizeof($sessions); $i++) {
				$this->joinSession($session[$i], $uids[1]);
			}
		}
	}

?>
