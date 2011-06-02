<?php		
	function bannerAndNavigation($thisPage) { ?>
		<div id="topbanner"> 
			<a href="studenthome.php"><img src="logo.png" alt="logo" /></a>
			<div id="greeting">
				<span id="cook"><?php echo 'Hello '.($_COOKIE['alias']!='' ? $_COOKIE['alias'] : 'Student') ?></span>
				| <a href="studentsettings.php">Your Courses</a> 
				| <a class="aboutlink" href="help_students.php">Help</a> 
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
<?php } 

	function bottomLinks() { ?>
		<div class="bottomlinks">
			<a class="aboutlink" href="student_bugreport.php">Report Bug</a> | 
			<a class="aboutlink" href="http://code.google.com/p/classroom-presenter/wiki/HomePage">About</a> | 
			<a class="aboutlink" >Privacy Policy</a> | 
			<a class="aboutlink" href="mailto:fu11h0use@googlegroups.com">Contact Us</a>
		</div>
<?php	} ?>
