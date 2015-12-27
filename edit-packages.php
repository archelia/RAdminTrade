<?php
session_start();
if (!isset($_SESSION['adzuser'])){header('Location:index.php');}
if (!isset($_POST['ide'])){header('Location:list-packages.php');}
include "top.php";

if (isset($_POST["save"]))
{				 	
	$query="UPDATE package ";
	$query.="SET active='$_POST[active]', name='$_POST[nama]', idcurr='$_POST[idcurr]', description='$_POST[desc]', qty='$_POST[qty]', price='$_POST[price]', userinput='$_SESSION[adzuser]', dateupdate=now() WHERE idpackage='$_POST[ide]'";
	$result=mysql_query($query);
	if ($result)
	echo "<script>alert('Package data has been saved !');window.location='list-packages.php';</script>";
	else echo "<script>alert('Failed to save !');window.location='list-packages.php';</script>";
}

$query="SELECT * FROM package WHERE idpackage='$_POST[ide]'";
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
		alert("Please fill the packages name !");
		$("#nama").focus();
		return false;
		}
		
		//var ekspresiRegular=new RegExp(/^[\+]?\d+$/); untuk no telp +8088		
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

<form action="edit-packages.php" method="POST" name="formulir" id="formulir">
<table width="50%" border="0" cellspacing="1" cellpadding="1" align="center" bgcolor="#CCCCCC">
<tr>
	<th align="left" colspan="3" valign="middle" class="judul">Edit Package</td>
</tr> 
<tr>
	<td align="right" width="30%">Name</td>
	<td align="center" width="5%">:</td>
	<td align="left" width="65%"><input type="text" name="nama" id="nama" size="40" maxlength='100' value="<?php echo $row['name']; ?>"><label class="kecilmerah"> *</label></td>
</tr>
<tr>
	<td align="right" width="30%">Description</td>
	<td align="center" width="5%">:</td>
	<td align="left" width="65%"><textarea cols="31" rows="5" name="desc" id="desc"><?php echo $row['description']; ?></textarea></td>
</tr>
<tr>
	<td align="right" width="30%">Qty</td>
	<td align="center" width="5%">:</td>
	<td align="left" width="65%"><input type="text" name="qty" id="qty" size="40" maxlength='10' value="<?php echo $row['qty']; ?>"><label class="kecilmerah"> *</label></td>
</tr>
<tr>
	<td align="right">Currency</td>
	<td align="center">:</td>
	<td align="left">
		<select id="idcurr" name="idcurr">
			<?php
			$sqcur="SELECT * FROM currency WHERE active=1 ORDER BY symbol ASC";
			$rescur=mysql_query($sqcur);
			while($rocur=mysql_fetch_array($rescur))
			{
				if($rocur['idcurr']==$row['idcurr'])
				echo '<option value="'.$rocur["idcurr"].'" selected>'.$rocur["symbol"].' - '.$rocur["currname"].'</option>';
				else echo '<option value="'.$rocur["idcurr"].'">'.$rocur["symbol"].' - '.$rocur["currname"].'</option>';
			}
			?>
		</select><label class="kecilmerah"> *</label>	
	</td>
</tr>
<tr>
	<td align="right" width="30%">Price</td>
	<td align="center" width="5%">:</td>
	<td align="left" width="65%"><input type="text" name="price" id="price" size="40" maxlength='10' value="<?php echo number_format($row["price"],0,",","."); ?>"><label class="kecilmerah"> *</label></td>
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
		<input type="hidden" name="ide" id="ide" value="<?php echo $row['idpackage']; ?>">
		<input type="button" name="batal" value="Back" class="btnNavigasi" onClick="klikBack()">
		<input type="reset" name="reset" id="Reset">
		<input type="submit" name="save" id="save" value="Save" style="width:70px">		
	</td>
</tr>	
</form>
</table>
