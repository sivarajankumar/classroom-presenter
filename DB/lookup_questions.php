<?php

	// This file looks up all questions associated with a given session

	// Connect to the database

	// These variables need to be changed for every person who wants to use their local db.
	// Production DB: ashen; 2kV2cNct; ashen_403_Local
	$username = "ashen";
	$password = "2kV2cNct"; 
	$db_name = "ashen_403_Local"; 

	$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
 
	if (!$db_conn) {
		die("Failed to connect to the mysql server"); 
	}

	mysql_select_db($db_name, $db_conn); 
	
	// Now query the database for all of the questions associated
	// with the current session
	$sid = $_POST['sid'];
	$filter = $_POST['filter'];
	$sort = $_POST['sort'];
	$rows = array();
	$query = null;
	if ( $filter == "none" )	// no filtering, so query both Question and Feedback
	{
		$query1 = null;
		$query2 = null;
		if ( $sort == "newest" )
		{
			$query1 = sprintf("SELECT * FROM Question WHERE sid = %d ORDER BY time DESC", $sid);
			$query2 = sprintf("SELECT * FROM Feedback WHERE sid = %d ORDER BY time DESC", $sid);
		}
		elseif ( $sort == "priority" )
		{
			$query1 = sprintf("SELECT * FROM Question WHERE sid = %d ORDER BY numvotes DESC", $sid);
			$query2 = sprintf("SELECT * FROM Feedback WHERE sid = %d ORDER BY numvotes DESC", $sid);
		}
		else
		{
			$query1 = sprintf("SELECT * FROM Question WHERE sid = %d", $sid);
			$query2 = sprintf("SELECT * FROM Feedback WHERE sid = %d", $sid);
		}
		$results = mysql_query($query1, $db_conn);
		while($r = mysql_fetch_assoc($results))
		{
			$rows[] = array('text'=>$r["text"],'votes'=>$r["numvotes"],'answered'=>$r["answered"],'type'=>'Q');
		}
		$results = mysql_query($query2, $db_conn);
		while($r = mysql_fetch_assoc($results))
		{
			$rows[] = array('text'=>$r["text"],'votes'=>$r["numvotes"],'isread'=>$r["isread"],'type'=>'F');
		}
	}
	elseif ( $filter == "qboth" )	// we only want questions
	{
		if ( $sort == "newest" )
		{
			$query = sprintf("SELECT * FROM Question WHERE sid = %d ORDER BY time DESC", $sid);
		}
		elseif ( $sort == "priority" )
		{
			$query = sprintf("SELECT * FROM Question WHERE sid = %d ORDER BY numvotes DESC", $sid);
		}
		else
		{
			$query = sprintf("SELECT * FROM Question WHERE sid = %d", $sid);
		}
		$results = mysql_query($query, $db_conn);
		while($r = mysql_fetch_assoc($results))
		{
			$rows[] = array('text'=>$r["text"],'votes'=>$r["numvotes"],'answered'=>$r["answered"],'type'=>'Q');
		}
	}
	elseif ( $filter == "fboth" )	// we only want feedback
	{
		if ( $sort == "newest" )
		{
			$query = sprintf("SELECT * FROM Feedback WHERE sid = %d ORDER BY time DESC", $sid);
		}
		elseif ( $sort == "priority" )
		{
			$query = sprintf("SELECT * FROM Feedback WHERE sid = %d ORDER BY numvotes DESC", $sid);
		}
		else
		{
			$query = sprintf("SELECT * FROM Feedback WHERE sid = %d", $sid);
		}
		$results = mysql_query($query, $db_conn);
		while($r = mysql_fetch_assoc($results))
		{
			$rows[] = array('text'=>$r["text"],'votes'=>$r["numvotes"],'isread'=>$r["isread"],'type'=>'F');
		}
	}
	elseif ( $filter == "answered" )	// we only want answered questions
	{
		if ( $sort == "newest" )
		{
			$query = sprintf("SELECT * FROM Question WHERE sid = %d AND answered = 1 ORDER BY time DESC", $sid);
		}
		elseif ( $sort == "priority" )
		{
			$query = sprintf("SELECT * FROM Question WHERE sid = %d AND answered = 1 ORDER BY numvotes DESC", $sid);
		}
		else
		{
			$query = sprintf("SELECT * FROM Question WHERE sid = %d AND answered = 1", $sid);
		}
		$results = mysql_query($query, $db_conn);
		$rows = array();
		while($r = mysql_fetch_assoc($results))
		{
			$rows[] = array('text'=>$r["text"],'votes'=>$r["numvotes"],'answered'=>$r["answered"],'type'=>'Q');
		}
	}
	elseif ( $filter == "unanswered" )	// we only want unanswered questions
	{
		if ( $sort == "newest" )
		{
			$query = sprintf("SELECT * FROM Question WHERE sid = %d AND answered = 0 ORDER BY time DESC", $sid);
		}
		elseif ( $sort == "priority" )
		{
			$query = sprintf("SELECT * FROM Question WHERE sid = %d AND answered = 0 ORDER BY numvotes DESC", $sid);
		}
		else
		{
			$query = sprintf("SELECT * FROM Question WHERE sid = %d AND answered = 0", $sid);
		}
		$results = mysql_query($query, $db_conn);
		$rows = array();
		while($r = mysql_fetch_assoc($results))
		{
			$rows[] = array('text'=>$r["text"],'votes'=>$r["numvotes"],'answered'=>$r["answered"],'type'=>'Q');
		}
	}
	elseif ( $filter == "unread" )	// we only want unread feedback
	{
		if ( $sort == "newest" )
		{
			$query = sprintf("SELECT * FROM Feedback WHERE sid = %d AND isread = 0 ORDER BY time DESC", $sid);
		}
		elseif ( $sort == "priority" )
		{
			$query = sprintf("SELECT * FROM Feedback WHERE sid = %d AND isread = 0 ORDER BY numvotes DESC", $sid);
		}
		else
		{
			$query = sprintf("SELECT * FROM Feedback WHERE sid = %d AND isread = 0", $sid);
		}
		$results = mysql_query($query, $db_conn);
		while($r = mysql_fetch_assoc($results))
		{
			$rows[] = array('text'=>$r["text"],'votes'=>$r["numvotes"],'isread'=>$r["isread"],'type'=>'F');
		}
	}
	elseif ( $filter == "read" )	// we only want read feedback
	{
		if ( $sort == "newest" )
		{
			$query = sprintf("SELECT * FROM Feedback WHERE sid = %d AND isread = 1 ORDER BY time DESC", $sid);
		}
		elseif ( $sort == "priority" )
		{
			$query = sprintf("SELECT * FROM Feedback WHERE sid = %d AND isread = 1 ORDER BY numvotes DESC", $sid);
		}
		else
		{
			$query = sprintf("SELECT * FROM Feedback WHERE sid = %d AND isread = 1", $sid);
		}
		$results = mysql_query($query, $db_conn);
		while($r = mysql_fetch_assoc($results))
		{
			$rows[] = array('text'=>$r["text"],'votes'=>$r["numvotes"],'isread'=>$r["isread"],'type'=>'F');
		}
	}
	
	/*
	$query = sprintf("SELECT * FROM Question WHERE sid = %d", $sid);
	$results = mysql_query($query, $db_conn);
	$rows = array();
	while($r = mysql_fetch_assoc($results))
	{
		$rows[] = array('text'=>$r["text"],'votes'=>$r["numvotes"],'answered'=>$r["answered"],'type'=>'Q');
	}
	
	$query = sprintf("SELECT * FROM Feedback WHERE sid = %d", $sid);
	$results = mysql_query($query, $db_conn);
	while($r = mysql_fetch_assoc($results))
	{
		$rows[] = array('text'=>$r["text"],'votes'=>$r["numvotes"],'isread'=>$r["isread"],'type'=>'F');
	}
	*/
	
	
	header('Content-type: application/json');
	echo json_encode($rows);

?>
