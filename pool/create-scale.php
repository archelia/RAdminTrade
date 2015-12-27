<?php
 session_start();
 if (!isset($_SESSION['adzuser'])){header('Location:./index.php');}
 include "../library/conn.php";
if(isset($_POST['btnTambah']))
{
	$eror="";
	// begin validating
	$sqlr = "SELECT * from scale WHERE scale='$_POST[name]'";
	$resultr = mysql_query($sqlr);
	$rowr=mysql_fetch_array($resultr);
	if ($rowr>0) {$eror.="This scale already exists, please choose another Scale !\\n";}
	if ($_POST['name']==""){$eror.="Scale can\'t be empty! \\n";}
	if ($eror=="")
	{
		$kode=0;
		// generate new id
		$sqlr = "SELECT max(idscale) as newid from scale ";
		$resultr = mysql_query($sqlr);
		$rowr=mysql_fetch_array($resultr);
		if ($rowr['newid']<1){$kode=time();}
		else
		{		
		$kode=$rowr['newid']+1;
		}

		$query = "insert into Scale values ('".$kode."','".$_POST['name']."')";
		$tambah = mysql_query($query);
		if($tambah)
		{

			echo "<script language='javascript'>alert('Add Scale Success');
				  window.location='list-Scale.php';
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


<br>
 <form name="frmTambahScaleTrading" method="post" action="">
	<table cellpadding="0" cellspacing="0" bgcolor="#CCCCCC" align="center">
    <tr>
    <td width="100%"><table cellpadding="8" cellspacing="1">
      <tr>
        <td bgcolor="#FFFFFF" colspan="3"><h4>Add Scale</h4></td>
      </tr>
      <tr>
        <td width="132" class="label2"><div align="right">Scale</div></td>
        <td width="7" class="label2"><div align="center">: </div></td>
        <td width="477" ><div align="left"><input tabindex="1" name="name" id="name"  size="70" value="" /> 
          * </div></td>
      </tr>
      <tr>
        <td colspan="2" class="input2" valign="top"><div align="right"> * ) Must be filled ! </div></td>
        <td class="input2"><input type="button" name="batal" value="Back" class="btnNavigasi" onclick="klikBack()" />
&nbsp;
<input type="reset" name="reset" id="Reset" />
&nbsp;
<input type="submit" name="btnTambah" id="btnTambah" value="Save" class="btnNavigasi" tabindex="3" onclick="tambahDataScale()"/>
<br />
<br /></td>
      </tr>
    </table></td>
	</tr>
	</table>
</form>

<script type="text/javascript" src="../jquery.js"></script>
<script>
function klikBack()
{
window.location='javascript:javascript:history.go(-1)';
}
</script>
<script type="text/javascript">
$(document).ready(function(){
	$("#name").focus();
});	
</script>
