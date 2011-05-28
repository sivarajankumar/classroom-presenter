<?php
	function bannerAndNavigation($thisPage) { ?>
		<div id="topbanner"> <!-- Includes logo & person's information/help/logout, & feed status -->			
			<a href="instructorfeed.php"><img src="logo.png" alt="logo" /></a>
			<div id="greeting">
				<?php echo 'Hello '.($_COOKIE['alias']!='' ? $_COOKIE['alias'] : 'Instructor') ?> 
				| <a href="instructorsettings.php">Your Courses</a> 
				| <a class="../help.com" href="../help.php">Help</a> 
				| <a href="scripts/logout.php">Logout</a> <br />
			</div>
		</div>			
		
		<div id="navigation">	<!-- Navigation bar -->
			<ul>
				<li <?=($thisPage=='Feed') ? ' id="currentpage"' : ' id="feedTab"' ?>><span><a class="tab" href="instructorfeed.php">Feed</a></span></li>
				<li <?=($thisPage=='Surveys') ? ' id="currentpage"' : ' id="surveys"' ?>><span><a class="tab" href="instructorfree.php">Surveys</a></span></li>
			</ul>		
			<a href=""><span id="timeline">VIEW TIMELINE </span></a>
		</div>
	<?php }
	
	function bottomLinks() { ?>
		<div class="bottomlinks">
			<a class="aboutlink" href="../bugreport.php">Report Bug</a> | 
			<a class="aboutlink" href="http://code.google.com/p/classroom-presenter/wiki/HomePage">About</a> | 
			<a class="aboutlink" >Privacy Policy</a> | 
			<a class="aboutlink" href="mailto:fu11h0use@googlegroups.com">Contact Us</a>
		</div>
	<?php }
?>
