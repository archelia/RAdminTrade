<?php
include("library/conn.php");
$query="DELETE FROM $_POST[tabel] WHERE $_POST[namaid]='$_POST[ide]'";
if(isset($_POST['ide2'])){$query .= " AND $_POST[namaid2]='$_POST[ide2]'";}

//echo $query;
mysql_query($query);
header("location:".$_POST['page']);
//echo "<script type='text/javascript'>window.location='javascript:javascript:history.go(-2)';</script>
?>