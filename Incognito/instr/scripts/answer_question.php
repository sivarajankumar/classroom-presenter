<?php	

	// Connect to the database and return the database connection
	function connectToDB()
	{
		include "../../db_credentials.php";
		$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
	 
		if (!$db_conn) {
			die("Failed to connect to the mysql server"); 
		}

		mysql_select_db($db_name, $db_conn);
		return $db_conn;
	}

	function answer($type, $id, $flag)
	{
				

		$query = null;
		$db_conn = connectToDB();
		
		if ($type == 'Q')
		{
			if ($flag == "true")	// set the question to answered
			{
				$query = sprintf("UPDATE Question SET answered = 1 WHERE qid = %d", $id);
			}
			else					// set the question to unanswered
			{
				$query = sprintf("UPDATE Question SET answered = 0 WHERE qid = %d", $id);
			}
			if (!mysql_query($query, $db_conn)) {
				die("Query error: " . mysql_error());
			}
		}
		elseif ($type == 'F')
		{
			if ($flag == "true")	// set the feedback to read
			{
				$query = sprintf("UPDATE Feedback SET isread = 1 WHERE fid = %d", $id);
			}
			else					// set the feedback to unread
			{
				$query = sprintf("UPDATE Feedback SET isread = 0 WHERE fid = %d", $id);
			}
			if (!mysql_query($query, $db_conn)) {
				die("Query error: " . mysql_error());
			}
		}
	}	

	if ( isset($_POST['type']) && isset($_POST['id']) && isset($_POST['flag']) )
	{
		$type = $_POST['type'];	// 'Q' for question, 'F' for feedback
		$id = $_POST['id'];		// ID for the question or feedback
		$flag = $_POST['flag'];	// "true" if we want to set the entry to answered/read, "false" for unanswered/not read
		answer($type, $id, $flag);
	}
	
?>
