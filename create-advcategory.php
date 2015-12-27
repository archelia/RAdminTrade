<?php
 session_start();
 if (!isset($_SESSION['adzuser'])){header('Location:./index.php');}
 include "top.php";
 
if(isset($_POST['btnTambah']))
{
	$eror="";
	$pesan="";
	// begin validating
	if (!empty($_FILES['gambar']['name']))
	{	
	    // validasi file gambar
		$allowed_filetypes = array('.jpg','.jpeg','.gif','.bmp','.png');
		$max_filesize = 50242880; //max 5 mega gede'e
		$filename = $_FILES['gambar']['name'];
		$ext = substr($filename, strpos($filename,'.'), strlen($filename)-1); 		
		//cek filetype
		if ($_FILES['gambar']['tmp_name']!='')
		{
			if(!in_array($ext,$allowed_filetypes))
			{
			   $error.='This type of file can\'t be uploaded !\\n';
			}
			else if(filesize($_FILES['gambar']['tmp_name']) > $max_filesize)
			{
			   $error.='This picture size is too big. Maximum allowed size are 5 MB.\\n';
			}
		}
	}	
	$sqlr = "SELECT * from advcategory WHERE categoryname='$_POST[nama_advcategory]'";
	$resultr = mysql_query($sqlr);
	$rowr=mysql_fetch_array($resultr);
	if ($rowr>0) {$eror.="This advcategory already exist, please choose another advcategory name !\\n";}
	if ($_POST['nama_advcategory']==""){$eror.="Category Name can\'t be empty! \\n";}
	if ($_POST['advcategory_description']==""){$eror.="Category Description can\'t be empty!";}
	if ($eror=="")
	{
		$kode=0;
		// generate new id
		$sqlr = "SELECT max(idadvcategory) as newid from advcategory ";
		$resultr = mysql_query($sqlr);
		if (mysql_num_rows($resultr)<1){$kode=1;}
		else
		{
		$rowr=mysql_fetch_array($resultr);
		$kode=$rowr['newid']+1;
		}		
		if (!empty($_FILES['gambar']['name']))
		{		
			// menentukan nama file
			$picname=$kode;			  
			//tentukan path untuk simpan gambar
			$path='advcategorypics/';
			 
			if(move_uploaded_file($_FILES['gambar']['tmp_name'],$path.$picname.".jpg"))
			{
			 $pesan="and Upload success.";	 
			}
			else 
			{
			$pesan="but Upload fail.";
			}
		}		
		$query = "insert into advcategory values ('".$kode."','".$_POST['nama_advcategory']."','".$_POST['pay_cat']."','".$_POST['advcategory_description']."','"."1"."')";
		$tambah = mysql_query($query);
		if($tambah)
		{
			$pesan="Add Advertisement Category Success ".$pesan;
			echo "<script language='javascript'>alert(\"$pesan\");
				  window.location='list-advcategory.php';
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
<script>
function klikBack()
{
window.location='javascript:javascript:history.go(-1)';
}
</script>
<form name="frmTambahadvcategoryTrading" method="post" action="" enctype="multipart/form-data">
<table width="50%" border="0" cellspacing="2" cellpadding="2" align="center" bgcolor="#CCCCCC">
	<tr>
		<td align="left" colspan="3" bgcolor="#FFFFFF" valign="middle"><h4>Create Advertisement Category</h4></td>
	<tr>
	<tr>
	    <td width="30%" class="label2"><div align="right">Category Name </div></td>
		<td width="5%" class="label2"><div align="center">:  </td> </div>
		<td width="65%" ><input tabindex="1" name="nama_advcategory" id="nama_advcategory"  size="44" value="" /><label class="kecilmerah"> *</label></td>
     </tr>    
	<tr>
		<td class="label3" align="right">Category Description</td>
		<td class="label3"> <div align="center">: </div></td>
		<td>
			<textarea name="advcategory_description" id="advcategory_description" rows="4" cols="34"></textarea>
		</td>
	</tr>
	<tr>
		<td class="label3" align="right">Payment Category</td>
		<td class="label3"> <div align="center">: </div></td>
		<td>
			<select id="pay_cat" name="pay_cat">
				<option value="a" selected>Category A</option>
				<option value="b">Category B</option>
				<option value="c">Category C</option>
			</select>
			<br><br>
			<label class="kecilmiring">
			Category A is the most expensive category in the promotional price and is the most requested category.<br>
			Category B is the average category.<br>
			And while category C's promotional price is the cheapest among all category.<br>
			</label>
		</td>
	</tr>
	<tr>
		<td align="right">Picture</td>
		<td align="center">:</td>
		<td align="left">
		<input type="file" name="gambar" id="gambar"></td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
	<tr>
		<td class="input2"><label class="kecilmiring"> * ) Must be filled</label></td>
		<td class="input2">&nbsp;</td>
		<td class="input2">&nbsp;</td>
	</tr>
	<tr>
		<td class="input2"><br /></td>
		<td class="input2">&nbsp;</td>
		<td class="input2">
		<input type="button" name="batal" value="Back" class="btnNavigasi" onClick="klikBack()">&nbsp;
		<input type="reset" name="reset" id="Reset">
		<input type="submit" name="btnTambah" id="btnTambah" value="Save" class="btnNavigasi" tabindex="3" style="width:70px"/></td>
	</tr>
	</table>
</form> 