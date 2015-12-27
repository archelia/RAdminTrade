<?php
session_start();
if (!isset($_SESSION['adzuser'])){header('Location:./index.php');}
include "top.php";

if (isset($_POST["submit"]))
{				 	
	$newid=0;
	// generate new idcurr
	$sqlr = "SELECT max(idcurr) as newid from currency ";
	$resultr = mysql_query($sqlr);
	if (mysql_num_rows($resultr)<1){$newid=1;}
	else
	{
	$rowr=mysql_fetch_array($resultr);
	$newid=$rowr['newid']+1;
	}
	
	$query="INSERT INTO currency ";
	$query.="VALUES ('$newid','$_POST[symbol]','$_POST[idcountry]','$_POST[nama]', 1)";
	$result=mysql_query($query);
	echo "<script>alert('currency data has been saved !');window.location='list-currency.php';</script>";
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
	$("#nama").focus();
	$("#formulir").submit(function(){
		if($.trim($("#nama").val())==""){
		alert("Please fill in the currency name !");
		$("#nama").focus();
		return false;
		}
		if($.trim($("#symbol").val())==""){
		alert("Please fill in the symbol !");
		$("#nama").focus();
		return false;
		}
		if($("#idcountry").val()=="0"){
			alert("Please choose the country name");
			$("#idcountry").focus();
			return false;
		}		
		/*var ekspresiRegular=new RegExp(/^[\+]?\d+$/);
		var nilai = $.trim($("#phcode").val());
		if (nilai=="" || !ekspresiRegular.test(nilai)){
		alert("Please enter numbers or '+' for Phone Area Code ");
		$("#phcode").focus();
		return false;
		}*/
	});
});	
</script>

<form action="create-currency.php" method="POST" name="formulir" id="formulir">
<table width="50%" border="0" cellspacing="1" cellpadding="1" align="center" bgcolor="#CCCCCC">
<tr>
	<td align="left" colspan="3" bgcolor="#FFFFFF" valign="middle"><h4>Create Currency</h4></td>
</tr>
<tr>
	<td align="right" width="30%">Currency Symbol</td>
	<td align="center" width="5%">:</td>
	<td align="left" width="65%"><input type="text" name="symbol" id="symbol" size="29" maxlength='10'><label class="kecilmerah"> *</label></td>
</tr>
<tr>
	<td align="right" width="30%">Currency Name</td>
	<td align="center" width="5%">:</td>
	<td align="left" width="65%"><input type="text" name="nama" id="nama" size="29" maxlength='100'><label class="kecilmerah"> *</label></td>
</tr>
<tr>
	<td align="right">Country</td>
	<td align="center">:</td>
	<td align="left">
		<SELECT NAME="idcountry" id="idcountry">
			<OPTION VALUE='0' selected>--Choose Country --</option>
			<?php
			$qs ="SELECT * FROM country WHERE active=1 ORDER BY countryname ASC";
			$rs=mysql_query($qs);
			while($rws = mysql_fetch_array($rs))
			{
			echo "<OPTION VALUE='$rws[idcountry]'>$rws[countryname]</option>";
			}
			?>	
		</SELECT><label class="kecilmerah"> *</label>		  
	</td>
</tr>
<tr>
	<td colspan="3">&nbsp;</td>
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
		<input type="submit" name="submit" value="Save" style="width:70px">		
	</td>
</tr>
</table>
</form>
