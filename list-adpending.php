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
<div id="list" style="margin-top:1.5em;" align="center">
<table width="70%" cellspacing="2" cellpadding="2" align="center" bgcolor="#D8D8D8" border="0">
<tr>
	<td align="left" bgcolor="#FFFFFF" colspan="2"><h4>Advertisement Pending Report</h4></td>
</tr>
<tr>
	<form name="formcari" id="formcari" method="POST" action="list-advertisement.php">
	<td colspan="2" align="center">
	Ad Search : <input type='text' name='tekscari' id='tekscari' size="50"><input type='submit' name='search' id='search' value='Search'>
	</td>
	</form>	
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td align="left" colspan="2">
	<table width="100%" cellspacing="0" cellpadding="1" align="center" bgcolor="#D8D8D8" border="1"  bordercolor="#FFFFFF">
	<tr>
		<td align="center" width="5%">ID</td>
		<td align="center" width="20%">Ad Title</td>
		<td align="center" width="20%">Ad Category</td>
		<td align="center" width="15%">Ad Type</td>
		<td align="center" width="20%">Ad Price</td>
		<td align="center" width="20%">City</td>
	</tr>
	<?php
	$query = "SELECT a.*, c.categoryname, t.cityname, r.symbol ";
	$query .= "FROM advertisement a, advcategory c, city t, currency r ";
	$query .= "WHERE a.idadvcategory=c.idadvcategory AND a.advidcity=t.idcity AND a.idcurr=r.idcurr ";
	$query .= "AND a.active=2 ";
	$query1 = $query."ORDER BY inputdate desc";

	if (isset($_POST['search']))
	{
		$tekscari=$_POST['tekscari'];
		$query .=" AND advtitle LIKE '$tekscari%' ORDER BY inputdate desc LIMIT $posisi,$batas ";
	}
	else
	$query .="ORDER BY inputdate desc LIMIT $posisi,$batas";
	$result = mysql_query($query) or die ("Ada yang salah !");

	while($row = mysql_fetch_array($result))
	{
		echo '<tr>
			<td align="right">'.$row["idadv"].'</td>
			<td align="left">'.$row["advtitle"].'</td>
			<td align="left">'.$row["categoryname"].'</td>	
			<td align="left">'.$row["advtype"].'</td>			
			<td align="left">'.$row['symbol'].' '.number_format($row["advprice"],0,",",".").'</td>					
			<td align="left">'.$row["cityname"].'</td>			
			';					
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
	$file="list-advertisement.php";
		
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