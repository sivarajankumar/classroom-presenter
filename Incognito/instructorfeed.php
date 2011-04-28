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
				Hello [teacher's name]! | <a href="">Your Classes</a> | <a class="aboutlink" href="help.php">Help</a> | <a href="login.php">Logout</a> <br />
				[course name] feed is currently: 
				<label><input type="radio" name="feedstatus" value="Open"/> Open </label>
				<label><input type="radio" name="feedstatus" value="Closed" checked="checked"/> Closed</label>
			</div>
		</div>			

		
		<div id="navigation">
			<ul>
				<li><span><a class="tab" href="instructorfeed.php">Feed</a></span></li>
				<li><span><a class="tab" href="surveys.php">Surveys</a></span></li>
				<li><span><a class="tab" href="history.php">History</a></span></li>
			</ul>		
			<a href=""><span id="timeline">VIEW TIMELINE </span></a>
		</div>
		
		<div id = "maincontent">
			<div id="filterandsort">	
				<span>
					FILTER BY: 
					<select name="filter">
						<option selected="selected"> None
						</option>
						<optgroup label="Questions">
							<option>Answered</option>
							<option>Unanswered</option>
							<option>Both</option>
						</optgroup>
						<optgroup label="Feedback">
							<option>Read</option>
							<option>Unread</option>
							<option>Both</option>
						</optgroup>
					</select>
				</span>
				
				<span>
					SORT BY:
					<a href="" >NEWEST</a> | <a href="" >HIGHEST PRIORITY</a>
				</span>				  
			</div>
			
			<div id="feedbox">
				<div id="votes"> Votes
				</div>
				<div id="submission"> Feed				
				</div>
				<div id="checklist"> Answered/Read?
				</div>	
				<hr />
				<span id="blankfeed">(Today&#39;s feed has not yet been open. To open, refer to  top-right of window.)</span>						
			</div>
			
		</div>

		
		
		<div class="bottomlinks">
			<a class="aboutlink" href="about.php">About</a> | 
			<a class="aboutlink" href="about.php">Privacy Policy</a> | 
			<a class="aboutlink" href="about.php">Contact Us</a>
		</div>
		
	</body>
</html>