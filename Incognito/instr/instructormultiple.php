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
        <script type="text/javascript" src="scripts/InstrSurveyView.js"></script>
        <script type="text/javascript" src="instructormultiple.js"></script>
	</head>

	<body>
		
		<?php //Inserting the banner, greeting, and navigation from common_instructor.php
			bannerAndNavigation('Surveys'); 
		?>
		
		<div id = "maincontent">
            <form id="multisurvey">
			<div id="createSurveyArea">		<!-- Includes: "Create new" types, textbox, create button, and checkbox -->
				<span>Create New:
					<a href="instructorfree.php">Free Response </a> | <a href="instructormultiple.php">Multiple Choice</a> <!--fix these options later! redirect w/ radio buttons-->
				</span> <br />
				<input type="textbox" id="questiontext" value="" height="1000" size="100" maxlength="120">
				</textarea>	<br />
				Choice 1) <input type="text" id="option" name="name" size="16"/> <br /> <!--fix these options later!!!!!!!-->
				Choice 2) <input type="text" id="option" name="name" size="16"/> <br /> 	
				Choice 3) <input type="text" id="option" name="name" size="16"/> <br /> 
                Choice 4) <input type="text" id="option" name="name" size="16"/> <br /> 
				<button type="submit" id="submitbutton" onClick="onSurvey()">Create</button> <br />
				<input type="checkbox" name="createSurvey" /> I do not want to create a survey.
			</div>
            </form>
			
			<div id="surveyFeed">
                <table>
				<td class="surveytype"> Type	<!-- Column names in feed -->
				</td>
				<td class="question"> Question
				</td>	
				<td class="surveystrtstp"> Start/Stop Survey
				</td>
                <td class="results"> Results
                </td>
                </table>
				<hr />				
			</div>
			
            <div id="feed"></div>
		</div>

			

		<?php //Inserting report a bug, about, privacy policy, contact us links
			bottomLinks();
		?>
		
	</body>
</html>
