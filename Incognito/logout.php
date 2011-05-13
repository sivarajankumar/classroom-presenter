<?php

  // Change this for whoever is using the php script
  // These variables need to be changed for every person who sets this up
  // Production DB: ashen; 2kV2cNct; ashen_403_Local
  $username = "ashen";
	$password = "2kV2cNct"; 
	$db_name = "ashen_403_Local"; 
 

  // Connect to server
  $db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
 
  if (!$db_conn) {
    die("Failed to connect to the mysql server"); 
  }
  
  // Select the correct database
  mysql_select_db($db_name, $db_conn); 
  
  // Current timestamp is auto-inserted
  $query = sprintf("UPDATE Session SET stop_time=now()
            WHERE sid = %d", );
  
  if(!mysql_query($query, $db_conn)) {
    die("Query error: " . mysql_error());
  }	
  
  mysql_close($db_conn);
?>