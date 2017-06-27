#!/usr/local/bin/php -d display_errors=STDOUT
<?php
ob_start();
ini_set('session.save_path', 'tmp');
session_start();
unset($_SESSION["username"]);  
unset($_SESSION['logged']);
header("Location: login.php");

?>