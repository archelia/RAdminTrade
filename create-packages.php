<?php
session_start();
if (!isset($_SESSION['adzuser'])){header('Location:./index.php');}
include "top.php";

if (isset($_POST["submit"]))
{				 	
	$newid=1000;
	// generate new idpackage
	$sqlr = "SELECT max(idpackage) as newid from package ";
	$resultr = mysql_query($sqlr);
	$rowr=mysql_fetch_array($resultr);
	if ($rowr['newid']>0)
	{
		$rowr['newid'];
		if($rowr['newid']!="") $newid=$rowr['newid'];
	}
	$newid=$newid+1;
	
	$price = str_replace(".", "", $_POST['price']);
	$query="INSERT INTO package ";
	$query.="VALUES ('$newid','$_POST[nama]','$_POST[desc]','$_POST[qty]','$_POST[idcurr]','$price',now(),'$_SESSION[adzuser]',now(), 1)";
	$result=mysql_query($query);
	if($result) echo "<script>alert('Package data has been saved !');window.location='list-packages.php';</script>";
	else echo "<script>alert('Package failed to save !')</script>";
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
		alert("Please fill in the packages name !");
		$("#nama").focus();
		return false;
		}
		if($.trim($("#idcurr").val())=="0"){
		alert("Please select a currency !");
		$("#idcurr").focus();
		return false;
		}
		
		//var ekspresiRegular=new RegExp(/^[\+]?\d+$/);		
		var ekspresiRegular=new RegExp(/^\s*\d+\s*$/);
		var nilai = $.trim($("#qty").val());
		if (nilai=="" || !ekspresiRegular.test(nilai)){
		alert("Please enter numbers for qty ");
		$("#qty").focus();
		return false;
		}
		
		var ekspresiRegular2=new RegExp("^[-]?[0-9]+[\.]?[0-9]+$");
		var nilai2 = $.trim($("#price").val());
		if (nilai2=="" || !ekspresiRegular2.test(nilai2)){
		alert("Please enter numbers for price ");
		$("#price").focus();
		return false;
		}
	});
});	
</script>

<form action="create-packages.php" method="POST" name="formulir" id="formulir">
<table width="50%" border="0" cellspacing="1" cellpadding="1" align="center" bgcolor="#CCCCCC">
<tr>
	<th align="left" colspan="3" valign="middle"><h4>Create packages</h4></th>
<tr>
<tr>
	<td align="right" width="25%">Package Name</td>
	<td align="center" width="5%">:</td>
	<td align="left" width="70%"><input type="text" name="nama" id="nama" size="40" maxlength='100'><label class="kecilmerah"> *</label></td>
</tr>
<tr>
	<td align="right">Description</td>
	<td align="center">:</td>
	<td align="left"><textarea cols="31" rows="5" name="desc" id="desc"></textarea></td>
</tr>
<tr>
	<td align="right">Qty</td>
	<td align="center">:</td>
	<td align="left"><input type="text" name="qty" id="qty" size="40" maxlength='10'><label class="kecilmerah"> *</label></td>
</tr>
<tr>
	<td align="right">Currency</td>
	<td align="center">:</td>
	<td align="left">
		<select id="idcurr" name="idcurr">
			<option value="0">Select Currency</option>
			<?php
			$sqcur="SELECT * FROM currency WHERE active=1 ORDER BY symbol ASC";
			$rescur=mysql_query($sqcur);
			while($rocur=mysql_fetch_array($rescur))
			{
				echo '<option value="'.$rocur["idcurr"].'">'.$rocur["symbol"].' - '.$rocur["currname"].'</option>';
			}
			?>
		</select><label class="kecilmerah"> *</label>	
	</td>
</tr>
<tr>
	<td align="right">Price</td>
	<td align="center">:</td>
	<td align="left">	
		<input type="text" name="price" id="price" size="40" maxlength='10'><label class="kecilmerah">*</label>
	</td>
</tr>
<tr>
	<td colspan="3">&nbsp;</td>
</tr>
<tr>
	<td colspan="3"><label class="kecilmiring">&nbsp; * ) Must be filled</label></td>
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
