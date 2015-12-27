<?php
session_start();
if (!isset($_SESSION['adzuser'])){header('Location:index.php');}
if (!isset($_GET['ide'])){header('Location:list-packages.php');}
include "top.php";

$query="SELECT * FROM package WHERE idpackage='$_GET[ide]'";
$res=mysql_query($query);
$row=mysql_fetch_array($res);
?>
<link rel="stylesheet" type="text/css" href="library/style2.css" />
<script type="text/javascript">
function klikBack()
{window.location='javascript:javascript:history.go(-1)';}
</script>
<table width="50%" align="center" cellpadding=0 cellspacing=2>
<tr>
	<th align="left" colspan="4" class="judul">Packages Data</th>
</tr>
<tr>
	<td align="right">Name</td>
	<td align="center">:</td>
	<td align="left" colspan="2"><b><?php echo $row['name']; ?></b></td>
</tr>
<tr>
	<td align="right" width="30%">ID packages</td>
	<td align="center" width="5%">:</td>
	<td align="left" width="65%"><?php echo $row['idpackage']; ?></td>
</tr>
<tr>
	<td align="right" width="30%">Description</td>
	<td align="center" width="5%">:</td>
	<td align="left" width="65%"><?php echo $row['description']; ?></td>
</tr>
<tr>
	<td align="right">Qty</td>
	<td align="center">:</td>
	<td align="left" colspan="2"><?php echo $row['qty']; ?></td>
</tr>
<tr>
	<td align="right">Price</td>
	<td align="center">:</td>
	<td align="left" colspan="2"><?php echo $row['price']; ?></td>
</tr>
<tr>
	<td align="right">Input Date</td>
	<td align="center">:</td>
	<td align="left" colspan="2"><?php echo $row['inputdate']; ?></td>
</tr>
<tr>
	<td align="right">User Input</td>
	<td align="center">:</td>
	<td align="left" colspan="2"><?php echo $row['userinput']; ?></td>
</tr>
<tr>
	<td colspan="3">&nbsp;</td>
</tr>
<tr>
	<td align="right">&nbsp;</td>
	<td align="center">&nbsp;</td>
	<td align="right" colspan="2" style="font-style:italic;">date modified : <?php echo $row['dateupdate']; ?>&nbsp;</td>
</tr>
<tr>
	<form action="list-packages.php" method="POST">
	<td align="left" colspan="5">	
			<input type="button" name="back" id="back" value="Back" onclick="klikBack()">
	</td>	
	</form>	
</tr>
</table>