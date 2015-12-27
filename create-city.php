<?php
session_start();
if (!isset($_SESSION['adzuser'])){header('Location:./index.php');}
include "top.php";

if (isset($_POST["submit"]))
{
	// begin validating
	$error= "";
	// generate new iduser
	//$sqlr = "SELECT * from city WHERE cityname='$_POST[nama]' and idcountry='$_POST[idcountry]'";
	//$resultr = mysql_query($sqlr);
	//$rowr=mysql_fetch_array($resultr);
	//if ($rowr>0) {$error.="This city name is already exist !\\n";}
	
	// saving data
	if ($error=="")
	{				 	
		$newid=0;
		// generate new id city
		$sqlr = "SELECT max(idcity) as newid from city ";
		$resultr = mysql_query($sqlr);
		if (mysql_num_rows($resultr)<1){$newid=1;}
		else
		{
		$rowr=mysql_fetch_array($resultr);
		$newid=$rowr['newid']+1;
		}
		
		$query="INSERT INTO city ";
		$query.="VALUES ('$newid','$_POST[idprovince]','$_POST[idcountry]','$_POST[nama]',1)";
		$result=mysql_query($query);
		if ($result)
		echo "<script>alert('City data has been saved !');window.location='list-city.php?id=$_POST[idcountry]';</script>";
		else echo "<script>alert('Data failed to save !');window.location='create-city.php';</script>";
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
{
window.location='javascript:javascript:history.go(-1)';
}

</script>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#idprovince").hide();
	$("#propinsi").show();
	$("#idcountry").focus();
	$("#formulir").submit(function(){
		if($.trim($("#nama").val())==""){
			alert("Please fill in the city name !");
			$("#nama").focus();
			return false;
		}
		if($("#idcountry").val()=="0"){
			alert("Please choose the country name !");
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

function showpropinsi(){
<!-- buat nampilin div provinsi-->
	   var select = document.getElementById("idcountry"); 
       var myvalue= select.options[select.selectedIndex].value;
	   var dataString = 'idcountry='+ myvalue;
	   document.getElementById('idprovince').value="0";
	     $.ajax({
           type: "POST",
           url: "get-province.php",
           data: dataString,
           cache: false,
           success: function(html)
		   {    
			//alert(html); 
		    document.getElementById("idprovince").innerHTML =html;	
           }
        });	
	$("#idprovince").show();
	$("#propinsi").hide();		
};
</script>
<form action="create-city.php" method="POST" name="formulir" id="formulir">
<table width="50%" border="0" cellspacing="1" cellpadding="1" align="center" bgcolor="#CCCCCC">
<tr>
	<td align="left" colspan="3" bgcolor="#FFFFFF" valign="middle"><h4>Create City</h4></td>
<tr>
<tr>
	<td align="right">Country</td>
	<td align="center">:</td>
	<td align="left">
		<SELECT NAME="idcountry" id="idcountry" onchange="showpropinsi()">
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
	<td align="right">Province</td>
	<td align="center">:</td>
	<td align="left">
		<p id="propinsi" name="propinsi" class="kecilmiring">Please select Country first</p>
		<SELECT name="idprovince" id="idprovince">
		</SELECT>	  
	</td>
</tr>
<tr>
	<td align="right" width="30%">City Name</td>
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
		<input type="submit" name="submit" value="Save" style="width:70px">			
	</td>
</tr>
</table>
</form>
