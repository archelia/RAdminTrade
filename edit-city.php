<?php
session_start();
if (!isset($_SESSION['adzuser'])){header('Location:./index.php');}
if (!isset($_POST['ide'])){header('Location:list-country.php');}
include "top.php";

if (isset($_POST["save"]))
{
	// begin validating
	$error= "";
	// generate new iduser
	$sqlr = "SELECT * from city WHERE cityname='$_POST[nama]' and idcountry='$_POST[idcountry]' and cityname!='$_POST[citylama]'";
	$resultr = mysql_query($sqlr);
	$rowr=mysql_fetch_array($resultr);
	if ($rowr>0) {$error.="This city name is already exist !\\n";}
	
	// saving data
	if ($error=="")
	{				 	
		$query="UPDATE city ";
		$query.="SET idprovince='$_POST[idprovince]', idcountry='$_POST[idcountry]', cityname='$_POST[nama]', active='$_POST[active]' ";
		$query.="WHERE idcity='$_POST[ide]'";
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

$query="SELECT * FROM city WHERE idcity='$_POST[ide]'";
$result=mysql_query($query);
$row=mysql_fetch_array($result);
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
	$("#idprovince").show();
	$("#propinsi").hide();
	$("#idcountry").focus();
	$("#formulir").submit(function(){
		if($.trim($("#nama").val())==""){
			alert("Please fill the city name !");
			$("#nama").focus();
			return false;
		}		
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
<form action="edit-city.php" method="POST" name="formulir" id="formulir">
<table width="50%" border="0" cellspacing="1" cellpadding="1" align="center" bgcolor="#CCCCCC">
<tr>
	<td align="left" colspan="3" bgcolor="#FFFFFF" valign="middle"><h4>Edit City</h4></td>
</tr>
<tr>
	<td align="right">Country</td>
	<td align="center">:</td>
	<td align="left">
		<SELECT NAME="idcountry" id="idcountry" onchange="showpropinsi()">
			<?php
			$qs ="SELECT * FROM country WHERE active=1 ORDER BY countryname ASC";
			$rs=mysql_query($qs);
			while($rws = mysql_fetch_array($rs))
			{
			if ($rws['idcountry']==$row['idcountry'])
			echo "<OPTION VALUE='$rws[idcountry]' selected>$rws[countryname]</option>";
			else echo "<OPTION VALUE='$rws[idcountry]'>$rws[countryname]</option>";
			}
			?>	
		</SELECT><label class="kecilmerah"> *</label>
		<input type="hidden" name="citylama" id="citylama" value="<?php echo $row['cityname']; ?>">
	</td>
</tr>
<tr>
	<td align="right">Province</td>
	<td align="center">:</td>
	<td align="left">
		<p id="propinsi" name="propinsi" style="font-style:italic;">Please select Country First</p>
		<SELECT name="idprovince" id="idprovince">
		<?php
			$qp ="SELECT * FROM province WHERE active=1 AND idcountry='$row[idcountry]' ORDER BY provincename ASC";
			$rp=mysql_query($qp);
			while($rwp = mysql_fetch_array($rp))
			{
			if ($rwp['idprovince']==$row['idprovince'])
			echo "<OPTION VALUE='$rwp[idprovince]' selected>$rwp[provincename]</option>";
			else echo "<OPTION VALUE='$rwp[idprovince]'>$rwp[provincename]</option>";
			}
			?>	
		</SELECT><label class="kecilmerah"> *</label>	  
	</td>
</tr>
<tr>
	<td align="right" width="30%">City Name</td>
	<td align="center" width="5%">:</td>
	<td align="left" width="65%"><input type="text" name="nama" id="nama" size="29" maxlength='100' value="<?php echo $row['cityname'];?>"><label class="kecilmerah"> *</label></td>
</tr>
<tr>
	<td align="right">Active</td>
	<td align="center">:</td>
	<td colspan="2">
		<Input type = 'Radio' Name ='active' value= '1' <?php if ($row['active']=1) echo "checked"; ?>>Active
		<Input type = 'Radio' Name ='active' value= '0' <?php if ($row['active']=0) echo "checked"; ?>>Inactive
	</td>
</tr>
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
		<input type="hidden" name="ide" id="ide" value="<?php echo $row['idcity']; ?>">
		<input type="button" name="batal" value="Back" class="btnNavigasi" onClick="klikBack()">
		<input type="reset" name="reset" id="Reset">
		<input type="submit" name="save" id="save" value="Save" style="width:70px">		
	</td>
</tr>	
</form>
</table>
