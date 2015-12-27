<?php
session_start();
if (!isset($_SESSION['adzuser'])){header('Location:index.php');}
if (!isset($_POST['ide'])){header('Location:list-advertisement.php');}
include "top.php";

$query = "SELECT a.*, ac.categoryname, c.cityname, cr.symbol, ";
$query.= "m.membername, m.telephone, m.email, m.idyahoo, m.fbpage, m.twitter, m.joindate ";
$query.= "FROM advertisement a, advcategory ac, city c, currency cr, member m ";
$query.= "WHERE a.idadvcategory=ac.idadvcategory AND a.advidcity=c.idcity AND a.idcurr=cr.idcurr ";
$query.= "AND a.idmember=m.idmember ";
$query.= "AND a.idadv='$_POST[ide]'";
$res=mysql_query($query);
$row=mysql_fetch_array($res);

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

// for click back
$last=$_POST['page'];
?>
<link rel="stylesheet" type="text/css" href="library/style2.css" />
<script type="text/javascript">
function klikBack()
{
	//window.location='javascript:javascript:history.go(-1)';
	window.location='<?php echo $last;?>';
}
</script>
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
<div id="isi" name="isi" style="margin-left:1.5em;" align="center" >
<h2>Advertisement</h2>
<table width="55%" border="0" align="center" cellspacing="3" cellpadding="3" align="center" bgcolor="#99FFCA">
<tr>
	<td align="left" colspan="5" style="font-weight:bold;" bgcolor="#FFFFFF">Member Data</td>
</tr>
<tr>
	<td colspan="5">&nbsp;</td>
</tr>
<tr>
	<td align="right">Member Name</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><?php echo $row['membername']; ?></td>
</tr>
<tr>
	<td align="right">Member ID</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><?php echo $row['idmember']; ?></td>
</tr>
<tr>
	<td align="right">Telephone</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><?php echo $row['telephone']; ?></td>
</tr>
<tr>
	<td align="right">Email</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><?php echo $row['email']; ?></td>
</tr>
<tr>
	<td align="right">Facebook</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><?php echo $row['fbpage']; ?></td>
</tr>
<tr>
	<td align="right">Twitter</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><?php echo $row['twitter']; ?></td>
</tr>
<tr>
	<td align="right">Member Since</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><?php echo $row['joindate']; ?></td>
</tr>
<tr>
	<td colspan="5">&nbsp;</td>
</tr>
<tr>
	<td align="left" colspan="5" style="font-weight:bold;" bgcolor="#FFFFFF">Advertisement Data</td>
</tr>
<tr>
	<td colspan="5">&nbsp;</td>
</tr>
<tr>
	<td align="right">Advertisement ID</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><?php echo $row['idadv']; ?></td>
</tr>
<tr>
	<td align="right">Ad Title</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><?php echo $row['advtitle']; ?></td>
</tr>
<tr valign="center">
	<td align="right">Ad Pictures</td>
	<td align="center">:</td>
	<td align="left" colspan="3" >
	<?php
		$gambar1="../img_adv/".$row['idadv']."_1.jpg";
		$gambar2="../img_adv/".$row['idadv']."_2.jpg";
		$gambar3="../img_adv/".$row['idadv']."_3.jpg";
		//echo $gambar1;
		//$kal = '<img src="'.$gambar1.'" width="120">&nbsp;';
		//echo $kal;
		//echo '<img src="'.$gambar1.'" width="120">&nbsp;';
		if (file_exists($gambar1)) echo '<img src="'.$gambar1.'" width="120">&nbsp;';
		if (file_exists($gambar2)) echo '<img src="'.$gambar2.'" width="120">&nbsp;';
		if (file_exists($gambar3)) echo '<img src="'.$gambar2.'" width="120">&nbsp;';
	?>
	</td>
</tr>
<tr>
	<td align="right">Ad Category</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><?php echo $row['categoryname']; ?></td>
</tr>
<tr>
	<td align="right">Ad Type</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><?php echo ucwords($row['advtype']); ?></td>
</tr>
<tr>
	<td align="right">Ad Price</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><?php echo $row['symbol']." ".number_format($row['advprice'],0,",","."); ?></td>
</tr>
<tr>
	<td align="right">Ad City</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><?php echo $row['cityname']; ?></td>
</tr>
<tr>
	<td align="right">Ad Condition</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><?php echo $row['advcondition']; ?></td>
</tr>
<tr>
	<td align="right">Ad Description</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><?php echo $row['advdesc']; ?></td>
</tr>
<tr>
	<td align="right">Input Date</td>
	<td align="center">:</td>
	<td align="left" colspan="3">
	<?php 
		$nowtime = time();
		//echo $row["inputdate"];
		$oldtime = strtotime($row["inputdate"]);
		echo time_elapsed_B($nowtime-$oldtime);
	?>
	</td>
</tr>
<tr>
	<td colspan="5">&nbsp;</td>
</tr>
<tr>
	<td colspan="5" bgcolor="#FFFFFF"><b>List Advertisement Promo</b></td>
</tr>
<tr>
	<td colspan="1">&nbsp;</td>
	<td colspan="4">
		<?php
		echo "<table align='left' width='100%' border='0'>";
		$qpromo = "SELECT a.advtitle, p.promoname, ad.* ";
		$qpromo.= "FROM advpromo ad, promo p, advertisement a ";
		$qpromo.= "WHERE ad.idadv=a.idadv AND ad.idpromo=p.idpromo ";
		$qpromo.= "AND ad.idadv='$row[idadv]' ";
		$qpromo.= "ORDER by promoname asc";
		$respromo=mysql_query($qpromo);
		$no=mysql_num_rows($respromo);
		if($no<1)echo "This ad has no promo.";
		else
		{
			$i = 1;
			while($rwp = mysql_fetch_array($respromo))
			{
				echo "<tr><td colspan='2' width='85%'>".$i.". ".ucwords($rwp['promoname']);	
				echo '<br>';
				echo '<p class="kecilmiring" style="margin-top:-0.05em;margin-left:2em;">Start : '.date('d-m-Y',strtotime($rwp['dateactive'])).', End : '.date('d-m-Y',strtotime($rwp['duedate'])).'</p>';				
				echo '<td width="15%" align="left">';
				?>
				<form action="deletesuper.php" method="POST" onsubmit="return confirm('Are you sure want to delete this promo ad?');">				
				<?php
				echo '
				<input type="submit" name="submit" id="submit" value="Delete">
				<input type="hidden" name="tabel" id="tabel" value="advpromo">
				<input type="hidden" name="ide" id="ide" value='.$row["idadv"].'>
				<input type="hidden" name="namaid" id="namaid" value="idadv">
				<input type="hidden" name="ide2" id="ide2" value='.$rwp["idpromo"].'>		
				<input type="hidden" name="namaid2" id="namaid2" value="idpromo">	
				<input type="hidden" name="page" id="page" value="detail-advertisement.php?ide='.$row['idadv'].'">		
				</form>';
				echo "</td></tr>";
				$i++;
			}
		}
		echo "</table>";
		?>	
	</td>
</tr>
<tr>
	<td colspan="5">&nbsp;</td>
</tr>
<tr>
	<td colspan="5" bgcolor="#FFFFFF"><b>Add new Promo to this Advertisement</b></td>
</tr>	
<tr>
	<td colspan="5">&nbsp;</td>
</tr>
<tr>
<form action="create-adv-promo.php" method="POST" name="formulir" id="formulir">
	<td colspan="5">&nbsp;
	Promo
	<select name="promo" id="promo">
		<option value="0">--Choose Promo--</option>
		<?php
		$qpr="SELECT * FROM promo WHERE active=1 ";
		$qpr.="AND idpromo NOT IN (SELECT idpromo FROM advpromo WHERE idadv='$_POST[ide]')";
		
		$respr=mysql_query($qpr);
		while($rwpr = mysql_fetch_array($respr))
		{
			echo'<option value='.$rwpr["idpromo"].'>'.$rwpr["promoname"].'</option>';
		}
		?>
	</select>
	Start at
	<input id="tanggalan" name="tanggalan">
	<input type="hidden" id="ide" name="ide" value="<?php echo $_POST['ide']; ?>">
	<input type="submit" value="Add" value="<?php echo now; ?>">
	</td>
</form>
</tr>
<tr>
	<td colspan="5">&nbsp;</td>
</tr>
<tr>
	<td colspan="5" bgcolor="#FFFFFF"><b>Respond to this Advertisement</b></td>
</tr>	
<tr>
	<td colspan="5">&nbsp;</td>
</tr>
<form action="accept-product.php" method="POST" id="acceptreq" name="acceptreq" onsubmit="return confirm('Are you sure want to proceed?');">			
<tr>
	<td align="right">Response</td>
	<td align="center">:</td>
	<td align="left" colspan="3">
		<Input type = 'Radio' Name ='action' value= 'accept' checked>Accept
		<Input type = 'Radio' Name ='action' value= 'reject'>Reject	
	</td>
</tr>
<tr>
	<td align="right">Reason</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><textarea name="reason" id="reason" cols="30" rows="5"></textarea></td>
</tr>
<tr>
	<td align="right" width="25%">&nbsp;</td>
	<td align="center" width="5%">&nbsp;</td>
	<td align="left" width="15%">
			<input type="submit" name="submit" id="submit" value="Submit">
			<input type="hidden" name="namaproduct" id="namaproduct" value="<?php echo $row['advtitle']; ?>">
			<input type="hidden" name="target" id="target" value="advertisement">
			<input type="hidden" name="namamember" id="namamember" value="<?php echo $row['membername']; ?>">
			<input type="hidden" name="emailmember" id="emailmember" value="<?php echo $row['email']; ?>">
			<input type="hidden" name="ide" id="ide" value="<?php echo $row['idadv']; ?>">	
	</td>
	<td align="left" width="45%">&nbsp;</td>
	<td align="left" width="10%">&nbsp;</td>	
</tr>
</form>
<tr>
	<td align="left" colspan="5"><input type="button" name="submit" id="sumbit" value="Back" onclick="klikBack();" style="width:70px;"></td>
</tr>
</table>
</div>