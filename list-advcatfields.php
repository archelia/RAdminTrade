<?php
session_start();
if (!isset($_SESSION['adzuser'])){header('Location:index.php');}
$id="";
if(isset($_GET['ide']))$id=$_GET['ide'];
if(isset($_POST['ide']))$id=$_POST['ide'];
if($id==""){header('Location:list-advcategory.php');}
include "top.php";

$qcat="SELECT categoryname FROM advcategory WHERE idadvcategory='$id'";
$rowcat=mysql_fetch_array(mysql_query($qcat));
if(isset($_POST['add']))
{
	// saving 
	$pesan="";
	// cek apakah ada field yang sama
	$qcek="SELECT * FROM field_adcategory WHERE idfield='$_POST[idfield]' AND idadvcategory='$_POST[ide]'";
	$rescek=mysql_query($qcek);
	if(mysql_num_rows($rescek)>0)
	$pesan.="This field has already in.\\n";
	
	if($pesan=="")
	{
	$qsimpan="INSERT INTO field_adcategory VALUES";
	$qsimpan.="('$_POST[idfield]','$_POST[ide]')";
	$rsimpan=mysql_query($qsimpan);
	}
	if($rsimpan)
	{
	$pesan.="Data has been saved !";
	}
	else
	{
	$pesan.="Data failed to save !";
	}	
	echo "<script>alert(\"$pesan\");windows.location='list-advcatfields.php?ide=\"$id\"';</script>";		
}

?>
<div id="list" style="margin-top:1.5em;">
<table width="60%" cellspacing="2" cellpadding="2" align="center" bgcolor="#A9D0F5" border="0">
<tr>
	<td align="left" bgcolor="#FFFFFF" colspan="2"><h4>Advertisement Category Field List</h4></td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td colspan="2"><b>Category : <?php echo $rowcat[0];?></b></td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>	
	<form name="formcari" id="formcari" method="POST" action="list-advcatfields.php">
	<td colspan="2" align="center">
	Add new field to this category : 
	<select name="idfield" id="idfield">
		<option value="0">--Choose Field--</option>
		<?php
		$qfield="SELECT * FROM fields WHERE active=1 AND idfield NOT in ";
		$qfield.="(SELECT idfield FROM field_adcategory WHERE idadvcategory='$id') ORDER by fieldname ASC ";		
		$rfield=mysql_query($qfield);
		while($rowf = mysql_fetch_array($rfield))
		{
			echo'<option value='.$rowf["idfield"].'>'.$rowf["fieldname"].'</option>';
		}
		?>
	</select>	
	<input type='hidden' name='ide' id='ide' value='<?php echo $id;?>'>
	<input type='submit' name='add' id='add' value='Add field'>
	</td>
	</form>	
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td align="left" colspan="2">
	<table width="70%" cellspacing="0" cellpadding="1" align="center" bgcolor="#A9D0F5" border="1"  bordercolor="#FFFFFF">
	<tr>
		<th align="center" width="20%">No</td>
		<th align="center" width="60%">Fieldname</td>
		<th align="center" width="20%">Delete</td>
	</tr>
	<?php
	$query="SELECT fa.*, f.fieldname FROM field_adcategory fa, fields f ";
	$query.="WHERE f.idfield=fa.idfield AND idadvcategory='$id' ORDER BY f.fieldname ASC";
	$result=mysql_query($query);
	if(mysql_num_rows($result)<1)
	{
	echo "<tr><td colspan='3' align='center'>There are no field in this category</td></tr>";
	}
	else
	{
		$i = 1;
		while($row = mysql_fetch_array($result))
		{
			echo "<tr>
				<td width='5%' align='right'>".$i."</td>
				<td width='80%'>".ucwords($row['fieldname'])."</td>";	
			echo '<td width="15%" align="left">';
			?>
			<form action="deletesuper.php" method="POST" onsubmit="return confirm('Are you sure want to delete this category field?');">				
			<?php
			echo '
			<input type="submit" name="submit" id="submit" value="Delete">
			<input type="hidden" name="tabel" id="tabel" value="field_adcategory">
			<input type="hidden" name="ide" id="ide" value='.$id.'>
			<input type="hidden" name="namaid" id="namaid" value="idadvcategory">
			<input type="hidden" name="ide2" id="ide2" value='.$row["idfield"].'>		
			<input type="hidden" name="namaid2" id="namaid2" value="idfield">	
			<input type="hidden" name="page" id="page" value="list-advcatfields.php?ide='.$id.'">		
			</form>';
			echo "</td></tr>";
			$i++;
		}
	}
	?>
	</table>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td width="40%" align="left">
		<input type="button" name="back" id="back" value="Back" onclick="window.location='list-advcategory.php';">
	</td>
	<td width="60%" align="left">&nbsp;</td>
</tr>
</table>
</div>