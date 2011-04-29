<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title>Incognito</title>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="pages.css" type="text/css" rel="stylesheet" />
	</head>

	<body>
		
		<div id="topbanner"> 
			
			<img src="logo.png" alt="logo" />
			<div id="greeting">
				Hello [student's alias]! | <a href="studentsettings.php">Your Settings</a> |  <a class="aboutlink" href="help.php">Help</a> | <a href="login.php">Logout</a> <br />
				You are currently looking at [course name].
			</div>
		</div>			

		
		<div id="navigation">
			<ul>
				<li><span><a class="tab" href="studenthome.php">Home</a></span></li>
				<li><span><a class="tab" href="studentfeed.php">Feed</a></span></li>
				<li><span><a class="tab" href="studentsurveys.php">Surveys</a></span></li>
			</ul>		
		</div>
		
		<div id = "maincontent">
			<div id="filterandsort">	
				<span>
					FILTER BY: 
					<select name="filter">
						<option selected="selected"> None </option>
						<option>Free Response</option>
						<option>Multiple Choice</option>
					</select>
				</span>
				
				<span>
					SORT BY:
					<a href="" >NEWEST</a> | <a href="" >HIGHEST PRIORITY</a>
				</span>				  
			</div>
			
			<div id="feedbox">
				<span>
					<div class="nonSubCol"> # Responses
					</div>
					<div id="subCol"> Question				
					</div>
					<div class="nonSubCol"> Respond?
					</div>	
					<hr />		
				</span>				
			</div>
			
		</div>

		
		
		<div class="bottomlinks">
			<a class="aboutlink" href="about.php">About</a> | 
			<a class="aboutlink" href="about.php">Privacy Policy</a> | 
			<a class="aboutlink" href="about.php">Contact Us</a>
		</div>
		
	</body>
</html>