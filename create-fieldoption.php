<?php
 session_start();
 if (!isset($_SESSION['adzuser'])){header('Location:./index.php');}
 if (!isset($_POST['ide'])){header("Location:./list-fieldoption.php?ide=$_POST[ide]");}
 include "top.php";
 
if(isset($_POST['btnTambah']))
{
	$eror="";
	// begin validating
	$sqlr = "SELECT * from field_pilihan WHERE caption='$_POST[caption]'";
	$resultr = mysql_query($sqlr);
	$rowr=mysql_fetch_array($resultr);
	if ($rowr>0) {$eror.="This field option is already exist, please choose another field option name !\\n";}
	if ($_POST['caption']==""){$eror.="Field caption can\'t be empty! \\n";}
	if ($_POST['value']==""){$eror.="Field value can\'t be empty! \\n";}
	if ($eror=="")
	{
		$kode=0;
		// generate new id
		$sqlr = "SELECT max(idoption) as newid from field_pilihan ";
		$resultr = mysql_query($sqlr);
		if (mysql_num_rows($resultr)<1){$kode=1;}
		else
		{
		$rowr=mysql_fetch_array($resultr);
		$kode=$rowr['newid']+1;
		}

		$query = "insert into field_pilihan values ('".$kode."','".$_POST['ide']."','".$_POST['value']."','".$_POST['caption']."')";
		$tambah = mysql_query($query);

		if($tambah)
		{
			echo "<script language='javascript'>alert('Add Field Success');
				  window.location='list-fieldoption.php?ide=$_POST[ide]';
				  </script>";
		} 
	}
	else
	{
		
		echo '<script type=\'text/javascript\'>var msg; msg='.$eror.';</script>';		
		echo "<script>alert(\"$eror\")</script>";		
	}
}
?> 

<script type="text/javascript" src="jquery.js"></script>
<script>
function klikBack()
{
window.location='javascript:javascript:history.go(-1)';
}
</script>
<br>
 <form name="inputcatfield" method="post" action="">
	<table cellpadding="0" cellspacing="0" bgcolor="#CCCCCC" align="center">
    <tr>
    <td width="100%"><table cellpadding="8" cellspacing="1">
      <tr>
        <td bgcolor="#FFFFFF" colspan="3" class="judul">Add Option For Field</td>
      </tr>
      <tr>
        <td width="132" class="label2"><div align="right">Caption</div></td>
        <td width="7" class="label2"><div align="center">: </div></td>
        <td width="477" ><div align="left"><input type="text" tabindex="1" name="caption" id="caption"  size="70" value="" /> * </div></td>
      </tr>
      <tr>
        <td width="132" class="label2"><div align="right">Value</div></td>
        <td width="7" class="label2"><div align="center">: </div></td>
        <td width="477" ><div align="left"><input tabindex="2" name="value" id="value"  size="70" value="" /> * </div></td>
      </tr>
      <tr>
		<td colspan="2" class="input2" valign="top"><div align="right">* ) Must be filled ! </div></td>
		<td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</div></td>
        <td class="input2"><input type="button" name="batal" value="Back" class="btnNavigasi" onclick="klikBack()" />
&nbsp;
<input type="reset" name="reset" id="Reset" />
&nbsp;
<input type="hidden" id="ide" name="ide" value="<?php echo $_POST['ide']; ?>">
<input type="submit" name="btnTambah" id="btnTambah" value="Save" class="btnNavigasi" tabindex="3" onclick="tambahDataCategory()"/>
<br />
<br /></td>
      </tr>
    </table></td>
	</tr>
	</table>
</form>
