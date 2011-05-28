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
		<h1>Instructor Help Index</h1>Welcome to Incognito's instructor help. 
			Use the links below the navigation bar to select a topic.<br />
		
		<br />		
		</div>

		
		
		<?php //Inserting report a bug, about, privacy policy, contact us links
			bottomLinks();
		?>
		
	</body>
</html>