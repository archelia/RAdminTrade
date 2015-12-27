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
{window.location='javascript:javascript:history.go(-1)';};
function newPopup(url) {
	popupWindow = window.open(
		url,'popUpWindow','height=500,width=900,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes')
};
</script>
<div id="list" style="margin-top:1.5em;">
<table width="80%" cellspacing="2" cellpadding="2" align="center" bgcolor="#A9D0F5" border="0">
<tr>
	<td align="left" bgcolor="#FFFFFF" colspan="2" class="judul">Coin Purchase Confirmation</td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<form name="formcari" id="formcari" method="POST" action="list-coinpurchaseconfirm.php">
	<td align="center" width="70%" class="keterangan">
	Search by : 
	<select name="caribdr" id="caribdr">
		<option value="idpayment" selected>ID Payment</option>
		<option value="idpurchase">ID Purchase</option>
		<option value="membername">Member Name</option>
	</select>
	Keywords : 
	<input type='text' name='tekscari' id='tekscari' size="40"><input type='submit' name='search' id='search' value='Search'>
	</td>
	<td align="right">Order By :
		<select name="urutan" id="urutan" onchange="document.getElementById('formcari').submit();">
			<option value="1" selected>Purchase Date Newest</option>
			<option value="2">Purchase Date Longest</option>
			<option value="3">Member Name A-Z</option>
			<option value="4">Member Name Z-A</option>
		</select>
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
		<th align="center" width="10%">ID Payment</th>
		<th align="center" width="10%">ID Purchase</th>
		<th align="center" width="15%">Date</th>
		<th align="center" width="15%">Membername</th>
		<th align="center" width="20%">Transfer By</th>
		<th align="center" width="20%">Transfer To</th>
		<th align="center" width="10%">Delete</th>
	</tr>
	<?php
	$query="SELECT p.*, m.membername ";
	$query.="FROM payment p, member m, purchase r ";
	$query.="WHERE p.idmember=m.idmember ";
	$query.="AND p.idpurchase=r.idpurchase ";
	$query.="AND r.status=2 ";
	if (isset($_POST['search']))
	{
		$tekscari=$_POST['tekscari'];
		$caribdr=$_POST['caribdr'];
		
		$query .=" AND $caribdr LIKE '$tekscari%' ";
		
	}
	if (isset($_POST['urutan']))
	{
		$urutan=$_POST['urutan'];
		if ($urutan=='1'){$urutan='p.inputdate desc';}
		else if ($urutan=='2'){$urutan='p.inputdate asc';}
		else if ($urutan=='3'){$urutan='membername desc';}
		else if ($urutan=='4'){$urutan='membername asc';}
		$query .=" ORDER BY $urutan ";
	}
	else $query .="ORDER BY p.inputdate desc ";
	$query1 = $query;	
	$query .="LIMIT $posisi,$batas";
	$result = mysql_query($query) or die ("Ada yang salah !");
	if(mysql_num_rows($result)>0)
	{
		while($row = mysql_fetch_array($result))
		{
			// <td align="right">'.$row['symbol']." ".number_format($row["promoprice"],0,",",".").'</td>
			echo '<tr>
				<td align="center">'.$row["idpayment"].'</td>
				<td align="center">';
				?>
				<a href="JavaScript:newPopup('detail-coinpurchase.php?ide=<?php echo $row["idpurchase"]; ?>');"><?php echo $row["idpurchase"]; ?></a>
				<?php
			echo '</td>
				<td align="center">'.$row["inputdate"].'</td>
				<td align="left">'.$row["membername"].'</td>
				<td align="left">'.$row["transferby"].'</td>
				<td align="left">'.$row["transferto"].'</td>
				<td align="center">';
			if ($row["active"]==0){echo "Deleted";} else 
			{
				?>
				<form action="delete2.php" method="POST" onsubmit="return confirm('Are you sure want to delete this data?');">
				<?php
				echo '<input type="submit" name="submit" id="submit" value="Delete">
					<input type="hidden" name="ide" id="ide" value='.$row["idpurchase"].'>
					<input type="hidden" name="tabel" id="tabel" value="purchase">
					<input type="hidden" name="namaid" id="namaid" value="idpurchase">	
					<input type="hidden" name="page" id="page" value="list-coinpurchaseconfirm.php">		
					</form> ';
			}
			echo '</td>
				</tr> ';
		}
	}
	else
	{
			echo '<tr>
				<td align="center" colspan="8">There\'s no data to display.</td>
				</tr>
				';
	}
	?>
	</table>
</td>
</tr>
<tr>
	<td colspan="2" align="center">
		<?php
		// PAGING langkah 3 halaman
		$tampil=mysql_query($query1);
		$jmldata=mysql_num_rows($tampil);
		$jmlhalaman=ceil($jmldata/$batas);
		$file="list-coinpurchaseconfirm.php";
			
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
		<input type="button" name="back" id="back" value="Back to previous page" onclick="klikBack()">
	</td>
	<form action="create-promo.php" method="POST">
	<td width="60%" align="left">&nbsp;</td>
	</form>	
</tr>
</table>
</div>