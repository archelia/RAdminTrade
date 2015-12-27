<?php
session_start();
if (!isset($_SESSION['adzuser'])){header('Location:./index.php');}
include "top.php";
// if this page isn't come from the user list or submit from this page
if (!isset($_POST['ide'])){header('Location:list-category.php');}

$query="SELECT * FROM subcategory WHERE idsubcategory='$_POST[ide]'";
$result=mysql_query($query);
$row = mysql_fetch_assoc($result);

if (isset($_POST["save"]))
{
	// begin validating
	$error= "";
	if ($_POST["name"]==""){$error.="Please fill in the subcategory name !\\n";}
	
	// saving data
	if ($error=="")
	{				
		$query  = "UPDATE subcategory SET ";
		$query .= "idcategory='$_POST[idcategory]', subcategoryname='$_POST[name]', subcategorydesc='$_POST[desc]', active='$_POST[active]'";
		$query .= "WHERE idsubcategory='$_POST[ide]'";
		$result=mysql_query($query);
		echo "<script>alert('Subcategory data has been saved !');window.location='./list-subcategory.php?id=$_POST[idcategory]';</script>";
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
<form action="edit-subcategory.php" method="POST">
<table width="50%" border="0" cellspacing="1" cellpadding="1" align="center" bgcolor="#CCCCCC">
<tr>
	<td align="left" colspan="3" bgcolor="#FFFFFF" valign="middle"><h4>Edit Subcategory</h4></td>
</tr>
<tr>
	<td align="right">ID Category</td>
	<td align="center">:</td>
	<td align="left" colspan="2">
		<SELECT NAME="idcategory" id="idcategory">	
			<?php					
				$query1= "SELECT * FROM category where active=1 order by categoryname asc";
				$result1 = mysql_query($query1);
				if(mysql_num_rows($result1)>0)
				{
					while($row1=mysql_fetch_assoc($result1))
					{
					if ($row1['idcategory']==$row['idcategory'])
						{
						echo "<option value='$row1[idcategory]' selected>".ucwords($row1[categoryname])."</option>";
						}
						else echo "<option value='$row1[idcategory]'>".ucwords($row1[categoryname])."</option>";
					}
				}
			?>
		</SELECT><label class="kecilmerah"> *</label>		  
	</td>
</tr>
<tr>
	<td align="right">Sub Category Name</td>
	<td align="center">:</td>
	<td align="left" colspan="2"><input type="text" name="name" id="name" size="29" maxlength="250" value="<?php echo $row['subcategoryname']; ?>"><label class="kecilmerah"> *</label></td>
</tr>
<tr>
	<td align="right">Sub Category Description</td>
	<td align="center">:</td>
	<td align="left" colspan="2"><textarea cols="30" rows="5" name="desc" id="desc"><?php echo $row['subcategorydesc']; ?></textarea></td>
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
	<td colspan="3">&nbsp;</td>
</tr>
<tr>
	<td colspan="3"><label class="kecilmiring"> * ) Must be filled</label></td>
</tr>
<tr>
	<td width="35%">&nbsp;</td>
	<td width="5%">&nbsp;</td>
	<td width="60%">
		<input type="hidden" name="ide" id="ide" value="<?php echo $row['idsubcategory']; ?>">
		<input type="button" name="batal" value="Back" class="btnNavigasi" onClick="klikBack()">
		<input type="reset" name="reset" id="Reset">
		<input type="submit" name="save" id="save" value="Save" style="width:70px">		
	</td>
</tr>	
</form>
</table>

