<?php
 session_start();
 if (!isset($_SESSION['adzuser'])){header('Location:./index.php');}
 include "top.php";
 
if(isset($_POST['btnTambah']))
{
	$eror="";
	// begin validating
	$sqlr = "SELECT * from category WHERE categoryname='$_POST[nama_category]'";
	$resultr = mysql_query($sqlr);
	$rowr=mysql_fetch_array($resultr);
	if ($rowr>0) {$eror.="This category already exist, please choose another category name !\\n";}
	if ($_POST['nama_category']==""){$eror.="Category Name can\'t be empty! \\n";}
	if ($_POST['category_description']==""){$eror.="Category Description can\'t be empty!";}
	if ($eror=="")
	{
		$kode=0;
		// generate new id
		$sqlr = "SELECT max(idcategory) as newid from category ";
		$resultr = mysql_query($sqlr);
		if (mysql_num_rows($resultr)<1){$kode=1;}
		else
		{
		$rowr=mysql_fetch_array($resultr);
		$kode=$rowr['newid']+1;
		}

		$query = "insert into category values ('".$kode."','".$_POST['nama_category']."','".$_POST['category_description']."','"."1"."')";

		$tambah = mysql_query($query);

		if($tambah)
		{

			echo "<script language='javascript'>alert('Add Category Success');
				  window.location='list-category.php';
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

<script type="text/javascript" src="jquery.js"></script>
<script>
function klikBack()
{
window.location='javascript:javascript:history.go(-1)';
}
</script>
<br>
 <form name="frmTambahCategoryTrading" method="post" action="">
	<table cellpadding="0" cellspacing="0" bgcolor="#CCCCCC" align="center">
    <tr>
    <td width="100%"><table cellpadding="8" cellspacing="1">
      <tr>
        <td bgcolor="#FFFFFF" colspan="3"><h4>Add Category</h4></td>
      </tr>
      <tr>
        <td width="132" class="label2"><div align="right">Nama Kategori</div></td>
        <td width="7" class="label2"><div align="center">: </div></td>
        <td width="477" ><div align="left"><input tabindex="1" name="nama_category" id="nama_category"  size="70" value="" /> 
          * </div></td>
      </tr>
      <tr>
        <td class="label3"><div align="right">Kategori Deskripsi </div></td>
        <td class="label3"><div align="center">: </div></td>
        <td ><div align="left"><input tabindex="1" name="category_description" id="category_description"  size="70" value=""  /> 
          * </div></td>
      </tr>
      <tr>
        <td colspan="2" class="input2" valign="top"><div align="right"> * ) Must be filled ! </div></td>
        <td class="input2"><input type="button" name="batal" value="Back" class="btnNavigasi" onclick="klikBack()" />
&nbsp;
<input type="reset" name="reset" id="Reset" />
&nbsp;
<input type="submit" name="btnTambah" id="btnTambah" value="Save" class="btnNavigasi" tabindex="3" onclick="tambahDataCategory()"/>
<br />
<br /></td>
      </tr>
    </table></td>
	</tr>
	</table>
</form>
