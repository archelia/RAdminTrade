<?php
include("library/conn.php");
$error="";

// pengecekan dulu apakah sudah ada data pembayaran dari trans tsb, bila ada tidak bisa dihapus
$sqlcek1="SELECT * FROM payment WHERE idpurchase='$_POST[ide]'";
$res=mysql_query($sqlcek1);
if(mysql_num_rows($res)>0)
{
	$error.="There is a confirmation payment on this purchase! Can not be deleted.\\n";
}

// pengecekan apabila data sudah sukses, tidak bisa dihapus
$sqlcek="SELECT * FROM purchase WHERE idpurchase='$_POST[ide]'";
$res=mysql_query($sqlcek);
$rowcek=mysql_fetch_array($res2);
if($rowcek['status']=="3")
{
	$error.="This purchase has been paid! Can not be deleted.";
}

if($error=="")
{
	$query="UPDATE $_POST[tabel] SET status=0 WHERE $_POST[namaid]='$_POST[ide]'";
	mysql_query($query);
	
	header("location: $last");
	//echo "<script type='text/javascript'>window.location='javascript:javascript:history.go(-2)';</script>";
}
else
{
	echo "<script language='javascript'>alert('Add Category Success');
		  window.location='$last';</script>";
}
?>