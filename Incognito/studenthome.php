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
				Hello [student's alias]! | <a class="aboutlink" href="help.php">Help</a> | <a href="login.php">Logout</a> <br />
				You are currently viewing ______.
			</div>
		</div>			

		
		<div id="navigation">
			<ul>
				<li><span><a class="tab" href="studenthome.php">Home</a></span></li>
				<li><span><a class="tab" href="studentfeed.php">Feed</a></span></li>
				<li><span><a class="tab" href="surveys.php">Surveys</a></span></li>
			</ul>		
		</div>
		
		<div id = "maincontent">
			<form method="post">
				<div class="submissioncontent">
					<div id="typearea">
						<span>Submit as:
							<label><input type="radio" name="submitType" value="Q" checked="checked"/> Question</label>
							<label><input type="radio" name="submitType" value="F"/> Feedback </label>
						</span>
						<textarea name="texthome" rows="10" cols="80">
						</textarea>
					</div>
					<div id="submitbuttondiv"><button id="submitbutton">Submit</button></div>
				</div>
			</form>

			
			<!--<form method="post">
				<div class="homebox">					
					<div class="homebox">
						<div id="submitas">
							Submit as: 
							<input name="submitas" type="button" value="Question"/> 
							<input name="submitas" type="button" value="Feedback" />
						</div>
					</div>	
						<textarea name="texthome" rows="10" cols="80">
						</textarea>
					<div id ="submithomebutton"> 
						<button id="submitsubbutton">Submit</button>
					</div>						
				</div>

			</form> -->
		</div>

		
		
		<div class="bottomlinks">
			<a class="aboutlink" href="about.php">About</a> | 
			<a class="aboutlink" href="about.php">Privacy Policy</a> | 
			<a class="aboutlink" href="about.php">Contact Us</a>
		</div>
		
	</body>
</html>