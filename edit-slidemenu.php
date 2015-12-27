<?php
session_start();
if (!isset($_SESSION['adzuser'])){header('Location:./index.php');}
include "top.php";
// if this slide isn't come from the slide list or submit from this slide
if (!isset($_POST['ide'])){header('Location:list-slide.php');}

$query="SELECT * FROM slidemenu WHERE idslide='$_POST[ide]'";
$result=mysql_query($query);
$row = mysql_fetch_assoc($result);

if (isset($_POST["save"]))
{
	// begin validating
	$error= "";
	$pesan="";
	if ($_POST["slidetitle"]==""){$error.="Please fill in the slide name !\\n";}
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
	if ($error=="")
	{			
		// upload gambar bila gambar diisi
		if (!empty($_FILES['gambar']['name']))
		{		
			if ($ok=1)
			{
				// menentukan nama file
				$picname=$row['idslide'];			  
				//tentukan path untuk simpan gambar
				$path='slidepics/';
				 
				if(move_uploaded_file($_FILES['gambar']['tmp_name'],$path.$picname.".jpg"))
				{
				 $pesan="and Upload success.";	 
				}
				else 
				{
				$pesan="but Upload fail.";
				}
				$namapic=$path.$picname.".jpg";
			}
		} 		
		if ($_POST['slidelink']!=""){$link=$_POST['slidelink'];}else{$link="#";}
		
		$query  = "UPDATE slidemenu SET ";
		$query .= "slidetitle='$_POST[slidetitle]', slidedesc='$_POST[slidedesc]', slideimage='$namapic', slidelink='$link', active='$_POST[active]'";
		$query .= "WHERE idslide='$_POST[ide]'";
		$result=mysql_query($query);
		$pesan = "Slide data has been saved ".$pesan;
		echo "<script>alert(\"$pesan\");window.location='./list-slidemenu.php';</script>";
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
<form action="edit-slidemenu.php" method="POST" enctype="multipart/form-data">
<table width="50%" border="0" cellspacing="1" cellpadding="1" align="center" bgcolor="#CCCCCC">
<tr>
	<td align="left" colspan="3" bgcolor="#FFFFFF" valign="middle"><h4>Edit Slide Menu</h4></td>
</tr>
<tr>
	<td align="right">Slide Title</td>
	<td align="center">:</td>
	<td align="left" colspan="2"><input type="text" name="slidetitle" id="slidetitle" size="38" maxlength='150' value="<?php echo $row['slidetitle']; ?>"><label class="kecilmerah"> *</label></td>
</tr>
<tr>
	<td align="right">Slide Description</td>
	<td align="center">:</td>
	<td align="left" colspan="2"><textarea rows="5" cols="30" name="slidedesc" id="slidedesc"><?php echo $row['slidedesc']; ?></textarea>	  
	</td>
</tr>
<tr>
	<td align="right">Slide Link</td>
	<td align="center">:</td>
	<td align="left" colspan="2"><input type="text" name="slidelink" id="slidelink" size="38" maxlength='150' value="<?php echo $row['slidelink']; ?>"><br><label class="kecilmiring">Leave it empty if you want to use auto generate link</label></td>
</tr>
<tr>
	<td align="right">Picture</td>
	<td align="center">:</td>
	<td align="left" colspan="2">
		<img src="slidepics/<?php echo $row['idslide']; ?>.jpg" width="" height="80"><br>
		<label class="kecilmiring">To change picture please choose file</label><input type="file" name="gambar" id="gambar"><br>
		<label class="kecilmiring">Picture's dimension should be 600x300</label>
	</td>
</tr>
<tr>
	<td align="right">Active</td>
	<td align="center">:</td>
	<td colspan="2" colspan="2">
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
		<input type="hidden" name="ide" id="ide" value="<?php echo $row['idslide']; ?>">
		<input type="button" name="batal" value="Back" class="btnNavigasi" onClick="klikBack()">
		<input type="reset" name="reset" id="Reset">
		<input type="submit" name="save" id="save" value="Save" style="width:70px">		
	</td>
</tr>	
</form>
</table>

