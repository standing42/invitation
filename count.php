#!/usr/local/bin/php -d display_errors=STDOUT
<?php 



ini_set('session.save_path', 'tmp');
session_start();
ob_start();
 


$user = $_SESSION['username'];


try  
{     
    $db = new SQLite3('invitation.db'); 
}
catch (Exception $exception)
{
    echo '<p>There was an error connecting to the database!</p>';

    if ($db)
    {
        echo $exception->getMessage();
    }
        
}

// define tablename and field names for a SQLite3 query to create a table in a database
$table = "events";

$field1 = "user";
$field2 = "type"; 
$field3 = "date"; 
$field4 = "location"; 
$field5 = "event_title"; 




// Create the table
$sql= "CREATE TABLE IF NOT EXISTS $table (
$field1 varchar(30),
$field2 varchar(20),
$field3 int(12),
$field4 varchar(100),
$field5 varchar(300)
)";
$result = $db->query($sql);



$query_string= $_REQUEST["event"]; 

$update=""; 

if ($query_string!=""){
    $arr = explode(";",$query_string); 


    $type = $arr[0]; 
    $dateT = $arr[1]; 
    date_default_timezone_set('America/Los_Angeles');
    $current = time();
    if($dateT=="today"){
        $date = time()+86400;
    }else if($dateT=="tomorrow"){
        $date = time()+172800; 
    }else if ($dateT=="this_week"){
        $date = time()+604800; 
    }else{
        $str1 = explode("-", $dateT); 
        $month = (int)$str1[0]; 
        $day = (int)$str1[1]; 
        $year = (int)$str1[2]; 

        $date = mktime(0,0,0,$month, $day+1,$year);
    }

    $location = $arr[2]; 
    $event_title = $arr[3]; 




    $sql = "INSERT INTO $table ($field1, $field2, $field3, $field4,$field5) VALUES('$user', '$type', $date, '$location', '$event_title')";
    $result = $db->query($sql);

    $sql = "UPDATE user SET online = $current WHERE username = '$user'"; 
    $result = $db->query($sql);

    $update="Invitation sent!"; 
}







 
$table = "events";



$sql = "SELECT *  FROM $table ORDER BY rowid desc limit 1";
    $result = $db->query($sql); 

    $record = $result->fetchArray(); 
    
    date_default_timezone_set('America/Los_Angeles');

    $user =  $record[$field1]; 
    $type = $record[$field2]; 
    $dateF = date("M d Y", $record[$field3]); 
    $event_title =  $record[$field5]; 
    $location = $record[$field4]; 







echo $user . "hash%%!" . $type . "hash%%!" . $dateF . "hash%%!" . $location . "hash%%!" . $event_title . "hash%%!" . $update; 



?>








