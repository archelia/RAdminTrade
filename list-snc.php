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
<div id="list" style="margin-top:1.5em;">
<table width="60%" cellspacing="2" cellpadding="2" align="center" bgcolor="#A9D0F5" border="0">
<tr>
	<td align="left" bgcolor="#FFFFFF" colspan="2"><h4>Suggestions and Critics List</h4></td>
</tr>
<tr>
	
	<form name="formcari" id="formcari" method="POST" action="list-snc.php">
	<td colspan="2" align="center">
	Search : <input type='text' name='tekscari' id='tekscari' size="50"><input type='submit' name='search' id='search' value='Search'>
	</td>
	</form>	
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td align="left" colspan="2">
	<table width="100%" cellspacing="0" cellpadding="1" align="center" bgcolor="#A9D0F5" border="1"  bordercolor="#FFFFFF">
	<tr>
		<td align="center" width="10%">ID</td>
		<td align="center" width="20%">Member Name</td>
		<td align="center" width="40%">Content</td>
		<td align="center" width="20%">Detail</td>
		<td align="center" width="10%">Delete</td>
	</tr>
	<?php
	$query = "SELECT s.*, m.membername FROM snc s, member m ";
	$query .= "WHERE s.idmember=m.idmember ";

	if (isset($_POST['search']))
	{
		$tekscari=$_POST['tekscari'];
		$query .=" AND s.snc LIKE '$tekscari%' ";
	}
	
	$query .="ORDER BY s.inputdate DESC ";
	$query1 = $query;
	$query .="LIMIT $posisi,$batas";
	$result = mysql_query($query) or die ("Ada yang salah !");

	while($row = mysql_fetch_array($result))
	{
		echo '<tr>
			<td align="right">'.$row["idsnc"].'</td>
			<td align="left">'.$row["membername"].'</td>
			<td align="left">'.$row["snc"].'</td>
			<td align="center"><a href="detail-snc.php?id='.$row["idsnc"].'">See Detail</a>';
		echo '</td>
		<td align="center">';
		?>
		<form action="deletesuper.php" method="POST" onsubmit="return confirm('Are you sure want to delete this data?');">
		<?php
		echo '<input type="submit" name="submit" id="submit" value="Delete">
			<input type="hidden" name="ide" id="ide" value='.$row["idsnc"].'>
			<input type="hidden" name="tabel" id="tabel" value="snc">
			<input type="hidden" name="namaid" id="namaid" value="idsnc">	
			<input type="hidden" name="page" id="page" value="list-snc.php">		
			</form> ';
		echo '</td></tr> ';
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
	$file="list-snc.php";
		
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
	<td width="40%" align="left">
		<input type="button" name="back" id="back" value="Back" onclick="klikBack()">
	</td>
	<td width="60%" align="left">&nbsp;
	</td>
</tr>
</table>
</div>

