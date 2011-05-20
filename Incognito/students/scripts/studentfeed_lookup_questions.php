<?php

	// This file looks up all questions associated with a given session. It's designed to
	// be used with the student feed, so it accepts an additional parameter (the student's alias)
	// and returns a flag indicating whether the student has voted for a given question or feedback
	// instead of the total votes.

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
	$username = $_POST['username'];
    
    // echo $sort;
	
	// Do a preliminary query to get the student's user ID for later use
	$uidquery = sprintf("SELECT uid FROM Student WHERE alias = '%s'", $username);
	$uidresult = mysql_query($uidquery, $db_conn);
	$uidrow = mysql_fetch_assoc($uidresult);
	$uid = (int)$uidrow["uid"];
  
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
		while($r = mysql_fetch_assoc($results))
		{
			$qid = (int)$r["qid"];
      // echo $qid;
      
			// Query QuestionVotedOn to see if the user has voted for this question
			$votequery = sprintf("SELECT * FROM QuestionVotedOn WHERE qid = %d AND uid = %d", $qid, $uid);
			$voteresults = mysql_query($votequery, $db_conn);
			$voted = 0;
			if ($vr = mysql_fetch_assoc($voteresults))
			{
				// If the query returns anything, the user has voted for this question
				$voted = 1;
			}
			$feed[] = array('voted'=>$voted,'text'=>$r["text"],'answered'=>$r["answered"],'type'=>'Q','id'=>$r["qid"]);
		}
		
		// Query the Feedback table and fetch results
		$results = mysql_query($query2, $db_conn);
		while($r = mysql_fetch_assoc($results))
		{
			$fid = (int)$r["fid"];
      // echo $fid;
      
			// Query FeedbackVotedOn to see if the user has voted for this feedback
			$votequery = sprintf("SELECT * FROM FeedbackVotedOn WHERE fid = %d AND uid = %d", $fid, $uid);
			$voteresults = mysql_query($votequery, $db_conn);
			$voted = 0;
			if ($vr = mysql_fetch_assoc($voteresults))
			{
				// If the query returns anything, the user has voted for this feedback
				$voted = 1;
			}
			$feed[] = array('voted'=>$voted,'text'=>$r["text"],'isread'=>$r["isread"],'type'=>'F','id'=>$r["fid"]);
		}
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
		while($r = mysql_fetch_assoc($results))
		{
			$qid = (int)$r["qid"];
			
			// Query QuestionVotedOn to see if the user has voted for this question
			$votequery = sprintf("SELECT * FROM QuestionVotedOn WHERE qid = %d AND uid = %d", $qid, $uid);
			$voteresults = mysql_query($votequery, $db_conn);
			$voted = 0;
			if ($vr = mysql_fetch_assoc($voteresults))
			{
				// If the query returns anything, the user has voted for this question
				$voted = 1;
			}
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
		while($r = mysql_fetch_assoc($results))
		{
			$fid = (int)$r["fid"];
      // echo $fid;
      
			// Query FeedbackVotedOn to see if the user has voted for this feedback
			$votequery = sprintf("SELECT * FROM FeedbackVotedOn WHERE fid = %d AND uid = %d", $fid, $uid);
			$voteresults = mysql_query($votequery, $db_conn);
			$voted = 0;
			if ($vr = mysql_fetch_assoc($voteresults))
			{
				// If the query returns anything, the user has voted for this feedback
				$voted = 1;
			}
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
		$feed = array();
		while($r = mysql_fetch_assoc($results))
		{
			$qid = (int)$r["qid"];
			
			// Query QuestionVotedOn to see if the user has voted for this question
			$votequery = sprintf("SELECT * FROM QuestionVotedOn WHERE qid = %d AND uid = %d", $qid, $uid);
			$voteresults = mysql_query($votequery, $db_conn);
			$voted = 0;
			if ($vr = mysql_fetch_assoc($voteresults))
			{
				// If the query returns anything, the user has voted for this question
				$voted = 1;
			}
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
		$feed = array();
		while($r = mysql_fetch_assoc($results))
		{
			$qid = (int)$r["qid"];
			
			// Query QuestionVotedOn to see if the user has voted for this question
			$votequery = sprintf("SELECT * FROM QuestionVotedOn WHERE qid = %d AND uid = %d", $qid, $uid);
			$voteresults = mysql_query($votequery, $db_conn);
			$voted = 0;
			if ($vr = mysql_fetch_assoc($voteresults))
			{
				// If the query returns anything, the user has voted for this question
				$voted = 1;
			}
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
		while($r = mysql_fetch_assoc($results))
		{
			$fid = (int)$r["fid"];
      // echo $fid;
      
			// Query FeedbackVotedOn to see if the user has voted for this feedback
			$votequery = sprintf("SELECT * FROM FeedbackVotedOn WHERE fid = %d AND uid = %d", $fid, $uid);
			$voteresults = mysql_query($votequery, $db_conn);
			$voted = 0;
			if ($vr = mysql_fetch_assoc($voteresults))
			{
				// If the query returns anything, the user has voted for this feedback
				$voted = 1;
			}
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
		while($r = mysql_fetch_assoc($results))
		{
			$fid = (int)$r["fid"];
      // echo $fid;
      
			// Query FeedbackVotedOn to see if the user has voted for this feedback
			$votequery = sprintf("SELECT * FROM FeedbackVotedOn WHERE fid = %d AND uid = %d", $fid, $uid);
			$voteresults = mysql_query($votequery, $db_conn);
			$voted = 0;
			if ($vr = mysql_fetch_assoc($voteresults))
			{
				// If the query returns anything, the user has voted for this feedback
				$voted = 1;
			}
			$feed[] = array('voted'=>$voted,'text'=>$r["text"],'isread'=>$r["isread"],'type'=>'F','id'=>$r["fid"]);
		}
	}
  
    echo $feed[0][0];
	
  
	/*
	$query = sprintf("SELECT * FROM Question WHERE sid = %d", $sid);
	$results = mysql_query($query, $db_conn);
	$rows = array();
	while($r = mysql_fetch_assoc($results))
	{
		$rows[] = array('text'=>$r["text"],'votes'=>$r["numvotes"],'answered'=>$r["answered"],'type'=>'Q','id'=>$r["qid"]);
	}
	
	$query = sprintf("SELECT * FROM Feedback WHERE sid = %d", $sid);
	$results = mysql_query($query, $db_conn);
	while($r = mysql_fetch_assoc($results))
	{
		$rows[] = array('text'=>$r["text"],'votes'=>$r["numvotes"],'isread'=>$r["isread"],'type'=>'F','id'=>$r["fid"]);
	}
	*/

    // Prints the feed data in a nice html format
    // 1 => indicates that the attribute is true

    echo "<table id=feedTable>";

    for($row = 0; $row < 200; $row++) {

        if(!empty($feed[$row])) {

            // Alternate the CSS style every other row
            if($feed[$row]["type"] == 'Q')
                echo "<tr class=alt>";
            else
                echo "<tr>";

            // Prints the Voted checkboxes on the left column
            if($feed[$row]["voted"] == 1)
                echo "<td class=checked><input class=check type=checkbox id=check_".$feed[$row]["type"].$feed[$row]["id"]." checked=true /></td>";
            else
                echo "<td class=checked><input class=check type=checkbox id=check_".$feed[$row]["type"].$feed[$row]["id"]." /></td>";

            // Prints the feed in the middle column
            echo "<td class=feed>".$feed[$row]["text"]."</td>";

            // Prints the Answered attribute on the right column
            if($feed[$row]["type"] == 'Q') {
                if(!empty($feed[$row]["answered"]))
                    echo "<td class=answered>Yes</td>";
                else
                	echo "<td class=answered>No</td>";

            // Prints the IsRead attribute on the right column
            } elseif($feed[$row]["type"] == 'F') {
                if(!empty($feed[$row]["isread"]))
                    echo "<td class=answered>Yes</td>";
				else
                    echo "<td class=answered>No</td>";
            }
                                
            echo "</tr>";
        }
    }
    echo "</table>";

?>
	
