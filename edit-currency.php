<?php
session_start();
if (!isset($_SESSION['adzuser'])){header('Location:index.php');}
if (!isset($_POST['ide'])){header('Location:list-currency.php');}
include "top.php";

if (isset($_POST["save"]))
{				 	
	$query="UPDATE currency ";
	$query.="SET active='$_POST[active]', currname='$_POST[nama]', symbol='$_POST[symbol]', idcountry='$_POST[idcountry]' WHERE idcurr='$_POST[ide]'";
	$result=mysql_query($query);
	if ($result)
	echo "<script>alert('Currency data has been saved !');window.location='list-currency.php';</script>";
	else echo "<script>alert('Failed to save !');window.location='list-currency.php';</script>";
}

$query="SELECT * FROM currency WHERE idcurr='$_POST[ide]'";
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
		alert("Please fill the currency name !");
		$("#nama").focus();
		return false;
		}		
		if($.trim($("#symbol").val())==""){
		alert("Please fill in the symbol !");
		$("#nama").focus();
		return false;
		}
	});
});	
</script>

<form action="edit-currency.php" method="POST" name="formulir" id="formulir">
<table width="50%" border="0" cellspacing="1" cellpadding="1" align="center" bgcolor="#CCCCCC">
<tr>
	<td align="left" colspan="3" bgcolor="#FFFFFF" valign="middle"><h4>Edit Currency</h4></td>
</tr>
<tr>
	<td align="right" width="30%">Currency Symbol</td>
	<td align="center" width="5%">:</td>
	<td align="left" width="65%"><input type="text" name="symbol" id="symbol" size="29" maxlength='10' value="<?php echo $row['symbol']; ?>"><label class="kecilmerah"> *</label></td>
</tr>
<tr>
	<td align="right" width="30%">Currency Name</td>
	<td align="center" width="5%">:</td>
	<td align="left" width="65%"><input type="text" name="nama" id="nama" size="29" maxlength='100' value="<?php echo $row['currname']; ?>"><label class="kecilmerah"> *</label></td>
</tr>
<tr>
	<td align="right">Country</td>
	<td align="center">:</td>
	<td align="left">
		<SELECT NAME="idcountry" id="idcountry">
			<?php
			$qs ="SELECT * FROM country WHERE active=1 ORDER BY countryname ASC";
			$rs=mysql_query($qs);
			while($rws = mysql_fetch_array($rs))
			{
			if($rws['idcountry']==$row['idcountry'])echo "<OPTION VALUE='$rws[idcountry]' selected>$rws[countryname]</option>";
			else echo "<OPTION VALUE='$rws[idcountry]'>$rws[countryname]</option>";
			}
			?>	
		</SELECT><label class="kecilmerah"> *</label>		  
	</td>
</tr>
<tr>
	<td align="right">Active</td>
	<td align="center">:</td>
	<td colspan="2">
		<Input type = 'Radio' Name ='active' value= '1' <?php if ($row['active']==1) echo "checked"; ?>>Active
		<Input type = 'Radio' Name ='active' value= '0' <?php if ($row['active']==0) echo "checked"; ?>>Inactive
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
		<input type="hidden" name="ide" id="ide" value="<?php echo $row['idcurr']; ?>">
		<input type="button" name="batal" value="Back" class="btnNavigasi" onClick="klikBack()">
		<input type="reset" name="reset" id="Reset">
		<input type="submit" name="save" id="save" value="Save" style="width:70px">		
	</td>
</tr>	
</form>
</table>
