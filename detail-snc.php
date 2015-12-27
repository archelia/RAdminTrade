<?php
session_start();
if (!isset($_SESSION['adzuser'])){header('Location:index.php');}
if (!isset($_GET['id'])){header('Location:list-snc.php');}
include "top.php";

$query="SELECT s.*, m.membername FROM snc s, member m WHERE s.idmember=m.idmember and idsnc='$_GET[id]'";
$res=mysql_query($query);
$row=mysql_fetch_array($res);
?>
<link rel="stylesheet" type="text/css" href="library/style2.css" />
<script type="text/javascript">
function klikBack()
{window.location='javascript:javascript:history.go(-1)';}
</script>
<div id="isi" name="isi" style="" align="center">
<h2>Suggestion and Critic</h2>
<table width="50%" border="0" cellspacing="2" cellpadding="2" align="center" bgcolor="#99FFCA" >
<tr>
	<td align="left" colspan="4" bgcolor="#FFFFFF"><b>From : <?php echo $row['membername']; ?></b></td>
</tr>
<tr>
	<td align="right">Message</td>
	<td align="center">:</td>
	<td align="left" colspan="2"><?php echo $row['snc']; ?></td>
</tr>
<tr>
	<td colspan="4">&nbsp;</td>
</tr>
<tr>
	<td align="right">&nbsp;</td>
	<td align="center">&nbsp;</td>
	<td align="right" colspan="2" style="font-style:italic;">Sent on : <?php echo $row['inputdate']; ?></td>
</tr>
<tr>
	<td align="right" width="10%">&nbsp;</td>
	<td align="center" width="5%">&nbsp;</td>
	<form action="list-snc.php" method="POST">
	<td align="left" width="10%">	
			<input type="button" name="back" id="back" value="Back" onclick="klikBack()">
	</td>	
	</form>	
	<form action="deletesuper.php" method="POST" onsubmit="return confirm('Are you sure want to delete this data?');">
	<td align="left" width="75%">	
		<?php
		echo '<input type="submit" name="submit" id="submit" value="Delete">
			<input type="hidden" name="ide" id="ide" value='.$row["idsnc"].'>
			<input type="hidden" name="tabel" id="tabel" value="snc">
			<input type="hidden" name="namaid" id="namaid" value="idsnc">	
			<input type="hidden" name="page" id="page" value="list-snc.php">';
		?>	
	</td>	
	</form>
</tr>
</table>
</div>