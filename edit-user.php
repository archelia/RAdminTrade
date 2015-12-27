<?php
session_start();
if (!isset($_SESSION['adzuser'])){header('Location:./index.php');}
include "top.php";
// if this page isn't come from the user list or submit from this page
if (!isset($_POST['ide'])&&!isset($_POST['submit'])){header('Location:list-user.php');}

$query="SELECT * FROM user WHERE iduser='$_POST[ide]'";
$result=mysql_query($query);
$row = mysql_fetch_assoc($result);

if (isset($_POST["save"]))
{
	// begin validating
	$error= "";
	// generate new iduser
	$sqlr = "SELECT * from user WHERE username='$_POST[username]' and username !='$_POST[usernamelama]'";
	$resultr = mysql_query($sqlr);
	$rowr=mysql_fetch_array($resultr);
	if ($rowr>0) {$error.="This username has been taken !\\n";}
	if ($_POST["username"]==""){$error.="Please fill in the username !\\n";}
	if ($_POST["password1"]!=$_POST["password2"]){$error.="Password doesn\'t match !\\n";}
	if ($_POST["usertype"]=="0"){$error.="You haven\'t choose the user type !";}
	
	// saving data
	if ($error=="")
	{				
		$query  = "UPDATE user SET ";
		$query .= "username='$_POST[username]', usertype='$_POST[usertype]', active='$_POST[active]'";
		if ($_POST["password1"]!=""){$query .= ",password=md5('$_POST[password1]') ";}
		$query .= "WHERE iduser='$_POST[ide]'";
		$result=mysql_query($query);
		echo "<script>alert('User data has been saved !');window.location='./list-user.php';</script>";
	}
	else
	{
		echo '<script type=\'text/javascript\'>var msg; msg='.$error.';</script>';		
		echo "<script>alert(\"$error\")</script>";		
	}
}


?>
<link rel="stylesheet" type="text/css" href="library/style2.css" />
<script type="text/javascript">
function klikBack()
{
window.location='javascript:javascript:history.go(-1)';
}

</script>
<form action="edit-user.php" method="POST">
<table width="50%" border="0" cellspacing="1" cellpadding="1" align="center" bgcolor="#CCCCCC">
<tr>
	<td align="left" colspan="3" bgcolor="#FFFFFF" valign="middle"><h4>Edit User Data</h4></td>
</tr>
<tr>
	<td align="right" >Username</td>
	<td align="center">:</td>
	<td align="left" colspan="2"><input type="text" name="username" id="username" size="29" maxlength="20" value="<?php echo $row['username']; ?>"><label class="kecilmerah"> *</label></td>
</tr>
<tr>
	<td align="right">Old Password</td>
	<td align="center">:</td>
	<td align="left" colspan="2"><input type="password" name="password" id="password" size="29" maxlength="250" value="<?php echo $row['password']; ?>" disabled></td>
</tr>
<tr>
	<td align="right">New Password</td>
	<td align="center">:</td>
	<td align="left" colspan="2"><input type="password" name="password1" id="password1" size="29" maxlength="30" value=""><label class="kecilmerah"> *</label></td>
</tr>
<tr>
	<td align="right">Confirm New Password</td>
	<td align="center">:</td>
	<td align="left" colspan="2"><input type="password" name="password2" id="password2" size="29" maxlength='30' value=""><label class="kecilmerah"> *</label></td>
</tr>
<tr>
	<td align="right">User Type</td>
	<td align="center">:</td>
	<td align="left" colspan="2">
		<SELECT NAME="usertype" id="usertype">	
		<OPTION VALUE='1' <?php if ($row['usertype']=='1') echo "selected"; ?>>Administrator</option>
		<OPTION VALUE='2' <?php if ($row['usertype']=='2') echo "selected"; ?>>Marketting</option>
		</SELECT>		  
	</td>
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
	<td width="35%">&nbsp;</td>
	<td width="5%">&nbsp;</td>
	<td width="60%"><input type="submit" name="save" id="save" value="Save">	
		<input type="hidden" name="usernamelama" id="usernamelama" value="<?php echo $row['username']; ?>">		
		<input type="hidden" name="ide" id="ide" value="<?php echo $row['iduser']; ?>">	
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
</form>
</table>

