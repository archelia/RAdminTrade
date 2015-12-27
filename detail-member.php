<?php
session_start();
if (!isset($_SESSION['adzuser'])){header('Location:index.php');}
if (!isset($_GET['ide'])){header('Location:list-member.php');}
include "top.php";

$query="SELECT m.* FROM member m WHERE m.idmember='$_GET[ide]'";
$res=mysql_query($query);
$row=mysql_fetch_array($res);

$page=$_GET['page'];
//$last=substr($last, 1, -1);
echo $page;
?>
<link rel="stylesheet" type="text/css" href="library/style2.css" />
<script type="text/javascript">
function klikBack()
{
	window.location='javascript:javascript:history.go(-1)';
	//window.location='<?php echo $page;?>';
}
</script>
<table width="50%" align="center" cellpadding=0 cellspacing=2>
<tr>
	<th align="left" colspan="4" class="judul">MEMBER DATA</th>
</tr>
<tr>
	<td align="right">Member Name</td>
	<td align="center">:</td>
	<td align="left" colspan="2"><b><?php echo $row['membername']; ?></b></td>
</tr>
<tr>
	<td align="right" width="30%">ID Member</td>
	<td align="center" width="5%">:</td>
	<td align="left" width="65%"><?php echo $row['idmember']; ?></td>
</tr>
<tr>
	<td align="right" width="30%">Username</td>
	<td align="center" width="5%">:</td>
	<td align="left" width="65%"><?php echo $row['username']; ?></td>
</tr>
<tr>
	<td align="right">Picture</td>
	<td align="center">:</td>
	<td align="left" colspan="2"><img src="../modulee/fotomember/<?php echo $row['idmember']; ?>.jpg" width="100" height="100"></td>
</tr>
<tr>
	<td align="right">Email</td>
	<td align="center">:</td>
	<td align="left" colspan="2"><?php echo $row['email']; ?></td>
</tr>
<tr>
	<td align="right">Telephone</td>
	<td align="center">:</td>
	<td align="left" colspan="2"><?php echo $row['telephone']; ?></td>
</tr>
<tr>
	<td align="right">Address</td>
	<td align="center">:</td>
	<td align="left" colspan="2"><?php echo $row['address']; ?></td>
</tr>
<tr>
	<td align="right">Location</td>
	<td align="center">:</td>
	<td align="left" colspan="2"><?php echo $row['location']; ?></td>
</tr>
<tr>
	<td align="right">Facebook</td>
	<td align="center">:</td>
	<td align="left" colspan="2"><?php echo $row['fbpage']; ?></td>
</tr>
<tr>
	<td align="right">Twitter</td>
	<td align="center">:</td>
	<td align="left" colspan="2"><?php echo $row['twitter']; ?></td>
</tr>
<tr>
	<td align="right">Member Since</td>
	<td align="center">:</td>
	<td align="left" colspan="2" class="keterangan"><?php echo $row['joindate']; ?></td>
</tr>
<tr>
	<td colspan="3">&nbsp;</td>
</tr>
<tr>
	<td align="right">&nbsp;</td>
	<td align="center">&nbsp;</td>
	<td align="right" colspan="2" style="font-style:italic;">Last Login : <?php echo $row['lastlogin']; ?>&nbsp;</td>
</tr>
<tr>
	<form action="list-member.php" method="POST">
	<td align="left" colspan="5">	
			<input type="button" name="back" id="back" value="Back" onclick="klikBack();">
	</td>	
	</form>	
</tr>
</table>