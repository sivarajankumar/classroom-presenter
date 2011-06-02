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
				
		<div id = "maincontent">
			<h1>Student Help</h1>Welcome to Incognito's student help. This page 
			briefly describes how Incognito works. For detailed help with 
			specific site features, use the links below the main navigation bar.<br>
			<h2>What is Incognito?</h2>Incognito	
			
			is designed to let students interact with their instructors in real 
			time during class. As students, you can use Incognito to submit 
			questions and comments to your instructors, who can then use 
			Incognito's live feed to see your questions and comments and respond to them in 
			class. You can also respond to surveys, which are simple quizzes 
			that your instructors can create using Incognito.<br>	
			<h2>How does it work?</h2>Incognito is structured around two fundamental ideas: courses and sessions.
			<br><br>Courses, as their name implies, correspond to the courses 
			you are enrolled in. At the beginning of a quarter or semester, your 
			instructor will create a course on Incognito. This course will be 
			used for all activities on Incognito pertaining to that class for 
			the rest of the quarter or semester.<br><br>Sessions, on the other 
			hand, represent individual lectures or class days for a course. 
			Whereas there is only one course on Incognito for each course you 
			are taking at your school or university, a new session will most 
			likely be created for each new day of class. After your instructor 
			opens a session for the current lecture, you will be able to join 
			the session and use Incognito until your instructor closes the 
			session for that day. The questions, comments, and surveys created 
			during a session are exclusively associated with that session, and 
			cannot be accessed again once the session is closed.<br><br>The 
			following diagram shows the relationship between courses, sessions, 
			and questions, feedback, and surveys on Incognito. As you can see, a 
			course may have multiple sessions associated with it, and each 
			session has its own set of questions, feedback, and surveys. 
			However, sessions are associated with only one course.<br><br>
			<img alt="Help Diagram" src="../help_diagram.PNG" width="900"></img></div>

			
		
		<?php //Inserting report a bug, about, privacy policy, contact us links
			bottomLinks();
		?>
		
	</body>
</html>