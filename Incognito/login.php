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
		</div>			

		
		<div id="navigation">
			<span class="tab">Welcome! Please log in below.	</span>
		</div>
		
		<div id = "maincontent">			
			<form method="post">
				<div class="logincontent">
					<div class="logintext">Email Account: <br />
						<input type="text" class="logincontent" name="email"/>
					</div>
					<div class="logintext">Password: <br />
						<input class="logincontent" name="password" type="password" /> <br />
					</div>
					<div>Need help? 
						<a href="">Click here!</a>
						<button id="loginbutton">Log In</button>
						
						<script>
							function studenthome(){
							    window.location = "studenthome.php"
							}
						</script>
						
						<script>
							function instructorfeed(){
							    window.location = "instructorfeed.php"
							}
						</script>

						<form>
							<input type="button" name="test" value="Student Home" onclick="studenthome()">
						</form> <br/>
						
						<form>
							<input type="button" name="test" value="Instructor Feed" onclick="instructorfeed()">
						</form>
					</div>
				</div>
			</form>

		</div>

		
		
		<div class="bottomlinks">	<!-- Links at bottom of page -->
			<a class="aboutlink" href="">Report Bug</a> | 
			<a class="aboutlink" href="help.php">About</a> | 
			<a class="aboutlink" href="help.php">Privacy Policy</a> | 
			<a class="aboutlink" href="help.php">Contact Us</a>
		</div>
		
	</body>
</html>