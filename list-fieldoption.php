<?php
session_start();
if (!isset($_SESSION['adzuser'])){header('Location:./index.php');}
if (!isset($_GET['ide'])){header('Location:list-catfields.php');}
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

$qc="SELECT idfield, fieldname FROM fields WHERE idfield='$_GET[ide]'";
$rc=mysql_query($qc);
$rowc=mysql_fetch_array($rc);
?>
<link rel="stylesheet" type="text/css" href="library/style2.css" />
<div id="list" style="margin-top:1.5em;">
<table width="70%" cellspacing="2" cellpadding="2" align="center" bgcolor="#A9D0F5" border="0">
<tr>
	<td align="left" bgcolor="#FFFFFF" colspan="2" class="judul">Field Option List</td>
</tr>

<tr>
	
	<form name="formcari" id="formcari" method="POST" action="list-fieldoption.php">
	<td colspan="2" align="center">
	Search : <input type='text' name='tekscari' id='tekscari' size="50"><input type='submit' name='search' id='search' value='Search'>
	</td>
	</form>	
</tr>
<tr>
	<td align="left" bgcolor="#FFFFFF" colspan="6">ID Field : <?php echo $rowc['idfield']; ?></td>
</tr>
<tr>
	<td align="left" bgcolor="#FFFFFF" colspan="6">Field name : <?php echo $rowc['fieldname']; ?></td>
</tr>
<tr>
	<td align="left" colspan="2">
	<table width="100%" cellspacing="0" cellpadding="1" align="center" bgcolor="#A9D0F5" border="1"  bordercolor="#FFFFFF">
	<tr>
		<th align="center" width="20%">ID Option</th>
		<th align="center" width="20%">Caption</th>
		<th align="center" width="20%">Value</th>
		<th align="center" width="5%">Edit</th>
		<th align="center" width="5%">Delete</th>
	</tr>
	<?php
	$query="SELECT f.fieldname, fo.* FROM fields f, field_pilihan fo ";
	$query.="WHERE fo.idfield=f.idfield ";
	$query.="AND fo.idfield='$_GET[ide]' ";
	if (isset($_POST['search']))
	{
		$tekscari=$_POST['tekscari'];
		$query .="WHERE fieldname LIKE '$tekscari%' ";
	}
	else
	$query .="ORDER BY caption ASC ";
	$query1 = $query;
	$query .="LIMIT $posisi,$batas";
	$result=mysql_query($query);
	if(mysql_num_rows($result)<1)
	{
		echo '<tr><td colspan="6" align="center">There\'s no data to display.</td></tr>';
	}
	else
	{
		while($row = mysql_fetch_array($result))
		{
			echo '<tr>
				<td align="left">'.$row["idoption"].'</td>
				<td align="left">'.$row['caption'].'</td>
				<td align="left">'.$row['value'].'</td>
				<td align="center">';
				?>
				<form action="edit-catoption.php" method="POST" onsubmit="return confirm('Are you sure want to edit this data?');">
				<?php
				echo '<input type="submit" name="submit" id="submit" value="Edit">
					<input type="hidden" name="ide" id="ide" value='.$row["idoption"].'>		
					<input type="hidden" name="idf" id="idf" value='.$row["idfield"].'>		
					</form> ';
			echo '</td>
			<td align="center">';
				?>
				<form action="deletesuper.php" method="POST" onsubmit="return confirm('Are you sure want to delete this data?');">
				<?php
				echo '<input type="submit" name="submit" id="submit" value="Delete">
					<input type="hidden" name="ide" id="ide" value='.$row["idoption"].'>
					<input type="hidden" name="tabel" id="tabel" value="field_pilihan">
					<input type="hidden" name="namaid" id="namaid" value="idoption">	
					<input type="hidden" name="page" id="page" value="list-fieldoption.php?ide='.$_GET["ide"].'">		
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
	<td colspan="2">&nbsp;</td>
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
	<td width="40%" align="right">
		<input type="button" name="back" id="back" value="Back" onclick="klikBack()">
	</td>
	<form action="create-fieldoption.php" method="POST">
	<td width="60%" align="left">
		<input type="hidden" name="ide" id="ide" value="<?php echo $_GET['ide'];?>">
		<input type="submit" name="createnew" id="createnew" value="Click here to create new option">
	</td>
	</form>	
</tr>
</table>
</div>

<script type="text/javascript">
function klikBack()
{window.location='javascript:javascript:history.go(-1)';}
</script>