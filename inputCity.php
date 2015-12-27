<html>
<head>
</head>

<?php
include "top.php";
 
if(isset($_POST['btnTambah']))

	{

		$kode = time();

        $query = "insert into category values ('".$kode."','".$_POST['nama_category']."','".$_POST['category_description']."','"."1"."')";

		$tambah = mysql_query($query);

		if($tambah)

		{

			echo "<script language='javascript'>alert('Add Category Success');

				

				</script>";

		} 

	}

		

?> 

<script type="text/javascript" src="jquery.js"></script>
<script>
 function tambahDataCategory(){
    alert("test");
 };
</script>

<body> 
 <form name="frmTambahCategoryTrading" method="post" action="" autocomplete="off">

	<table cellpadding="0" cellspacing="0" bgcolor="#CCCCCC" align="center">

    <tr>

    <td>

	<table cellpadding="8" cellspacing="1">

	  <tr>

      <td bgcolor="#FFFFFF" colspan="2">

	  	<div class="judulInput">

        	Add Category

        </div>

	  </td>

      </tr>

	  <tr>

	  <td class="label2">Nama Kategori (*) : </td>

	  <td ><input tabindex="1" name="nama_category" id="nama_category"  size="100" value=""  style="width:89%;" /></td>

      </tr>
     
       <tr>

	      <td class="label3">Kategori Deskripsi (*) : </td>

	      <td ><input tabindex="1" name="category_description" id="category_description"  size="100" value=""  style="width:89%;" /></td>

      </tr>

    
      
	  <tr>

	  <td colspan="2" class="input2">

      <input type="button" name="batal" value="Back" class="btnNavigasi" onClick="klikBack()">

      &nbsp;

	  <input type="submit" name="btnTambah" id="btnTambah" value="Add" class="btnNavigasi" tabindex="3" onClick="tambahDataCategory()"/>

      <br /><br />

	  ( * : wajib diisi )



	  </td>

      </tr>

	</table>

	</td>

	</tr>

	</table>

	

</form>
 
</body>
</html>