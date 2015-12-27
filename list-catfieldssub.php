<?php
session_start();
if (!isset($_SESSION['adzuser'])){header('Location:./index.php');}
if (!isset($_GET['ide'])){header('Location:list-catfields.php');}
$ide=$_GET['ide'];
include "top.php";

/* << paging >> */
// langkah awal halaman
$batas=10;
if (isset($_GET['halaman'])){$halaman=$_GET['halaman'];}
if (empty($halaman))
{
	$posisi=0;
	$halaman=1;
}
else
{
	$posisi=($halaman-1)*$batas;
}
// langkah 2 halaman
$no=$posisi+1;
/* << end of paging >> */

if(isset($_POST['btnTambah']))
{
	$eror="";
	// begin validating
	if ($_POST['nama_field']==""){$eror.="Field Name can\'t be empty! \\n";}
	$sqlr = "SELECT * from field_subfield WHERE value='$_POST[nama_field]'";
	$resultr = mysql_query($sqlr);
	if (mysql_num_rows($resultr)>0) {$eror.="This subfield is already exists, please choose another subfield name !\\n";}
	
	if ($eror=="")
	{
		$kode=0;
		// generate new id
		$sqlr = "SELECT max(idsubfield) as newid from field_subfield ";
		$resultr = mysql_query($sqlr);
		if (mysql_num_rows($resultr)<1){$kode=1;}
		else
		{
		$rowr=mysql_fetch_array($resultr);
		$kode=$rowr['newid']+1;
		}

		$query = "insert into field_subfield values ('".$kode."','".$ide."','".$_POST['nama_field']."')";
		$tambah = mysql_query($query);

		if($tambah)
		{

			echo "<script language='javascript'>alert('Add Field Success');
				  window.location='list-catfieldssub.php?ide=$ide';
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
<script type="text/javascript">
function klikBack()
{window.location='javascript:javascript:history.go(-1)';}
</script>
<div id="list" style="margin-top:1.5em;">
<table width="75%" cellspacing="2" cellpadding="2" align="center" bgcolor="#A9D0F5" border="0">
<tr>
	<td align="left" bgcolor="#FFFFFF" colspan="2" class="judul">List SubField</td>
</tr>
<tr>
	<td colspan="2" align="right">
		ID Field : <?php echo $ide;?>&nbsp;
		<br>
		Field name :
		<?php 
		$query="SELECT f.* FROM fields f WHERE idfield='$ide'";
		$rowf=mysql_fetch_array(mysql_query($query));
		echo $rowf["fieldname"];
		?>
		&nbsp;
	</td>
</tr>
<tr>
	
	<form name="formcari" id="formcari" method="POST" action="list-catfields.php">
	<td colspan="2" align="center">
	Search : <input type='text' name='tekscari' id='tekscari' size="50"><input type='submit' name='search' id='search' value='Search'>
	</td>
	</form>	
</tr>
<tr>
	<td align="left" colspan="2">
	<table width="70%" cellspacing="0" cellpadding="1" align="center" bgcolor="#A9D0F5" border="1"  bordercolor="#FFFFFF">
	<tr>
		<th align="center" width="10%">ID</th>
		<th align="center" width="30%">Subfield Value</th>
		<th align="center" width="5%">Delete</th>
	</tr>
	<?php
	$query="SELECT f.* FROM field_subfield f ";
	$query.="WHERE idfield=$ide ";
	if (isset($_POST['search']))
	{
		$tekscari=$_POST['tekscari'];
		$query .="AND value LIKE '$tekscari%' ";
	}
	else
	$query .="ORDER BY idsubfield ASC ";
	$query1 = $query;
	$query .="LIMIT $posisi,$batas";
	$result=mysql_query($query);
	if(mysql_num_rows($result)<1)
	{
		echo 
			'<tr>
				<td colspan=3 align="center">
					There is no subfield in this field.
				</td>
			</tr>';
	}
	else
	{
		while($row = mysql_fetch_array($result))
		{
			echo '<tr>
				<td align="right">'.$row["idsubfield"].'</td>
				<td align="left">'.$row["value"].'</td>';
			echo '
			<td align="center">';
				?>
				<form action="deletesuper.php" method="POST" onsubmit="return confirm('Are you sure want to delete this data?');">
				<?php
				echo '<input type="submit" name="submit" id="submit" value="Delete">
					<input type="hidden" name="ide" id="ide" value='.$row["idsubfield"].'>
					<input type="hidden" name="tabel" id="tabel" value="field_subfield">
					<input type="hidden" name="namaid" id="namaid" value="idsubfield">	
					<input type="hidden" name="page" id="page" value="list-catfieldssub.php?ide='.$ide.'">		
					</form> ';
			echo '</td>
				</tr> ';
		}
	}
	?>
	</table>
</td>
</tr>
<tr>
	<td colspan="2" align="center">
	<?php
	// PAGING langkah 3 halaman
	$tampil= mysql_query($query1);
	$jmldata=mysql_num_rows($tampil);
	$jmlhalaman=ceil($jmldata/$batas);
	$file="list-catfields.php";
		
	// link ke halaman berikutnya, first-previous
	if($halaman>1)
	{
	$previous=$halaman-1;
	echo "<a href='$file?halaman=1'> << First</a> | <a href=$file?halaman=$previous> < Previous</a> | ";
	}
	else
	echo "<< First | <Previous |";
			
	// tampilkan link halaman 123 modif ala google
	// 3 angka awal
	$angka="";
	if ($halaman>1)
	{				
		for ($i=$halaman-3; $i<$halaman; $i++)
		{
			if ($i<1) continue;					
			$angka =$angka." <a href=$file?halaman=$i>$i</a> ";
		}
	}
	else $angka =" ";		

	// angka tengah
	$angka .="<b>$halaman</b>";		
	//3 angka setelahnya
	for ($i=$halaman+1;$i<($halaman+4);$i++)
	{
		if ($i > $jmlhalaman)
		break;
		$angka .=" <a href=$file?halaman=$i>$i</a> ";
	}			
	// angka akhir
	$angka .= ($halaman+2<$jmlhalaman ?" ... <a href=$file?halaman=$jmlhalaman>$jmlhalaman</a> " : " ... ");

	// cetak angka semua
	echo "$angka";

	// link ke halaman selanjutnya
	if ($halaman<$jmlhalaman)
	{
	$next=$halaman+1;
	echo "<a href=$file?halaman=$next> Next > </a> | <a href=$file?halaman=$jmlhalaman> Last >> </a>";
	}
	else
	{
	echo "Next > | Last >>";
	}
	?>
	</td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td>
		<form name="inputsubcatfield" method="post" action="">
		<table width="50%" cellspacing="0" cellpadding="1" align="center" bgcolor="#A9D0F5" border="1"  bordercolor="#FFFFFF">
			<tr>
				<th colspan="3" style="font-size:14px;height:30px;"><b>Add New Subfield</b></th>
			</tr>
			<tr>
				<td width="132" class="label2">
					<div align="center">Value : <input tabindex="1" name="nama_field" id="nama_field"  size="70" value="" />*</div>
					<br>
					<div align="left">* ) Must be filled ! </div>
					<br>
					<div align="center">
						<input type="reset" name="reset" id="Reset" />
							&nbsp;
						<input type="submit" name="btnTambah" id="btnTambah" value="Save" class="btnNavigasi" tabindex="3" onclick="tambahDataCategory()"/>
					</div>
				</td>
			</tr>
		</table>	
		</form>
	</td>
</tr>	
<tr>
	<td width="40%" align="left">
		<input type="button" name="back" id="back" value="Back" onclick="klikBack()">
	</td>
</tr>
</table>
</div>