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
		<script src="jquery-1.5.2.js" type="text/javascript"></script>
        <script type="text/javascript" src="jquery.cookie.js"></script>
        <script type="text/javascript" src="jquery-impromptu.3.1.js"></script>
        <script type="text/javascript" src="scripts/InstrSettingsView.js"></script>
		<script type="text/javascript" src="instructorSettings.js"></script>
	</head>

	<body>
		
		<?php //Inserting the banner, greeting, and navigation from common_instructor.php
			bannerAndNavigation(''); 
		?>
		
		<div id = "maincontent">

			<div id="feedbox">
				<div>
					<h1>Your Current Courses:</h1>	
					<div id="courseInfo"></div>		
					Course: <input type="text" id="courseName"/> 
					Mailing List: <input type="text" id="mailingList"/>
					<button type="submit" id="courseSubmitButton"/>Add!</button>
				</div>
			</div>
			
		</div>

		
		<?php //Inserting report a bug, about, privacy policy, contact us links
			bottomLinks();
		?>
		
	</body>
</html>
