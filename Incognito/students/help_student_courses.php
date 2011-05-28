<?php
    include "../doLogin.php";
	include "common_student.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title>Incognito</title>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="pages.css" type="text/css" rel="stylesheet" />
	</head>

	<body>
		
		<?php //Inserting the banner, greeting, and navigation from common_student.php
			bannerAndNavigation('Help'); 
		?>
		
		<div id="studenthelpnavigation">
			<a href="help_questions_feedback.php">Questions and Feedback</a> | 
			<a href="help_student_courses.php">Your Courses</a> |  
		<a href="help_student_feed.php">Using the Feed</a> | 
		<a href="help_student_surveys.php">Surveys</a> |
		<a href="help_student_troubleshooting.php">Troubleshooting</a>  
		</div>

		
		<div id="maincontent">
			<h1>Your Courses</h1>Incognito organizes questions, comments, and 
			surveys based on courses and course sessions. Before you can submit 
			questions and comments, see the questions and comments your 
			classmates have submitted, or respond to Incognito surveys, you need 
			to join the course session your instructor has opened for your 
			class. This page will show you how to enroll in a course and how to 
			join and leave course sessions.<br />
			<h2>Enrolling In A Course</h2>1.&nbsp;&nbsp;&nbsp; Give your CSE 
			NetID to your instructor.<br />
			2.&nbsp;&nbsp;&nbsp; When your instructor adds you to the course, 
			you will see the course listed on the "Your Courses" page.<br />
			<h2>Viewing Your Courses</h2>1.&nbsp;&nbsp;&nbsp; Click on the "Your 
			Courses" link at the top right of the page.<br />
			2.&nbsp;&nbsp;&nbsp; All courses you are currently enrolled in will 
			be displayed under "Your Current Courses."<br />
			<h2>Joining A Course Session</h2>1.&nbsp;&nbsp;&nbsp; Click on the 
			"Your Settings" link at the top right of the page.<br />
			2.&nbsp;&nbsp;&nbsp; Click the "Join" button next to the course 
			session you want to join.<br><h2>Leaving A Course Session</h2>
			1.&nbsp;&nbsp;&nbsp; 
			Click on the "Your Courses" link at the top right of the page.<br>2.&nbsp;&nbsp;&nbsp; 
			Click on the "Quit" button next to the course session you want to 
			leave.<br />
			
		</div>

		
		
		<?php //Inserting report a bug, about, privacy policy, contact us links
			bottomLinks();
		?>
		
	</body>
</html>