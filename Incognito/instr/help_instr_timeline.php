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
		<a href="help_instr_questions_feedback.php">Questions and Feedback</a>
		</div>

		
		<div id="maincontent">
			<h1>The Timeline Graph</h1>
			<h2>What Is It?</h2>The timeline gives you a visual representation 
			of the class session's overall activity. Time is on the horizontal 
			axis, and number of submissions is on the vertical axis. Each point 
			indicates the number of submissions received during a unit of time. 
			If you notice the graph starting to rise, your students are 
			submitting questions and comments.<br />
			<br />
			The timeline is designed to let you monitor a class session without 
			constantly checking Incognito's feed. You can overlay the timeline 
			on top of PowerPoint slides, for example, so that you can use 
			lecture slides and keep track of Incognito's activity at the same 
			time.<br />
			<br />
			<h2>Using The Timeline</h2>1.&nbsp;&nbsp;&nbsp; Open a class 
			session. (See "Course Management" help for more information.)<br />
			2.&nbsp;&nbsp;&nbsp; From the Survey or Feed page, click the "View 
			Timeline" button on the right side of the navigation bar. The graph 
			window will appear.<br />
			3.&nbsp;&nbsp;&nbsp; To hide the timeline, minimize its window.<br />
		</div>

		
		
		<?php //Inserting report a bug, about, privacy policy, contact us links
			bottomLinks();
		?>
		
	</body>
</html>