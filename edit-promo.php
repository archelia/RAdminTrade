<?php
session_start();
if (!isset($_SESSION['adzuser'])){header('Location:./index.php');}
if (!isset($_POST['ide'])){header('Location:list-promo.php');}

include "top.php";
if (isset($_POST["save"]))
{		
		$mynum1 = doubleval(str_replace(".","",$_POST["price1"]));;
		$mynum2 = doubleval(str_replace(".","",$_POST["price2"]));;
		$mynum3 = doubleval(str_replace(".","",$_POST["price3"]));;
		$query  = "UPDATE promo SET ";
		$query .= "promoname='$_POST[promoname]', price1='$mynum1', price2='$mynum2', price3='$mynum3', airtime='$_POST[airtime]', promodesc='$_POST[promodesc]', active='$_POST[active]' ";
		$query .= "WHERE idpromo='$_POST[ide]'";
		$result=mysql_query($query);
			
		if ($result)
		echo "<script>alert('Promo data has been saved !');window.location='./list-promo.php';</script>";
		else echo "<script>alert('Data failed to save !');window.location='./list-promo.php';</script>";	
}

$query="SELECT * FROM promo WHERE idpromo='$_POST[ide]'";
$result=mysql_query($query);
$row = mysql_fetch_assoc($result);
?>
<link rel="stylesheet" type="text/css" href="library/style2.css" />
<script type="text/javascript">
function klikBack()
{
window.location='javascript:javascript:history.go(-1)';
};
</script>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#promoname").focus();
	$("#formulir").submit(function(){		
		if($.trim($("#promoname").val())==""){
		alert("woy");
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
		if($.trim($("#airtime").val())==""){
		alert("Please fill in the airtime !");
		$("#airtime").focus();
		return false;
		}
	
		var ekspresiRegularDec=new RegExp(/^\s*(\+|-)?((\d+(\.\d+)?)|(\.\d+))\s*$/);
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
				
		var ekspresiRegularAngka=new RegExp(/^\s*(\+|-)?\d+\s*$/);
		var nilai2 = $.trim($("#airtime").val());		
		if (nilai2=="" || !ekspresiRegularAngka.test(nilai2)){
		alert("Please enter numbers for the air time");
		$("#airtime").focus();
		return false;
		}
	});
});	
</script>
<form id="formulir" name="formulir" action="edit-promo.php" method="POST" >
<table width="50%" border="0" cellspacing="1" cellpadding="1" align="center" bgcolor="#CCCCCC">
<tr>
	<td align="left" colspan="3" bgcolor="#FFFFFF" valign="middle"><h4>Edit Promo</h4></td>
</tr>
<tr>
	<td align="right" width="30%">Promo Name</td>
	<td align="center" width="5%">:</td>
	<td align="left" width="65%"><input type="text" name="promoname" id="promoname" size="40" maxlength='100' value="<?php echo $row['promoname']; ?>"><label class="kecilmerah"> *</label></td>
</tr>
<tr>
	<td align="right" width="30%">Price for Category A</td>
	<td align="center" width="5%">:</td>
	<td align="left" width="65%"><input type="text" name="price1" id="price1" size="25" maxlength='30' value="<?php echo $row['price1']; ?>"> coin(s)<label class="kecilmerah"> *</label></td>
</tr>
<tr>
	<td align="right" width="30%">Price for Category B</td>
	<td align="center" width="5%">:</td>
	<td align="left" width="65%"><input type="text" name="price2" id="price2" size="25" maxlength='30' value="<?php echo $row['price2']; ?>"> coin(s)<label class="kecilmerah"> *</label></td>
</tr>
<tr>
	<td align="right" width="30%">Price for Category C</td>
	<td align="center" width="5%">:</td>
	<td align="left" width="65%"><input type="text" name="price3" id="price3" size="25" maxlength='30' value="<?php echo $row['price3']; ?>"> coin(s)<label class="kecilmerah"> *</label></td>
</tr>
<tr>
	<td align="right" width="30%">Promo Air Time</td>
	<td align="center" width="5%">:</td>
	<td align="left" width="65%"><input type="text" name="airtime" id="airtime" size="35" maxlength='7' value="<?php echo $row['airtime']; ?>"> day(s)</td>
</tr>
<tr>
	<td align="right" width="30%">Promo Description</td>
	<td align="center" width="5%">:</td>
	<td align="left" width="65%"><textarea name="promodesc" id="promodesc" rows="7" cols="35"><?php echo $row['promodesc']; ?></textarea></td>
</tr>
<tr>
	<td align="right">Active</td>
	<td align="center">:</td>
	<td colspan="2">
		<Input type = 'Radio' Name ='active' value= '1' <?php if ($row['active']=1) echo "checked"; ?>>Active
		<Input type = 'Radio' Name ='active' value= '0' <?php if ($row['active']=0) echo "checked"; ?>>Inactive
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
		<input type="hidden" name="ide" id="ide" value="<?php echo $row['idpromo']; ?>">
		<input type="button" name="batal" value="Back" class="btnNavigasi" onClick="klikBack()">
		<input type="reset" name="reset" id="Reset">
		<input type="submit" name="save" id="save" value="Save" style="width:70px">		
	</td>
</tr>	
</form>
</table>