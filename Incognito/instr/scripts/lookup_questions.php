<?php

	// This file looks up all questions associated with a given session. It's designed for
	// the instructor feed, so it doesn't accept a username parameter, and it returns
	// the total votes for each question or feedback.

	function connectToDB()
	{
		// Connect to the database

		include '../../db_credentials.php';

		$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
	 
		if (!$db_conn) {
			die("Failed to connect to the mysql server"); 
		}

		mysql_select_db($db_name, $db_conn);
		return $db_conn;
	}
	
	function sortResults($feed, $sort)
	{
		if ($sort == "Newest")
		{
			foreach ($feed as $key => $row)
			{
				$time[$key] = $row['time'];
			}
			array_multisort($time, SORT_DESC, $feed);
		}
		elseif ($sort == "Priority")
		{
			foreach ($feed as $key => $row)
			{
				$numvotes[$key] = $row['numvotes'];
			}
			array_multisort($numvotes, SORT_DESC, $feed);
		}
		return $feed;
	}
	
	function getQuestions($sid, $filter, $sort)
	{
		$db_conn = connectToDB();
		
		$rows = array();
		$query = null;
		
		// There are seven filtering options and three sorting options. Each combination
		// of these options needs to be handled differently. 
		if ( $filter == "None" )	// no filtering, so query both Question and Feedback
		{
			$query1 = null;
			$query2 = null;
			if ( $sort == "Newest" )
			{
				// Get results sorted by timestamp in descending order
				$query1 = sprintf("SELECT * FROM Question WHERE sid = %d ORDER BY time DESC", $sid);
				$query2 = sprintf("SELECT * FROM Feedback WHERE sid = %d ORDER BY time DESC", $sid);
			}
			elseif ( $sort == "Priority" )
			{
				// Get results sorted by the number of votes in descending order
				$query1 = sprintf("SELECT * FROM Question WHERE sid = %d ORDER BY numvotes DESC", $sid);
				$query2 = sprintf("SELECT * FROM Feedback WHERE sid = %d ORDER BY numvotes DESC", $sid);
			}
			else
			{
				// No sorting specified
				$query1 = sprintf("SELECT * FROM Question WHERE sid = %d", $sid);
				$query2 = sprintf("SELECT * FROM Feedback WHERE sid = %d", $sid);
			}
			
			// Query the Question table and fetch results
			$results = mysql_query($query1, $db_conn);
			while($r = mysql_fetch_assoc($results))
			{
				$rows[] = array('text'=>$r["text"],'votes'=>$r["numvotes"],'answered'=>$r["answered"],'type'=>'Q','id'=>$r["qid"],'numvotes'=>$r["numvotes"],'time'=>$r["time"]);
			}
			
			// Query the Feedback table and fetch results
			$results = mysql_query($query2, $db_conn);
			while($r = mysql_fetch_assoc($results))
			{
				$rows[] = array('text'=>$r["text"],'votes'=>$r["numvotes"],'isread'=>$r["isread"],'type'=>'F','id'=>$r["fid"],'numvotes'=>$r["numvotes"],'time'=>$r["time"]);
			}
			
			$rows = sortResults($rows);
		}
		elseif ( $filter == "All Questions" )	// we only want questions
		{
			if ( $sort == "Newest" )
			{
				// Get results sorted by timestamp in descending order
				$query = sprintf("SELECT * FROM Question WHERE sid = %d ORDER BY time DESC", $sid);
			}
			elseif ( $sort == "Priority" )
			{
				// Get results sorted by the number of votes in descending order
				$query = sprintf("SELECT * FROM Question WHERE sid = %d ORDER BY numvotes DESC", $sid);
			}
			else
			{
				// No sorting specified
				$query = sprintf("SELECT * FROM Question WHERE sid = %d", $sid);
			}
			
			// Run the query and fetch the results
			$results = mysql_query($query, $db_conn);
			while($r = mysql_fetch_assoc($results))
			{
				$rows[] = array('text'=>$r["text"],'votes'=>$r["numvotes"],'answered'=>$r["answered"],'type'=>'Q','id'=>$r["qid"]);
			}
		}
		elseif ( $filter == "All Feedback" )	// we only want feedback
		{
			if ( $sort == "Newest" )
			{
				// Get results sorted by timestamp in descending order
				$query = sprintf("SELECT * FROM Feedback WHERE sid = %d ORDER BY time DESC", $sid);
			}
			elseif ( $sort == "Priority" )
			{
				// Get results sorted by the number of votes in descending order
				$query = sprintf("SELECT * FROM Feedback WHERE sid = %d ORDER BY numvotes DESC", $sid);
			}
			else
			{
				// No sorting specified
				$query = sprintf("SELECT * FROM Feedback WHERE sid = %d", $sid);
			}
			
			// Run the query and fetch the results
			$results = mysql_query($query, $db_conn);
			while($r = mysql_fetch_assoc($results))
			{
				$rows[] = array('text'=>$r["text"],'votes'=>$r["numvotes"],'isread'=>$r["isread"],'type'=>'F','id'=>$r["fid"]);
			}
		}
		elseif ( $filter == "Answered" )	// we only want answered questions
		{
			if ( $sort == "Newest" )
			{
				// Get results sorted by timestamp in descending order
				$query = sprintf("SELECT * FROM Question WHERE sid = %d AND answered = 1 ORDER BY time DESC", $sid);
			}
			elseif ( $sort == "Priority" )
			{
				// Get results sorted by the number of votes in descending order
				$query = sprintf("SELECT * FROM Question WHERE sid = %d AND answered = 1 ORDER BY numvotes DESC", $sid);
			}
			else
			{
				// No sorting specified
				$query = sprintf("SELECT * FROM Question WHERE sid = %d AND answered = 1", $sid);
			}
			
			// Run the query and fetch the results
			$results = mysql_query($query, $db_conn);
			$rows = array();
			while($r = mysql_fetch_assoc($results))
			{
				$rows[] = array('text'=>$r["text"],'votes'=>$r["numvotes"],'answered'=>$r["answered"],'type'=>'Q','id'=>$r["qid"]);
			}
		}
		elseif ( $filter == "Unanswered" )	// we only want unanswered questions
		{
			if ( $sort == "Newest" )
			{
				// Get results sorted by timestamp in descending order
				$query = sprintf("SELECT * FROM Question WHERE sid = %d AND answered = 0 ORDER BY time DESC", $sid);
			}
			elseif ( $sort == "Priority" )
			{
				// Get results sorted by the number of votes in descending order
				$query = sprintf("SELECT * FROM Question WHERE sid = %d AND answered = 0 ORDER BY numvotes DESC", $sid);
			}
			else
			{
				// No sorting specified
				$query = sprintf("SELECT * FROM Question WHERE sid = %d AND answered = 0", $sid);
			}
			
			// Run the query and fetch the results
			$results = mysql_query($query, $db_conn);
			$rows = array();
			while($r = mysql_fetch_assoc($results))
			{
				$rows[] = array('text'=>$r["text"],'votes'=>$r["numvotes"],'answered'=>$r["answered"],'type'=>'Q','id'=>$r["qid"]);
			}
		}
		elseif ( $filter == "Unread" )	// we only want unread feedback
		{
			if ( $sort == "Newest" )
			{
				// Get results sorted by timestamp in descending order
				$query = sprintf("SELECT * FROM Feedback WHERE sid = %d AND isread = 0 ORDER BY time DESC", $sid);
			}
			elseif ( $sort == "Priority" )
			{
				// Get results sorted by the number of votes in descending order
				$query = sprintf("SELECT * FROM Feedback WHERE sid = %d AND isread = 0 ORDER BY numvotes DESC", $sid);
			}
			else
			{
				// No sorting specified
				$query = sprintf("SELECT * FROM Feedback WHERE sid = %d AND isread = 0", $sid);
			}
			
			// Run the query and fetch the results
			$results = mysql_query($query, $db_conn);
			while($r = mysql_fetch_assoc($results))
			{
				$rows[] = array('text'=>$r["text"],'votes'=>$r["numvotes"],'isread'=>$r["isread"],'type'=>'F','id'=>$r["fid"]);
			}
		}
		elseif ( $filter == "Read" )	// we only want read feedback
		{
			if ( $sort == "Newest" )
			{
				// Get results sorted by timestamp in descending order
				$query = sprintf("SELECT * FROM Feedback WHERE sid = %d AND isread = 1 ORDER BY time DESC", $sid);
			}
			elseif ( $sort == "Priority" )
			{
				// Get results sorted by the number of votes in descending order
				$query = sprintf("SELECT * FROM Feedback WHERE sid = %d AND isread = 1 ORDER BY numvotes DESC", $sid);
			}
			else
			{
				// No sorting specified
				$query = sprintf("SELECT * FROM Feedback WHERE sid = %d AND isread = 1", $sid);
			}
			
			// Run the query and fetch the results
			$results = mysql_query($query, $db_conn);
			while($r = mysql_fetch_assoc($results))
			{
				$rows[] = array('text'=>$r["text"],'votes'=>$r["numvotes"],'isread'=>$r["isread"],'type'=>'F','id'=>$r["fid"]);
			}
		}
		
		mysql_close($db_conn);
		return $rows;
	}
	
	function echoTable($rows)
	{
		// Prints out the feed data in a nice html format
		echo "<table id=feedTable>";
		for($row = 0; $row < 200; $row++) {
			if(!empty($rows[$row])) {
				if($rows[$row]["type"] == "Q")
					echo "<tr class=alt>";
				else
					echo "<tr>";
				echo "<td class=votes>".$rows[$row]["votes"]."</td>";
				echo "<td class=feed>".$rows[$row]["text"]."</td>";
				if($rows[$row]["answered"] == 1 || $rows[$row]["isread"] == 1)
					echo "<td class=checked><input class=check type=checkbox id=check_".$rows[$row]["type"].$rows[$row]["id"]." checked=true /></td>";
				else
					echo "<td class=checked><input class=check type=checkbox id=check_".$rows[$row]["type"].$rows[$row]["id"]."/></td>";
				echo "</tr>";
			}
		}
		echo "</table>";
	}
	
	if (isset($_POST['sid']) && isset($_POST['filter']) && isset($_POST['sort']))
	{
		$sid = $_POST['sid'];
		$filter = $_POST['filter'];
		$sort = $_POST['sort'];
		$rows = getQuestions($sid, $filter, $sort);
		echoTable($rows);
	}
?>
