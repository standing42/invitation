#!/usr/local/bin/php -d display_errors=STDOUT
<?php

ini_set('session.save_path', 'tmp');
session_start();
ob_start();
 


$username = $_SESSION['username'];


?>

<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="utf-8">
<title>Invitation</title> 
<link rel="stylesheet" href="home.css"/>
</head>
<body>



<div class = "user">

        <ul >
        	<li>Welcome, <?php echo " $username"?> </li>
            <li><a class="logout" href="logout.php">Logout</a></li>
        </ul>
    </div>


<div class="topcorner"><a class="logout" href="home.php">Back to Home</a></div>


<div class="container">



<?php

	$database = "invitation.db";   

	$count = 0;        

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

	date_default_timezone_set('America/Los_Angeles');
	

	$query= (isset($_GET["type"]))?$_GET["type"]:"";

	$query_d = $_REQUEST["date"];
	$query_m = $_REQUEST["month"]; 
	$query_y = $_REQUEST["year"]; 


	$this_day = mktime(0,0,0,$query_m,$query_d,$query_y); 
	$time_stamp  = time();

	$time_string = date("M j, Y", $this_day); 


	print "<h1>" . $time_string . "</h1>";


	print "<form  class='choose_type' id='All' method='get' action='list.php'>"; 
	print "<p>"; 
	print "<input type='hidden' name='date' value='" . $query_d . "'/>"; 
	print "<input type='hidden' name='month' value='" . $query_m . "'/>"; 
	print "<input type='hidden' name='year' value='" . $query_y . "'/>"; 
	print "<input type='hidden' name='type' value=''/>"; 
	print "<input type='submit' value='All'/>"; 
	print "</p>"; 
	print "</form>"; 

	print "<form  class='choose_type' id='Sport' method='get' action='list.php'>"; 
	print "<p>"; 
	print "<input type='hidden' name='date' value='" . $query_d . "'/>"; 
	print "<input type='hidden' name='month' value='" . $query_m . "'/>"; 
	print "<input type='hidden' name='year' value='" . $query_y . "'/>"; 
	print "<input type='hidden' name='type' value='Sport'/>"; 
	print "<input type='submit' value='Sport'/>"; 
	print "</p>"; 
	print "</form>"; 

	print "<form  class='choose_type' id='Art' method='get' action='list.php'>"; 
	print "<p>"; 
	print "<input type='hidden' name='date' value='" . $query_d . "'/>"; 
	print "<input type='hidden' name='month' value='" . $query_m . "'/>"; 
	print "<input type='hidden' name='year' value='" . $query_y . "'/>"; 
	print "<input type='hidden' name='type' value='Art'/>"; 
	print "<input type='submit' value='Art'/>"; 
	print "</p>"; 
	print "</form>"; 


	print "<form  class='choose_type' id='Movie' method='get' action='list.php'>"; 
	print "<p>"; 
	print "<input type='hidden' name='date' value='" . $query_d . "'/>"; 
	print "<input type='hidden' name='month' value='" . $query_m . "'/>"; 
	print "<input type='hidden' name='year' value='" . $query_y . "'/>"; 
	print "<input type='hidden' name='type' value='Movie'/>"; 
	print "<input type='submit' value='Movie'/>"; 
	print "</p>"; 
	print "</form>"; 

	print "<form  class='choose_type' id='Food' method='get' action='list.php'>"; 
	print "<p>"; 
	print "<input type='hidden' name='date' value='" . $query_d . "'/>"; 
	print "<input type='hidden' name='month' value='" . $query_m . "'/>"; 
	print "<input type='hidden' name='year' value='" . $query_y . "'/>"; 
	print "<input type='hidden' name='type' value='Food'/>"; 
	print "<input type='submit' value='Food'/>"; 
	print "</p>"; 
	print "</form>"; 


	print "<form  class='choose_type' id='Travel' method='get' action='list.php'>"; 
	print "<p>"; 
	print "<input type='hidden' name='date' value='" . $query_d . "'/>"; 
	print "<input type='hidden' name='month' value='" . $query_m . "'/>"; 
	print "<input type='hidden' name='year' value='" . $query_y . "'/>"; 
	print "<input type='hidden' name='type' value='Travel'/>"; 
	print "<input type='submit' value='Travel'/>"; 
	print "</p>"; 
	print "</form>"; 


	print "<form  class='choose_type' id='Other' method='get' action='list.php'>"; 
	print "<p>"; 
	print "<input type='hidden' name='date' value='" . $query_d . "'/>"; 
	print "<input type='hidden' name='month' value='" . $query_m . "'/>"; 
	print "<input type='hidden' name='year' value='" . $query_y . "'/>"; 
	print "<input type='hidden' name='type' value='Other'/>"; 
	print "<input type='submit' value='Other'/>"; 
	print "</p>"; 
	print "</form>"; 

	

	$sql = "SELECT *  FROM $table ORDER BY $field3";
	$result = $db->query($sql); 

	if($query=="")
	{
		while($record = $result->fetchArray())
		{
			if($record[$field3]>=$this_day)
			{

				$date = date("M d Y", $record[$field3]); 
				$count +=1; 

				print "<div class = 'list'>"; 
				print "<p>INVITATION: </p>";
				print "<p class='information'> Sent by: " . $record[$field1]. "</p>"; 
				print "<p class='information'> Type: " . $record[$field2]. "</p>"; 
				print "<p class='information'> Effective Until: " . $date . "</p>"; 
				print "<p class='information'> Event: " .  $record[$field5] . "</p>"; 
				print "<p class='information'> Location: " . $record[$field4] . "</p>"; 
				print "</div>"; 
			}
		} 
	}else{
		while($record = $result->fetchArray())
		{
			if($record[$field3]>=$this_day&&$record[$field2]==$query)
			{

				$date = date("M d Y", $record[$field3]); 
				$count +=1; 

				print "<div class = 'list'>"; 
				print "<p>INVITATION: </p>";
				print "<p class='information'> Sent by: " . $record[$field1]. "</p>"; 
				print "<p class='information'> Type: " . $record[$field2]. "</p>"; 	
				print "<p class='information'> Effective Until: " . $date . "</p>"; 
				print "<p class='information'> Event: " .  $record[$field5] . "</p>"; 
				print "<p class='information'> Location: " . $record[$field4] . "</p>"; 
				print "</div>"; 
			}
		} 
	}

	

	if($count==0)
		print "<p>Sorry, there is currently no event. </p>"; 

?>	




</div>
</body>
</html>

