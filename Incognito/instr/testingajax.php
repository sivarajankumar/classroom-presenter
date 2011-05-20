<?php

if(isset($_GET["id"])){
	$id = $_GET["id"];
	$time = $_GET["time"];
	
	$randomNumber = rand(0, 6);
		//$results = mysql_query("SELECT COUNT(*) FROM tbl_user_profiles WHERE id < 7;");
		//$return_arr = array();
		//while ($row = mysql_fetch_array($results)) {
		$return_arr = array($time, $time + $randomNumber);
			//echo "<p>" . $row['name'] . "</p>";
			//echo "<p>" . $time ."</p>";
		//}	
		echo json_encode($return_arr);

}

	mysql_close($db);
?>