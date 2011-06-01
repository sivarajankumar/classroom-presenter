<?php



// This test script tests the scripts that are designed to update
// the state in the database when an instructor marks a question as
// answered or feedback marked as read.
class testTimeline extends PHPUnit_Framework_TestCase
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

	// This function performs a test on the timeline script
	public function testScriptTimeline() {
		
		// Connect to the db and insert a session, a course, and a question
		$db_conn = $this->connectToDatabase(); 
		
		$query = "INSERT INTO Course (name, mailinglist) VALUES ('test', 'test');";
		$results = mysql_query($query, $db_conn);
		
		// Error check
		if (!$results) {
			die ("Error: " . mysql_error($db_conn));
		}
		
		// Get the cid
		$query = "SELECT cid FROM Course WHERE name = 'test' AND 
							mailinglist = 'test' ORDER BY cid DESC;";
		$results = mysql_query($query, $db_conn);
		
		// Error check
		if (!$results) {
			die ("Error: " . mysql_error($db_conn));
		}
		
		$row = mysql_fetch_row($results);
		$cid = $row[0];
		
		// Make a session
		$query = sprintf("INSERT INTO Session (cid, open) VALUES (%d, 1);", $cid);
		$results = mysql_query($query, $db_conn);
		
		// Error check
		if (!$results) {
			die ("Error: " . mysql_error($db_conn));
		}
		
		// Get the sid
		$query = sprintf("SELECT sid FROM Session WHERE cid = %d ORDER BY sid DESC;", $cid);
		$results = mysql_query($query, $db_conn);
		
		// Error check
		if (!$results) {
			die ("Error: " . mysql_error($db_conn));
		}
		
		$row = mysql_fetch_row($results);
		$sid = $row[0];
		
		// Now insert a question
		$query = sprintf("INSERT INTO Question (sid) VALUES (%d);", $sid);
		$results = mysql_query($query, $db_conn);
		
		// Error check
		if (!$results) {
			die ("Error: " . mysql_error($db_conn));
		}
		
		// Now test
		$_POST['id'] = $sid;
		$_POST['time'] = 0; 
		include "../../Incognito/instr/scripts/timeline.php";
		
		// Assert that we counted the question in the timeline and that the response
		// is the correct format
		$this->assertEquals(1, $response[1]);
		$this->assertEquals(0, $response[0]);
	}
}

?>
