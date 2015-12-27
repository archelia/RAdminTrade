<?php
session_start();
if (!isset($_SESSION['adzuser'])){header('Location:./index.php');}
include "top.php";
// if this page isn't come from the member list or submit from this page
if (!isset($_POST['ide'])){header('Location:list-member.php');}

$query="SELECT * FROM member WHERE idmember='$_POST[ide]'";
$result=mysql_query($query);
$row = mysql_fetch_assoc($result);

if (isset($_POST["save"]))
{		
	$query  = "UPDATE member SET ";
	$query .= "username='$_POST[username]', membername='$_POST[membername]', membertype='$_POST[membertype]', telephone='$_POST[telephone]', ";
	$query .= "address='$_POST[address]', location='$_POST[location]', email='$_POST[email]', idyahoo='$_POST[yahooid]',active='$_POST[active]'";
	$query .= "WHERE idmember='$_POST[ide]'";
	$result=mysql_query($query);

	if ($result)
	echo "<script>alert('Member data has been saved !'); window.location='list-member.php';</script>";
	else echo "<script>alert('Member failed to save !'); window.location='list-member.php';</script>";
}

// for click back
$last=$_POST['page'];
?>
<link rel="stylesheet" type="text/css" href="library/style2.css" />
<script type="text/javascript">
function klikBack()
{
//window.location='javascript:javascript:history.go(-1)';
window.location='<?php echo $last;?>';
}
</script>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#membername").focus();
	$("#formulir").submit(function(){
		if($.trim($("#membername").val())==""){
		alert("Please fill in the member name !");
		$("#membername").focus();
		return false;
		}	
		if($.trim($("#username").val())==""){
		alert("Please fill in the username !");
		$("#username").focus();
		return false;
		}			
		// email validation
		var emailval = $.trim($("#email").val());
		if(emailval==""){
			alert("Please fill in the email !");
			$("#email").focus();
			return false;
		}
		var ekspresiRegularImel=new RegExp(/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);	
		if (emailval=="" || !ekspresiRegularImel.test(emailval)){
			alert("Please enter a valid email !");
			$("#email").focus();
			return false;
		}
		//var ekspresiRegularAngka=new RegExp(/^\d+$/);
		var ekspresiRegularTelp=new RegExp(/^[\+]?\d+$/); 
		var nilai = $.trim($("#telephone").val());		
		if (nilai=="" || !ekspresiRegularTelp.test(nilai)){
			alert("Please enter numbers for telephone data");
			$("#telephone").focus();
			return false;
		}		
	});	
});	
</script>
<form action="edit-member.php" method="POST" id="formulir" name="formulir">
<table width="50%" border="0" cellspacing="1" cellpadding="1" align="center" bgcolor="#CCCCCC">
<tr>
	<td align="left" colspan="3" bgcolor="#FFFFFF" valign="middle"><h4>Edit Member</h4></td>
</tr>
<tr>
	<td align="right" >Username</td>
	<td align="center">:</td>
	<td align="left" colspan="2"><input type="text" name="username" id="username" size="29" maxlength="200" value="<?php echo $row['username']; ?>"><label class="kecilmerah"> *</label></td>
</tr>
<tr>
	<td align="right" >Member Name</td>
	<td align="center">:</td>
	<td align="left" colspan="2"><input type="text" name="membername" id="membername" size="29" maxlength="200" value="<?php echo $row['membername']; ?>"><label class="kecilmerah"> *</label></td>
</tr>
<tr>
	<td align="right">Member Type</td>
	<td align="center">:</td>
	<td align="left" colspan="2">
		<SELECT NAME="membertype" id="membertype">	
		<OPTION VALUE='0' <?php if ($row['membertype']=='0') echo "selected"; ?>>Copper</option>
		<OPTION VALUE='1' <?php if ($row['membertype']=='1') echo "selected"; ?>>Silver</option>
		<OPTION VALUE='2' <?php if ($row['membertype']=='2') echo "selected"; ?>>Gold</option>
		</SELECT><label class="kecilmerah"> *</label>	
	</td>
</tr>
<tr>
	<td align="right" >Email</td>
	<td align="center">:</td>
	<td align="left" colspan="2"><input type="text" name="email" id="email" size="29" maxlength="150" value="<?php echo $row['email']; ?>"><label class="kecilmerah"> *</label></td>
</tr>
<tr>
	<td align="right">Telephone</td>
	<td align="center">:</td>
	<td align="left" colspan="2"><input type="text" name="telephone" id="telephone" size="29" maxlength='30' value="<?php echo $row['telephone']; ?>"></td>
</tr>
<tr>
	<td align="right">Address</td>
	<td align="center">:</td>
	<td align="left" colspan="2"><input type="text" name="address" id="address" size="29" maxlength='100' value="<?php echo $row['address']; ?>">
	</td>
</tr>
<tr>
	<td align="right">Location</td>
	<td align="center">:</td>
	<td align="left" colspan="2"><input type="text" name="location" id="location" size="29" maxlength='100' value="<?php echo $row['location']; ?>">
	</td>
</tr>
<tr>
	<td align="right" >Yahoo ID</td>
	<td align="center">:</td>
	<td align="left" colspan="2"><input type="text" name="yahooid" id="yahooid" size="29" maxlength="100" value="<?php echo $row['idyahoo']; ?>"></td>
</tr>
<tr>
	<td align="right" >Member Since</td>
	<td align="center">:</td>
	<td align="left" colspan="2"><?php echo $row['joindate']; ?></td>
</tr>
<tr>
	<td align="right">Active</td>
	<td align="center">:</td>
	<td colspan="2">
		<Input type = 'Radio' Name ='active' value= '1' <?php if ($row['active']==1) echo "checked"; ?>>Active
		<Input type = 'Radio' Name ='active' value= '0' <?php if ($row['active']==0) echo "checked"; ?>>Inactive
	</td>
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
		<input type="hidden" name="ide" id="ide" value="<?php echo $row['idmember']; ?>">
		<input type="button" name="batal" value="Back" class="btnNavigasi" onClick="klikBack()">
		<input type="reset" name="reset" id="Reset">
		<input type="submit" name="save" id="save" value="Save" style="width:70px">		
	</td>
</tr>	
</form>
</table>

