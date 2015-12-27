<?php
session_start();
if (!isset($_SESSION['adzuser'])){header('Location:./index.php');}
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
?>
<link rel="stylesheet" type="text/css" href="library/style2.css" />
<script type="text/javascript">
function klikBack()
{window.location='javascript:javascript:history.go(-1)';}
</script>

<div id="list">
<table width="70%" cellspacing="2" cellpadding="2" align="center" bgcolor="#A9D0F5" border="0">
<tr>
	<td align="left" colspan="2" class="judul">&nbsp;Package List</td>
</tr>
<tr>
	<form name="formcari" id="formcari" method="POST" action="list-packages.php">
	<td colspan="2" align="center">
	Search : <input type='text' name='tekscari' id='tekscari' size="50"><input type='submit' name='search' id='search' value='Search'>
	</form>
	</td>
</tr>
<tr>
	<td colspan="2">
	<table width="100%" cellspacing="0" cellpadding="1" align="center" bgcolor="#A9D0F5" border="1"  bordercolor="#FFFFFF">
	<tr>
		<th align="center" width="5%">ID</th>
		<th align="center" width="25%">Name</th>
		<th align="center" width="35%">Description</th>
		<th align="center" width="10%">Qty</th>
		<th align="center" width="15%">Price</th>
		<th align="center" width="5%">Edit</th>
		<th align="center" width="5%">Delete</th>
	</tr>

	<?php
	$query = "SELECT * FROM package ";
	if (isset($_POST['search']))
	{
		$tekscari=$_POST['tekscari'];
		$query .=" WHERE name LIKE '%$tekscari%' ";
	}
	$query .="ORDER BY active desc, inputdate DESC ";
	$query1 = $query;	
	$query .="LIMIT $posisi,$batas";
	$result = mysql_query($query) or die ("Ada yang salah !");
	
	while($row = mysql_fetch_array($result))
	{
		if($row["active"]==0) echo '<tr bgcolor="#B9B1B1">'; else echo '<tr>';
		echo '	<td align="right">'.$row["idpackage"].'</td>
			<td align="left"><a href="detail-packages.php?ide='.$row["idpackage"].'">'.$row["name"].'</a></td>
			<td align="left">'.$row["description"].'</td>
			<td align="right">'.$row["qty"].'</td>
			<td align="right">'.number_format($row["price"],0,",",".").'</td>
			<td align="center">';
			?>
			<form action="edit-packages.php" method="POST" onsubmit="return confirm('Are you sure want to edit this data?');">
			<?php
			echo '<input type="submit" name="submit" id="submit" value="Edit">
				<input type="hidden" name="ide" id="ide" value='.$row["idpackage"].'>		
				</form> ';
		echo '</td>
		<td align="center">';
		if ($row["active"]==0){echo "Deleted";} else {
			?>
			<form action="delete.php" method="POST" onsubmit="return confirm('Are you sure want to delete this data?');">
			<?php
			echo '<input type="submit" name="submit" id="submit" value="Delete">
				<input type="hidden" name="ide" id="ide" value='.$row["idpackage"].'>
				<input type="hidden" name="tabel" id="tabel" value="package">
				<input type="hidden" name="namaid" id="namaid" value="idpackage">	
				<input type="hidden" name="page" id="page" value="list-packages.php">		
				</form> ';}
		echo '</td>
			</tr> ';
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
		$file="list-packages.php";
			
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
	<td width="60%" align="left"><input type="button" name="bnew" id="bnew" value="Create New Package" onclick="window.location='create-packages.php'"></td>
</tr>
</table>			
</div>
