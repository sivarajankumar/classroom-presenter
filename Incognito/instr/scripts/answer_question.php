<?php

	$username = "ashen";
	$password = "2kV2cNct";
	$db_name = "ashen_403_Local";

	$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);

	if (!$db_conn) {
		die("Failed to connect: " . mysql_error());
	}

	mysql_select_db($db_name, $db_conn);

	$type = $_POST['type'];	// 'Q' for question, 'F' for feedback
	$id = $_POST['id'];		// ID for the question or feedback
	$flag = $_POST['flag'];	// "true" if we want to set the entry to answered/read, "false" for unanswered/not read

	$query = null;

	if ($type == 'Q')
	{
		if ($flag == "true")
		{
			$query = sprintf("UPDATE Question SET answered = 1 WHERE qid = %d", $id);
		}
		else
		{
			$query = sprintf("UPDATE Question SET answered = 0 WHERE qid = %d", $id);
		}
		if (!mysql_query($query, $db_conn)) {
			die("Query error: " . mysql_error());
		}
	}
	elseif ($type == 'F')
	{
		if ($flag == "true")
		{
			$query = sprintf("UPDATE Feedback SET isread = 1 WHERE qid = %d", $id);
		}
		else
		{
			$query = sprintf("UPDATE Feedback SET isread = 0 WHERE qid = %d", $id);
		}
		if (!mysql_query($query, $db_conn)) {
			die("Query error: " . mysql_error());
		}
	}
	mysql_close($db_conn);

?>
