<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<script src="jquery-1.5.2.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="studentfeed.js"></script>
<script type="text/javascript" src="studentUIcontroller.js"></script>	

<script type="text/javascript">

    $(document).ready(function(){
      print_2d_string_array()
    });

  function print_2d_string_array() 
  { 
    var array = getFeed(22222, $_COOKIE['session'], "QBoth", "newest");
    document.writeln ("<table>") ;
    for (row = 0; row < 3; ++row)
    { 
      document.writeln ("<tr>");
      for (col = 0; col < 3; ++col) {
        document.writeln("<td>" + array[row][col] + "</td>"); 
      }
      document.writeln("</tr>");
    } 
    document.writeln ("</table>");
  }
</script>

<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title>Incognito</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="pages.css" type="text/css" rel="stylesheet" />
	</head>

	<body>
		
		<div id="topbanner"> 	<!-- Includes logo & person's information/help/logout, & course name -->		
			<img src="logo.png" alt="logo" />
			<div id="greeting">
				<?php echo 'Hello '.($_COOKIE['session']!='' ? $_COOKIE['session'] : 'Guest') ?>  | <a href="studentsettings.php">Your Settings</a> |  <a class="aboutlink" href="help.php">Help</a> | <a href="login.php">Logout</a> <br />
				You are currently looking at [course name].
			</div>
		</div>			

		
		<div id="navigation"> <!-- Navigation bar -->
			<ul>
				<li><span><a class="tab" href="studenthome.php">Home</a></span></li>
				<li><span><a class="tab" href="studentfeed.php">Feed</a></span></li>
				<li><span><a class="tab" href="studentsurveys.php">Surveys</a></span></li>
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
						<input type="text" name="texthome" value="" id="texthome" size="80" maxlength="50">
            <div id="display"></div>
						<button type="submit" id="submitbutton" onClick="onSubmit()">Submit</button>
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
                url: "../../DB/lookup_questions.php",
                data: "sid=22222", // still need to retrieve the session ID dynamically.
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
				
				<span> SORT BY:
					<a href="" >NEWEST</a> | <a href="" >HIGHEST PRIORITY</a>
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
      
      <div id="feed">
      
        <script type="text/javascript">
          print_2d_string_array();
        </script>
      
        <?php 
          $feed = array( array("checked", "First Feed" , "answered"),
                         array("unchecked", "First Feed" , "unanswered"),
                         array("checked", "First Feed" , "answered") 
                       );
          
          echo "<table>";
          for($row = 0; $row < 3; $row++)
          {
            echo "<tr>";
            for($col = 0; $col < 3; $col++)
            {
              echo "<td>".$feed[$row][$col]."</td>";
            }
            echo "</tr>";
          }
          echo "</table>";
        ?>
      </div>
			
		</div>

		
		<div class="bottomlinks">	<!-- Links at bottom of page -->
			<a class="aboutlink" href="">Report Bug</a> | 
			<a class="aboutlink" href="help.php">About</a> | 
			<a class="aboutlink" href="help.php">Privacy Policy</a> | 
			<a class="aboutlink" href="help.php">Contact Us</a>
		</div>
		
	</body>
</html>
