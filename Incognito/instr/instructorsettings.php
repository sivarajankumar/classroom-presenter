<?php
    include "../doLogin.php";
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title>Incognito</title>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="pages.css" type="text/css" rel="stylesheet" />
		<script src="jquery-1.5.2.js" type="text/javascript"></script>
		<script type="text/javascript" src="instructorSettings.js"></script>
		<script type="text/javascript" src="jquery.cookie.js"></script> 
		<script type="text/javascript" src="scripts/InstrSettingsView.js"></script>
	</head>

	<body>
		
		<div id="topbanner"> <!-- Includes logo & person's information/help/logout, & feed status -->			
			<a href="instructorfeed.php"><img src="logo.png" alt="logo" /></a>
			<div id="greeting">
				<?php echo 'Hello '.($_COOKIE['alias']!='' ? $_COOKIE['alias'] : 'Instructor') ?> 
				| <a href="instructorsettings.php">Your Settings</a> 
				| <a class="../help.com" href="help.php">Help</a> 
				| <a href="scripts/logout.php">Logout</a> <br />
			</div>
		</div>		

		
		<div id="navigation">	<!-- Navigation bar -->
			<ul>
				<li><span><a class="tab" href="instructorfeed.php">Feed</a></span></li>
				<li><span><a class="tab" href="instructorfree.php">Surveys</a></span></li>
				<!--<li><span><a class="tab" href="instructorhistory.php">History</a></span></li>-->
			</ul>		
			<a href=""><span id="timeline">VIEW TIMELINE </span></a>
		</div>
		
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

		
		

		<div class="bottomlinks">
			<a class="aboutlink" href="../bugreport.php">Report Bug</a> | 
			<a class="aboutlink" href="http://code.google.com/p/classroom-presenter/wiki/HomePage">About</a> | 
			<a class="aboutlink" >Privacy Policy</a> | 
			<a class="aboutlink" href="mailto:fu11h0use@googlegroups.com">Contact Us</a>
		</div>
		
	</body>
</html>
