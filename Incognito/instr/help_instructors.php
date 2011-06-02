<?php
    include "../doLogin.php";
	include "common_instructor.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title>Incognito</title>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="pages.css" type="text/css" rel="stylesheet" />
	</head>

	<body>
		
		<?php //Inserting the banner, greeting, and navigation from common_instructor.php
			bannerAndNavigation('Help'); 
		?>
		
		<div id="instrhelpnavigation">
			<a href="help_instr_surveys.php">Survey Management</a> | 
		<a href="help_instr_timeline.php">Timeline</a> | 
		<a href="help_instr_courses.php">Course Management</a> |  
		<a href="help_instr_questions_feedback.php">Questions and Feedback</a> |
		<a href="help_instr_troubleshooting.php">Troubleshooting</a>
		</div>

		
		<div id = "maincontent">
		<h1>Instructor Help Index</h1>Welcome to Incognito's instructor help.&nbsp; 
			This page briefly describes how Incognito works. For detailed help 
			with specific site features, use the links below the main navigation 
			bar.<br>
			<h2>What is Incognito?</h2>Incognito	
			
			is designed to let students interact with their instructors in real 
			time during class. As instructors, you can use Incognito's live feed to view 
			questions and comments submitted by your students, and then respond 
			to them during class. You can also create surveys, which are simple quizzes 
			that your students can answer using Incognito.<br>	
			<h2>How does it work?</h2>Incognito is structured around two fundamental ideas: courses and sessions.
			<br><br>Courses, as their name implies, correspond to the courses 
			you are teaching. At the beginning of a quarter or semester, you will 
			want to create a course on Incognito for each course that you want 
			to use Incognito for. Once created, these courses can be used for all activities on Incognito pertaining to their 
			respective classes for 
			the rest of the quarter or semester.<br><br>Sessions, on the other 
			hand, represent individual lectures or class days for a course. 
			Whereas there is only one course on Incognito for each course you 
			areteaching, you will most likely create a new session for each new day of class. After you 
			open a session for the current lecture, your students will be able to join 
			the session and use Incognito until you close the 
			session for that day. The questions, comments, and surveys created 
			during a session are exclusively associated with that session, and 
			cannot be accessed again once the session is closed.<br><br>The 
			following diagram shows the relationship between courses, sessions, 
			and questions, feedback, and surveys on Incognito. As you can see, a 
			course may have multiple sessions associated with it, and each 
			session has its own set of questions, feedback, and surveys. 
			However, sessions are associated with only one course.<br><br>
			<img alt="Help Diagram" src="../help_diagram.png" width="900"></img></div>

		<br />		
		</div>

		
		
		<?php //Inserting report a bug, about, privacy policy, contact us links
			bottomLinks();
		?>
		
	</body>
</html>