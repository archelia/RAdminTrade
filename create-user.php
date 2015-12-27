<?php
session_start();
if (!isset($_SESSION['adzuser'])){header('Location:./index.php');}
include "top.php";

if (isset($_POST["submit"]))
{
	// begin validating
	$error= "";
	// generate new iduser
	$sqlr = "SELECT * from user WHERE username='$_POST[username]'";
	$resultr = mysql_query($sqlr);
	$rowr=mysql_fetch_array($resultr);
	if ($rowr>0) {$error.="This username has been taken !\\n";}
	if ($_POST["username"]==""){$error.="Please fill in the username !\\n";}
	if ($_POST["password1"]==""){$error.="Please fill in the password !\\n";}
	if ($_POST["password1"]!=$_POST["password2"]){$error.="Password doesn\'t match !\\n";}
	if ($_POST["usertype"]=="0"){$error.="You haven\'t choose the user type !";}
	
	// saving data
	if ($error=="")
	{	
		// taking ip user
		$client_ip = getIP();
				 	
		$newid=0;
		// generate new iduser
		$sqlr = "SELECT max(iduser) as newid from user ";
		$resultr = mysql_query($sqlr);
		if (mysql_num_rows($resultr)<1){$newid=1;}
		else
		{
		$rowr=mysql_fetch_array($resultr);
		$newid=$rowr['newid']+1;
		}
		
		$query="INSERT INTO user ";
		$query.="VALUES ('$newid','$_POST[username]',md5('$_POST[password1]'),'$_POST[usertype]', now(), now(), '$client_ip',1)";
		$result=mysql_query($query);
		echo "<script>alert('User data has been saved !');window.location='./index.php';</script>";
	}
	else
	{
		echo '<script type=\'text/javascript\'>var msg; msg='.$error.';</script>';		
		// only works with the double quotes siiih spent 2 hours on it
		echo "<script>alert(\"$error\")</script>";		
	}
}
?>

<link rel="stylesheet" type="text/css" href="library/style2.css" />
<script type="text/javascript">
function klikBack()
{window.location='javascript:javascript:history.go(-1)';}
</script>
<div align="center">
<form action="create-user.php" method="POST">
<table width="50%" border="0" cellspacing="2" cellpadding="2" align="center" bgcolor="#CCCCCC">
<tr>
	<td align="left" colspan="3" bgcolor="#FFFFFF" valign="middle"><h4>Create User</h4></td>
<tr>
</tr>
	<td align="right" width="30%">Username</td>
	<td align="center" width="5%">:</td>
	<td align="left" width="65%"><input type="text" name="username" id="username" size="29" maxlength='20'><label class="kecilmerah"> *</label></td>
</tr>
<tr>
	<td align="right">Password</td>
	<td align="center">:</td>
	<td align="left"><input type="password" name="password1" id="password1" size="29" maxlength='30'><label class="kecilmerah"> *</label></td>
</tr>
<tr>
	<td align="right">Confirm Password</td>
	<td align="center">:</td>
	<td align="left"><input type="password" name="password2" id="password2" size="29" maxlength='30'><label class="kecilmerah"> *</label></td>
</tr>
<tr>
	<td align="right">User Type</td>
	<td align="center">:</td>
	<td align="left"><SELECT NAME="usertype" id="usertype">
		<OPTION VALUE='0' selected>--Choose User Type --</option>
		<OPTION VALUE='1'>Administrator</option>
		<OPTION VALUE='2'>Marketting</option>";
		</SELECT>
	<label class="kecilmerah"> *</label>		
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
		<input type="button" name="batal" value="Back" class="btnNavigasi" onClick="klikBack()">	
		<input type="reset" name="reset" id="Reset">
		<input type="submit" name="submit" value="Save" style="width:70px">			  
	</td>
</tr>
</table>
</form>
</div>
