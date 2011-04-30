<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title>Incognito</title>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="pages.css" type="text/css" rel="stylesheet" />
	</head>

	<body>
		
		<div id="topbanner"> <!-- Includes logo & person's information/help/logout, & feed status -->			
			<img src="logo.png" alt="logo" />
			<div id="greeting">
				Hello [student's alias]! | <a href="studentsettings.php">Your Settings</a> |  <a class="aboutlink" href="help.php">Help</a> | <a href="login.php">Logout</a> <br />
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
					CSE403 Leave Course					
					<button type="submit" id="joinCourseButton">Add Course</button>
				</div>
					<h1> Edit Profile </h1>
					Change Username <br />
					Change Password <br>
			</div>
			
		</div>

		
		
		<div class="bottomlinks">	<!-- Links at bottom of page -->
			<a class="aboutlink" href="help.php">About</a> | 
			<a class="aboutlink" href="help.php">Privacy Policy</a> | 
			<a class="aboutlink" href="help.php">Contact Us</a>
		</div>
		
	</body>
</html>