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
// function to create url
$(document).ready(function(){
	var currenturl = jQuery(location).attr('href');
	//alert(currenturl);
	$('.page').val(currenturl);
});
function klikBack()
{window.location='javascript:javascript:history.go(-1)';}
</script>
<div id="list" style="margin-top:1.5em;">
<table width="80%" cellspacing="2" cellpadding="2" align="center" bgcolor="#D8D8D8" border="0">
<tr>
	<td align="left" bgcolor="#FFFFFF" colspan="2"><h4>Product Registered Report</h4></td>
</tr>
<tr>
	<form name="formcari" id="formcari" method="POST" action="list-productregistered.php">
	<td colspan="2" align="center">
	Search by : <select name='pilihancari' id='pilihancari'>
										<option value='kosong' selected>Choose Category</option>
										<option value='productname' selected>Product Name</option>
										<option value='idproduct'>ID Product</option>
										<option value='c.categoryname'>Category</option>
										<option value='s.subcategoryname'>Subcategory</option>										
										</select>
	<input type='text' name='tekscari' id='tekscari' size="50"><input type='submit' name='search' id='search' value='Search'>
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
		<td align="center" width="10%">ID</td>
		<td align="center" width="20%">Name</td>
		<td align="center" width="10%">Picture</td>
		<td align="center" width="15%">Category</td>
		<td align="center" width="15%">Subcategory</td>
		<td align="center" width="10%">Price</td>
		<td align="center" width="10%">Member</td>
		<td align="center" width="10%">Port</td>
	</tr>

	<?php
	$query="SELECT p.*, c.categoryname, s.subcategoryname, m.membername, t.cityname, r.symbol ";
	$query .= "FROM products p, category c, subcategory s, member m, city t, currency r ";
	$query .= "WHERE p.idsubcategory=s.idsubcategory and s.idcategory=c.idcategory AND p.port=t.idcity AND p.idmember=m.idmember AND p.idcurr=r.idcurr AND p.active=2 ";

	if (isset($_POST['search']))
	{
		if ($_POST['pilihancari']!="kosong")
		{
		$tekscari=$_POST['tekscari'];
		$pilihan=$_POST['pilihancari'];
		$query .="AND $pilihan LIKE '$tekscari%' ";
		}
	}
	$query .="ORDER by p.inputdate desc ";
	$query1=$query;
	$query .="LIMIT $posisi,$batas";
	$result =mysql_query($query);

	while($row = mysql_fetch_array($result))
	{
		echo '<tr bgcolor>
			<td align="left">'.$row["idproduct"].'</td>
			<td align="left">'.$row["productname"].'</td>
			<td align="left">';
			$gambar="../imgz_product/".$row["idproduct"].".jpg";
			if (file_exists($gambar)) 
			echo '<img src="" width="100%" height="">';
			else echo '<img src="../images/noimage.jpg" width="100%" height="">';		
		echo '</td>
			<td align="left">'.$row["categoryname"].'</td>
			<td align="left">'.$row["subcategoryname"].'</td>';
		echo '<td align="center">'.$row['symbol'].' '.number_format($row["productprice"],0,",",".").'</td>';
		echo '<td align="center">'.$row["membername"].'</td>';
		echo '<td align="center">'.$row["cityname"].'</td>';
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
	$file="list-productregistered.php";
		
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