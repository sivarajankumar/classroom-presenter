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
			<h1>Troubleshooting</h1>This page offers some suggested solutions to 
			potential problems.<br />
			<h2>Before You Read Farther:</h2>Incognito uses cookies to track which session you're currently in. Incognito <i>will not</i> 
			work correctly if your web browser is blocking the cookies that 
			Incognito uses. If you can log in to the site but can't use any of 
			its features (for example, you can't see any courses on your course 
			list or you can't submit questions or feedback), first check to make 
			sure that your browser will accept Incognito's cookies. Usually, 
			this involves lowering your browser's privacy settings so that 
			Incognito's cookies will not be blocked.<br><br>If you're sure your 
			browser is accepting Incognito's cookies, but you're still having 
			trouble, read on.<br>
			<h2>Where's the button for joining a session? I can't find it!</h2>
			Your course probably doesn't have a session open right now. Wait 
			until your instructor opens a session for your course, and the Join 
			Session button should appear on the Your Courses screen.<br>
			<h2>I can't see the course I'm looking for on the Your Courses screen!</h2>
			Your instructor needs to add you to a course on Incognito before the course will appear
			on your course list. Ask your instructor to add you to the course. 
			After he or she has added you, you should see the course on your 
			course list.<br>
			<h2>I can't submit anything! <br /> I can't see any questions/feedback on the feed!
			<br /> My instructor created a survey, but I don't see it!</h2>
			You probably haven't joined the correct session, or you may not be 
			in a session at all. Go to Your Courses and make sure you've joined 
			the right session. If you're not in a session, all your courses will 
			have a "Join Session" button next to them. Click on the Join button 
			for the course session you want to join.<br><br>If you're in the 
			wrong session (the session you've joined will have a "Quit Session" 
			button next to it), click the Quit button, then click the Join 
			button next to the session you want to join.<br>
			<h2>I submitted a question/comment, but it isn't showing up on the feed!</h2>
			Check your filtering settings. 
			Most likely, your question or comment is simply being filtered out. 
			Try selecting "Filter By: None" on the feed page.</div>
			<h2>I've still got a problem!</h2>
			If these suggestions didn't solve your problem, you can always use the link at the bottom of the page to email Incognito's developers 
		and ask for further help.
		
		<?php //Inserting report a bug, about, privacy policy, contact us links
			bottomLinks();
		?>
		
	</body>
</html>