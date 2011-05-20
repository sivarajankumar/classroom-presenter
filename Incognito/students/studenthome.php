<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
    include "../get_uid.php";
	$thisPage = 'Home';
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
		
		<div id="topbanner"> 	<!-- Includes logo & person's information/help/logout, & course name -->
			<a href="studenthome.php"><img src="logo.png" alt="logo" /></a>
			<div id="greeting">
				<span id="cook"><?php echo 'Hello '.($_COOKIE['alias']!='' ? $_COOKIE['alias'] : 'Guest')." " ?></span>| <a href="studentsettings.php">Your Settings</a> |  <a class="aboutlink" href="help.php">Help</a> | <a href="scripts/logout.php">Logout</a> <br />
				You are currently looking at <?php echo ($_COOKIE['course'] != '' ? $_COOKIE['course'] : 'no courses') ?>.
			</div>
		</div>			

		
		<div id="navigation">	<!-- Navigation bar -->
			<ul>
				<li <?=($thisPage=='Home') ? ' id="currentpage"' : ' id="home"' ?>><span><a class="tab" href="studenthome.php">Home</a></span></li>
				<li <?=($thisPage=='Feed') ? ' id="currentpage"' : ' id="feed"' ?>><span><a class="tab" href="studentfeed.php">Feed</a></span></li>
				<li <?=($thisPage=='Surveys') ? ' id="currentpage"' : ' id="surveys"' ?>><span><a class="tab" href="studentsurveys.php">Surveys</a></span></li>
			</ul>		
		</div>
		
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
 	states = [





  	     	];

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

		
		
		<div class="bottomlinks">	<!-- Links at bottom of page -->
			<a class="aboutlink" href="">Report Bug</a> | 
			<a class="aboutlink" href="help.php">About</a> | 
			<a class="aboutlink" href="help.php">Privacy Policy</a> | 
			<a class="aboutlink" href="help.php">Contact Us</a>
		</div>
		
	</body>
</html>
