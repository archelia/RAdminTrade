<?php
 session_start();
 if (!isset($_SESSION['adzuser'])){header('Location:./index.php');}
 include "top.php";
 
if(isset($_POST['btnTambah']))
{
	$eror="";
	// begin validating
	$sqlr = "SELECT * from fields WHERE fieldname='$_POST[nama_field]'";
	$resultr = mysql_query($sqlr);
	$rowr=mysql_fetch_array($resultr);
	if ($rowr>0) {$eror.="This field already exist, please choose another field name !\\n";}
	if ($eror=="")
	{
		$kode=0;
		// generate new id
		$sqlr = "SELECT max(idfield) as newid from fields ";
		$resultr = mysql_query($sqlr);
		if (mysql_num_rows($resultr)<1){$kode=1;}
		else
		{
		$rowr=mysql_fetch_array($resultr);
		$kode=$rowr['newid']+1;
		}

		$query = "insert into fields values ('".$kode."','".$_POST['nama_field']."','".$_POST['ftype']."','".$_POST['level']."',now(),'".$_SESSION['adzuser']."','1')";
		$tambah = mysql_query($query);

		if($tambah)
		{

			echo "<script language='javascript'>alert('Add Field Success');
				  window.location='list-catfields.php';
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
        <td bgcolor="#FFFFFF" colspan="3"><h4>Add Field</h4></td>
      </tr>
      <tr>
        <td width="132" class="label2"><div align="right">Field Name</div></td>
        <td width="7" class="label2"><div align="center">: </div></td>
        <td width="477" ><div align="left"><input tabindex="1" name="nama_field" id="nama_field"  size="70" value="" /> 
          * </div></td>
      </tr>
      <tr>
        <td width="132" class="label2"><div align="right">Field Type</div></td>
        <td width="7" class="label2"><div align="center">: </div></td>
        <td width="477" ><div align="left">
			<select name="ftype" id="ftype">
				<option value="1" selected>Text</option>
				<option value="2">Options</option>
				<option value="3">Lists</option>
			</select>
          * </div></td>
      </tr>
      <tr>
        <td width="132" class="label2"><div align="right">Field Level</div></td>
        <td width="7" class="label2"><div align="center">: </div></td>
        <td width="477" ><div align="left">
			<select name="level" id="level">
				<option value="1" selected>1</option>
				<option value="2">2</option>
			</select>
			</div></td>
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
<input type="submit" name="btnTambah" id="btnTambah" value="Save" class="btnNavigasi" tabindex="3" onclick="tambahDataCategory()"/>
<br />
<br /></td>
      </tr>
    </table></td>
	</tr>
	</table>
</form>

<script type="text/javascript">
$(document).ready(function(){
	$("#fparent").hide();
	$("#formulir").submit(function(){
		if($.trim($("#nama_field").val())==""){
			alert("Please fill in the field name !");
			$("#nama_field").focus();
			return false;
		}
	});
});	
</script>