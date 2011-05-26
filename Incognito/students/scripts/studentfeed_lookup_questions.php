<?php
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
	
	function hasVoted($type, $id, $uid, $db_conn)
	{
		$voted = 0;
		$votequery = null;
		if ($type == 'Q')
		{
			// Query QuestionVotedOn to see if the user has voted for this question
			$votequery = sprintf("SELECT * FROM QuestionVotedOn WHERE qid = %d AND uid = %d", $id, $uid);
		}
		else
		{
			// Query FeedbackVotedOn to see if the user has voted for this feedback
			$votequery = sprintf("SELECT * FROM FeedbackVotedOn WHERE fid = %d AND uid = %d", $id, $uid);
		}
		
		$voteresults = mysql_query($votequery, $db_conn);
		if (!$voteresults)
		{
			die("Error: " . mysql_error($db_conn));
		}
		
		if ($vr = mysql_fetch_assoc($voteresults))
		{
			// If the query returns anything, the user has voted for this question or feedback
			$voted = 1;
		}
		
		return $voted;
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

	function getQuestions($sid, $filter, $sort, $uid)
	{
		$db_conn = connectToDB(); 
		
		$uid;
        if(isset($_POST['sid']))
            $uid = $_POST['uid'];
	  
		$feed = array();
		$query = null;
		
		// There are seven filtering options and three sorting options. Each combination
		// of these options needs to be handled differently. 
		if ( $filter == "None" )	// no filtering, so query both Question and Feedback
		{
			// Get results sorted by timestamp in descending order
			// echo "Filter By: None</br>";
			$query1 = null;
			$query2 = null;
			if ( $sort == "Newest" )
			{
				// echo "Sorting by: Newest</br>";
				$query1 = sprintf("SELECT * FROM Question WHERE sid = %d ORDER BY time DESC", $sid);
				$query2 = sprintf("SELECT * FROM Feedback WHERE sid = %d ORDER BY time DESC", $sid);
			}
			elseif ( $sort == "Priority" )
			{
				// Get results sorted by the number of votes in descending order
				// echo "Sorting by: Priority</br>";
				$query1 = sprintf("SELECT * FROM Question WHERE sid = %d ORDER BY numvotes DESC", $sid);
				$query2 = sprintf("SELECT * FROM Feedback WHERE sid = %d ORDER BY numvotes DESC", $sid);
			}
			else
			{
				// No sorting specified
				// echo "Sorting by: None</br>";
				$query1 = sprintf("SELECT * FROM Question WHERE sid = %d", $sid);
				$query2 = sprintf("SELECT * FROM Feedback WHERE sid = %d", $sid);
			}
			
			// Query the Question table and fetch results
			$results = mysql_query($query1, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			while($r = mysql_fetch_assoc($results))
			{
				$qid = (int)$r["qid"];
				$voted = hasVoted('Q', $qid, $uid, $db_conn);
				
				$feed[] = array('voted'=>$voted,'text'=>$r["text"],'answered'=>$r["answered"],'type'=>'Q','id'=>$r["qid"],'numvotes'=>$r["numvotes"],'time'=>$r["time"]);
			}
			
			// Query the Feedback table and fetch results
			$results = mysql_query($query2, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			while($r = mysql_fetch_assoc($results))
			{
				$fid = (int)$r["fid"];
				$voted = hasVoted('F', $fid, $uid, $db_conn);
				
				$feed[] = array('voted'=>$voted,'text'=>$r["text"],'isread'=>$r["isread"],'type'=>'F','id'=>$r["fid"],'numvotes'=>$r["numvotes"],'time'=>$r["time"]);
			}
			
			$feed = sortResults($feed, $sort);
		}
		elseif ( $filter == "All Questions" )	// we only want questions
		{
			// echo "Filter By: All Questions</br>";
			if ( $sort == "Newest" )
			{
				// Get results sorted by timestamp in descending order
				// echo "Sort By: Newest</br>";
				$query = sprintf("SELECT * FROM Question WHERE sid = %d ORDER BY time DESC", $sid);
			}
			elseif ( $sort == "Priority" )
			{
				// Get results sorted by the number of votes in descending order
				// echo "Sort By: Priority</br>";
				$query = sprintf("SELECT * FROM Question WHERE sid = %d ORDER BY numvotes DESC", $sid);
			}
			else
			{
				// No sorting specified
				// echo "Sort By: None</br>";
				$query = sprintf("SELECT * FROM Question WHERE sid = %d", $sid);
			}
			
			// Run the query and fetch the results
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			while($r = mysql_fetch_assoc($results))
			{
				$qid = (int)$r["qid"];
				$voted = hasVoted('Q', $qid, $uid, $db_conn);
				
				$feed[] = array('voted'=>$voted,'text'=>$r["text"],'answered'=>$r["answered"],'type'=>'Q','id'=>$r["qid"]);
			}
		}
		elseif ( $filter == "All Feedback" )	// we only want feedback
		{
			// echo "Filter By: All Feedback</br>";
			if ( $sort == "Newest" )
			{
				// Get results sorted by timestamp in descending order
				// echo "Sort By: Newest</br>";
				$query = sprintf("SELECT * FROM Feedback WHERE sid = %d ORDER BY time DESC", $sid);
			}
			elseif ( $sort == "Priority" )
			{
				// Get results sorted by the number of votes in descending order
				// echo "Sort By: Priority</br>";
				$query = sprintf("SELECT * FROM Feedback WHERE sid = %d ORDER BY numvotes DESC", $sid);
			}
			else
			{
				// No sorting specified
				// echo "Sort By: None</br>";
				$query = sprintf("SELECT * FROM Feedback WHERE sid = %d", $sid);
			}
			
			
			// Run the query and fetch the results
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			while($r = mysql_fetch_assoc($results))
			{
				$fid = (int)$r["fid"];
				$voted = hasVoted('F', $qid, $uid, $db_conn);
				
				$feed[] = array('voted'=>$voted,'text'=>$r["text"],'isread'=>$r["isread"],'type'=>'F','id'=>$r["fid"]);
			}
		}
		elseif ( $filter == "Answered" )	// we only want answered questions
		{
			// echo "Filter By: Answered</br>";
			if ( $sort == "Newest" )
			{
				// Get results sorted by timestamp in descending order
				// echo "Sort By: Answered</br>";
				$query = sprintf("SELECT * FROM Question WHERE sid = %d AND answered = 1 ORDER BY time DESC", $sid);
			}
			elseif ( $sort == "Priority" )
			{
				// Get results sorted by the number of votes in descending order
				// echo "Sort By: Priority</br>";
				$query = sprintf("SELECT * FROM Question WHERE sid = %d AND answered = 1 ORDER BY numvotes DESC", $sid);
			}
			else
			{
				// No sorting specified
				// echo "Sort By: None</br>";
				$query = sprintf("SELECT * FROM Question WHERE sid = %d AND answered = 1", $sid);
			}
			
			// Run the query and fetch the results
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			while($r = mysql_fetch_assoc($results))
			{
				$qid = (int)$r["qid"];
				$voted = hasVoted('Q', $qid, $uid, $db_conn);
				
				$feed[] = array('voted'=>$voted,'text'=>$r["text"],'answered'=>$r["answered"],'type'=>'Q','id'=>$r["qid"]);
			}
		}
		elseif ( $filter == "Unanswered" )	// we only want unanswered questions
		{
			// echo "Filter By: Unanswered</br>";
			if ( $sort == "Newest" )
			{
				// Get results sorted by timestamp in descending order
				// echo "Sort By: Newest</br>";
				$query = sprintf("SELECT * FROM Question WHERE sid = %d AND answered = 0 ORDER BY time DESC", $sid);
			}
			elseif ( $sort == "Priority" )
			{
				// Get results sorted by the number of votes in descending order
				// echo "Sort By: Priority</br>";
				$query = sprintf("SELECT * FROM Question WHERE sid = %d AND answered = 0 ORDER BY numvotes DESC", $sid);
			}
			else
			{
				// No sorting specified
				// echo "Sort By: None</br>";
				$query = sprintf("SELECT * FROM Question WHERE sid = %d AND answered = 0", $sid);
			}
			
			// Run the query and fetch the results
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			while($r = mysql_fetch_assoc($results))
			{
				$qid = (int)$r["qid"];
				$voted = hasVoted('Q', $qid, $uid, $db_conn);
				
				$feed[] = array('voted'=>$voted,'text'=>$r["text"],'answered'=>$r["answered"],'type'=>'Q','id'=>$r["qid"]);
			}
		}
		elseif ( $filter == "Unread" )	// we only want unread feedback
		{
			// echo "Filter By: Unread</br>";
			if ( $sort == "Newest" )
			{
				// Get results sorted by timestamp in descending order
				// echo "Sort By: Newest</br>";
				$query = sprintf("SELECT * FROM Feedback WHERE sid = %d AND isread = 0 ORDER BY time DESC", $sid);
			}
			elseif ( $sort == "Priority" )
			{
				// Get results sorted by the number of votes in descending order
				// echo "Sort By: Priority</br>";
				$query = sprintf("SELECT * FROM Feedback WHERE sid = %d AND isread = 0 ORDER BY numvotes DESC", $sid);
			}
			else
			{
				// No sorting specified
				// echo "Sort By: None</br>";
				$query = sprintf("SELECT * FROM Feedback WHERE sid = %d AND isread = 0", $sid);
			}
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			while($r = mysql_fetch_assoc($results))
			{
				$fid = (int)$r["fid"];
				$voted = hasVoted('F', $fid, $uid, $db_conn);
				
				$feed[] = array('voted'=>$voted,'text'=>$r["text"],'isread'=>$r["isread"],'type'=>'F','id'=>$r["fid"]);
			}
		}
		elseif ( $filter == "Read" )	// we only want read feedback
		{
			// echo "Filter By: Read</br>";
			if ( $sort == "Newest" )
			{
				// Get results sorted by timestamp in descending order
				// echo "Sort By: Newest</br>";
				$query = sprintf("SELECT * FROM Feedback WHERE sid = %d AND isread = 1 ORDER BY time DESC", $sid);
			}
			elseif ( $sort == "Priority" )
			{
				// Get results sorted by the number of votes in descending order
				// echo "Sort By: Priority</br>";
				$query = sprintf("SELECT * FROM Feedback WHERE sid = %d AND isread = 1 ORDER BY numvotes DESC", $sid);
			}
			else
			{
				// No sorting specified
				// echo "Sort By: None</br>";
				$query = sprintf("SELECT * FROM Feedback WHERE sid = %d AND isread = 1", $sid);
			}
			
			// Run the query and fetch the results
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			while($r = mysql_fetch_assoc($results))
			{
				$fid = (int)$r["fid"];
				$voted = hasVoted('F', $fid, $uid, $db_conn);
				
				$feed[] = array('voted'=>$voted,'text'=>$r["text"],'isread'=>$r["isread"],'type'=>'F','id'=>$r["fid"]);
			}
		}
	  
		mysql_close($db_conn);
		return $feed;
	}
	
	function echoTable($feed)
	{
		echo $feed[0][0];

		// Prints the feed data in a nice html format
		echo "<table id=feedTable>";
		for($row = 0; $row < 200; $row++) {
			if(!empty($feed[$row])) {
				if($feed[$row]["type"] == 'Q')
					echo "<tr class=alt>";
				else
					echo "<tr>";

				if($feed[$row]["voted"] == 1)
					echo "<td class=checked><input class=check type=checkbox id=check_".$feed[$row]["type"].$feed[$row]["id"]." checked=true /></td>";
				else
					echo "<td class=checked><input class=check type=checkbox id=check_".$feed[$row]["type"].$feed[$row]["id"]." /></td>";
				echo "<td class=feed>".$feed[$row]["text"]."</td>";
			if(($feed[$row]["type"] == 'Q' && $feed[$row]["answered"] == 1) ||
			($feed[$row]["type"] == 'F' && $feed[$row]["isread"] == 1))
			{
			echo "<td class=answered>Yes</td>";
			}
			else
			{
			echo "<td class=answered>No</td>";
			}
				//echo "<td class=answered>".$feed[$row]["answered"]."</td>";
				echo "</tr>";
			}
		}
		echo "</table>";
	}

	if (isset($_POST['sid']) && isset($_POST['filter']) && isset($_POST['sort']) && isset($_POST['uid']))
	{
		$sid = $_POST['sid'];
		$filter = $_POST['filter'];		
		$sort = $_POST['sort'];
		$uid = $_POST['uid'];
		$feed = getQuestions($sid, $filter, $sort, $uid);
		echoTable($feed);
	}
?>
	
