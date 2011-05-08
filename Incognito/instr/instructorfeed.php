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
  $query = sprintf("INSERT INTO Session (cid) 
            VALUES (11111)");
  
  if(!mysql_query($query, $db_conn)) {
    die("Query error: " . mysql_error());
  }	
  
  mysql_close($db_conn);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title>Incognito</title>
		<script src="/homes/cubist/chriacua/classroom-presenter/jscript/libs/jquery-1.5.2.js"></script>
		<script src="instructorfeed.js"></script>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="pages.css" type="text/css" rel="stylesheet" />
	</head>

	<body>
		
		<div id="topbanner"> <!-- Includes logo & person's information/help/logout, & feed status -->			
			<img src="logo.png" alt="logo" />
			<div id="greeting">
				Hello [teacher's name]! | <a href="instructorsettings.php">Your Settings</a> | <a class="aboutlink" href="help.php">Help</a> | <a href="login.php">Logout</a> <br />
				<a href="">[course name]</a> feed is currently: 
				<label><input type="radio" name="feedstatus" value="Open"/> Open </label>
				<label><input type="radio" name="feedstatus" value="Closed" checked="checked"/> Closed</label>
			</div>
		</div>			

		
		<div id="navigation">	<!-- Navigation bar -->
			<ul>
				<li><span><a class="tab" href="instructorfeed.php">Feed</a></span></li>
				<li><span><a class="tab" href="instructorfree.php">Surveys</a></span></li>
				<li><span><a class="tab" href="instructorhistory.php">History</a></span></li>
			</ul>		
			<a href=""><span id="timeline">VIEW TIMELINE </span></a>
		</div>
		
		<div id = "maincontent">
			<div id="filterandsort">	<!-- Filtering & Sorting -->
				<span>
					FILTER BY: 
					<select name="filter">
						<option selected="selected"> None
						</option>
						<optgroup label="Questions">
							<option>Answered</option>
							<option>Unanswered</option>
							<option>Both</option>
						</optgroup>
						<optgroup label="Feedback">
							<option>Read</option>
							<option>Unread</option>
							<option>Both</option>
						</optgroup>
					</select>
				</span>
				
				<span>
					SORT BY:
					<a href="" >NEWEST</a> | <a href="" >HIGHEST PRIORITY</a>
				</span>				  
			</div>
			
			<div id="feedbox">
				<div class="nonSubCol">Votes	<!-- Column names in feed -->
				</div>
				<div id="subCol">Feed				
				</div>
				<div class="nonSubCol">Answered/Read?
				</div>					
				<hr />
				
				<span id="blankfeed">(Today&#39;s feed has not yet been open. To open, refer to  top-right of window.)</span>						
			</div>
			
		</div>

		
		
		<div class="bottomlinks">	<!-- Links at bottom of page -->
			<a class="aboutlink" href="">Report Bug</a> | 
			<a class="aboutlink" href="help.php">About</a> | 
			<a class="aboutlink" href="help.php">Privacy Policy</a> | 
			<a class="aboutlink" href="help.php">Contact Us</a>
		</div>
		
	</body>
</html>