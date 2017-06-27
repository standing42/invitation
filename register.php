#!/usr/local/bin/php -d display_errors=STDOUT
<?php

ini_set('session.save_path', 'tmp');
session_start();
ob_start();
    

if(isset($_POST['submit'])){




$database = "invitation.db";          

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



$table = "user";

$field1 = "username";
$field2 = "password"; 
$field3 = "online"; 


    // Create the table
    $sql= "CREATE TABLE IF NOT EXISTS $table (
    $field1 varchar(100),
    $field2 varchar(100),
    $field3 int(12)
    )";
    $result = $db->query($sql);



   $username = $_POST['username']; 
   $password = $_POST['password']; 
   $confirm = $_POST['confirm_password']; 
   date_default_timezone_set('America/Los_Angeles');
   $login = time(); 

   $found = 0;

   $duplicate = 0; 


    $sql = "SELECT * FROM $table";
    $result = $db->query($sql);


    while($record = $result->fetchArray())
    {  
        if($username==$record[$field1]){ 
            $found=1; 
        }
    }

    if($found==1){
        print "<br/><h3 style = 'color:#b8c0cc'> User has already existed. </h3>";
    }else if($password != $confirm) {
        print "<br/><h3 style = 'color:#b8c0cc'> Please enter the password for twice as same. </h3>"; 
    }else{

        $sql = "INSERT INTO $table ($field1, $field2, $field3) VALUES('$username', '$password', $login)";

        $result = $db->query($sql);

        header("Location:login.php"); 
    }

    

}


?>


<!DOCTYPE html>
<head>   
<meta charset="utf-8">
<title>Register</title> 
<link rel="stylesheet" href="main.css"/>
<script type="text/javascript" src="main.js"></script>

</head>


    
    <body onload="checkCookie()">
        <div class="page-container">

            <h1>Please register to Invitation </h1>

            <div class = "login_b" >

            <ul>
                <li><a href="login.php">Login</a></li>
            </ul>

        </div>


            <form action="#" method="post" name="register">
            <fieldset>
                <input type="text" name="username" class="username" placeholder="Username" />
                <input type="password" name="password" class="password" placeholder="Password" />
                <input type="password" name="confirm_password" class="password" placeholder="Confirm Password" />

                <button type="submit" name="submit" class="submit_button">Register</button>
                <br/><br/><br/><br/>
            </fieldset>
            </form>

        </div>
        


    </body>

</html>



















