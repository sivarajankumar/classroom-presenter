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
			4.&nbsp;&nbsp;&nbsp; Type the answer options into the fields below the text box.<br /> 
			5.&nbsp;&nbsp;&nbsp; Click "Create."<br />
			<h2>Creating A Free Response Question</h2>
		1.&nbsp;&nbsp;&nbsp; 
			Go to the Survey page.<br />
			2.&nbsp;&nbsp;&nbsp; Select "Free Response" from the options above the text box.<br /> 
			3.&nbsp;&nbsp;&nbsp; Type the question's prompt into the text box.<br /> 
			4.&nbsp;&nbsp;&nbsp; Click "Create."<br>
			<h2>Starting A Survey</h2>1.&nbsp;&nbsp;&nbsp; Go to the Survey 
			page.<br>2.&nbsp;&nbsp;&nbsp; After creating a survey, click the 
			"Start Survey" button for the survey you want to start. Your 
			students will now be able to see and respond to the survey until you 
			close it.<br />
			<h2>Closing A Survey</h2>1.&nbsp;&nbsp;&nbsp; 
			Go to the Survey page.<br />
			2.&nbsp;&nbsp;&nbsp; Click the "Close Survey" button for the open survey you want 
			to close.<i> Note:</i> The "Close Survey" button is not visible for 
			surveys that are not open.<br />
			<h2>Viewing Survey Responses</h2>1.&nbsp;&nbsp;&nbsp; 
			Go to the Survey page.<br />
			2.&nbsp;&nbsp;&nbsp; (Optional) Close the survey that you want to see responses 
			for.<br />
			3.&nbsp;&nbsp;&nbsp; Click the "Get Results" button for the desired survey. A 
			pop-up dialog box will appear and show the survey's results.<br />
			
		</div>

		
		
		<?php //Inserting report a bug, about, privacy policy, contact us links
			bottomLinks();
		?>
		
	</body>
</html>