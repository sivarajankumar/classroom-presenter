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
			<h1>The Feed</h1><br />
			The feed page lets you view all questions and comments that have 
			been submitted in your current session. As more questions and 
			comments are submitted, they will appear on the feed in real time.
			The feed's left column shows the submissions you have voted for, 
			while the feed's right column displays the submission's status 
			(i.e., whether your instructor has responded to the submission).<br>
			<br>Please note that the feed will only display questions and 
			comments from your class's current session, so you must join a 
			course session to use the feed. For assistance with joining 
			sessions, please see the "Your Courses" help link at the top of this 
			page.<br />
			<h2>Voting For A Question Or Comment</h2>Each question or comment 
			has a checkbox next to it on the left side of the page. To vote for 
			a question or comment you see on the feed, click its checkbox. If 
			you want to undo your vote for a question or comment, uncheck that 
			submission's checkbox.<br />
			<br />
			<i>Note:</i> You can only vote for any single comment or question once. 
			<br />
			<h2>Sorting and Filtering The Feed</h2>The feed's contents are 
			categorized as questions or feedback. If you only want to see 
			submissions of a single type and status (i.e. read/unread for 
			feedback, and answered/unanswered for questions), select the option 
			you want from the drop-down menu above the feed.<br />
			<br />
			You can also sort the feed's contents so that the most recent 
			submissions or the most popular submissions (determined by the 
			number of votes they have received) are displayed at the top of the 
			feed. To do this, click the appropriate choice from the "Sort By:" 
			options above the feed.<br />
			
		</div>

		
		
		<?php //Inserting report a bug, about, privacy policy, contact us links
			bottomLinks();
		?>
		
	</body>
</html>