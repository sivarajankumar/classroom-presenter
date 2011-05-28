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
		<a href="help_student_surveys.php">Surveys</a>  
		</div>

	
		<div id="maincontent">
		<h1>Questions and Feedback</h1>
			<br />
		Questions and comments are at the heart of Incognito's design, and the primary ways students interact with their instructors using Incognito.
		If you want to ask your instructor a question during class, and your instructor uses Incognito for the class, you can use Incognito to submit your question instantly.
			Your instructor can then use Incognito to see your question. Similarly, if you have a comment for your instructor during class, you can use Incognito to submit your feedback immediately.<br>
			<br>Before you can submit questions or comments, you must join a 
			course session. For assistance with joining sessions, please see the 
			"Your Courses" help link at the top of this page.
		<h2>Submitting A New Question Or Comment</h2>1.&nbsp;&nbsp;&nbsp; Join 
			an open course session.<br>2.&nbsp;&nbsp;&nbsp; Go to the Home or 
			the Feed page.<br />
			3.&nbsp;&nbsp;&nbsp; Type your question 
			or comment into the text box near the top of the page.<br />
			4.&nbsp;&nbsp;&nbsp; 
			To submit a question, select "Question" from the "Submit As:" options 
			above the text box. To submit feedback, select "Feedback" from the 
			same set of options.<br />
			5.&nbsp;&nbsp;&nbsp; Click "Submit."<br />
			<br />
			<h2>Voting For An Existing Question or Comment Using The 
			Autocomplete Box</h2>1.&nbsp;&nbsp;&nbsp; Join an open course 
			session.<br>2.&nbsp;&nbsp;&nbsp; Go to the Home or the Feed 
			page.<br />
			3.&nbsp;&nbsp;&nbsp; Start typing your question or comment into the 
			text box near the top of the page. Incognito will automatically 
			display all existing submissions that match the text you have 
			entered.<br />
			4.&nbsp;&nbsp;&nbsp; Find the question or comment you want to vote 
			for in the list of suggestions, and click on it.<br />
			5.&nbsp;&nbsp;&nbsp; Click "Submit."<br />
		</div>

		
		
		<?php //Inserting report a bug, about, privacy policy, contact us links
			bottomLinks();
		?>
		
	</body>
</html>