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
			<h1>Surveys</h1>Incognito's surveys let instructors create questions 
			that students can respond to using Incognito. These questions can 
			either be multiple choice or free response, which lets you type in 
			any response you want.<br><br>Before you can respond to surveys, you 
			must join a course session. For assistance with joining sessions, 
			please see the "Your Courses" help link at the top of this page.<br />
			<h2>Responding To A Survey</h2>1.&nbsp;&nbsp;&nbsp; Join an open 
			course session.<br>2.&nbsp;&nbsp;&nbsp; Go to the Survey 
			page.<br />
			2.&nbsp;&nbsp;&nbsp; Click the "Respond" checkbox next to the prompt 
			you want to answer.<br />
			3.&nbsp;&nbsp;&nbsp; Type your response into the provided check box.<br />
			4.&nbsp;&nbsp;&nbsp; Click "Submit."<br />
		</div>

		
		
		<?php //Inserting report a bug, about, privacy policy, contact us links
			bottomLinks();
		?>
		
	</body>
</html>