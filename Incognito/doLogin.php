<?php
   $user_type = $id;
    if(!isset($_COOKIE['uid'])) {
        get_user_id($_SERVER['REMOTE_USER'], $user_type);
    }
   // if(!isset($_COOKIE['alias'])){
   //     get_alias($_COOKIE['uid']);
   // }

   //if(!isset($_COOKIE['sid'])){
	//	get_sid($_COOKIE['uid'])
	//}
	
    function get_user_id($netid, $user_type) {
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
        if(empty($row))
     {
	// if user doesn't exist yet, add to user table 
         $query = sprintf("INSERT INTO User (`email`) VALUES ('%s');", $netid);
 	 $results = mysql_query($query, $db_conn);
        $query = sprintf("SELECT uid FROM User WHERE email = '%s';", $netid);
        $results = mysql_query($query, $db_conn);
        
        // Error check
       if (!$results) {
            die("Error: " + mysql_error($db_conn));
        }
        // Get the uid and then do the update
        $row = mysql_fetch_row($results);
   	// now insert the user into the instructor or student table.
 	// currently adds to both.
	if($user_type == 1){
	 $query = sprintf("INSERT INTO Student (`uid`, `netid`) VALUES ('%d', '%s');", $uid, $netid);
	}else if($user_type ==2){
		 $query = sprintf("INSERT INTO Instructor (`uid`) VALUES ('%d');", $uid);
	}
        mysql_query($query, $db_conn); 
    }else{
	$uid = $row[0];
	}
	  setcookie('uid', $uid, $expire, "/"); 
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
