<?php
    include "../doLogin.php";
	$thisPage='Feed';	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<script src="jquery-1.5.2.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="studentfeed.js"></script>
<script type="text/javascript" src="studentUIcontroller.js"></script>
<script type="text/javascript" src="http://yui.yahooapis.com/3.3.0/build/yui/yui-min.js"></script>

<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title>Incognito</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="pages.css" type="text/css" rel="stylesheet" />
		<script type="text/javascript" src="jquery.cookie.js"></script>
		<script src="jquery-1.5.2.js" type="text/javascript"></script>
	</head>

	<body>

		<div id="topbanner"> 
			<a href="studenthome.php"><img src="logo.png" alt="logo" /></a>
			<div id="greeting">
				<span id="cook"><?php echo 'Hello '.($_COOKIE['alias']!='' ? $_COOKIE['alias'] : 'Student') ?></span>
				| <a href="studentsettings.php">Your Settings</a> 
				| <a class="aboutlink" href="../help.php">Help</a> 
				| <a href="scripts/logout.php">Logout</a> <br />
			</div>
		</div>

	<div id="navigation"> <!-- Navigation bar -->
			<ul>
				<li <?=($thisPage=='Home') ? ' id="currentpage"' : ' id="home"' ?>><span><a class="tab" href="studenthome.php">Home</a></span></li>
				<li <?=($thisPage=='Feed') ? ' id="currentpage"' : ' id="feedTab"' ?>><span><a class="tab" href="studentfeed.php">Feed</a></span></li>
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
						<input type="text" name="texthome" value="" id="ac-input" size="80" maxlength="50">
            <div id="display"></div>
						<button type="submit" id="submitbutton" onClick="onSubmit()">Submit</button>
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

			</form>

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

				<span> SORT BY:
					<a id="newest">NEWEST</a> | <a id="priority">HIGHEST PRIORITY</a>
				</span>
			</div>


			<div id="feedbox">
				<div class="nonSubCol"> Vote? <!-- Column names in feed -->
				</div>
				<div id="subCol"> Feed
				</div>
				<div class="nonSubCol"> Answered/Read?
				</div>

				<hr />
			</div>

            <div id="feed"></div>

		</div>


		<div class="bottomlinks">
			<a class="aboutlink" href="../bugreport.php">Report Bug</a> | 
			<a class="aboutlink" href="http://code.google.com/p/classroom-presenter/wiki/HomePage">About</a> | 
			<a class="aboutlink" >Privacy Policy</a> | 
			<a class="aboutlink" href="mailto:fu11h0use@googlegroups.com">Contact Us</a>
		</div>

	</body>
</html>
