#!/usr/local/bin/php -d display_errors=STDOUT
<?php
ini_set('session.save_path', 'tmp');
session_start();
ob_start();
 
//Jump to login page if not logged in 
if( !isset($_SESSION['username']) ) {
  	header("Location: login.php");
  	exit;
}


$username = $_SESSION['username'];



//set calendar class
date_default_timezone_set('America/Los_Angeles');
$params = array();
if (isset($_GET['year']) && isset($_GET['month'])) {
    $params = array(
        'year' => $_GET['year'],
        'month' => $_GET['month'],
    );
}
$params['url']  = 'home.php';
require_once 'calendar.php';

?>


<!DOCTYPE html>
<html>
<head>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />

<title>Invitation Calendar </title>
<link rel="stylesheet" href="home.css">
<script type="text/javascript" src="main.js"></script>
</head>

<header></header>

<body class = "container">

<div class = "account">

	
    <!--Display username; logout button-->
	<div class = "user">

        <ul >
        	<li class="welcome">Welcome, <?php echo " $username "?> </li>
            <li><a class="logout" href="logout.php">Logout</a></li>
        </ul>
    </div>

<aside>

<?php

	date_default_timezone_set('America/Los_Angeles');

	$time_stamp = time();
	$database = "invitation.db";          

    //open database
    try  
    {     
        $db = new SQLite3($database);
    }

    catch (Exception $exception)
    {
        echo '<p>There was an error connecting to the database!</p>';

        if ($db)
        {
            echo $exception->getMessage();
        }
        
    }

    
    
    $table = "events";

    $field1 = "user";
	$field2 = "type"; 
	$field3 = "date"; 
	$field4 = "location"; 
	$field5 = "event_title"; 
	$sql = "SELECT * FROM $table";
	$result = $db->query($sql);


    //Get the most recently updated invitation
	$sql = "SELECT *  FROM $table ORDER BY rowid desc limit 1";
	$result = $db->query($sql); 

	$record = $result->fetchArray(); 

	$date = date("M d Y", $record[$field3]); 
	print "<div class='right'>"; 
	print "<p class='title'> UP TO DATE INVITATION </p>";
	print "<p class='info'> Sent by: <br/>" . $record[$field1]. "</p>"; 
	print "<p class='info'> Type: <br/>" . $record[$field2] . "</p>"; 
	print "<p class='info'> Effective until: <br/>" . $date . "</p>"; 
	print "<p class='info'> Location: <br/>" . $record[$field4] . "</p>";
    print "<p class='info'> Event detail: <br/>" . $record[$field5] . "</p>";
	print "</div>";

    
   
?>      

</aside>  
        
</div>

<div>
    <?php
        //display calendar
        $cal = new Calendar($params);
        $cal->display();

    ?> 
</div>  


<div class = "invite">

<form class = "invitation" action="#" method="get">
	<fieldset class = "invitation_home">

    	<legend>Invite someone!</legend>

    	<h4>Event Type</h4>
		    <input type='radio' name='event' value='Sport'  checked='checked'/><label class='event'>Sport</label>
		    <input type='radio' name='event' value='Food' /><label class='event'>Food</label>
			<input type='radio' name='event' value='Movie'  /><label class='event'>Movie</label> 
			<input type='radio' name='event' value='Travel' /><label class='event'>Travel</label>
			<input type='radio' name='event' value='Art'  /><label class='event'>Art</label> 
			<input type='radio' name='event' value='Other' /><label class='event'>Other</label> 
			<br/>
			<br/>

		
		<h4>When and Where</h4>
			<input onclick="document.getElementById('dateS').disabled = true;" type="radio" name="date" value="today" checked='checked'>
			<label>Today</label>
			<input onclick="document.getElementById('dateS').disabled = true;" type="radio" name="date" value="tomorrow">
			<label>Tomorrow</label>
			<input onclick="document.getElementById('dateS').disabled = true;" type="radio" name="date" value="this_week">
			<label>Sometime this week </label><br/>
			<input onclick="document.getElementById('dateS').disabled = false;" type="radio" name="date" value="specific">
            <label>Specific date (mm-dd-yyyy)</label>
			<input type="text" name="dateS" id="dateS" disabled="disabled" placeholder="mm-dd-yyyy" />
			<br/>
			

			<label class='location'>Location: </label>
			<input type="text" name="location" id="location" placeholder="Location"/>
			<br/>

			<label class='event_title'>Details of the Event</label>

			<textarea rows="5" cols="50" name="event_title" id="event_title"></textarea>
			<br/>

            <input type="button" value = "Submit" onclick="process_form()"/>
            <input type="button" value="Reset"/>
            <p id="update_success"></p>
        
	</fieldset>
</form>
</div>


    
</body>
</html>
