<?php

$db = mysql_connect("vergil.u.washington.edu:6435", "root", "Ri0819cO");
if (!$db)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db("users");
if(isset($_GET["id"])){
	$id = $_GET["id"];
	$time = $_GET["time"];
	if($id < 8){
		//$results = mysql_query("SELECT COUNT(*) FROM tbl_user_profiles WHERE id < 7;");
		$return_arr = array();
		//while ($row = mysql_fetch_array($results)) {
			$return_arr[] = array($time, $time);
			//echo "<p>" . $row['name'] . "</p>";
			//echo "<p>" . $time ."</p>";
		//}	
		echo json_encode($return_arr);

	}
}

	mysql_close($db);
?>