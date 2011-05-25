<?php

	// This test suite tests submit_question.php.
	// NOTE: You MUST make sure the database connection parameters
	//	in submit_question.php are the same as those in these tests!
	class testSubmitQuestion extends PHPUnit_Framework_Testcase
	{
		// Test submitting a new question.
		public function testSubmitNewQuestion()
		{
			include 'db_credentials.php';
			
			$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
			if ( !$db_conn )
			{
				die("Could not connect");
			}
			
			mysql_select_db($db_name, $db_conn);
			
			// Wipe the Questions table
			$query = "DELETE FROM Question";
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			
			// Set up parameters for the submission
			$_POST['type'] = 'Q';
			$_POST['numvotes'] = 0;
			$_POST['text'] = 'test question';
			$_POST['sid'] = 23456;
			$_POST['uid'] = 23456;
			
			// Run the script
			include '../../Incognito/students/scripts/submit_question.php';
			
			// If the script worked correctly, this query should return 1 row.
			$query = "SELECT * FROM Question WHERE text = 'test question' AND sid = 23456 AND numvotes = 0";
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			$this->assertEquals(1, mysql_num_rows($results));
		}
		
		// Test submitting a new comment.
		public function testSubmitNewFeedback()
		{
			include 'db_credentials.php';
			
			$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
			if ( !$db_conn )
			{
				die("Could not connect");
			}
			
			mysql_select_db($db_name, $db_conn);
			
			// Wipe the Feedback table
			$query = "DELETE FROM Feedback";
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			
			// Set up parameters for the submission
			$_POST['type'] = 'F';
			$_POST['numvotes'] = 0;
			$_POST['text'] = 'test feedback';
			$_POST['sid'] = 23456;
			$_POST['uid'] = 123;
			
			// Run the script
			include '../../Incognito/students/scripts/submit_question.php';

			// If the script worked correctly, this query should return 1 row.
			$query = "SELECT * FROM Feedback WHERE text = 'test feedback' AND sid = 23456 AND numvotes = 0";
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			$this->assertEquals(1, mysql_num_rows($results));
		}
		
		// Test two different cases:
		//	1. Submit a question that already exists, that the user hasn't already voted for
		//	2. Submit a question that already exists, and that the user has already voted for
		public function testSubmitVoteForExistingQuestion()
		{
			include 'db_credentials.php';
			
			$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
			if ( !$db_conn )
			{
				die("Could not connect");
			}
			
			mysql_select_db($db_name, $db_conn);
			
			// Wipe the Questions table
			$query = "DELETE FROM Question";
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			
			// Insert the question
			$query = "INSERT INTO Question (text, numvotes, answered, sid) VALUES ('test', 2, 0, 23456)";
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			
			// Now set up the script's parameters and run it
			$_POST['type'] = 'Q';
			$_POST['numvotes'] = 0;
			$_POST['text'] = 'test';
			$_POST['sid'] = 23456;
			$_POST['uid'] = 123;
			
			include '../../Incognito/students/scripts/submit_question.php';
			
			// This query checks that the question's vote count is correct, and that there is a row in
			//	QuestionVotedOn that corresponds to the question. It should return 1 row if everything worked.
			$query = "SELECT * FROM Question, QuestionVotedOn WHERE Question.text = 'test' AND Question.sid = 23456 AND Question.numvotes = 3 AND QuestionVotedOn.qid = Question.qid AND QuestionVotedOn.uid = 123";
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			
			// First assertion: voting for a question that the user hasn't already voted for
			$this->assertEquals(1, mysql_num_rows($results));
			
			// Run the script again (i.e. try to submit the same thing twice)
			$_POST['type'] = 'Q';
			$_POST['numvotes'] = 0;
			$_POST['text'] = 'test';
			$_POST['sid'] = 23456;
			$_POST['uid'] = 123;
			
			include '../../Incognito/students/scripts/submit_question.php';
			
			// Since the user has already voted for this question, nothing should have changed since the first assertion.
			//	Verify that this is still the case.
			$query = "SELECT * FROM Question, QuestionVotedOn WHERE Question.text = 'test' AND Question.sid = 23456 AND Question.numvotes = 3 AND QuestionVotedOn.qid = Question.qid AND QuestionVotedOn.uid = 123";
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			
			// Second assertion: voting for a question that the user has already voted for
			$this->assertEquals(1, mysql_num_rows($results));
		}
		
		public function testSubmitVoteForExistingFeedback()
		{
			include 'db_credentials.php';
			
			$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
			if ( !$db_conn )
			{
				die("Could not connect");
			}
			
			mysql_select_db($db_name, $db_conn);
			
			// Wipe the Feedback table
			$query = "DELETE FROM Feedback";
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			
			// Insert the comment
			$query = "INSERT INTO Feedback (text, numvotes, isread, sid) VALUES ('test', 2, 0, 23456)";
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			
			// Set up the script's parameters and run it
			$_POST['type'] = 'F';
			$_POST['numvotes'] = 0;
			$_POST['text'] = 'test';
			$_POST['sid'] = 23456;
			$_POST['uid'] = 123;
			
			include '../../Incognito/students/scripts/submit_question.php';
			
			// This query checks that the comment's vote count is correct, and that there is a row in
			//	FeedbackVotedOn that corresponds to the comment. It should return 1 row if everything worked.
			$query = "SELECT * FROM Feedback, FeedbackVotedOn WHERE Feedback.text = 'test' AND Feedback.sid = 23456 AND Feedback.numvotes = 3 AND FeedbackVotedOn.fid = Feedback.fid AND FeedbackVotedOn.uid = 123";
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			
			// First assertion: voting for a feedback that the user hasn't already voted for
			$this->assertEquals(1, mysql_num_rows($results));
			
			// Run the script again (i.e. try to submit the same thing twice)
			$_POST['type'] = 'F';
			$_POST['numvotes'] = 0;
			$_POST['text'] = 'test';
			$_POST['sid'] = 23456;
			$_POST['uid'] = 123;
			
			include '../../Incognito/students/scripts/submit_question.php';
			
			// Since the user has already voted for this comment, nothing should have changed since the first assertion.
			//	Verify that this is still the case.
			$query = "SELECT * FROM Feedback, FeedbackVotedOn WHERE Feedback.text = 'test' AND Feedback.sid = 23456 AND Feedback.numvotes = 3 AND FeedbackVotedOn.fid = Feedback.fid AND FeedbackVotedOn.uid = 123";
			$results = mysql_query($query, $db_conn);
			if (!$results)
			{
				die("Error: " . mysql_error($db_conn));
			}
			
			// Second assertion: voting for a comment that the user has already voted for
			$this->assertEquals(1, mysql_num_rows($results));
		}
	}

?>
