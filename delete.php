<?php
include("library/conn.php");
$query="UPDATE $_POST[tabel] SET active=0 WHERE $_POST[namaid]='$_POST[ide]'";
mysql_query($query);

$last=$_POST['page'];
header("location: $last");
//echo "<script type='text/javascript'>window.location='javascript:javascript:history.go(-2)';</script>";
?>