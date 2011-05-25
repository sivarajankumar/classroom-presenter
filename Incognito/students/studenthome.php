<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
    include "../doLogin.php";
	include "common_student.php";
?>

	<head>
		<title>Incognito</title>
		
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="pages.css" type="text/css" rel="stylesheet" />
		<script type="text/javascript" src="http://yui.yahooapis.com/3.3.0/build/yui/yui-min.js"></script>
		<script type="text/javascript" src="studentUIcontroller.js"></script>
		<script type="text/javascript" src="jquery-1.5.2.js"></script>
		<script type="text/javascript" src="jquery.cookie.js"></script>
		<script type="text/javascript" src="scripts/StudentSettingsView.js"></script>

	</head>

	<body>
		
		<?php //Inserting the banner, greeting, and navigation from common_student.php
			bannerAndNavigation('Home'); 
		?>
		
		<div id = "maincontent">
    <form id="submitform">
				<div class="submissioncontent">	<!-- Includes: "Submit as", textbox, & submit button -->
					<div id="typeAreaFeed">
						<span>Submit as:
							<label><input type="radio" name="submitType" value="Q" checked="checked"/> Question</label>
							<label><input type="radio" name="submitType" value="F"/> Feedback </label>
						</span> <br />
						<input type="textbox" name="texthome" value="" id="ac-input" height="1000" size="80" maxlength="50">
            <div id="display"></div>
						<button type="submit" id="submitbutton" onClick="onSubmit()">Submit</button>
					</div>
				</div>
		</div>
<script>
YUI({ filter: 'raw' }).use("autocomplete", "autocomplete-filters", "autocomplete-highlighters", function (Y) {
  Y.one('#ac-input').plug(Y.Plugin.AutoComplete, {
    resultFilters    : 'phraseMatch',
    resultHighlighter: 'phraseMatch',
    source           : function(query) {
		$.ajax({
			type: "POST",
			url: "scripts/studenthome_lookup_questions.php",
			data: "sid=23456", // still need to retrieve the session ID dynamically.
			success: function(msg){
				data = new Array();
				for (var i = 0; i < msg.length; i++)
				{
					//alert( msg[i].text );
					data[i] = msg[i].text;
				}
			}
		});
		return data;
	}
  });
});
</script>

		<?php //Inserting report a bug, about, privacy policy, contact us links
			bottomLinks();
		?>
		
	</body>
</html>
