<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
  setcookie('netid', $_SERVER['REMOTE_USER']);
?>

	<head>
		<title>Incognito</title>
		<script src="/homes/cubist/chriacua/classroom-presenter/jscript/libs/jquery-1.5.2.js"></script>
		<script src="instructorfeed.js"></script>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="pages.css" type="text/css" rel="stylesheet" />
		<script src="jquery-1.5.2.js" type="text/javascript"></script>
		<script type="text/javascript" src="jquery.cookie.js"></script>
		<script type="text/javascript" src="testingInstructorFeed.js"></script
	</head>

	<body>
		
		<div id="topbanner"> <!-- Includes logo & person's information/help/logout, & feed status -->			
			<img src="logo.png" alt="logo" />
			<div id="greeting">
				<?php echo 'Hello '.($_COOKIE['netid']!='' ? $_COOKIE['netid'] : 'Guest') ?> | <a href="instructorsettings.php">Your Settings</a> | <a class="aboutlink" href="help.php">Help</a> | <a href="../logout.php">Logout</a> <br />
			</div>
		</div>			

		
		<div id="navigation">	<!-- Navigation bar -->
			<ul>
				<li><span><a class="tab" href="instructorfeed.php">Feed</a></span></li>
				<li><span><a class="tab" href="instructorfree.php">Surveys</a></span></li>
				<li><span><a class="tab" href="instructorhistory.php">History</a></span></li>
			</ul>		
			<a href=""><span id="timeline">VIEW TIMELINE </span></a>
		</div>
		
		<div id = "maincontent">
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
				
				<span>
					SORT BY:
					<a href="#feedbox" id="newest" >NEWEST</a> | <a href="#feedbox" id="priority">HIGHEST PRIORITY</a>
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
      
            <div id="feed">
        <?php 
          $feed = array( array("43", "Why is 403 the most awesome class ever??? OMG" , "answered"),
                         array("100", "What is worse than 403?" , "read"),
                         array("2000", "What is a good design pattern for graduating as soon as possible?" , "answered") 
                       );
          
          echo "<table id=feedTable>";
          for($row = 0; $row < 3; $row++)
          {
            if($row % 2 == 1)
            {
              echo "<tr class=alt>";
            }
            else
            {
              echo "<tr>";
            }
            for($col = 0; $col < 3; $col++)
            {
              if($col == 2)
              {
                if(strcmp($feed[$row][$col], "answered") == 0)
                {
                  echo "<td class=check><input type=checkbox id=check checked=true /></td>";
                }
                else
                {
                  echo "<td class=check><input type=checkbox id=check /></td>";
                }
              }
              elseif($col == 1)
              {
                echo "<td class=feed>".$feed[$row][$col]."</td>";
              }
              else
              {
                echo "<td class=votes>".$feed[$row][$col]."</td>";
              }
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
