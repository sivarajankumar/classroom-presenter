<?php
    if(!isset($_COOKIE['uid'])) {
	echo $_SERVER['REMOTE_USER'];
        get_user_id($_SERVER['REMOTE_USER']);
    }
   // if(!isset($_COOKIE['alias'])){
   //     get_alias($_COOKIE['uid']);
   // }

   //if(!isset($_COOKIE['sid'])){
	//	get_sid($_COOKIE['uid'])
	//}
	
    function get_user_id($netid) {
		$db_name = "ashen_403_Local";
		$db_conn = make_dbconn();

        if (!$db_conn) {
            die("Could not connect");
        }
        mysql_select_db($db_name, $db_conn);
        $query = sprintf("SELECT uid FROM User WHERE email = '%s';", $netid);
        $results = mysql_query($query, $db_conn);
        
        // Error check
        if (!$results) {
            die("Error: " + mysql_error($db_conn));
        }
        // Get the uid and then do the update
        $row = mysql_fetch_row($results);
       
        $expire=time()+ 60*60*24*1;
        if(!empty($row))
            setcookie('uid', $row[0], $expire, "/");
            
    }
	
    function get_alias($id){
		$db_name = "ashen_403_Local";
		$db_conn = make_dbconn();
        if (!$db_conn) {
            die("Could not connect");
        }
        
        mysql_select_db($db_name, $db_conn);
		$query = sprintf("SELECT * FROM `Instructor` WHERE uid='%d';",$id );
		$results = mysql_query($query, $db_conn);
        
        // Error check
        if (!$results) {
            die("Error: " + mysql_error($db_conn));
        }
        
        // see if the person is an instructor
        $row = mysql_fetch_row($results);
	// not an instructor
 	if(empty($row)){ 

        $query = sprintf("SELECT alias FROM `Student` WHERE uid = '%d';", $id);
        }else{
	$query = sprintf("SELECT email FROM `User` WHERE uid = '%d';", $id);
	} 
       
        $results = mysql_query($query, $db_conn);
	 // Error check
        if (!$results) {
            die("Error: " + mysql_error($db_conn));
        }
        
        // Get the uid and then do the update
        $row = mysql_fetch_row($results);
       
        $expire=time()+60*60*24*30;
        if(!empty($row))
            setcookie('alias', $row[0], $expire, "/");
       } 
	
	/*function get_sid($uid){
		$db_name = "ashen_403_Local";
		$db_conn = make_dbconn();
		if (!$db_conn) {
			die("Could not connect");
		}
        
        mysql_select_db($db_name, $db_conn);
		$query = sprintf("SELECT sid FROM Joined WHERE uid = '%d';", $uid);
        $results = mysql_query($query, $db_conn);
        
        // Error check
        if (!$results) {
            die("Error: " + mysql_error($db_conn));
        }
	}*/
	
	function make_dbconn(){
		// Connect to the production database
		$username = "ashen";
		$db_name = "ashen_403_Local";
		$password = "2kV2cNct";
		$db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
		return $db_conn;
   }
?>
