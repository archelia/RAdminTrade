<?php
$server = "localhost";
$username = "roriponc_traders";
$password = "roriponMuach2";
$database = "roriponc_roritrading";
mysql_connect($server,$username,$password) or die("Failed Connection! check your connection please");
mysql_select_db($database) or die("Cannot open database!");
?>
