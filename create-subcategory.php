<?php
 session_start();
 if (!isset($_SESSION['adzuser'])){header('Location:./index.php');}
 include "top.php";
 
if(isset($_POST['btnTambah']))
{	
	$eror="";
	// begin validating
	if ($_POST['idkategori']=="nol"){$eror.="Please choose a category! \\n";}
	if ($_POST['nama_category']==""){$eror.="Subcategory Name can\'t be empty! \\n";}
	if ($_POST['category_description']==""){$eror.="Category Description can\'t be empty!";}
	if ($eror=="")
	{
		$kode=0;
		// generate new id
		$sqlr = "SELECT max(idsubcategory) as newid from subcategory ";
		$resultr = mysql_query($sqlr);
		if (mysql_num_rows($resultr)<1){$kode=1;}
		else
		{
		$rowr=mysql_fetch_array($resultr);
		$kode=$rowr['newid']+1;
		}

		$query = "insert into subcategory values ('".$kode."','".$_POST['idkategori']."','".$_POST['nama_category']."','".$_POST['category_description']."','"."1"."')";
		$tambah = mysql_query($query);
		if($tambah)
		{
			$location="list-subcategory.php?id=".$_POST['idkategori'];
			echo "<script language='javascript'>alert('Add Subcategory Success');
				  window.location=\"$location\";
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
<link rel="stylesheet" type="text/css" href="library/style2.css" />
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript">
function klikBack()
{
window.location='javascript:javascript:history.go(-1)';
}

</script> 
<form name="frmTambahCategoryTrading" method="post" action="create-subcategory.php" autocomplete="off">
<table width="50%" border="0" cellspacing="2" cellpadding="2" align="center" bgcolor="#CCCCCC">
<tr>
	<td align="left" colspan="3" bgcolor="#FFFFFF" valign="middle"><h4>Create Subcategory</h4></td>
<tr>
<tr>
	<td align="right">Choose Category</td>
	<td align="center">:</td>
	<td>
		<select name="idkategori" id="idkategori" tabindex="1" style="width:170px;">
		  <option value="nol">--- Choose Category ---</option>
		  <?php
			$data = mysql_query("select * from category");
			while($hslData = mysql_fetch_array($data))
			{

				$id = $hslData["idcategory"];

				$namaCategory = $hslData["categoryname"];

				echo "<option value=\"".$id."\">".ucwords($namaCategory)."</option>   ";

			}

		?>      
	  </select><label class="kecilmerah"> *</label>            
	</td>      
</tr>
<tr>
	<td class="label2" align="right">Subcategory Name</td>
	<td class="label2" align="center">:</td>
	<td ><input tabindex="1" name="nama_category" id="nama_category"  size="44" value=""  style="" /><label class="kecilmerah"> *</label></td>
</tr>   
<tr>
	<td class="label3" align="right">Subcategory Description</td>
	<td class="label3" align="center">:</td>
	<td ><input tabindex="1" name="category_description" id="category_description"  size="44" value="" style="" /></td>
</tr> 
<tr>
	<td colspan="3">&nbsp;</td>
</tr>
<tr>
	<td colspan="3"><label class="kecilmiring"> * ) Must be filled</label></td>
</tr>
<tr>
	<td class="input2" width="30%">&nbsp;</td>
	<td class="input2" width="5%"><br /><br /></td>
	<td class="input2" width="65%">
		<input type="button" name="batal" value="Back" class="btnNavigasi" onClick="klikBack()">
		<input type="reset" name="reset" id="Reset">
		<input type="submit" name="btnTambah" id="btnTambah" value="Save" class="btnNavigasi" tabindex="3" onClick="" style="width:70px"/></td>
</tr>
</table>