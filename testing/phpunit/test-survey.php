<?php

	// This test file tests all of the functionality associated with 
	// surveys. This includes opening, closing, and creating surveys. 
	class testSurvey extends PHPUnit_Framework_TestCase
	{
		// This function adds surveys to the database
		public function addSurvey($sid, $db_conn) {
			
			// Insert the Survey
			$query1 = sprintf("INSERT INTO Survey (sessionid) VALUES (%d);", $sid);
			$results1 = mysql_query($query1, $db_conn);
				
			// Error check
			if (!$results1) {
				die("Error: " + mysql_error($db_conn));
			}
				
			// Get the survey id
			// Getting the the most recent survey added
            $query2 = sprintf("SELECT sid FROM Survey ORDER BY sid DESC;");
            $results2 = mysql_query($query2, $db_conn);
            
            // Do some more error checking
            if (!$results2) {
                die("Error: " + mysql_error($db_conn));
            }
				
			$row = mysql_fetch_row($results2);
			$sid = $row[0];
			
			return $sid;
		}
		
        // This function adds multiple choice surveys to the database
		public function addSession($db_conn) {
			
			// Insert the Multiple Choice Survey
			$query1 = sprintf("INSERT INTO Session (cid, uid, open) VALUES (%d, %d, %d);", 1,1,1);
			$results1 = mysql_query($query1, $db_conn);
				
			// Error check
			if (!$results1) {
				die("Error: " + mysql_error($db_conn));
			}
            
            // Check the session
            // Getting the the most recent survey added
            $query = sprintf("SELECT sid FROM Session ORDER BY DESC;");
            $results = mysql_query($query, $db_conn);
            
            // Do some more error checking
            if (!$results) {
                die("Error: " + mysql_error($db_conn));
            }
				
			$row = mysql_fetch_row($results);
            
            return $row[0];
		}
        
        // This function tests start_survey.php
        public function testStartSurvey() {
        
            // Connect to DB
			include_once '../../db_credentials.php';
            
            $db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
            if (!$db_conn) {
                die("Could not connect");
            }
            
            mysql_select_db($db_name, $db_conn);
            
            $session = $this->addSession($db_conn);
            
            // Add a Survey to the database and grab the survey ID
            $sid = $this->addSurvey($session, $db_conn); // 23456 session id
            $_POST['sid'] = $sid;
			
            // Run start survey code
			include_once '../../Incognito/instr/scripts/start_survey.php';
            
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
			$this->assertEquals(1, $row[0]);
            return $sid;
        }
        
        // This function tests start_survey.php
        public function testStopSurvey() {
        
            $sid = $this->testStartSurvey();
            
            $db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
            if (!$db_conn) {
                die("Could not connect");
            }
            
            mysql_select_db($db_name, $db_conn);
            
            // Pass in the survey id to close
            $_POST['sid'] = $sid;
            
            // Run stop survey code
			include_once '../../Incognito/instr/scripts/close_survey.php';
            
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
        
        public function testCreateMC() {
            
            // Connect to DB
			include_once '../../db_credentials.php';
            
            $db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
            if (!$db_conn) {
                die("Could not connect");
            }
            
            mysql_select_db($db_name, $db_conn);
            
            $session = $this->addSession($db_conn);
            
            $sid = $this->addSurvey($session, $db_conn);

            $text1 = "Question1";
            $text2 = "";
            $text3 = "REALLLLLLLLLLLLLLLYYYYYYYYY LLLLLLLLLLLLLONNNNNNNNNNNNNNNNNNNNNGGGGGG QUUUUUUUUUUUUUUUUESTTTTTTTTTTTTIOOOOOOOOOONNNNNNNN";
            
            //Add first test case
            
            $_POST['sid'] = $sid;
            $_POST['text'] = $text1;
            $_POST['type'] = "mc";
            $_POST['choices'] = "['choice1','choice2','choice3','choice4']";
            include '../../Incognito/instr/scripts/createsurvey.php';
            
            //Add second test case
            
            $_POST['sid'] = $sid;
            $_POST['text'] = $text2;
            $_POST['type'] = "mc";
            $_POST['choices'] = "['','','','']";
            include '../../Incognito/instr/scripts/createsurvey.php';

            //Add third test case
            
            $_POST['sid'] = $sid;
            $_POST['text'] = $text3;
            $_POST['type'] = "mc";
            $_POST['choices'] = "['','choice2','','choice4']";
            include '../../Incognito/instr/scripts/createsurvey.php';
            
            // Testing for $test1
            // Getting the the most recent survey added
            $query = sprintf("SELECT text FROM MultipleChoice WHERE text = '%s';", $text1);
            $results = mysql_query($query, $db_conn);
            
            // Do some more error checking
            if (!$results) {
                die("Error: " + mysql_error($db_conn));
            }
				
			$row = mysql_fetch_row($results);
            
            //Assert that the text is the same
			$this->assertEquals($text1, $row[0]);
            
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
            
            // Testing for $test3
            // Getting the the most recent survey added
            $query = sprintf("SELECT text FROM MultipleChoice WHERE text = '%s';", $text3);
            $results = mysql_query($query, $db_conn);
            
            // Do some more error checking
            if (!$results) {
                die("Error: " + mysql_error($db_conn));
            }
				
			$row = mysql_fetch_row($results);
            
            //Assert that the text is the same
			$this->assertEquals($text3, $row[0]);
            
        }

        public function testFreeResponse() {
            // Connect to DB
			include_once '../../db_credentials.php';
            
            $db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
            if (!$db_conn) {
                die("Could not connect");
            }
            
            mysql_select_db($db_name, $db_conn);
            
            $session = $this->addSession($db_conn);
            
            $sid = $this->addSurvey($session, $db_conn);

            $text1 = "Question1";
            $text2 = "";
            $text3 = "REALLLLLLLLLLLLLLLYYYYYYYYY LLLLLLLLLLLLLONNNNNNNNNNNNNNNNNNNNNGGGGGG QUUUUUUUUUUUUUUUUESTTTTTTTTTTTTIOOOOOOOOOONNNNNNNN";
            
            //add first test case
            
            $_POST['sid'] = $sid;
            $_POST['text'] = $text1;
            $_POST['type'] = "fr";
            
            include '../../Incognito/instr/scripts/createsurvey.php';
            
            //add second test case
            
            $_POST['sid'] = $sid;
            $_POST['text'] = $text2;
            $_POST['type'] = "fr";
            
            include '../../Incognito/instr/scripts/createsurvey.php';
            
            //add third test case
            
            $_POST['sid'] = $sid;
            $_POST['text'] = $text3;
            $_POST['type'] = "fr";
         
            include '../../Incognito/instr/scripts/createsurvey.php';
            
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
            
            // Testing for $test3
            // Getting the the most recent survey added
            $query = sprintf("SELECT text FROM FreeResponse WHERE text = '%s';", $text3);
            $results = mysql_query($query, $db_conn);
            
            // Do some more error checking
            if (!$results) {
                die("Error: " + mysql_error($db_conn));
            }
				
			$row = mysql_fetch_row($results);
            
            //Assert that the text is the same
			$this->assertEquals($text3, $row[0]);
            return $sid;
        }
        
        public function testAnswerMC() {
        
            // Connect to DB
			include_once '../../db_credentials.php';
            
            $db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
            if (!$db_conn) {
                die("Could not connect");
            }
            
            mysql_select_db($db_name, $db_conn);
            
            $session = $this->addSession($db_conn);
            
            $sid = $this->addSurvey($session, $db_conn);

            $text1 = "Question1";
            
            //Add Multiple Choice
            $_POST['sid'] = $sid;
            $_POST['text'] = $text1;
            $_POST['type'] = "mc";
            $_POST['choices'] = "['choice1','choice2','choice3','choice4']";
            include '../../Incognito/instr/scripts/createsurvey.php';
            
            //Get the count of the choice to test answering
            //Multiple-Choice Survey
            
            // Testing for $test1
            // Getting the the most recent survey added
            $query = sprintf("SELECT count FROM FreeResponse WHERE text = '%s';", $text1);
            $results = mysql_query($query, $db_conn);
            
            // Do some more error checking
            if (!$results) {
                die("Error: " + mysql_error($db_conn));
            }
				
			$row = mysql_fetch_row($results);
            $this->assertEquals(0, $row[0]); // assert that the no survey
                                            // submissions have been made
                                            
            //update the count to 1
            $count = $row[0] + 1;
            
            $query2 = sprintf("UPDATE Choices SET count = %d WHERE sid = %d AND text = '%s';",
								$count, $sid, $text1);
            $results2 = mysql_query($query2, $db_conn);
            
            // Do some more error checking
            if (!$results2) {
                die("Error: " + mysql_error($db_conn));
            }
            
            $this->assertEquals(1, $row[0]); // assert there is one survey
                                            // submissions that has been made
             
        }
        
        public function testAnswerFR() {
            
            // Connect to DB
			include_once '../../db_credentials.php';
            
            $db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
            if (!$db_conn) {
                die("Could not connect");
            }
            
            mysql_select_db($db_name, $db_conn);
            
            $sid = $this->testFreeResponse();
            $answer1 = "";
            $answer2 = "b]-=25[2p59,";
            $answer3 = "REALLLLLLLLLLLLLLLLYYYYYYYY LONNNNNNNNNNNGGGGGGGGGGGGGGGGGGGGGGGGG RESSSSSSSSSSSSSSSSSSSPONNNNNNNNNSSSSSEEE";
            
            // First test case
            $_POST['sid'] = $sid;
            $_POST['answer'] = $answer1;
            
            include '../../Incognito/students/scripts/submit_survey_answer.php';
            
            // Testing for test1
            // Getting the the most recent survey added
            $query = sprintf("SELECT answer FROM FreeResponse WHERE answer = '%s';", $answer1);
            $results = mysql_query($query, $db_conn);
            
            // Do some more error checking
            if (!$results) {
                die("Error: " + mysql_error($db_conn));
            }
				
			$row = mysql_fetch_row($results);
            
            $this->assertEquals($answer1, $row[0]);
            
            // Second test case
            $_POST['sid'] = $sid;
            $_POST['answer'] = $answer2;
            
            include '../../Incognito/students/scripts/submit_survey_answer.php';
            
            // Testing for test2
            // Getting the the most recent survey added
            $query = sprintf("SELECT answer FROM FreeResponse WHERE answer = '%s';", $answer2);
            $results = mysql_query($query, $db_conn);
            
            // Do some more error checking
            if (!$results) {
                die("Error: " + mysql_error($db_conn));
            }
				
			$row = mysql_fetch_row($results);
            
            $this->assertEquals($answer2, $row[0]);
            
            // Third test case
            $_POST['sid'] = $sid;
            $_POST['answer'] = $answer3;
            
            include '../../Incognito/students/scripts/submit_survey_answer.php';
            
            // Testing for test1
            // Getting the the most recent survey added
            $query = sprintf("SELECT answer FROM FreeResponse WHERE answer = '%s';", $answer3);
            $results = mysql_query($query, $db_conn);
            
            // Do some more error checking
            if (!$results) {
                die("Error: " + mysql_error($db_conn));
            }
				
			$row = mysql_fetch_row($results);
            
            $this->assertEquals($answer3, $row[0]);
            
        }
	}
?>
