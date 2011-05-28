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
			bannerAndNavigation('Feed'); 
		?>
		
		<div id="studenthelpnavigation">
			<a href="help_questions_feedback.php">Questions and Feedback</a> | 
		<a href="help_alias.php">Aliases</a> | 
		<a href="help_student_courses.php">Your Courses</a> |  
		<a href="help_student_feed.php">Using the Feed</a> | 
		<a href="help_student_surveys.php">Surveys</a> | 
		<a href="help_students.php">Troubleshooting</a> 
		</div>

	
		<div id="maincontent">
		<h1>Questions and Feedback</h1>
			<br />
		<h2>Submitting A New Question Or Comment</h2>1.&nbsp;&nbsp;&nbsp; Go to the Home or 
			the Feed page.<br />
			2.&nbsp;&nbsp;&nbsp; Type your question 
			or comment into the text box near the top of the page.<br />
			3.&nbsp;&nbsp;&nbsp; 
			To submit a question, select "Question" from the "Submit As:" options 
			above the text box. To submit feedback, select "Feedback" from the 
			same set of options.<br />
			4.&nbsp;&nbsp;&nbsp; Click "Submit."<br />
			<br />
			<h2>Voting For An Existing Question or Comment Using The 
			Autocomplete Box</h2>1.&nbsp;&nbsp;&nbsp; Go to the Home or the Feed 
			page.<br />
			2.&nbsp;&nbsp;&nbsp; Start typing your question or comment into the 
			text box near the top of the page. Incognito will automatically 
			display all existing submissions that match the text you have 
			entered.<br />
			3.&nbsp;&nbsp;&nbsp; Find the question or comment you want to vote 
			for in the list of suggestions, and click on it.<br />
			4.&nbsp;&nbsp;&nbsp; Click "Submit."<br />
		</div>

		
		
		<?php //Inserting report a bug, about, privacy policy, contact us links
			bottomLinks();
		?>
		
	</body>
</html>