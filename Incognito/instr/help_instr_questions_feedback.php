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
			<h1>Managing Questions and Feedback</h1>In addition to displaying 
			questions and comments that your students submit, Incognito also 
			lets you organize these submissions. The real-time feed can be 
			filtered and sorted to control what submissions are displayed, and 
			you can mark submissions to reflect their status once you have read 
			or responded to them.<br />
			<h2>Sorting and Filtering The Feed</h2>Incognito's filtering options 
			can be found in the drop-down menu above and to the left of the 
			feed. To filter the feed, select the option you want from the menu.<br />
			<br />
			To sort the feed, click on one of the "Sort By:" options above the 
			feed. Selecting Newest will sort the feed in order of time submitted 
			from most to least recent, while selecting Highest Priority will 
			display the submissions that have received the most votes at the top 
			of the feed.<br />
			<h2>Marking Questions And Feedback</h2>After you have answered a 
			question, you can mark the question as answered by selecting the 
			checkbox to the right of the question. Similarly, once you have read 
			a comment, you can set its status to "Read" by checking the checkbox 
			to its right.<br />
		</div>

		
		
		<?php //Inserting report a bug, about, privacy policy, contact us links
			bottomLinks();
		?>
		
	</body>
</html>