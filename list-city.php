<?php
session_start();
if (!isset($_SESSION['adzuser'])){header('Location:./index.php');}
if (!isset($_GET["id"])){header("location:list-province.php");}

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
	<td align="left" bgcolor="#FFFFFF" colspan="2"><h4>City List</h4></td>
</tr>
<tr>
	
	<form name="formcari" id="formcari" method="POST" action="list-city.php?id=<?php echo $_GET['id'] ?>">
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
		<td align="center" width="10%">ID City</td>
		<td align="center" width="20%">Country</td>
		<td align="center" width="20%">Province</td>
		<td align="center" width="30%">City Name</td>
		<td align="center" width="10%">Edit</td>
		<td align="center" width="10%">Delete</td>
	</tr>

	<?php
	$query = "SELECT s.*, c.countryname from city s, country c where s.idcountry=c.idcountry and s.idcountry=".$_GET["id"]." ";
	if (isset($_GET['pid'])){$query.="and s.idprovince=".$_GET["pid"]." ";}
	$query1 = $query."ORDER BY cityname asc";

	if (isset($_POST['search']))
	{
		$tekscari=$_POST['tekscari'];
		$query .="AND cityname LIKE '$tekscari%' ORDER BY cityname ASC LIMIT $posisi,$batas";
	}
	else $query .="ORDER BY cityname ASC LIMIT $posisi,$batas";
	$result = mysql_query($query) or die ("Ada yang salah !");
	while($row = mysql_fetch_array($result))
	{
		echo '<tr>
			<td align="left">'.$row["idcity"].'</td>
			<td align="left">'.$row["countryname"].'</td>';
		$rwp = mysql_fetch_array(mysql_query("SELECT p.provincename FROM city c, province p WHERE c.idprovince=p.idprovince and c.idcity='$row[idcity]'"));
		echo '<td align="left">'.$rwp["provincename"].'</td>
			<td align="left">'.$row["cityname"].'</td>
			<td align="center">';
			?>
			<form action="edit-city.php" method="POST" onsubmit="return confirm('Are you sure want to edit this data?');">
			<?php
			echo '<input type="submit" name="submit" id="submit" value="Edit">
				<input type="hidden" name="ide" id="ide" value='.$row["idcity"].'>		
				</form> ';
		echo '</td>
		<td align="center">';
		if ($row["active"]==0){echo "Deleted";} else 
		{
			?>
			<form action="delete.php" method="POST" onsubmit="return confirm('Are you sure want to delete this data?');">
			<?php
			echo '<input type="submit" name="submit" id="submit" value="Delete">
				<input type="hidden" name="ide" id="ide" value='.$row["idcity"].'>
				<input type="hidden" name="tabel" id="tabel" value="city">
				<input type="hidden" name="namaid" id="namaid" value="idcity">	
				<input type="hidden" name="page" id="page" value="list-city.php">		
				</form> ';
		}
		echo '</td>
			</tr> ';
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
	$file="list-city.php?id=".$_GET['id'];
	if(isset($_GET['pid']))$file.="&pid=".$_GET['pid'];
		
	// link ke halaman berikutnya, first-previous
	if($halaman>1)
	{
	$previous=$halaman-1;
	echo "<a href='$file&halaman=1'> << First</a> | <a href='$file&halaman=$previous'> < Previous</a> | ";
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
			$angka =$angka." <a href='$file&halaman=$i'>$i</a> ";
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
		$angka .=" <a href='$file&halaman=$i'>$i</a> ";
	}			
	// angka akhir
	$angka .= ($halaman+2<$jmlhalaman ?" ... <a href='$file&halaman=$jmlhalaman'>$jmlhalaman</a> " : " ... ");

	// cetak angka semua
	echo "$angka";

	// link ke halaman selanjutnya
	if ($halaman<$jmlhalaman)
	{
	$next=$halaman+1;
	echo "<a href='$file&halaman=$next'> Next > </a> | <a href='$file&halaman=$jmlhalaman'> Last >> </a>";
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
	<form action="create-city.php" method="POST">
	<td width="60%" align="left">
		<input type="submit" name="createnew" id="createnew" value="Click here to create new city">
	</td>
	</form>	
</tr>
</table>
</div>	