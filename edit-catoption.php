<?php
session_start();
if (!isset($_SESSION['adzuser'])){header('Location:index.php');}
if (!isset($_POST['ide'])){header('Location:list-catfields.php');}
include "top.php";

if (isset($_POST["save"]))
{				 	
	$query="UPDATE field_pilihan ";
	$query.="SET caption='$_POST[caption]', value='$_POST[value]' WHERE idoption='$_POST[ide]'";
	$result=mysql_query($query);
	if ($result)
	echo "<script>alert('Field option data has been saved !');window.location='list-fieldoption.php?ide=".$_POST["idf"]."';</script>";
	else echo "<script>alert('Failed to save !');window.location='list-fieldoption.php?ide=".$_POST["idf"]."';</script>";
}

$query="SELECT * FROM field_pilihan WHERE idoption='$_POST[ide]'";
$row = mysql_fetch_array(mysql_query($query));
?>
<link rel="stylesheet" type="text/css" href="library/style2.css" />
<div id="list" style="margin-top:1.5em;">
<table width="65%" cellspacing="2" cellpadding="2" align="center" bgcolor="#A9D0F5" border="0">
<form action="edit-catoption.php" method="POST" name="formulir" id="formulir">
    <tr>
        <th bgcolor="#FFFFFF" colspan="3" class="judul">Edit Option For Field</th>
    </tr>
	<tr>
		<td width="132" class="label2"><div align="right">Caption</div></td>
		<td width="7" class="label2"><div align="center">: </div></td>
		<td width="477" ><div align="left"><input type="text" tabindex="1" name="caption" id="caption"  size="70" value="<?php echo $row['caption']; ?>" maxlength="100"/> * </div></td>
	</tr>
	<tr>
	<td width="132" class="label2"><div align="right">Value</div></td>
	<td width="7" class="label2"><div align="center">: </div></td>
	<td width="477" ><div align="left"><input tabindex="2" name="value" id="value"  size="70" value="<?php echo $row['caption']; ?>" maxlength="100" /> * </div></td>
	</tr>
	<tr>
	<td colspan="2" class="input2" valign="top" class="keterangan"><div align="right">* ) Must be filled ! </div></td>
	<td>&nbsp;</td>
	</tr>
	<tr>
	<td colspan="2">&nbsp;</div></td>
	<td class="input2"><input type="button" name="batal" value="Back" class="btnNavigasi" onclick="klikBack()" />
&nbsp;
<input type="reset" name="reset" id="Reset" />
&nbsp;
<input type="submit" name="save" id="save" value="Save" class="btnNavigasi" tabindex="3" onclick=""/>
<input type="hidden" name="ide" id="ide" value="<?php echo $_POST['ide'];?>">
<input type="hidden" name="idf" id="idf" value="<?php echo $_POST['idf'];?>">
<br />
<br /></td>
      </tr>
    </table></td>
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
	$("#caption").focus();
	$("#formulir").submit(function(){
		if($.trim($("#caption").val())==""){
		alert("Please fill the field caption !");
		$("#caption").focus();
		return false;
		}
		if($.trim($("#value").val())==""){
		alert("Please fill the value caption !");
		$("#value").focus();
		return false;
		}
	});
});
</script>