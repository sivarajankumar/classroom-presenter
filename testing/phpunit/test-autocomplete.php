<?php

	class testAutoComplete extends PHPUnit_Framework_Testcase
	{
		public function testAutoComplete()
		{
			include 'db_credentials.php';
			
			$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
			if ( !$db_conn )
			{
				die("Could not connect");
			}
			
			mysql_select_db($db_name, $db_conn);
			
			// Wipe the tables
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
			
			// Insert some test values
			$query = "INSERT INTO Question (text, numvotes, answered, sid) VALUES ('test1', 0, 0, 23456)";
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			
			$query = "INSERT INTO Question (text, numvotes, answered, sid) VALUES ('test2', 1, 0, 23456)";
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			
			$query = "INSERT INTO Feedback (text, numvotes, isread, sid) VALUES ('test3', 0, 0, 23456)";
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			
			$query = "INSERT INTO Feedback (text, numvotes, isread, sid) VALUES ('test4', 0, 0, 12345)";
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			
			include '../../Incognito/students/scripts/studenthome_lookup_questions.php';
			
			$array = getQuestions(23456);
			$this->assertEquals('test1', $array[0]['text']);
			$this->assertEquals('test2', $array[1]['text']);
			$this->assertEquals('test3', $array[2]['text']);
			$this->assertEquals(3, count($array));				// the feedback with sid=12345 shouldn't be in here.
		}
	}

?>