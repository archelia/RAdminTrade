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

/* << function >> */
function time_elapsed_B($secs)
{
	if($secs>31556926)
	{
		$bit = array(
			' year'    => $secs / 31556926 % 12,
			' week'    => $secs / 604800 % 52,
			' day'     => $secs / 86400 % 7
			); 
	}
    else if($secs>604800)
	{
		$bit = array(
			' week'    => $secs / 604800 % 52,
			' day'     => $secs / 86400 % 7
			); 
	}
    else if($secs>86400)
	{
		$bit = array(
			' day'     => $secs / 86400 % 7
			); 
	}
	else
	{
		$bit = array(
			' hour'    => $secs / 3600 % 24,
			' minute'  => $secs / 60 % 60 
			); 
	}
	/*{
		$bit = array(
			' year'    => $secs / 31556926 % 12,
			' week'    => $secs / 604800 % 52,
			' day'     => $secs / 86400 % 7,
			' hour'    => $secs / 3600 % 24,
			' minute'  => $secs / 60 % 60, 
			' second'  => $secs % 60
			); 
	}*/
    foreach($bit as $k => $v){
        if($v > 1)$ret[] = $v . $k . 's';
        if($v == 1)$ret[] = $v . $k;
        }
    if(count($ret)>1){array_splice($ret, count($ret)-1, 0, 'and');}
    $ret[] = 'ago.';
    
    return join(' ', $ret);
} 

//echo "time_elapsed_A: ".time_elapsed_A($nowtime-$oldtime)."\n";
//echo "time_elapsed_B: ".time_elapsed_B($nowtime-$oldtime)."\n";
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
	window.location='javascript:javascript:history.go(-1)';
};
</script>
<link rel="stylesheet" type="text/css" href="library/style2.css" />
<div id="list" style="margin-top:1.5em;" align="center">
<table width="80%" cellspacing="2" cellpadding="2" align="center" class="tabelluar" border="0">
<tr>
	<td align="left" class="judul" colspan="2">Pending Advertisement List</td>
</tr>
<tr>
	
	<form name="formcari" id="formcari" method="POST" action="list-advpending.php">
	<td colspan="2" align="center">
	Search by title : <input type='text' name='tekscari' id='tekscari' size="50"><input type='submit' name='search' id='search' value='Search'>
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
		<th align="center" width="5%">ID</th>
		<th align="center" width="10%">Ad Picture</th>
		<th align="center" width="25%">Ad Title</th>
		<th align="center" width="20%">Ad Category</th>
		<th align="center" width="20%">Detail</th>
		<th align="center" width="10%">Status</th>
		<th align="center" width="10%">Delete</th>
	</tr>
	<?php
	$query = "SELECT a.*, c.categoryname FROM advertisement a, advcategory c WHERE a.idadvcategory=c.idadvcategory ";
	$query.="AND a.active=2 ";
	if (isset($_POST['search']))
	{
		$tekscari=$_POST['tekscari'];
		$query .="AND advtitle LIKE '%$tekscari%' ";
	}
	$query .="ORDER BY inputdate desc ";
	$query1=$query;	
	$query .="LIMIT $posisi,$batas";
	$result = mysql_query($query) or die ("Ada yang salah !");

	while($row = mysql_fetch_array($result))
	{
		if ($row["active"]=='0')echo '<tr bgcolor="#D8D8D8">';
		else if ($row["active"]=='3')echo '<tr bgcolor="#BE81F7">';
		else if ($row["active"]=='2')echo '<tr bgcolor="#F2F5A9">';
		else echo '<tr>';
		echo '<td align="right">'.$row["idadv"].'</td>
			<td>';
			$gambar1="../img_adv/".$row['idadv']."_1.jpg";
			if (file_exists($gambar1)) 
				echo '<img src="'.$gambar1.'" width="100%">'; 
				else echo '<img src="../images/noimage.jpg" width="100%">
			</td>';
		echo '
			<td align="left">'.$row["advtitle"].'</b><br><br><br><span class="keterangan">';
			echo "&nbsp;&#187;&nbsp;added ";
			$nowtime = time();
			//echo $row["inputdate"];
			$oldtime = strtotime($row["inputdate"]);
			echo time_elapsed_B($nowtime-$oldtime);
		echo '</span></td>
			<td align="left">'.$row["categoryname"].'</td>';		
			?>
			<form action="detail-advertisement.php" method="POST" onsubmit="return confirm('See detail Ad?');">		
			<?php
			echo '<td align="center">';
			echo '<input type="submit" name="submit" id="submit" value="See Detail">
				<input type="hidden" name="ide" id="ide" value='.$row["idadv"].'>
				<input type="hidden" name="page" id="page" class="page" value="">				
				</form></td>' ;	
		echo '<td align="center">';
			switch ($row["active"]) 
			{
			case 0:
				echo "Deleted";
				break;
			case 1:
				echo "Active";
				break;
			case 2:
				echo "Pending";
				break;
			case 3:
				echo "Rejected";
				break;
			}
		echo '</td>';
			?>
			<form action="delete.php" method="POST" onsubmit="return confirm('Are you sure want to delete this data?');">
			<?php
		echo '<td align="center">';
			if ($row["active"]==0){echo "Deleted";} else {	
			echo '<input type="submit" name="submit" id="submit" value="Delete">
				<input type="hidden" name="ide" id="ide" value='.$row["idadv"].'>
				<input type="hidden" name="tabel" id="tabel" value="advertisement">
				<input type="hidden" name="namaid" id="namaid" value="idadv">	
				<input type="hidden" name="page" id="page" class="page" value="">';}
		echo '</td></form>
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
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td colspan="2" align="center">
	<?php
	// PAGING langkah 3 halaman
	$tampil= mysql_query($query1);
	$jmldata=mysql_num_rows($tampil);
	$jmlhalaman=ceil($jmldata/$batas);
	$file="list-advpending.php";
		
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
	<?php  
	$jum2=0;

	$query33="SELECT idadv FROM advertisement WHERE active='2'";
	$result33=mysql_query($query33);
	$jum3=mysql_num_rows($result33);
	
	?>
	<td align="right" colspan="2">		
		<label class="keterangan" >There are <?php echo $jum3; ?> advertisement(s) <b>pending</b></label>
	</td>
</tr>
<tr>
	<td width="40%" align="left">
		<input type="button" name="back" id="back" value="Back" onclick="klikBack()">
	</td>
	<td width="60%" align="left">&nbsp;
	</td>
	</form>	
</tr>
</table>	
</div>