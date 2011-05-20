<?php
    include "../get_uid.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title>Incognito</title>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="pages.css" type="text/css" rel="stylesheet" />
		<script src="jquery-1.5.2.js" type="text/javascript"></script>
		<script type="text/javascript" src="studentSettings.js"></script>
		<script type="text/javascript" src="jquery.cookie.js"></script>
		<script type="text/javascript" src="scripts/StudentSettingsView.js"></script>
	</head>

	<body>
		
		<div id="topbanner"> <!-- Includes logo & person's information/help/logout, & feed status -->			
			<img src="logo.png" alt="logo" />
			<div id="greeting"> <!--<span id="cook"></span> -->
				<span id="cook"><?php echo 'Hello '.($_COOKIE['alias']!='' ? $_COOKIE['alias'] : 'Guest') ?></span> | <a href="studentsettings.php">Your Settings</a> |  <a class="aboutlink" href="help.php">Help</a> | <a href="scripts/logout.php">Logout</a> <br />
				You are currently looking at [course name].
			</div>
		</div>			

		
		<div id="navigation">	<!-- Navigation bar -->
			<ul>
				<li><span><a class="tab" href="studenthome.php">Home</a></span></li>
				<li><span><a class="tab" href="studentfeed.php">Feed</a></span></li>
				<li><span><a class="tab" href="studentsurveys.php">Surveys</a></span></li>
			</ul>		
			<a href=""><span id="timeline">VIEW TIMELINE </span></a>
		</div>
		
		<div id = "maincontent">

			<div id="feedbox">
				<div>
					<h1>Your Current Courses:</h1>	
					<div id="courseInfo"></div>		
					<!--Add course: <input type="text" id="courseName"/>
					<button type="submit" id="courseSubmitButton"/>Add!</button>-->
				</div>
					<h1> Edit Profile </h1>
					Change Alias:  <input type="text" id="aliasName"/>
					<button type="submit" id="aliasChangeButton"/>Change!</button>
					<br /> <!--<?php# SETCOOKIE('session', '$studentchangedname');?> -->
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
