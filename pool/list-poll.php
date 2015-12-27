<?php
session_start();
if (!isset($_SESSION['adzuser'])){header('Location:../index.php');}
include "../library/conn.php";


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


<script type="text/javascript">
function klikBack()
{window.location='javascript:javascript:history.go(-1)';}
</script>
<div id="list" style="margin-top:1.5em;">
<table width="60%" cellspacing="2" cellpadding="2" align="center" bgcolor="#A9D0F5" border="0">
<tr>
	<td align="left" bgcolor="#FFFFFF" colspan="2"><h4>Pool List</h4></td>
</tr>
<tr>
	
	<form name="formcari" id="formcari" method="POST" action="list-poll.php">
	<td colspan="2" align="center">
	Search by date :<input type='submit' name='search' id='search' value='Search'>
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
		<th align="center" width="10%">Date</th>
		<th align="center" width="10%">Username</th>
		<th align="center" width="">poll</th>
		<th align="center" width="">Desc</th>
		<th align="center" width="10%">Delete</th>
	</tr>

	<?php
	$query = "SELECT * FROM poll ";
	$query1 = $query."ORDER BY poll asc ";

	if (isset($_POST['search']))
	{
		$tekscari=$_POST['tekscari'];
		$query .="WHERE poll LIKE '$tekscari%' ORDER BY idpoll ASC LIMIT $posisi,$batas";
	}
	else
	$query .="ORDER BY idpoll ASC LIMIT $posisi,$batas";
	$result = mysql_query($query) or die ("Ada yang salah !");
	$result=mysql_query($query);
	while($row = mysql_fetch_array($result))
	{
		echo '<tr>
			<td align="left">'.$row["idpoll"].'</td>
			<td align="left">'.$row["poll"].'</td>
			<td align="center">';			
			?>
			<form action="delete.php" method="POST" onsubmit="return confirm('Are you sure want to delete this data?');">
			<?php
			echo '	<input type="submit" name="submit" id="submit" value="Delete">
				<input type="hidden" name="ide" id="ide" value='.$row["idpoll"].'>
				<input type="hidden" name="tabel" id="tabel" value="poll">		
				<input type="hidden" name="page" id="page" value="list-poll.php">
				<input type="hidden" name="namaid" id="namaid" value="idpoll">	
				</form> ';
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
		$file="list-poll.php";
			
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
	<form action="create-poll.php" method="POST">
	<td width="60%" align="left">
		<input type="submit" name="createnew" id="createnew" value="Click here to create new poll">
	</td>
	</form>	
</tr>
</table>
</div>
<!-- javascript -->
<script type="text/javascript" src="library/jqueryui/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="library/jqueryui/jquery-ui-1.8.23.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="library/jqueryui/jquery-ui-1.8.23.custom.css" />

<script type="text/javascript">
$(document).ready(function(){
	$("#tanggalan").datepicker({
		dateFormat:"dd-mm-yy",
		changeMonth:true,
		changeYear:true,
		yearRange:"-3:+2"
	});
	$("#formulir").submit(function(){
		if($.trim($("#promo").val())=="0"){
		alert("Please choose a promo !");
		$("#promo").focus();
		return false;
		}
		if($.trim($("#tanggalan").val())==""){
		alert("Please select a date !");
		$("#tanggalan").focus();
		return false;
		}
	})	
});
</script>
