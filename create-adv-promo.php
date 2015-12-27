<?php
session_start();
include "library/conn.php";
if (!isset($_SESSION['adzuser'])){header('Location:index.php');}

// getting the due date
$qr="SELECT airtime FROM promo WHERE idpromo='$_POST[promo]'";
$rw=mysql_fetch_array(mysql_query($qr));
$plus=$rw['airtime']." day";
$newDate = date("Y-m-d", strtotime($_POST['tanggalan']));
$dueDate = strtotime(date("Y-m-d", strtotime($_POST['tanggalan'])).$plus);
$dueDate = date("Y-m-d", $dueDate);

// inserting data
$query="INSERT into advpromo VALUES";
$query.="('$_POST[ide]', '$_POST[promo]', '$newDate', '$dueDate', now(), '$_SESSION[adzuser]', 1)";
$res=mysql_query($query);

if ($res)	
echo "<script>alert('Ad Promo data has been saved !');window.location='./detail-advertisement.php?ide=".$_POST['ide']."';</script>";
else echo "<script>alert('Ad Promo failed to save !');window.location='./detail-advertisement.php?ide=".$_POST['ide']."';</script>";

?>