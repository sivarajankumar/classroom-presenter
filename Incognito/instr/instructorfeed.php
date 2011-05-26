<?php
$id = 2;
    include "../doLogin.php";
	include "common_instructor.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Incognito</title>
		<script src="jquery-1.5.2.js"></script>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="pages.css" type="text/css" rel="stylesheet" />
		<script src="jquery-1.5.2.js" type="text/javascript"></script>
		
		<script type="text/javascript" src="jquery.cookie.js"></script>
        <script type="text/javascript" src="instructorfeed.js"></script>
        <script type="text/javascript" src="scripts/InstrSettingsView.js"></script>
	</head>
  
	<body>
		
		<?php //Inserting the banner, greeting, and navigation from common_instructor.php
			bannerAndNavigation('Feed'); 
		?>
		
		<div id = "maincontent">
			<div id="filterandsort">	<!-- Filtering & Sorting -->
				<span>
					FILTER BY: 
					<select name="filter" id="filter">
						<optgroup>
							<option selected="selected">None</option>
						</optgroup>
						<optgroup label="Questions">
							<option>Answered</option>
							<option>Unanswered</option>
							<option>All Questions</option>
						</optgroup>
						<optgroup label="Feedback">
							<option>Read</option>
							<option>Unread</option>
							<option>All Feedback</option>
						</optgroup>
					</select>
				</span>
				
				<span>
					SORT BY:
					<a class="sortingBy" id="newest" >NEWEST</a> | <a class="sortingBy" id="priority">HIGHEST PRIORITY</a>
				</span>				  
			</div>
			
			<div id="feedbox">
				<div class="nonSubCol">Votes	<!-- Column names in feed -->
				</div>
				<div id="subCol">Feed					
				</div>
				<div class="nonSubCol">Answered/Read?
				</div>					
				<hr />
				
				<span id="blankfeed"><!--(Today&#39;s feed has not yet been open. To open, refer to your settings.)--></span>						
			</div>
      
			<div id="feed"></div>
			
		</div>

		<?php //Inserting report a bug, about, privacy policy, contact us links
			bottomLinks();
		?>		
		
	</body>
</html>
