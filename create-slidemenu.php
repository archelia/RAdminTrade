<?php
session_start();
if (!isset($_SESSION['adzuser'])){header('Location:./index.php');}
include "top.php";

if (isset($_POST["submit"]))
{
	// begin validating
	$error= "";
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
		$newid=0;
		// generate new iduser
		$sqlr = "SELECT max(idslide) as newid from slidemenu";
		$resultr = mysql_query($sqlr);
		if (mysql_num_rows($resultr)<1){$newid=1;}
		else
		{
		$rowr=mysql_fetch_array($resultr);
		$newid=$rowr['newid']+1;
		}
		
		$namapic="";
		// upload gambar bila gambar diisi
		if (!empty($_FILES['gambar']['name']))
		{		
			if ($ok=1)
			{
				// menentukan nama file
				$picname=$newid;			  
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
		
		// saving data		
		$query="INSERT INTO slidemenu ";
		$query.="VALUES ('$newid','$_POST[slidetitle]','$_POST[slidedesc]','$link','$namapic', now(),1)";
		$result=mysql_query($query);
		$pesan="Slide data has been saved ".$pesan;
		echo "<script>alert(\"$pesan\");window.location='./create-slidemenu.php';</script>";
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
{window.location='javascript:javascript:history.go(-1)';}
</script>
<form action="create-slidemenu.php" method="POST" enctype="multipart/form-data">
<table width="50%" border="0" cellspacing="2" cellpadding="2" align="center" bgcolor="#CCCCCC">
<tr>
	<td align="left" colspan="3" bgcolor="#FFFFFF" valign="middle"><h4>Create Slide Menu</h4></td>
<tr>
<tr>
	<td align="right" width="30%">Slide Title</td>
	<td align="center" width="5%">:</td>
	<td align="left" width="65%"><input type="text" name="slidetitle" id="slidetitle" size="44" maxlength='150'><label class="kecilmerah"> *</label></td>
</tr>
<tr>
	<td align="right">Slide Description</td>
	<td align="center">:</td>
	<td align="left"><textarea rows="5" cols="34" name="slidedesc" id="slidedesc"></textarea>	  
	</td>
</tr>
<tr>
	<td align="right" width="30%">Slide Link</td>
	<td align="center" width="5%">:</td>
	<td align="left" width="65%"><input type="text" name="slidelink" id="slidelink" size="44" maxlength='150'><br><label class="kecilmiring">Leave it empty if you want to use auto generate link</label></td>
</tr>
<tr>
	<td align="right">Picture</td>
	<td align="center">:</td>
	<td align="left"><input type="file" name="gambar" id="gambar"><br><label class="kecilmiring">Picture's dimension should be 600x300</label>  
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
</table>
</form>
