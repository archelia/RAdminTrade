<?php
session_start();
if (!isset($_SESSION['adzuser'])){header('Location:index.php');}
if (!isset($_GET['ide'])){header('Location:index.php');}
include "top.php";

$ide=$_GET['ide'];
$query="SELECT p.*, g.name as packagename, g.description, c.symbol, m.membername, m.telephone, m.email, m.fbpage, m.twitter, m.joindate ";
$query.="FROM purchase p, package g, currency c, member m ";
$query.="WHERE p.idpackage=g.idpackage ";
$query.="AND p.idmember=m.idmember ";
$query.="AND g.idcurr=c.idcurr ";
$query.= "AND p.idpurchase='$ide'";
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
<h2>Detail Coin Purchased</h2>
<table width="55%" border="0" align="center" cellspacing="3" cellpadding="3" align="center" bgcolor="#99FFCA">
<tr>
	<th align="left" colspan="5" style="font-weight:bold;" bgcolor="#FFFFFF">Member Information<th>
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
	<th align="left" colspan="5" style="font-weight:bold;" bgcolor="#FFFFFF">Purchase Information</th>
</tr>
<tr>
	<td colspan="5">&nbsp;</td>
</tr>
<tr>
	<td align="right">Purchase ID</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><?php echo $row['idpurchase']; ?></td>
</tr>
<tr>
	<td align="right">Purchase Date</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><?php echo $row['inputdate']; ?></td>
</tr>
<tr>
	<td align="right">Package</td>
	<td align="center">:</td>
	<td align="left" colspan="3" class="keterangan">ID Package : <?php echo $row['idpackage']; ?><br> Package Name : <?php echo $row['packagename']; ?><br> Price : <?php echo $row['symbol']." ".number_format($row['price'],0,",","."); ?>
	</td>
</tr>
<tr>
	<td align="right">Status</td>
	<td align="center">:</td>
	<td align="left" colspan="3" class="keterangan"><?php echo ucwords($row['note']); ?></td>
</tr>
<!--
<tr>
	<td align="right">Input Date</td>
	<td align="center">:</td>
	<td align="left" colspan="3">
	<?php /*
		$nowtime = time();
		//echo $row["inputdate"];
		$oldtime = strtotime($row["inputdate"]);
		echo time_elapsed_B($nowtime-$oldtime); */
	?>
	</td>
</tr>
-->
<tr>
	<td colspan="5">&nbsp;</td>
</tr>
<?php
// cek if there any payment related to this purchase
	$query="SELECT p.* ";
	$query.="FROM payment p ";
	$query.="WHERE idpurchase='$_GET[ide]' ";
	$res=mysql_query($query);
	if(mysql_num_rows($res)>0)
	{
	$rowt=mysql_fetch_array($res);
?>
<tr>
	<th colspan="5" bgcolor="#FFFFFF"><b>Payment Information</b></th>
</tr>
<tr>
	<td colspan="5">&nbsp;</td>
</tr>
<tr>
	<td align="right">Transfer Date</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><?php echo $rowt['transferdate']; ?></td>
</tr>
<tr>
	<td align="right">Transfer By</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><?php echo $rowt['transferby']; ?></td>
</tr>
<tr>
	<td align="right">Transfer To</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><?php echo $rowt['transferto']; ?></td>
</tr>
<tr>
	<td align="right">Amount</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><?php echo $rowt['amount']; ?></td>
</tr>	
<tr>
	<td align="right">Attatchment</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><?php echo $rowt['amount']; ?></td>
</tr>	
<tr>
	<td align="right">Attatchment</td>
	<td align="center">:</td>
	<td align="left" colspan="3"><?php echo $rowt['amount']; ?></td>
</tr>	
<?php 
if($row["status"]=="1")
{
?>
<tr>
	<td>&nbsp;</td>
	<form action="accept-coinpayment.php" method="POST" name="formulir" id="formulir">
	<td colspan="5" align="left">&nbsp;
	<input type="hidden" id="ide" name="ide" value="<?php echo $ide; ?>">
	<input type="hidden" id="target" name="target" value="advertisement">
	<input type="hidden" id="action" name="action" value="accept">
	<input type="hidden" id="email" name="email" value="<?php echo $row['email']; ?>">
	<input type="submit" value="Accept Coin Purchase Confirmation" value="<?php echo now; ?>">
	</td>
	</form>
</tr>
<?php 
}
?>	
<tr>
	<td colspan="5">&nbsp;</td>
</tr>
<tr>
	<td align="left" colspan="5"><input type="button" name="submit" id="sumbit" value="Back to previous page" onclick="klikBack();" style="width:150px;"></td>
</tr>
<?php
}
?>
</table>
</div>