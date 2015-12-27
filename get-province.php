<?php
include "library/conn.php";
$ide = trim($_POST['idcountry']);

$htmle="";
$htmle .= "<OPTION VALUE='0' selected>--Choose Province --</option>";
		$data = mysql_query("select * from province where idcountry='$ide'");  
		while($hslData = mysql_fetch_array($data))
		{
			$htmle.= "<OPTION VALUE='$hslData[idprovince]'>$hslData[provincename]</option>";
		};
echo $htmle;
?> 

