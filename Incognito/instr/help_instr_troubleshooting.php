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

		
		<div id="maincontent">
			<h1>Troubleshooting</h1>
			This page offers some suggested solutions to 
			potential problems.<br />
			<h2>Before You Read Farther:</h2>Incognito uses cookies to track which session you're currently in. Incognito <i>will not</i> 
			work correctly if your web browser is blocking the cookies that 
			Incognito uses. If you can log in to the site but can't use any of 
			its features (for example, you can't see any questions or feedback on the feed), first check to make 
			sure that your browser will accept Incognito's cookies. Usually, 
			this involves lowering your browser's privacy settings so that 
			Incognito's cookies will not be blocked.<br><br>If you're sure your 
			browser is accepting Incognito's cookies, but you're still having 
			trouble, read on.<br>
			<h2>I can't see anything on the feed!</h2>
			First check to make sure you've opened the right course session (the open session will have a "Close Session"
			button next to it). If you opened the wrong session, close the 
			currently open session and open the correct one. If you haven't 
			opened a session at all (this is what's happening if all your 
			courses have "Open Session" buttons next to them), just find the 
			course you want to open a session for and click "Open Session."<br>
			<br />
			You
			also may be filtering out all submissions on the feed. Go to the 
			Feed page and select "Filter By: None."<br><br>Finally, check to 
			make sure you've added your students to the course properly.
			<h2>I just created a survey, but my students can't see it!</h2>
			Make sure you've started
			the survey. See the help page for survey management for more 
			information on using surveys.<br><br>Also, make sure that your 
			course session is open. See the first paragraph of the previous 
			section for information on how to do this.
			<h2>Nothing's showing up on the timeline graph!</h2>
			Check to make sure your course session is open. The first paragraph of the "I can't see anything on the feed!" section 
			has information about how to do this.<br><br>If you've verified that 
			your session is open, but you still don't see anything on the graph, 
			your students probably just haven't submitted anything yet.
			<h2>One of my students can't see the course, but I added him/her already!</h2>
			Make sure that you entered the student's CSE NetID correctly when you added him/her. 
			Try adding the student again, and make sure to type in his/her CSE 
			NetID carefully.<br>
			<h2>I've still got a problem!</h2>
			If these suggestions didn't solve your problem, you can always use the link at the bottom of the page to email Incognito's developers 
		and ask for further help.
			</div>

		
		
		<?php //Inserting report a bug, about, privacy policy, contact us links
			bottomLinks();
		?>
		
	</body>
</html>