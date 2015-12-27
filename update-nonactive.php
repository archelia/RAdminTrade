<?php
session_start();
//if (!isset($_SESSION['adzuser'])){header('Location:./index.php');}
include "top.php";

// find the last input date of 10000 data and below & date is not empty
$i = 9999;
$tanggal="0000-00-00 00:00:00";
while ($tanggal == "0000-00-00 00:00:00") 
{
	$s="SELECT idadv, inputdate FROM advertisement ORDER BY inputdate DESC limit $i,1";
	$res=mysql_query($s);
	$row=mysql_fetch_array($res);
	$tanggal=$row['inputdate'];
	$i++;
}
 
if(mysql_num_rows($res)>0)
{
	// query update where inputdate > lastdate
	echo $sql="UPDATE advertisement SET active=2 WHERE inputdate < '".$row['inputdate']."'";
	$res=mysql_query($sql);
	if($res)
	{
	echo "Sukses";
	}
	else
	{
	echo "Error. Please call your administrator.";
	}
}
?>