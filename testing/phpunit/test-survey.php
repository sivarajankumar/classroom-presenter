<?php

	// This test file tests all of the functionality associated with 
	// surveys. This includes opening, closing, and creating surveys. 
	class testSurvey extends PHPUnit_Framework_TestCase
	{
    
        public function testSurvey() {
            
            // Connect to DB
			include '../../db_credentials.php';
            
            $db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
            if (!$db_conn) {
                die("Could not connect");
            }
            
            mysql_select_db($db_name, $db_conn);

            // Insert the User
			$query1 = "INSERT INTO User (email) VALUES ('test')";
			$results1 = mysql_query($query1, $db_conn);
				
			// Error check
			if (!$results1) {
				die("Error: " + mysql_error($db_conn));
			}
            
            // Getting the the most recent user added
            $query = "SELECT uid FROM User WHERE email = 'test' ORDER BY uid DESC;";
			$results = mysql_query($query, $db_conn);

            // Do some more error checking
            if (!$results) {
                die("Error: " + mysql_error($db_conn));
            }
          
            $row = mysql_fetch_row($results);
            
            $uid = $row[0];
            
            // Insert the Course
			$query1 = "INSERT INTO Course (name, mailingList) VALUES ('test', 'testmail');";
			$results1 = mysql_query($query1, $db_conn);
				
			// Error check
			if (!$results1) {
				die("Error: " + mysql_error($db_conn));
			}
            
            // Getting the the most recent course added
            $query = "SELECT cid FROM Course WHERE name='test' and mailingList='testmail';";
            $results = mysql_query($query, $db_conn);
            
            // Do some more error checking
            if (!$results) {
                die("Error: " + mysql_error($db_conn));
            }
            
            $row = mysql_fetch_row($results);
            
            $cid = $row[0];
            
			// Insert a new session
			$query1 = sprintf("INSERT INTO Session (cid, uid, open) VALUES (%d, %d, %d);", $cid, $uid, 0);
			$results1 = mysql_query($query1, $db_conn);
				
			// Error check
			if (!$results1) {
				die("Error: " + mysql_error($db_conn));
			}

            // Check the session
            // Getting the the most session
            $query = sprintf("SELECT sid FROM Session WHERE cid=%d and uid=%d;", $cid, $uid);
            $results = mysql_query($query, $db_conn);
            
            // Do some more error checking
            if (!$results) {
                die("Error: " + mysql_error($db_conn));
            }
			
			$row = mysql_fetch_row($results);
            
            $session = $row[0];
            
            //test cases
            $text1 = "Question1";
            $text2 = "";
            $text3 = "REALLLLYYY LLLONNNNGGG QUUUUUESTTTTIOOOOOONNNN";
            
            // Testing Creating a Multiple-Choice Survey ----------------------->>>>
            
            //Add first test case
            
            $_POST['sid'] = $session;
            $_POST['text'] = $text1;
            $_POST['type'] = "mc";
            $choices = array('choice1', 'choice2', 'choice3', 'choice4');
            $_POST['choices'] = json_encode($choices);
            include '../../Incognito/instr/scripts/create_survey.php';
            
            // Testing for $test1
            // Getting the the most recent survey added
            $query = sprintf("SELECT sid, text FROM MultipleChoice WHERE text = '%s' ORDER BY sid DESC;", $text1);
            $results = mysql_query($query, $db_conn);
            
            // Do some more error checking
            if (!$results) {
                die("Error: " + mysql_error($db_conn));
            }
				
			$row = mysql_fetch_row($results);
            $sid1 = $row[0];
            //Assert that the text is the same
			$this->assertEquals($text1, $row[1]);
            
            //Add second test case
            
            $_POST['sid'] = $session;
            $_POST['text'] = $text2;
            $_POST['type'] = "mc";
            $_POST['choices'] = "['','','','']";
            include '../../Incognito/instr/scripts/create_survey.php';

            // Testing for $test2
            // Getting the the most recent survey added
            $query = sprintf("SELECT text FROM MultipleChoice WHERE text = '%s';", $text2);
            $results = mysql_query($query, $db_conn);
            
            // Do some more error checking
            if (!$results) {
                die("Error: " + mysql_error($db_conn));
            }
				
			$row = mysql_fetch_row($results);
            
            //Assert that the text is the same
			$this->assertEquals($text2, $row[0]);
            
            //Add second test case
            
            $_POST['sid'] = $session;
            $_POST['text'] = $text3;
            $_POST['type'] = "mc";
            $_POST['choices'] = "['blah','you','hello','yeah']";
            include '../../Incognito/instr/scripts/create_survey.php';

            // Testing for $test3
            // Getting the the most recent survey added
            $query = sprintf("SELECT sid, text FROM MultipleChoice WHERE text = '%s';", $text3);
            $results = mysql_query($query, $db_conn);
            
            // Do some more error checking
            if (!$results) {
                die("Error: " + mysql_error($db_conn));
            }
				
			$row = mysql_fetch_row($results);
            
            //Assert that the text is the same
			$this->assertEquals($text3, $row[1]);
            
            // Testing Answering Multiple Choice Surveys ----------------------->>>>
            
            //Run submit_survey_answer script
            $_POST['sid'] = $sid1;
            $_POST['answer'] = 'choice1';
            $_POST['type'] = 'mc';
            
            include '../../Incognito/students/scripts/submit_survey_answer.php';
            
            $query = sprintf("SELECT count FROM Choices WHERE sid = %d and text='choice1' ORDER BY sid DESC;", $sid1);
            $results = mysql_query($query, $db_conn);
            
            // Do some more error checking
            if (!$results) {
                die("Error: " + mysql_error($db_conn));
            }
				
			$row = mysql_fetch_row($results);
            $this->assertEquals(1, $row[0]); // assert that one survey
                                            // submission has been made
            
            //Testing Creating a Free Response Survey  ----------------------->>>>
            
            //add first test case
            
            $_POST['sid'] = $session;
            $_POST['text'] = $text1;
            $_POST['type'] = "fr";
            
            include '../../Incognito/instr/scripts/create_survey.php';
                   
            // Testing for $test1
            // Getting the the most recent survey added
            $query = sprintf("SELECT text FROM FreeResponse WHERE text = '%s';", $text1);
            $results = mysql_query($query, $db_conn);
            
            // Do some more error checking
            if (!$results) {
                die("Error: " + mysql_error($db_conn));
            }
				
			$row = mysql_fetch_row($results);
            
            //Assert that the text is the same
			$this->assertEquals($text1, $row[0]);
            
            //add second test case
            
            $_POST['sid'] = $session;
            $_POST['text'] = $text2;
            $_POST['type'] = "fr";
            
            include '../../Incognito/instr/scripts/create_survey.php';
                        
            // Testing for $test2
            // Getting the the most recent survey added
            $query = sprintf("SELECT text FROM FreeResponse WHERE text = '%s';", $text2);
            $results = mysql_query($query, $db_conn);
            
            // Do some more error checking
            if (!$results) {
                die("Error: " + mysql_error($db_conn));
            }
				
			$row = mysql_fetch_row($results);
            
            //Assert that the text is the same
			$this->assertEquals($text2, $row[0]);
            //add third test case
            
            $_POST['sid'] = $session;
            $_POST['text'] = $text3;
            $_POST['type'] = "fr";
         
            include '../../Incognito/instr/scripts/create_survey.php';
            
            // Testing for $test3
            // Getting the the most recent survey added
            $query = sprintf("SELECT sid, text FROM FreeResponse WHERE text = '%s';", $text3);
            $results = mysql_query($query, $db_conn);
            
            // Do some more error checking
            if (!$results) {
                die("Error: " + mysql_error($db_conn));
            }
				
			$row = mysql_fetch_row($results);
            
            //Assert that the text is the same
			$this->assertEquals($text3, $row[1]);
            
            // Testing Answering Free Response Surveys ----------------------->>>>
            
            $sid3 = $row[0];
            
            // Testing for $test3
            // Getting the the most recent survey added
            $query = sprintf("SELECT COUNT(sid) FROM Answer WHERE sid = %d;", $sid3);
            $results = mysql_query($query, $db_conn);
            
            // Do some more error checking
            if (!$results) {
                die("Error: " + mysql_error($db_conn));
            }
				
			$row = mysql_fetch_row($results);
            $count = $row[0];
            
            //Run submit_survey_answer script
            $_POST['uid'] = $uid;
            $_POST['sid'] = $sid3;
            $_POST['answer'] = $text3;
            $_POST['type'] = 'fr';
            
            include '../../Incognito/students/scripts/submit_survey_answer.php';
            
            $query = sprintf("SELECT COUNT(sid) FROM Answer WHERE sid = %d;", $sid3);
            $results = mysql_query($query, $db_conn);
            
            // Do some more error checking
            if (!$results) {
                die("Error: " + mysql_error($db_conn));
            }
				
			$row = mysql_fetch_row($results);
            $this->assertEquals($count+1, $row[0]); // assert that one survey
                                            // submission has been made
            
            // Testing Start/Stop Survey ----------------------->>>>
            
            // Insert the Survey
			$query1 = sprintf("INSERT INTO Survey (sessionid, open) VALUES (%d, %d);", $session, 0);
			$results1 = mysql_query($query1, $db_conn);
				
			// Error check
			if (!$results1) {
				die("Error: " + mysql_error($db_conn));
			}
				
			// Get the survey id
			// Getting the the most recent survey added
            $query2 = sprintf("SELECT sid FROM Survey WHERE sessionid=%d;", $session);
            $results2 = mysql_query($query2, $db_conn);
            
            // Do some more error checking
            if (!$results2) {
                die("Error: " + mysql_error($db_conn));
            }
				
			$row = mysql_fetch_row($results2);
			$sid = $row[0];
			
			$_POST['sid'] = $sid;
            
            // Run start survey code
			include '../../Incognito/instr/scripts/start_survey.php';
            
            // Check if the survey is opened
            // Getting the the most recent survey added
            $query = sprintf("SELECT open FROM Survey WHERE sid=%d;", $sid);
            $results = mysql_query($query, $db_conn);
            
            // Do some more error checking
            if (!$results) {
                die("Error: " + mysql_error($db_conn));
            }
				
			$row = mysql_fetch_row($results);
            
            //Assert that the survey is indeed open
			$this->assertEquals(1, $row[0]);
            
            // Pass in the survey id to close
            $_POST['sid'] = $sid;
            
            // Run stop survey code
			include '../../Incognito/instr/scripts/close_survey.php';
            
            // Check if the survey is opened
            // Getting the the most recent survey added
            $query = sprintf("SELECT open FROM Survey WHERE sid = %d;", $sid);
            $results = mysql_query($query, $db_conn);
            
            // Do some more error checking
            if (!$results) {
                die("Error: " + mysql_error($db_conn));
            }
				
			$row = mysql_fetch_row($results);
            
            //Assert that the survey is indeed open
			$this->assertEquals(0, $row[0]);
        }
	}
?>
