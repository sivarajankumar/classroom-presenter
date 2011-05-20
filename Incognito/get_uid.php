<?php
    function get_user_id($netid) {

        // Connect to the production database
        $username = "ashen";
        $password = "2kV2cNct";
        $db_name = "ashen_403_Local";
        
        $db_conn = mysql_connect("cubist.cs.washington.edu", $username, $password);
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
        
        $expire=time()+60*60*24*30;
        
        if(!empty($row))
            setcookie('uid', $row[0], $expire);
            
    }
?>