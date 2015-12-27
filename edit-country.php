<?php
session_start();
if (!isset($_SESSION['adzuser'])){header('Location:index.php');}
if (!isset($_POST['ide'])){header('Location:list-country.php');}
include "top.php";

if (isset($_POST["save"]))
{				 	
	$query="UPDATE country ";
	$query.="SET active='$_POST[active]', countryname='$_POST[nama]', phonecode='$_POST[phcode]' WHERE idcountry='$_POST[ide]'";
	$result=mysql_query($query);
	if ($result)
	echo "<script>alert('Country data has been saved !');window.location='list-country.php';</script>";
	else echo "<script>alert('Failed to save !');window.location='list-country.php';</script>";
}

$query="SELECT * FROM country WHERE idcountry='$_POST[ide]'";
$row = mysql_fetch_array(mysql_query($query));
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
		alert("Please fill the country name !");
		$("#nama").focus();
		return false;
		}
		
		var ekspresiRegular=new RegExp(/^[\+]?\d+$/);
		var nilai = $.trim($("#phcode").val());
		if (nilai=="" || !ekspresiRegular.test(nilai)){
		alert("Please enter numbers or '+' for Phone Area Code ");
		$("#phcode").focus();
		return false;
		}
	});
});
</script>

<form action="edit-country.php" method="POST" name="formulir" id="formulir">
<table width="50%" border="0" cellspacing="1" cellpadding="1" align="center" bgcolor="#CCCCCC">
<tr>
	<td align="left" colspan="3" bgcolor="#FFFFFF" valign="middle"><h4>Edit Country</h4></td>
</tr>
<tr>
	<td align="right" width="30%">Country Name</td>
	<td align="center" width="5%">:</td>
	<td align="left" width="65%"><input type="text" name="nama" id="nama" size="29" maxlength='100' value="<?php echo $row['countryname']; ?>"><label class="kecilmerah"> *</label></td>
</tr>
<tr>
	<td align="right" width="30%">Phone Area Code</td>
	<td align="center" width="5%">:</td>
	<td align="left" width="65%"><input type="text" name="phcode" id="phcode" size="29" maxlength='10' value="<?php echo $row['phonecode']; ?>"></td>
</tr>
<tr>
	<td align="right">Active</td>
	<td align="center">:</td>
	<td colspan="2">
		<Input type = 'Radio' Name ='active' value= '1' <?php if ($row['active']==1) echo "checked"; ?>>Active
		<Input type = 'Radio' Name ='active' value= '0' <?php if ($row['active']==0) echo "checked"; ?>>Inactive
	</td>
</tr>
</tr>
<tr>
	<td colspan="3">&nbsp;</td>
</tr>
<tr>
	<td colspan="3"><label class="kecilmiring"> * ) Must be filled</label></td>
</tr>
<tr>
	<td width="35%">&nbsp;</td>
	<td width="5%">&nbsp;</td>
	<td width="65%">
		<input type="hidden" name="ide" id="ide" value="<?php echo $row['idcountry']; ?>">
		<input type="button" name="batal" value="Back" class="btnNavigasi" onClick="klikBack()">
		<input type="reset" name="reset" id="Reset">
		<input type="submit" name="save" id="save" value="Save" style="width:70px">		
	</td>
</tr>	
</form>
</table>
