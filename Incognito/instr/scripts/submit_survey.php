<?php
	
	// Change this for whoever is using the php script
	$database = "mcmk_ballerdb";

	// Connect to the mysql server
	$db_conn = mysql_connect("cubist.cs.washington.edu", "mcmk", "hyi2Uq7B"); 

	// Check if we connected properly
	if (!$db_conn) {
		die("Could not connect to the mysql server");
	}
	
	// Select the correct database
	mysql_select_db($database, $db_conn); 

	// Insert the question into the table given
	// all of the relevent fields
	$text = $_POST['text'];
	echo $text;
	$sql_query1 = "INSERT INTO Survey (sid,sessionid)
              VALUES (13578,22222)";
  if (mysql_query($sql_query1,$db_conn))
  {
    echo "Created a Survey.\n";
  }
  else
  {
    echo "Error: " . mysql_error();
  }
  $sql_query2 = "INSERT INTO FreeResponse (sid,text)
              VALUES (13578,'$text')";
  if (mysql_query($sql_query2,$db_conn))
  {
    echo "Created a FreeResponse.\n";
  }
  else
  {
    echo "Error: " . mysql_error();
  }
  echo "1 record added.\n";
  mysql_close($db_conn)
?>
