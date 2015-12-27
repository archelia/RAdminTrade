<?php
session_start();
if (!isset($_SESSION['adzuser'])){header('Location:./index.php');}
include "top.php";

if (isset($_POST["submit"]))
{		 	
	$newid=0;
	// generate new idpromo
	$sqlr = "SELECT max(idpromo) as newid from promo ";
	$resultr = mysql_query($sqlr);
	if (mysql_num_rows($resultr)<1){$newid=1;}
	else
	{
	$rowr=mysql_fetch_array($resultr);
	$newid=$rowr['newid']+1;
	}
	
	$query="INSERT INTO promo ";
	$query.="VALUES ('$newid', '$_POST[promoname]', '$_POST[price1]', '$_POST[price2]', '$_POST[price3]', '$_POST[airtime]', '$_POST[promodesc]', now(), '$_SESSION[adzuser]', 1)";
	$result=mysql_query($query);
	if ($result)
	echo "<script>alert('Promo data has been saved !');window.location='./list-promo.php';</script>";
	else echo "<script>alert('Promo failed to save !');window.location='./list-promo.php';</script>";
}
?>

<link rel="stylesheet" type="text/css" href="library/style2.css" />
<script type="text/javascript">
function klikBack()
{
window.location='javascript:javascript:history.go(-1)';
}

</script>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#promoname").focus();
	$("#formulir").submit(function(){
		if($.trim($("#promoname").val())==""){
		alert("Please fill in the promo name !");
		$("#promoname").focus();
		return false;
		}
		if($.trim($("#price1").val())==""){
		alert("Please fill in the promo price for category A !");
		$("#price1").focus();
		return false;
		}
		if($.trim($("#price2").val())==""){
		alert("Please fill in the promo price for category B !");
		$("#price2").focus();
		return false;
		}
		if($.trim($("#price3").val())==""){
		alert("Please fill in the promo price for category C !");
		$("#price3").focus();
		return false;
		}
		
		//var ekspresiRegular=new RegExp(/^[\+]?\d+$/);
		var ekspresiRegular=new RegExp(/^\d+$/);
		var nilai = $.trim($("#price1").val());	
		if (nilai=="" || !ekspresiRegular.test(nilai)){
		alert("Please enter numbers for the promo price category A");
		$("#price1").focus();
		return false;
		}
		var nilai = $.trim($("#price2").val());	
		if (nilai=="" || !ekspresiRegular.test(nilai)){
		alert("Please enter numbers for the promo price category B");
		$("#price2").focus();
		return false;
		}
		var nilai = $.trim($("#price3").val());	
		if (nilai=="" || !ekspresiRegular.test(nilai)){
		alert("Please enter numbers for the promo price category C");
		$("#price3").focus();
		return false;
		}
		
		nilai = $.trim($("#airtime").val());		
		if (nilai=="" || !ekspresiRegular.test(nilai)){
		alert("Please enter numbers for the air time");
		$("#airtime").focus();
		return false;
		}
	});
});	
</script>

<form action="create-promo.php" method="POST" id="formulir" name="formulir">
<table width="50%" border="0" cellspacing="1" cellpadding="1" bgcolor="#CCCCCC" align="center">
<tr>
	<th colspan="3" bgcolor="#FFFFFF" class="judul">Create Promo</td>
</tr>
<tr>
	<td colspan="3">&nbsp;</td>
</tr>
<tr>
	<td align="right" width="30%">Promo Name</td>
	<td align="center" width="5%">:</td>
	<td align="left" width="65%"><input type="text" name="promoname" id="promoname" size="40" maxlength='100'><label class="kecilmerah"> *</label></td>
</tr>
<tr>
	<td align="right" width="30%">Price for Category A</td>
	<td align="center" width="5%">:</td>
	<td align="left" width="65%"><input type="text" name="price1" id="price1" size="25" maxlength='30' value="0"> coin(s)<label class="kecilmerah"> *</label></td>
</tr>
<tr>
	<td align="right" width="30%">Price for Category B</td>
	<td align="center" width="5%">:</td>
	<td align="left" width="65%"><input type="text" name="price2" id="price2" size="25" maxlength='30' value="0"> coin(s)<label class="kecilmerah"> *</label></td>
</tr>
<tr>
	<td align="right" width="30%">Price for Category C</td>
	<td align="center" width="5%">:</td>
	<td align="left" width="65%"><input type="text" name="price3" id="price3" size="25" maxlength='30' value="0"> coin(s)<label class="kecilmerah"> *</label></td>
</tr>
<tr>
	<td align="right" width="30%">Promo Air Time</td>
	<td align="center" width="5%">:</td>
	<td align="left" width="65%"><input type="text" name="airtime" id="airtime" size="35" maxlength='7' value="0"> day/s</td>
</tr>
<tr>
	<td align="right" width="30%">Promo Description</td>
	<td align="center" width="5%">:</td>
	<td align="left" width="65%"><textarea name="promodesc" id="promodesc" rows="7" cols="35"></textarea></td>
</tr>
<tr>
	<td colspan="3"><label class="kecilmiring"> * ) Must be filled</label></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>
		<input type="button" name="batal" value="Back" class="btnNavigasi" onClick="klikBack()">	
		<input type="reset" name="reset" id="Reset">
		<input type="submit" name="submit" value="Save">		
	</td>
</tr>
</table>
</form>
