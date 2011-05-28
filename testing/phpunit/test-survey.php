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
            
            return $sid;
		}
        
        // This function tests start_survey.php
        public function testStartSurvey() {
        
            // Connect to DB
			include_once '../../db_credentials.php';
            
            $session = addSession($db_conn);
            
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
        
            $sid = testStartSurvey();
            
            // Connect to DB
			include_once '../../db_credentials.php';
            
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
            
            $session = addSession($db_conn);
            
            $sid = addSurvey($session, $db_conn);

            $text1 = "Question1";
            $text2 = "";
            $text3 = "REALLLLLLLLLLLLLLLYYYYYYYYY LLLLLLLLLLLLLONNNNNNNNNNNNNNNNNNNNNGGGGGG QUUUUUUUUUUUUUUUUESTTTTTTTTTTTTIOOOOOOOOOONNNNNNNN";
            
            $_POST['sid'] = $sid;
            $_POST['text'] = $text1;
            $_POST['type'] = "mc";
            
            $_POST['sid'] = $sid;
            $_POST['text'] = $text2;
            $_POST['type'] = "mc";
            
            $_POST['sid'] = $sid;
            $_POST['text'] = $text3;
            $_POST['type'] = "mc";
         
            include_once '../../Incognito/instr/scripts/createsurvey.php';
            
            // Texting for $test1
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
            
            // Texting for $test2
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
            
            // Texting for $test3
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
            
            $session = addSession($db_conn);
            
            $sid = addSurvey($session, $db_conn);

            $text1 = "Question1";
            $text2 = "";
            $text3 = "REALLLLLLLLLLLLLLLYYYYYYYYY LLLLLLLLLLLLLONNNNNNNNNNNNNNNNNNNNNGGGGGG QUUUUUUUUUUUUUUUUESTTTTTTTTTTTTIOOOOOOOOOONNNNNNNN";
            
            $_POST['sid'] = $sid;
            $_POST['text'] = $text1;
            $_POST['type'] = "fr";
            
            $_POST['sid'] = $sid;
            $_POST['text'] = $text2;
            $_POST['type'] = "fr";
            
            $_POST['sid'] = $sid;
            $_POST['text'] = $text3;
            $_POST['type'] = "fr";
         
            include_once '../../Incognito/instr/scripts/createsurvey.php';
            
            // Texting for $test1
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
            
            // Texting for $test2
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
            
            // Texting for $test3
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
        }
        
        public function testAnswerMC {
        
        }
        
        public function testAnswerFR {
        
        }
	}
?>
