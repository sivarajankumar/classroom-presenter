<?php

	class testTesting extends PHPUnit_Framework_TestCase
	{
		
		// Test the get alias php script
		public function testGetAlias() {
			
			include 'db_credentials.php';
	
			// Connect to the database and insert an arbitrary student
			$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
			if (!$db_conn) {
				die("Could not connect");
			}
		
			mysql_select_db($db_name, $db_conn);

			// Now start inserting
			$query = "INSERT INTO User (email) VALUES ('test');";
			mysql_query($query, $db_conn);

			// Get the uid
			$query = "SELECT uid FROM User WHERE email = 'test';";
			$results = mysql_query($query, $db_conn); 
	
			$row = mysql_fetch_row($results);
			$uid = $row[0];

			// Insert into student
			$query ="INSERT INTO Student VALUES ($uid, 0, 'testing');";
			mysql_query($query, $db_conn);      	

			$_POST['uid'] = $uid; 
	
			include "../../Incognito/students/scripts/get_alias.php";

			// Now check the value that was echoed to see if we have correctly grabbed the right alias
			$this->assertEquals('testing', $row[0]); 
		}
		
	}
	
	

?>
