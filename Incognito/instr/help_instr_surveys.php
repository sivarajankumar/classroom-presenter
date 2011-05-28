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
			<h1>Survey Management</h1>Incognito lets you create surveys, or 
			questions, for 
			your students to answer during class. These questions can be either 
			multiple choice or free response, which let students type in any 
			response they want.<br />
			<h2>Creating A Multiple Choice Question</h2>1.&nbsp;&nbsp;&nbsp; 
			Go to the Survey page.<br />
			2.&nbsp;&nbsp;&nbsp; Select 
			"Multiple Choice" from the options above the text box. <br />
			3.&nbsp;&nbsp;&nbsp; Type the poll's prompt into the text box. <br />
			4.&nbsp;&nbsp;&nbsp; Type the answer options into the fields below the text box. To add another option, click the "+" button to the right of the last option. To remove an option, click the 
			"-" button to the right of the last option.<br /> 
			5.&nbsp;&nbsp;&nbsp; Click "Create."<br />
			<h2>Creating A Free Response Question</h2>
		1.&nbsp;&nbsp;&nbsp; 
			Go to the Survey page.<br />
			2.&nbsp;&nbsp;&nbsp; Select "Free Response" from the options above the text box.<br /> 
			3.&nbsp;&nbsp;&nbsp; Type the question's prompt into the text box.<br /> 
			4.&nbsp;&nbsp;&nbsp; Click "Create."<br />
			<h2>Closing A Survey</h2>1.&nbsp;&nbsp;&nbsp; 
			Go to the Survey page.<br />
		2.&nbsp;&nbsp;&nbsp; Select "Closed" from the drop-down menu 
			to the left of the survey you want to close. <br />
			<br />
			<i>Note:</i> A survey can only be closed if its status is currently 
			"Open."<br />
			<h2>Viewing Survey Responses</h2>1.&nbsp;&nbsp;&nbsp; 
			Go to the Survey page.<br />
			2.&nbsp;&nbsp;&nbsp; Close the survey that you want to see responses 
			for.<br />
		2.&nbsp;&nbsp;&nbsp; 
			After the survey has been closed, a drop-down menu will appear in 
			the "View Responses" column. Select "Yes" from the drop-down menu to the right of the desired survey.<br />
			
		</div>

		
		
		<?php //Inserting report a bug, about, privacy policy, contact us links
			bottomLinks();
		?>
		
	</body>
</html>