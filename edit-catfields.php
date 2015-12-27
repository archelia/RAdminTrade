<?php
session_start();
if (!isset($_SESSION['adzuser'])){header('Location:index.php');}
if (!isset($_POST['ide'])){header('Location:list-fieldoption.php');}
include "top.php";

if (isset($_POST["save"]))
{				 	
	$query="UPDATE fields ";
	$query.="SET active='$_POST[active]', fieldname='$_POST[nama_field]', tipefield='$_POST[ftype]', userinput='$_SESSION[adzuser]', inputdate=now() WHERE idfields='$_POST[ide]'";
	$result=mysql_query($query);
	if ($result)
	echo "<script>alert('fields data has been saved !');window.location='list-fields.php';</script>";
	else echo "<script>alert('Failed to save !');window.location='list-fields.php';</script>";
}

$query="SELECT * FROM fields WHERE idfield='$_POST[ide]'";
$row = mysql_fetch_array(mysql_query($query));
?>
<link rel="stylesheet" type="text/css" href="library/style2.css" />
<div id="list" style="margin-top:1.5em;">
<table width="700" cellspacing="2" cellpadding="2" align="center" bgcolor="#A9D0F5" border="0">
<form action="edit-catfields.php" method="POST" name="formulir" id="formulir">
    <tr>
    <td width="" colspan="2">
		<table cellpadding="8" cellspacing="1" align="center">
		  <tr>
			<th bgcolor="" colspan="4" class="judul">Edit Field</th>
		  </tr>
		  <tr>
			<td width="132" class="label2"><div align="right">Field Name</div></td>
			<td width="7" class="label2"><div align="center">: </div></td>
			<td width="477" ><div align="left"><input tabindex="1" name="nama_field" id="nama_field"  size="70" value="<?php echo $row["fieldname"];?>" /> 
			  * </div></td>
		  </tr>
		  <tr>
			<td width="132" class="label2"><div align="right">Field Type</div></td>
			<td width="7" class="label2"><div align="center">: </div></td>
			<td width="477" ><div align="left">
				<select name="ftype" id="ftype">
					<option value="1" <?php if($row["tipefield"]=="1") echo "selected";?>>Text</option>
					<option value="2" <?php if($row["tipefield"]=="2") echo "selected";?>>Options</option>
					<option value="2" <?php if($row["tipefield"]=="3") echo "selected";?>>List</option>
				</select>
			  * </div></td>
		  </tr>
		  <tr>
			<td colspan="2" class="input2" valign="top" class="keterangan"><div align="right">* ) Must be filled ! </div></td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td colspan="2">&nbsp;</div></td>
			<td class="input2">	
				<input type="hidden" name="ide" id="ide" value="<?php echo $_POST['ide'];?>" />
				<input type="button" name="batal" value="Back" class="btnNavigasi" onclick="klikBack()" />
				&nbsp;
				<input type="reset" name="reset" id="Reset" />
				&nbsp;
				<input type="submit" name="btnTambah" id="btnTambah" value="Save" class="btnNavigasi" tabindex="3" onclick="tambahDataCategory()"/>
				<br />
				<br />
			</td>
		  </tr>
		</table>
	</td>
	</tr>
	</form>
	</table>
</div>

<script type="text/javascript">
function klikBack()
{
window.location='javascript:javascript:history.go(-1)';
}
</script>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#nama_field").focus();
	$("#formulir").submit(function(){
		if($.trim($("#nama_field").val())==""){
		alert("Please fill the field name !");
		$("#nama_field").focus();
		return false;
		}
	});
});
</script>