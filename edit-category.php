<?php
session_start();
if (!isset($_SESSION['adzuser'])){header('Location:./index.php');}
include "top.php";
// if this page isn't come from the user list or submit from this page
if (!isset($_POST['ide'])){header('Location:list-category.php');}

$query="SELECT * FROM category WHERE idcategory='$_POST[ide]'";
$result=mysql_query($query);
$row = mysql_fetch_assoc($result);

if (isset($_POST["save"]))
{
	// begin validating
	$error= "";
	if ($_POST["name"]==""){$error.="Please fill in the category name !\\n";}
	if (!empty($_FILES['gambar']['name']))
	{	
	    // validasi file gambar
		$allowed_filetypes = array('.jpg','.jpeg','.gif','.bmp','.png');
		$max_filesize = 50242880; //max 5 mega gede'e
		$filename = $_FILES['gambar']['name'];
		$ext = substr($filename, strpos($filename,'.'), strlen($filename)-1); 
		
		//cek filetype
		$ok=1;
		if ($_FILES['gambar']['tmp_name']==''){$ok=0;}
		else
		{
			if(!in_array($ext,$allowed_filetypes))
			{
			   $error.='This type of file can\'t be uploaded !';
			   $ok=0;
			}
			else if(filesize($_FILES['gambar']['tmp_name']) > $max_filesize)
			{
			   $error.='This picture size is too big. Maximum allowed size are 5 MB.';
			   $ok=0;
			}
			else $ok=1;
		}
	}
	
	// saving data
	if ($error=="")
	{				
		// upload gambar bila gambar diisi
		if (!empty($_FILES['gambar']['name']))
		{		
			if ($ok=1)
			{
				// menentukan nama file
				$picname=$_POST['ide'];			  
				//tentukan path untuk simpan gambar
				$path='categorypics/';
				 
				if(move_uploaded_file($_FILES['gambar']['tmp_name'],$path.$picname.".jpg"))
				{
				 $pesan="and Upload success.";	 
				}
				else 
				{
				$pesan="but Upload fail.";
				}
			}
		}
		
		$query  = "UPDATE category SET ";
		$query .= "categoryname='$_POST[name]', categorydesc='$_POST[desc]', active='$_POST[active]'";
		$query .= "WHERE idcategory='$_POST[ide]'";
		$result=mysql_query($query);
		echo "<script>alert('Category data has been saved !');window.location='./list-category.php?id=$_POST[ide]';</script>";
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
<form action="edit-category.php" method="POST" enctype="multipart/form-data">
<table width="50%" border="0" cellspacing="1" cellpadding="1" align="center" bgcolor="#CCCCCC">
<tr>
	<td align="left" colspan="3" bgcolor="#FFFFFF" valign="middle"><h4>Edit Category</h4></td>
</tr>
<tr>
	<td align="right">Category Name</td>
	<td align="center">:</td>
	<td align="left" colspan="2"><input type="text" name="name" id="name" size="29" maxlength="250" value="<?php echo $row['categoryname']; ?>"><label class="kecilmerah"> *</label></td>
</tr>
<tr>
	<td align="right">Category Description</td>
	<td align="center">:</td>
	<td align="left" colspan="2"><textarea cols="30" rows="5" name="desc" id="desc"><?php echo $row['categorydesc']; ?></textarea></td>
</tr> 
<tr>
	<td align="right">Picture</td>
	<td align="center">:</td>
	<td align="left" colspan="2"><img src="categorypics/<?php echo $row['idcategory']; ?>.jpg" width="" height="80"><br>
		*To change picture please choose file<input type="file" name="gambar" id="gambar">		
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
	<td colspan="3">&nbsp;</td>
</tr>
<tr>
	<td colspan="3"><label class="kecilmiring"> * ) Must be filled</label></td>
</tr>
<tr>
	<td width="35%">&nbsp;</td>
	<td width="5%">&nbsp;</td>
	<td width="60%">
		<input type="hidden" name="ide" id="ide" value="<?php echo $row['idcategory']; ?>">
		<input type="button" name="batal" value="Back" class="btnNavigasi" onClick="klikBack()">
		<input type="reset" name="reset" id="Reset">
		<input type="submit" name="save" id="save" value="Save" style="width:70px">		
	</td>
</tr>	
</form>
</table>