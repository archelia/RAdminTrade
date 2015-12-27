<?php
$server = "localhost";
$username = "root";
$password = "";
//$username = "roriponc_rori212";
//$password = "5byroripon2012dotcom";
$database = "alibaba";
mysql_connect($server,$username,$password) or die("Failed Connection! check your connection please");
mysql_select_db($database) or die("Cannot open database!");
?>
