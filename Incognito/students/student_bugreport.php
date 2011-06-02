<?php
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
			bannerAndNavigation('Bug'); 
		?>

		
		<div id="maincontent">
			<form action="../submit_bug.php" method="post" style="width: 492px">
			<br />
			Summary of the Problem:
			
			<br />
				<input name="summary" type="text" style="width: 220px" /><br />
				<br />
			
			Please describe the problem below. Be as detailed as possible. The more information you give us, the easier it is for us to resolve the issue.
				<br />
				<textarea name="description" rows="10" style="width: 486px" id="submissioncontent"></textarea><br />
				<input id="submitbutton" name="SubmitBugButton" type="submit" value="Submit" />
			</form>
		</div>
		
		<?php //Inserting report a bug, about, privacy policy, contact us links
			bottomLinks();
		?>

	</body>
</html>