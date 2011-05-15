<?php

	// This file looks up all questions associated with a given session. It's designed for
	// the instructor feed, so it doesn't accept a username parameter, and it returns
	// the total votes for each question or feedback.

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
	if ( $filter == "None" )	// no filtering, so query both Question and Feedback
	{
		$query1 = null;
		$query2 = null;
		if ( $sort == "Newest" )
		{
			$query1 = sprintf("SELECT * FROM Question WHERE sid = %d ORDER BY time DESC", $sid);
			$query2 = sprintf("SELECT * FROM Feedback WHERE sid = %d ORDER BY time DESC", $sid);
		}
		elseif ( $sort == "Priority" )
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
	elseif ( $filter == "All Questions" )	// we only want questions
	{
		if ( $sort == "Newest" )
		{
			$query = sprintf("SELECT * FROM Question WHERE sid = %d ORDER BY time DESC", $sid);
		}
		elseif ( $sort == "Priority" )
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
	elseif ( $filter == "All Feedback" )	// we only want feedback
	{
		if ( $sort == "Newest" )
		{
			$query = sprintf("SELECT * FROM Feedback WHERE sid = %d ORDER BY time DESC", $sid);
		}
		elseif ( $sort == "Priority" )
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
	elseif ( $filter == "Answered" )	// we only want answered questions
	{
		if ( $sort == "Newest" )
		{
			$query = sprintf("SELECT * FROM Question WHERE sid = %d AND answered = 1 ORDER BY time DESC", $sid);
		}
		elseif ( $sort == "Priority" )
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
	elseif ( $filter == "Unanswered" )	// we only want unanswered questions
	{
		if ( $sort == "Newest" )
		{
			$query = sprintf("SELECT * FROM Question WHERE sid = %d AND answered = 0 ORDER BY time DESC", $sid);
		}
		elseif ( $sort == "Priority" )
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
	elseif ( $filter == "Unread" )	// we only want unread feedback
	{
		if ( $sort == "Newest" )
		{
			$query = sprintf("SELECT * FROM Feedback WHERE sid = %d AND isread = 0 ORDER BY time DESC", $sid);
		}
		elseif ( $sort == "Priority" )
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
	elseif ( $filter == "Read" )	// we only want read feedback
	{
		if ( $sort == "Newest" )
		{
			$query = sprintf("SELECT * FROM Feedback WHERE sid = %d AND isread = 1 ORDER BY time DESC", $sid);
		}
		elseif ( $sort == "Priority" )
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
	
	
	//header('Content-type: application/json');
	//echo json_encode($rows);
	
	//$rows[] = array('text'=>$r["text"],'votes'=>$r["numvotes"],'isread'=>$r["isread"],'type'=>'F');
    
    // Prints out the feed data in a nice html format
    echo "<table id=feedTable>";
    for($row = 0; $row < 3; $row++) {
        if(!empty($rows[$row])) {
            if($row % 2 == 1)
                echo "<tr class=alt>";
            else
                echo "<tr>";
            echo "<td class=votes>".$rows[$row]["votes"]."</td>";
            echo "<td class=feed>".$rows[$row]["text"]."</td>";
            if($feed[$row]["answered"] == 1)
                echo "<td class=checked><input type=checkbox id=check checked=true /></td>";
            else
                echo "<td class=checked><input type=checkbox id=check /></td>";
            echo "</tr>";
        }
    }
    echo "</table>";

?>
