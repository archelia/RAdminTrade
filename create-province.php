<?php
session_start();
if (!isset($_SESSION['adzuser'])){header('Location:./index.php');}
include "top.php";

if (isset($_POST["submit"]))
{
	// begin validating
	$error= "";
	// generate new iduser
	$sqlr = "SELECT * from province WHERE provincename='$_POST[nama]' and idcountry='$_POST[idcountry]'";
	$resultr = mysql_query($sqlr);
	$rowr=mysql_fetch_array($resultr);
	if ($rowr>0) {$error.="This province name is already exist !\\n";}
	//if ($_POST["username"]==""){$error.="Please fill in the username !\\n";}
	//if ($_POST["usertype"]=="0"){$error.="You haven\'t choose the user type !";}
	
	// saving data
	if ($error=="")
	{				 	
		$newid=0;
		// generate new id province
		$sqlr = "SELECT max(idprovince) as newid from province ";
		$resultr = mysql_query($sqlr);
		if (mysql_num_rows($resultr)<1){$newid=1;}
		else
		{
		$rowr=mysql_fetch_array($resultr);
		$newid=$rowr['newid']+1;
		}
		
		$query="INSERT INTO province ";
		$query.="VALUES ('$newid','$_POST[idcountry]','$_POST[nama]',1)";
		$result=mysql_query($query);
		if ($result)
		echo "<script>alert('Province data has been saved !');window.location='list-province.php?id=$_POST[idcountry]';</script>";
		else echo "<script>alert('Data failed to save !');window.location='create-province.php';</script>";
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
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#nama").focus();
	$("#formulir").submit(function(){
		if($.trim($("#nama").val())==""){
			alert("Please fill the province name !");
			$("#nama").focus();
			return false;
		}
		if($("#idcountry").val()=="0"){
			alert("Please choose the country name");
			$("#idcountry").focus();
			return false;
		}
		
		/*
		validasi integer only
		var ekspresiRegular=new RegExp(/^[\+]?\d+$/);
		var nilai = $.trim($("#phcode").val());
		if (nilai=="" || !ekspresiRegular.test(nilai)){
		alert("Please enter numbers or '+' for Phone Area Code ");
		$("#phcode").focus();
		return false;
		}
		*/
	});
});	
</script>
<form action="create-province.php" method="POST" name="formulir" id="formulir">
<table width="50%" border="0" cellspacing="1" cellpadding="1" bgcolor="#CCCCCC" align="center">
<tr>
	<td align="left" colspan="3" bgcolor="#FFFFFF" valign="middle"><h4>Create Province</h4></td>
<tr>
<tr>
	<td align="right">Country</td>
	<td align="center">:</td>
	<td align="left">
		<SELECT NAME="idcountry" id="idcountry">
			<OPTION VALUE='0' selected>--Choose Country --</option>
			<?php
			$qs ="SELECT * FROM country WHERE active=1 ORDER BY countryname ASC";
			$rs=mysql_query($qs);
			while($rws = mysql_fetch_array($rs))
			{
			echo "<OPTION VALUE='$rws[idcountry]'>$rws[countryname]</option>";
			}
			?>	
		</SELECT><label class="kecilmerah"> *</label>		  
	</td>
</tr>
<tr>
	<td align="right" width="30%">Province Name</td>
	<td align="center" width="5%">:</td>
	<td align="left" width="65%"><input type="text" name="nama" id="nama" size="29" maxlength='100'><label class="kecilmerah"> *</label></td>
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
		<input type="submit" name="submit" value="Save" style="width:60px;">		
	</td>
</tr>
</table>
</form>
