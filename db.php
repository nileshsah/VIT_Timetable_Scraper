<?php
$username = "root";
$password = "";
$hostname = "localhost";
$database = "vitsapp";

$dbhandle = mysql_connect($hostname, $username, $password);
@mysql_select_db($database) or die( "Unable to select database");
?>
