<?php
    include "../doLogin.php";
	include "common_student.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title>Incognito</title>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="pages.css" type="text/css" rel="stylesheet" />
		<script src="jquery-1.5.2.js" type="text/javascript"></script>
		<script type="text/javascript" src="jquery.cookie.js"></script>
		<script type="text/javascript" src="scripts/StudentSettingsView.js"></script>
        <script type="text/javascript" src="jquery-impromptu.3.1.js"></script>
        <script type="text/javascript" src="scripts/StudentSurveyView.js"></script>
        <script type="text/javascript" src="studentsurveys.js"></script>
	</head>

	<body>
		
		<?php //Inserting the banner, greeting, and navigation from common_student.php
			bannerAndNavigation('Surveys'); 
		?>
		
		<div id = "maincontent">
			<div id="filterandsort">
				<span>
					FILTER BY: 
					<select name="filter" id="filter">
                        <optgroup>
                            <option selected="selected"> None </option>
                            <option>Free Response</option>
                            <option>Multiple Choice</option>
                        </optgroup>
					</select>
				</span>
				
				<span>
					SORT BY:
					<a id="newest" >NEWEST</a> | <a id="priority" >HIGHEST PRIORITY</a>
				</span>

			</div>
			
			<div id="feedbox">
				<span>
					<div class="nonSubCol"> Survey Type
					</div>
					<div id="subCol"> Question				
					</div>
					<div class="nonSubCol"> Respond?
					</div>	
					<hr />		
				</span>				
			</div>

			<div id="feed"></div>
            
		</div>

		
		
		<?php //Inserting report a bug, about, privacy policy, contact us links
			bottomLinks();
		?>
		
	</body>
</html>
