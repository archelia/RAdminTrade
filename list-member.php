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

$last="list-member.php";
if(isset($_POST['page'])){$last=$_POST['page'];}
?>
<script type="text/javascript">
// function to create url
$(document).ready(function(){
	var currenturl = jQuery(location).attr('href');
	//alert(currenturl);
	$('.page').val(currenturl);
});
function klikBack()
{
	//window.location='javascript:javascript:history.go(-1)';
	window.location='<?php echo $last;?>';
};
function loadurutan(sortby)
{window.location = "../javascriptredirect.php";};
</script>
<link rel="stylesheet" type="text/css" href="library/style2.css" />
<div id="list">
<table width="80%" cellspacing="2" cellpadding="2" align="center" class="tabelluar" border="0">
<tr>
	<td width="40%" align="left">
		<input type="button" name="back" id="back" value="Back to Previous Page" onclick="klikBack()">
	</td>
	<td width="60%" align="left">&nbsp;</td>
</tr>
<tr>
	<td align="left" class="judul" colspan="2">MEMBER LIST</td>
</tr>
<tr>
	<form name="formcari" id="formcari" method="POST" action="list-member.php">
	<td align="center" width="70%" class="keterangan">
	Search by : 
	<select name="caribdr" id="caribdr">
		<option value="username" selected>Username</option>
		<option value="membername">Member Name</option>
		<option value="email">Email</option>
		<option value="location">Location</option>
	</select>
	Keywords : 
	<input type='text' name='tekscari' id='tekscari' size="40"><input type='submit' name='search' id='search' value='Search'>
	</td>
	<td align="right">Order By :
		<select name="urutan" id="urutan" onchange="document.getElementById('formcari').submit();">
			<option value="1" selected>Username A-Z</option>
			<option value="2">Username Z-A</option>
			<option value="3">Member Name A-Z</option>
			<option value="4">Member Name Z-A</option>
			<option value="5">Member Type A-Z</option>
			<option value="6">Member Type Z-A</option>
			<option value="7">Join Date Newest</option>
			<option value="8">Join Date Longest</option>
		</select>
	</td>
	</form>
</tr>
<tr>
	<td colspan="2">
	<table width="100%" cellspacing="0" cellpadding="1" align="center" bgcolor="#A9D0F5" border="1"  bordercolor="#FFFFFF">
	<tr>
		<th width="10%">ID</td>
		<th width="20%">Username</td>
		<th width="30%">Member Name</td>
		<th width="15%">Member Type</td>
		<th width="15%">Join Date</td>
		<th width="5%">Edit</td>
		<th width="5%">Delete</td>
	</tr>
	<?php
	$query = "SELECT * FROM member ";
	if (isset($_POST['search']))
	{
		$tekscari=$_POST['tekscari'];
		$caribdr=$_POST['caribdr'];
		
		$query .=" WHERE $caribdr LIKE '$tekscari%' ";
		
	}
	if (isset($_POST['urutan']))
	{
		$urutan=$_POST['urutan'];
		if ($urutan=='1'){$urutan='username asc';}
		else if ($urutan=='2'){$urutan='username desc';}
		else if ($urutan=='3'){$urutan='membername asc';}
		else if ($urutan=='4'){$urutan='membername desc';}
		else if ($urutan=='5'){$urutan='membertype asc';}
		else if ($urutan=='6'){$urutan='membertype desc';}
		else if ($urutan=='7'){$urutan='joindate desc';}
		else if ($urutan=='8'){$urutan='joindate asc';}
		$query .=" ORDER BY $urutan ";
	}
	else $query .="ORDER BY joindate DESC ";
	$query1 = $query;	
	$query .="LIMIT $posisi,$batas";
	$result = mysql_query($query) or die ("Ada yang salah !");
	
	while($row = mysql_fetch_array($result))
	{
		echo '<tr>
			<td align="left">'.$row["idmember"].'</td>
			<td align="left"><a href="detail-member.php?ide='.$row["idmember"].'">'.$row["username"].'</a></td>
			<td align="left">'.$row["membername"].'</td>
			<td align="left">';
			if ($row["membertype"]==0) echo 'Copper';
			else if ($row["membertype"]==1) echo 'Silver';
			else if ($row["membertype"]==2) echo 'Gold';
		echo '</td>
			<td align="left">'.$row["joindate"].'</td>
			<td align="center">';
			?>
			<form action="edit-member.php" method="POST" onsubmit="return confirm('Are you sure want to edit this data?');">
			<?php
			echo '<input type="submit" name="submit" id="submit" value="Edit">
				<input type="hidden" name="ide" id="ide" value='.$row["idmember"].'>	
				<input type="hidden" name="page" id="page" value="" class="page">	
				</form> ';
		echo '</td>		
		<td align="center">';
		if ($row["active"]==0){echo "Deleted";} else {
			?>
			<form action="delete.php" method="POST" onsubmit="return confirm('Are you sure want to delete this data?');">
			<?php
			echo '<input type="submit" name="submit" id="submit" value="Delete">
				<input type="hidden" name="ide" id="ide" value='.$row["idmember"].'>
				<input type="hidden" name="tabel" id="tabel" value="member">
				<input type="hidden" name="namaid" id="namaid" value="idmember">	
				<input type="hidden" name="page" id="page" value="" class="page">		
				</form> ';}
		echo '</td>
			</tr> ';
	}
	?>
	<tr>
		<td colspan="10" class="keterangan" align="right">
			<?php
			// query jumlah data
			$qjum="SELECT * FROM member WHERE active=1";
			$resjum=mysql_query($qjum);
			$jum=0;
			if($resjum){$jum=mysql_num_rows($resjum);}
			?>
		Active Member : <?php echo $jum; ?> &nbsp;<br><br>
		<?php
		// query jumlah data
		$qjum="SELECT * FROM member WHERE active!=1";
		$resjum=mysql_query($qjum);
		$jum=0;
		if($resjum){$jum=mysql_num_rows($resjum);}
		?>
		Nonactive Member : <?php echo $jum; ?> &nbsp;</td>
	</tr>
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
		$file="list-member.php";
			
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
</table>			
</div>
