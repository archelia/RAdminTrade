<?php
session_start();
if (!isset($_SESSION['adzuser'])){header('Location:./index.php');}

// if this page isn't come from the user list or submit from this page
if (!isset($_POST['ide'])){header('Location:list-Scale.php');}

include "../library/conn.php";

$query="SELECT * FROM scale WHERE idscale='$_POST[ide]'";
$result=mysql_query($query);
$row = mysql_fetch_assoc($result);

if (isset($_POST["save"]))
{
	// begin validating
	$error= "";
	if ($_POST["name"]==""){$error.="Please fill in the Scale !\\n";}
	
	// saving data
	if ($error=="")
	{				
		// upload gambar bila gambar diisi		
		$query  = "UPDATE scale SET ";
		$query .= "scale='$_POST[name]' ";
		$query .= "WHERE idscale='$_POST[ide]'";
		$result=mysql_query($query);
		echo "<script>alert('Scale data has been saved !');window.location='./list-Scale.php?id=$_POST[ide]';</script>";
	}
	else
	{
		echo '<script type=\'text/javascript\'>var msg; msg='.$error.';</script>';		
		echo "<script>alert(\"$error\")</script>";		
	}
}
?>
<link rel="stylesheet" type="text/css" href="library/style2.css" />

<form action="edit-Scale.php" method="POST" enctype="multipart/form-data">
<table width="50%" border="0" cellspacing="1" cellpadding="1" align="center" bgcolor="#CCCCCC">
<tr>
	<td align="left" colspan="3" bgcolor="#FFFFFF" valign="middle"><h4>Edit Scale</h4></td>
</tr>
<tr>
	<td align="right">Scale</td>
	<td align="center">:</td>
	<td align="left" colspan="2"><input type="text" name="name" id="name" size="29" maxlength="250" value="<?php echo $row['scale']; ?>"><label class="kecilmerah"> *</label></td>
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
	<td width="60%">
		<input type="hidden" name="ide" id="ide" value="<?php echo $row['idscale']; ?>">
		<input type="button" name="batal" value="Back" class="btnNavigasi" onClick="klikBack()">
		<input type="reset" name="reset" id="Reset">
		<input type="submit" name="save" id="save" value="Save" style="width:70px">		
	</td>
</tr>	
</form>
</table>

<script type="text/javascript">
$( document ).ready(function() {
  // Handler for .ready() called.
});

function klikBack()
{
window.location='javascript:javascript:history.go(-1)';
}

</script>